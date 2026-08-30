<?php

Yii::import('kepegawaian.models.KPPresensiT');

class PenggajianpegTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'create';
  public $path_view = 'penggajian.views.penggajianpegT.';
  public $kategoripegawaiasal = 'RS';
  protected $email;

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($linkHalaman = null)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $format = new MyFormatter();
    $model = new GJPenggajianpegT;
    $model->tglpenggajian = date('Y-m-d H:i:s');
    //        $model->pemotong_id = Yii::app()->user->getState('pegawai_id');
    // $model->pemotong_id = 2054; //pegawai atas nama PHOA BING HAN
    if (!empty($model->pemotong_id)) {
      $model->pemotong = PegawaiM::model()->findByPk($model->pemotong_id)->namaLengkap;
    }
    $model->pajak_id = 1; //Pajak PPh 21

    $model->penerimaanbersih = 0;
    $model->totalpajak = 0;
    $model->totalpotongan = 0;
    $model->totalterima = 0;
    $model->thr_potong_pajak = 0;
    $modPegawai = new GJPegawaiM();
    $komponen = new PenggajiankompT();

    $mon = (int) date('m');
    $tahun = (int) date('Y');
    $mon--;
    if ($mon == 0) {
      $mon = 12;
      $tahun--;
    }

    $model->periodegaji = Params::getBulan3()[$mon] . ' ' . $tahun;
    $model->no_temp = '-- Otomatis --';
    // Uncomment the following line if AJAX validation is needed

    $approval = ApprovalotorisasiM::model()->find();
    // var_dump($approval->attributes, $model->attributes); die;
    // var_dump($model->attributes); die;

    if (!empty($approval)) {
      $model->mengetahui_id = $approval->direkturrs_id;
      $model->mengetahuipt_id = $approval->kasipersonalia_id;
      $model->menyetujui_id = $approval->direkturpt_id;
    }


    if (isset($_GET['id'])) {
      $model = GJPenggajianpegT::model()->findByPk($_GET['id']);
      $model->periodegaji = Params::getBulan3()[(int) date('m', strtotime($model->periodegaji))] . ' ' . date('Y', strtotime($model->periodegaji));
      $modPegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);
      $model->no_temp = $model->nopenggajian;
    }

    if (!empty($model->mengetahui_id)) {
      $peg = PegawaiM::model()->findByPk($model->mengetahui_id);
      if (!empty($peg)) {
        $model->mengetahui = $peg->namaLengkap;
      }
    }
    if (!empty($model->mengetahuipt_id)) {
      $peg = PegawaiM::model()->findByPk($model->mengetahuipt_id);
      if (!empty($peg)) {
        $model->mengetahuipt = $peg->namaLengkap;
      }
    }
    if (!empty($model->menyetujui_id)) {
      $peg = PegawaiM::model()->findByPk($model->menyetujui_id);
      if (!empty($peg)) {
        $model->menyetujui = $peg->namaLengkap;
      }
    }

    if (isset($_POST['GJPenggajianpegT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['GJPenggajianpegT'];
        $model->pegawai_id = $_POST['GJPegawaiM']['pegawai_id'];
        $model->tglpenggajian = $format->formatDateTimeForDb($model->tglpenggajian);
        $model->nopenggajian = MyGenerator::noPenggajian($model->tglpenggajian);
        $model->harikerja = $_POST['GJPenggajianpegT']['harikerja'];
        $model->periodegaji = MyFormatter::formatMonthForDb($model->periodegaji) . '-01';
        $data = $_POST['PenggajiankompT'];

        /* RSPMC-424 */
        $model->pph21pertahun = $_POST['GJPenggajianpegT']['pphpersen'];
        $model->pph21perbulan = $_POST['GJPenggajianpegT']['pph21'];
        $model->tunjanganmakan = $_POST['tunjanganmakan'];
        $model->tunjanganbonus = $_POST['tunjangantransportasi'];
        $model->penerimaanbersihpertahun = $_POST['netto_tahun'];

        $model->ptkppertahun = $_POST['GJPenggajianpegT']['ptkp'];
        $model->potonganpensiun = $_POST['GJPenggajianpegT']['iuranpensiun'];
        $modPegawaiPost = PegawaiM::model()->findByPk($model->pegawai_id);
        if (isset($modPegawaiPost->ptkp_id)) {
          $modPtkpM = PtkpM::model()->findByPk($modPegawaiPost->ptkp_id);
          $model->kodeptkp = $modPtkpM->kodeptkp . "/" . $modPtkpM->jmltanggunan;
        }

        if (isset($_POST['thr_bruto'])) {
          $model->thr_bruto = $_POST['thr_bruto'];
          $model->thr_thr = $_POST['thr_thr'];
          $model->thr_jabatan = $_POST['thr_biaya_jabatan'];
          $model->thr_pph21gajithr = $_POST['thr_pph21'];
          $model->thr_pph21thr = $_POST['thr_pph21_atasthr'];
          $model->thr_thrbersih = $_POST['thr_pph21_ygdidapat'];
        }
        // $periode = date('Y-m-d', strtotime($model->periodegaji['tahun'].'-'.$model->periodegaji['bulan'].'-01'));
        // $model->periodegaji = $periode;

        $ok = $ok && $model->save();

        // var_dump($model->attributes);
        // die;
        //var_dump($data); die;

        if ($ok) {
          $jumlah = 0;
          if (count((array)$data) > 0) {
            foreach ($data as $i => $v) {

              $row = new PenggajiankompT();
              $row->komponengaji_id = $i;
              $row->jumlah = $v['jumlah'];
              $row->qty = $v['qty'];
              $row->satuan = $v['satuan'];
              $row->unit = $v['unit'];
              $row->penggajianpeg_id = $model->penggajianpeg_id;

              // var_dump($row->attributes, $v); die;
              if ($row->save()) {
                $jumlah++;

                if (isset($_POST['data_jasa'][$i])) {
                  foreach ($_POST['data_jasa'][$i] as $id) {
                    $jasa = PembjasadetailT::model()->findByPk($id);
                    $jasa->penggajiankomp_id = $row->penggajiankomp_id;
                    $jasa->save();
                  }
                }

                if (isset($_POST['data_askep'][$i])) {
                  foreach ($_POST['data_askep'][$i] as $id) {
                    $jasa = PembjasaperawatT::model()->findByPk($id);
                    $jasa->penggajianpeg_id = $row->penggajianpeg_id;
                    $jasa->save();
                  }
                }
              }
            }
          }

          if ((count((array)$data) > 0) && ($jumlah == count((array)$data))) {
            $ok = $ok && true;

            //                        Yii::app()->db
            //                                ->createCommand("select ins_afterpenggajianpeg_fix(" . $model->penggajianpeg_id . ")")
            //                                ->query();
          } else {
            $ok = $ok && false;
          }
        }

        //if ((count((array)$data) > 0) && ($jumlah == count((array)$data))) {
        // var_dump($ok); die;

        if ($ok) {

          $this->notifPenggajian($model);

          $transaction->commit();

          Yii::app()->user->setFlash('success', 'Data ' . $model->pegawai->nama_pegawai . ' berhasil disimpan.');
          $this->redirect(array('create', 'id' => $model->penggajianpeg_id, 'sukses' => 1));
        } else {
          // var_dump($model->getErrors());die;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modPegawai' => $modPegawai, 'komponen' => $komponen, 'linkHalaman' => $linkHalaman
    ));
  }

  protected function notifPenggajian($model)
  {
    $judul = "Pengajuan Gaji Pegawai - " . $model->nopenggajian;

    $isi = "Periode Penggajian : " . MyFormatter::formatMonthForUser($model->periodegaji) . "<br/>";
    $isi .= "Pegawai : " . $model->pegawai->namaLengkap . "<br/>";
    $isi .= "Total Gaji : " . MyFormatter::formatNumberForPrint($model->penerimaanbersih) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruanganKepegawaian = RuanganM::model()->findByPk(Params::RUANGAN_ID_KEPEGAWAIAN);
    $ruanganPenggajian = RuanganM::model()->findByPk(Params::RUANGAN_ID_PENGGAJIAN);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      array('instalasi_id' => $ruanganKepegawaian->instalasi_id, 'ruangan_id' => $ruanganKepegawaian->ruangan_id, 'modul_id' => $ruanganKepegawaian->modul_id),
      array('instalasi_id' => $ruanganPenggajian->instalasi_id, 'ruangan_id' => $ruanganPenggajian->ruangan_id, 'modul_id' => $ruanganPenggajian->modul_id),
    ));

    //var_dump($judul, $isi, Yii::app()->user->getState('ruangan_id'), $model->attributes);

    //die;
  }


  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GJPenggajianpegT'])) {
      $model->attributes = $_POST['GJPenggajianpegT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->penggajianpeg_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('GJPenggajianpegT');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new GJPenggajianpegT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GJPenggajianpegT']))
      $model->attributes = $_GET['GJPenggajianpegT'];

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionInformasi($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Penggajian Seluruh Pegawai";
    $model = new GJPenggajianpegT('search');
    $model->unsetAttributes();  // clear any default values
    $model->periodegaji = date('Y-m');
    $model->kategoripegawaiasal = $this->kategoripegawaiasal;
    
    if (isset($_GET['GJPenggajianpegT'])) {
      $model->attributes = $_GET['GJPenggajianpegT'];
      $model->status = $_GET['GJPenggajianpegT']['status'];
      $model->periodegaji = MyFormatter::formatMonthForDB($model->periodegaji);
     
      //$model->kategoripegawaiasal = !empty($_GET['GJPenggajianpegT']['kategoripegawaiasal']) ? $_GET['GJPenggajianpegT']['kategoripegawaiasal'] : '';

      $model->nomorindukpegawai = !empty($_GET['GJPenggajianpegT']['nomorindukpegawai']) ? $_GET['GJPenggajianpegT']['nomorindukpegawai'] : '';
      $model->nama_pegawai = !empty($_GET['GJPenggajianpegT']['nama_pegawai']) ? $_GET['GJPenggajianpegT']['nama_pegawai'] : '';
      $model->kelompokpegawai_id = !empty($_GET['GJPenggajianpegT']['kelompokpegawai_id']) ? $_GET['GJPenggajianpegT']['kelompokpegawai_id'] : '';
      $model->jabatan_id = !empty($_GET['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : '';
    }

    $this->render($this->path_view . 'informasi', array(
      'model' => $model, 'linkHalaman' => $linkHalaman
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GJPenggajianpegT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionDetail($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kppenggajianpeg-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mengubah status aktif
   * @param type $id
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint($id, $pegawai_id = null, $jenis = null)
  {
    $modelpegawai = GJPegawaiM::model()->findByPk($pegawai_id);
    $modDetail = PenggajiankompT::model()->findAll('penggajianpeg_id = ' . $id . '');
    $model = PenggajianpegT::model()->find('penggajianpeg_id = ' . $id . ' AND pegawai_id = ' . $pegawai_id . '');
    $modelpegawai = GJPegawaiM::model()->findByPk($pegawai_id);
    $tandabuktikueluarT = null;

    if (!empty($model->pengeluaranumum_id)) {
      $pengeluaranumum = PengeluaranumumT::model()->findByPk($model->pengeluaranumum_id);

      if (isset($pengeluaranumum)) {
        $tandabuktikueluarT = TandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id' => $pengeluaranumum->tandabuktikeluar_id));
      }
    }

    $modelpegawai->attributes = (isset($_REQUEST['GJPegawaiM']) ? $_REQUEST['GJPegawaiM'] : null);
    $judulLaporan = '--- Detail Penggajian Pegawai ---';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($jenis == null) {
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'Print', array('tandabuktikueluarT' => $tandabuktikueluarT, 'model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render($this->path_view . 'Print', array('tandabuktikueluarT' => $tandabuktikueluarT, 'model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');     // Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');          // Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('tandabuktikueluarT' => $tandabuktikueluarT, 'model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
      }
    } else {
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'PrintBaru', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render($this->path_view . 'PrintBaruExcel', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');     // Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');          // Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $periode = $model->periodegaji;

        if (empty($model->periodegaji)) {
          $periode = $model->tglpenggajian;
        }
        $date = MyFormatter::getMonthId(date('m', strtotime($periode))) . " " . date('Y', strtotime($periode));
        $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => "<b>SLIP GAJI - " . strtoupper($date) . '</b>', 'periode' => '', 'colspan' => 10), true));
        $mpdf->SetHTMLFooter('{PAGENO}');


        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintBaru', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => "<b>SLIP GAJI - " . strtoupper($date) . '</b>', 'caraPrint' => $caraPrint), true));
        $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
      } else {
        $this->layout = '//layouts/iframe';
        $this->render($this->path_view . 'PrintBaru', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      }
    }
  }

  public function actionDetailPenggajian($id)
  {
    $model = PenggajianpegT::model()->findByPk($id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.penggajianpeg_id', $id);
    $crkom->order = 'k.ispotongan asc, t.penggajiankomp_id';


    $kom = PenggajiankompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PenggajianpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");


    $tandabuktikueluarT = null;

    if (!empty($model->pengeluaranumum_id)) {
      $pengeluaranumum = PengeluaranumumT::model()->findByPk($model->pengeluaranumum_id);

      if (isset($pengeluaranumum)) {
        $tandabuktikueluarT = TandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id' => $pengeluaranumum->tandabuktikeluar_id));
      }
    }

    $this->render($this->path_view . 'detailPenggajian', array(
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'kom' => $kom,
      'tandabuktikueluarT' => $tandabuktikueluarT,
    ));
  }

  public function actionPrintPenggajian($id)
  {
    $modelpegawai = GJPegawaiM::model()->findByPk($id);
    $model = PenggajianpegT::model()->find('pegawai_id = ' . $modelpegawai->pegawai_id . ' ', array(
      'order' => 'penggajianpeg'
    ));
    $modelpegawai->attributes = (isset($_REQUEST['GJPegawaiM']) ? $_REQUEST['GJPegawaiM'] : null);
    if (empty($model)) {
      $model = new PenggajianpegT;
    }
    $judulLaporan = 'Penggajian Pegawai';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionAmbilPph()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pkp = $_POST['pkp'];

      // $sql = "SELECT persentarifpenghsl FROM potonganpph21_m WHERE penghasilandari >= $pkp AND sampaidgn_thn <=$pkp ";
      // $persen_pph = Yii::app()->db->createCommand($sql)->queryAll();
      //$conditions = "penghasilandari <= " . $pkp . " AND sampaidgn_thn >=" . $pkp . " ";
      $criteria = new CDbCriteria;
      $criteria->select = 'potonganpph21_id, penghasilandari::numeric, sampaidgn_thn::numeric, persentarifpenghsl';
      $criteria->order = 'penghasilandari';
      //$criteria->addCondition($conditions);
      $modpph = Potonganpph21M::model()->findAll($criteria);

      $data = array(
        'persen' => 0,
        'nilai' => 0,
      );

      $pengurang = 0;
      foreach ($modpph as $key => $pph) {
        $sampai_dgn = $pph->sampaidgn_thn;
        $penghasilandari = $pph->penghasilandari;

        $base = $pkp;
        if ($pkp > $sampai_dgn) {
          $base = $sampai_dgn;
          $data['nilai'] += ($base - $pengurang) * $pph->persentarifpenghsl / 100;
          $pengurang += $sampai_dgn - $penghasilandari;
        } else {
          $data['nilai'] += ($base - $pengurang) * $pph->persentarifpenghsl / 100;
          break;
        }
      }

      // var_dump($data);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionHitungKeterlambatan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pegawai_id = $_POST['pegawai_id'];
      $periodegaji = $_POST['periodegaji'];
      $periodegaji_awal = MyFormatter::formatMonthForDb($periodegaji) . '-01';
      $periodegaji_akhir = date('Y-m-t', strtotime($periodegaji_awal));

      $sql = "SELECT count(terlambat_mnt) as jumlah FROM presensi_t WHERE statuskehadiran_id = 1 "
        . " and statusscan_id = 1 and pegawai_id = " . $pegawai_id . " AND terlambat_mnt > " . Params::WAKTU_KETERLAMBATAN_1 . " AND terlambat_mnt <= " . Params::WAKTU_KETERLAMBATAN_2 . " and DATE(tglpresensi) BETWEEN '" . $periodegaji_awal . "' AND '" . $periodegaji_akhir . "'";
      $result = Yii::app()->db->createCommand($sql)->queryRow();

      $sql2 = "SELECT count(terlambat_mnt) as jumlah FROM presensi_t WHERE statuskehadiran_id = 1 "
        . " and statusscan_id = 1 and pegawai_id = " . $pegawai_id . " AND terlambat_mnt > " . Params::WAKTU_KETERLAMBATAN_2 . " AND DATE(tglpresensi) BETWEEN '" . $periodegaji_awal . "' AND '" . $periodegaji_akhir . "'";
      $result2 = Yii::app()->db->createCommand($sql2)->queryRow();

      $data['lama15'] = $result['jumlah'];
      $data['lama60'] = $result2['jumlah'];

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetPinjamanKoperasi()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $data['status'] = '';
      $data['jmlcicilan'] = '0';
      $pegawai_id = $_POST['pegawai_id'];
      $sql = "select pinjampegdet_t.jmlcicilan
                    from pinjamanpeg_t
                    JOIN pinjampegdet_t ON pinjamanpeg_t.pinjamanpeg_id = pinjampegdet_t.pinjamanpeg_id
                    WHERE pinjampegdet_t.bulan = " . date('m') . " AND pinjampegdet_t.tahun ='" . date('Y') . "' AND pegawai_id =" . $pegawai_id;
      $jmlcicilan = Yii::app()->db->createCommand($sql)->queryRow();
      if (isset($jmlcicilan)) {
        if ($jmlcicilan > 0) {
          $data['status'] = 'ada';
          $data['jmlcicilan'] = $jmlcicilan['jmlcicilan'];
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetPtkp()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $data['status'] = '';
      $data['ptkp'] = '0';
      $pegawai_id = $_POST['pegawai_id'];
      $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
      $modSusunan = SusunankelM::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id));
      $sql = "select wajibpajak_thn
                    from ptkp_m
                    WHERE LOWER(statusperkawinan) = '" . strtolower($modPegawai->statusperkawinan) . "' AND jmltanggunan ='" . count((array)$modSusunan) . "'";
      $ptkp = Yii::app()->db->createCommand($sql)->queryRow();
      if (isset($ptkp)) {
        if ($ptkp > 0) {
          $data['status'] = 'ada';
          $data['ptkp'] = $ptkp['wajibpajak_thn'];
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetPtkpNew()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $data['status'] = '';
      $data['ptkp'] = '0';
      $pegawai_id = $_POST['pegawai_id'];
      $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
      if (!empty($modPegawai)) {
        $ptkp = PtkpM::model()->findByPk($modPegawai->ptkp_id);
      }

      if (!empty($ptkp)) {
        $data['status'] = 'ada';
        $data['ptkp'] = $ptkp->wajibpajak_bln;
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetPertamaGaji()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $dataArray = array();
      $tahun = date("Y");
      $pegawai_id = $_POST['pegawai_id'];

      $criteria = new CDbCriteria();
      $criteria->select = "date_part('month', tglpenggajian) as tglpenggajian";
      $criteria->addCondition("date_part('year', tglpenggajian) =" . $tahun);
      $criteria->addCondition("pegawai_id =" . $pegawai_id);
      $criteria->order = "tglpenggajian desc";
      $modPenggajianPeg = PenggajianpegT::model()->findAll($criteria);

      $bulan = 0;
      if (count((array)$modPenggajianPeg) > 0) {
        foreach ($modPenggajianPeg as $data) {
          $bulan = $data->tglpenggajian;
        }
      }

      $dataArray['bulan'] = $bulan;
      echo json_encode($dataArray);
      Yii::app()->end();
    }
  }

  public function getBulanPertamaGaji($pegawai_id, $periode = null)
  {
    $dataArray = array();

    if (!empty($periode)) {
      $tahun = date('Y', strtotime($periode));
      $bulan = date('m', strtotime($periode));
    } else {
      $tahun = date('Y');
      $bulan = date('m');
    }

    $criteria = new CDbCriteria();
    $criteria->select = "date_part('month', periodegaji) as periodegaji";
    $criteria->addCondition("date_part('year', periodegaji) =" . $tahun);
    $criteria->addCondition("pegawai_id =" . $pegawai_id);
    $criteria->order = "periodegaji asc";
    $criteria->limit = 1;
    $modPenggajianPeg = PenggajianpegT::model()->findAll($criteria);

    if (count((array)$modPenggajianPeg) > 0) {
      foreach ($modPenggajianPeg as $data) {
        $bulan = $data->periodegaji;
      }
    }

    return $bulan;
  }

  public function actionSetKomponenGaji()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $odate = date('Y-m-d');
      // $odate = date('Y-m-d', strtotime('-1 month'));
      $pegawai_id = $_POST['pegawai_id'];
      $periode = $_POST['periode'];


      $odate = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb("01 " . $periode)));

      $monthAwal = date('m', strtotime($odate)) - 1;
      $konfig = KonfigsystemK::model()->find();
      $day = 0;
      if ($monthAwal < 10) {
        $monthAwal = '0' . $monthAwal;
      }
      if (isset($konfig->cutoff_penggajian)) {
        $day = $konfig->cutoff_penggajian;
      }
      $dayAwal = $day + 1;
      if ($dayAwal < 9) {
        $dayAwal = '0' . $dayAwal;
      }
      $year = date('Y', strtotime($odate));
      $periodeAkhir = date('m-Y', strtotime(MyFormatter::formatDateTimeForDb("01 " . $periode)));
      $tgl_awal = $dayAwal . "-" . $monthAwal . "-" . $year;
      $tgl_akhir = $day . "-" . $periodeAkhir;

      $tglgaji_awal = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($tgl_awal)));
      $tglgaji_akhir = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($tgl_akhir)));

      // var_dump($periode, $odate); die;

      $tr = '';
      $peg = PegawaiM::model()->findByPk($pegawai_id);

      // --------------------------------------------------------------

      $modGaji = PenggajianpegT::model()->findByAttributes(array(
        'pegawai_id' => $pegawai_id,
        'periodegaji' => $odate,
      ));

      // var_dump($odate); die;

      $ndate = MyFormatter::getMonthId(date('m', strtotime($odate))) . " " . date('Y', strtotime($odate));

      $data = array_merge($data, $this->getHariKerjaPegawai($peg, $tglgaji_awal, $tglgaji_akhir));
      $data['sudah_ada'] = empty($modGaji) ? 0 : 1;
      $data['sudah_ada_msg'] = empty($modGaji) ? '' : "Pegawai " . $peg->namaLengkap . " sudah diajukan penggajian untuk periode " . $ndate . ".";
      $data['ptkp'] = 0;
      $data['kodeptkp'] = '';
      $data['is_tetap'] = in_array(trim(strtolower($peg->kategoripegawai)), array(strtolower(Params::KATEGORI_PEGAWAI_TETAP), strtolower(Params::KATEGORI_PEGAWAI_KONTRAK))) ? 1 : 0;
      $data['is_tetap_thr'] = in_array(trim(strtolower($peg->kategoripegawai)), array(strtolower(Params::KATEGORI_PEGAWAI_TETAP))) ? 1 : 0;
      $data['bulan_pertama'] = $this->getBulanPertamaGaji($pegawai_id, $odate);

      $data['bulan_lama_kerja'] = 0;
      if (!empty($peg->tglditerima)) {
        $tgl_diterima = new DateTime(date('Y-m-01', strtotime($peg->tglditerima)));
        $tgl_gaji = new DateTime($odate);
        $interval = $tgl_diterima->diff($tgl_gaji);

        $data['bulan_lama_kerja'] = ($interval->y * 12) + $interval->m;
      }

      if (!empty($peg->ptkp_id)) {
        $ptkp = PtkpM::model()->findByPk($peg->ptkp_id);
        if (!empty($ptkp)) {
          $data['ptkp'] = $ptkp->wajibpajak_thn;
          $data['kodeptkp'] = $ptkp->kodeptkp;
        }
      }

      // --------------------------------------------------------------

      $modKomponen = array();
      $komponen = new PenggajiankompT();
      $a = 1;


      $data['sukses'] = 0;

      $kom_id = array();

      if ($peg->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK) {
        $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true AND (kelompokpegawai_id = ' . $peg->kelompokpegawai_id . ') order by ispotongan IS TRUE ASC, nourutgaji');
      } // else {
      //    $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true AND (kelompokpegawai_id = '.$peg->kelompokpegawai_id.' OR kelompokpegawai_id IS NULL) order by ispotongan IS TRUE ASC, nourutgaji');
      // }


      $cr = new CDbCriteria();
      $cr->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
      $cr->order = 'k.nourutgaji, k.komponengaji_nama';
      $cr->compare('t.pegawai_id', $pegawai_id);
      $modKomponenPegawai = KomponengajipegawaiM::model()->findAll($cr);

      foreach ($modKomponenPegawai as $item) {
        $kom = KomponengajiM::model()->findByPk($item->komponengaji_id);
        // var_dump($kom->attributes);
        array_push($modKomponen, $kom);
      }




      $modKomponenBeta = array_merge($modKomponen);
      $modKomponenAlpha = array();
      $modKomponen = array();

      $off = 999;


      foreach ($modKomponenBeta as $item) {
        $nourut = $item->nourutgaji . "_" . $item->komponengaji_nama;

        if (empty($nourut) || trim($nourut) == "") {
          $nourut = $off++;
        }

        $modKomponenAlpha[$nourut] = $item;
      }

      ksort($modKomponenAlpha);

      foreach ($modKomponenAlpha as $idx => $val) {
        $potongan = $val->ispotongan ? 2 : 1;
        $tipekomponen = empty($val->tipekomponengaji) ? "LAIN-LAIN" : $val->tipekomponengaji;

        if (empty($modKomponen[$potongan])) {
          $modKomponen[$potongan] = array();
        }
        if (empty($modKomponen[$potongan][$tipekomponen])) {
          $modKomponen[$potongan][$tipekomponen] = array();
        }

        $modKomponen[$potongan][$tipekomponen][$idx] = $val;
      }



      $listJaga = $peg->getUangJagaBulan($odate);

      if (count((array)$modKomponen) > 0) {
        $komponen = new PenggajiankompT();
        $a = 1;
        foreach ($modKomponen as $j => $detail) {

          $tr .= '<tr><td colspan="5" style="font-weight: bold;">' . ($j == 1 ? 'Penerimaan' : 'Potongan') . '</td></tr>';


          foreach ($detail as $k => $detail2) {

            $tr .= '<tr><td colspan="5" style="font-weight: bold; padding-left: 20px;">' . $k . '</td></tr>';

            foreach ($detail2 as $i => $v) {

              $val = 0;
              $qty = 1;
              $penguranganterlambat = 0;

              $mod_jasa = array();
              $mod_askep = array();

              $modKomponenPegawai = KomponengajipegawaiM::model()->findByAttributes(array(
                'komponengaji_id' => $v->komponengaji_id,
                'pegawai_id' => $peg->pegawai_id
              ));

              if (!empty($modKomponenPegawai)) {
                $val = $modKomponenPegawai->nilaigaji;
              }

              switch ($v->komponengaji_kode) {
                case 'TT':
                  $pengurang = 0;
                  $hari_kerja = $data['harikerja'] == 0 ? 1 : $data['harikerja'];

                  if (!empty($data['potongan_terlambat'])) {
                    foreach ($data['potongan_terlambat'] as $item) {
                      //                                            echo '== '.($item * $val / $hari_kerja);
                      $pengurang += $item * $val;
                    }
                  }

                  //                                    $val = $val - $pengurang;
                  $val = $val;
                  $penguranganterlambat = $pengurang;
                  break;
                case 'JM':
                  $val = $peg->getUangJasaMedisSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'OSP':
                  //    $qty = $listJaga[$v->komponengaji_kode];
                  //    break;
                case 'OSM':
                  //    $qty = $listJaga[$v->komponengaji_kode];
                  $val = $v->nominal_satuan;
                  break;
                  /*
                                  case 'GP':
                                  $val = (($data['harikerja'] - $data['alpa'])/$data['harikerja']) * $val;
                                  break;
                                 *
                                 */
                case 'SIP':
                  $val = $peg->nilaiSIP;
                  break;
                case 'FLAB':
                  $val = $peg->getUangRujukInternalBulan($odate, Params::RUANGAN_ID_LAB_KLINIK);
                  break;
                case 'FRAD':
                  $val = $peg->getUangRujukInternalBulan($odate, Params::RUANGAN_ID_RAD);
                  break;
                  // case 'PRM':
                  //    $qty = TindakanpelayananT::model()->getTotalTindakanAsuhanKeperawatan($odate, $pegawai_id);
                  //    break;
                case 'PRM':
                  $val = $peg->getUangJasaParamedisSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'LMBR':
                  $criterialm = new CDbCriteria;
                  $criterialm->addBetweenCondition('tglmulai', $tglgaji_awal, $tglgaji_akhir);
                  $criterialm->addCondition('pegawai_id =' . $pegawai_id);
                  $lembur = RealisasilemburdetT::model()->findAll($criterialm);
                  $qtyLm = 1;
                  $valLm = 0;

                  if (count((array)$lembur) > 0) {
                    foreach ($lembur as $item) {
                      $valLm += $item->total_nilai_lembur;
                    }
                  }
                  //                                    $lembur = $peg->getLembur($odate, 1);
                  $qty = $qtyLm;
                  $val = $valLm;
                  break;
                case 'LMOC':
                  $lembur = $peg->getLembur($odate, 2);
                  $qty = $lembur['qty'];
                  $val = $lembur['val'];
                  break;
                case 'JO':
                  $val = $peg->getUangJasaApotekSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'JTS':
                  $val = $peg->getUangJasaSopirSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'JTL':
                  $val = $peg->getUangJasaLaundrySudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'JTKG':
                  $val = $peg->getUangJasaGiziSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'JR':
                  $val = $peg->getUangJasaRadiograferSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'THR':
                  $modKomponenPeg = KomponengajipegawaiM::model()->findAll('(komponengaji_id = 1 or komponengaji_id = 2 or komponengaji_id = 4) and pegawai_id = ' . $peg->pegawai_id);
                  $total = 0;
                  if (!empty($modKomponenPeg)) {
                    $val_thr = 0;
                    foreach ($modKomponenPeg as $key => $value) {
                      $val_thr += $value->nilaigaji;
                    }
                  }

                  if ($peg->kategoripegawai == 'PEGAWAI TETAP') {
                    $total = $val_thr;
                  } else {
                    //                                        $jmlBln = CustomFunction::getTotalBulan(date('Y-m-d'), $peg->tglditerima);
                    $jmlBln = CustomFunction::getTotalBulan(date('Y-m-d', strtotime($odate)), date('Y-m-d', strtotime($peg->tglditerima)));

                    if ($jmlBln <= 12) {
                      $total = ($jmlBln / 12) * $val_thr;
                    } else {
                      $total = $val_thr;
                    }
                  }

                  $val = $total;
                  break;
              }

              $val = MyFormatter::formatNumberForPrint($val);

              $tr .= $this->renderPartial($this->path_view . '_rowKomponenGaji', array(
                'v' => $v,
                'komponen' => $komponen,
                'val' => $val,
                'qty' => $qty,
                'mod_jasa' => $mod_jasa,
                'mod_askep' => $mod_askep,
                'penguranganterlambat' => $penguranganterlambat
              ), true);
              $a++;
            }
          }
        }

        $data['sukses'] = 1;
      }

      if ($data['sukses'] == 0) {
        $data['pesan'] = 'Komponen Gaji tidak Ditemukan';
      }


      /*
              // $modKomponen = $this->getKomponenGajiPegawai($pegawai_id);

              if ($peg->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK) {
              $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true AND (kelompokpegawai_id = '.$peg->kelompokpegawai_id.') order by ispotongan IS TRUE ASC, nourutgaji');
              } else {
              $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true AND (kelompokpegawai_id = '.$peg->kelompokpegawai_id.' OR kelompokpegawai_id IS NULL) order by ispotongan IS TRUE ASC, nourutgaji');
              }



              // print_r($listJaga); die;




             *
             */
      //var_dump($i);
      // presensi
      /*
              $cr = new CDbCriteria();
              $cr->select = 't.pegawai_id, t.tglpresensi::date';
              $cr->addCondition("t.statusscan_id = 1 and t.statuskehadiran_id = 1");
              $cr->group = 't.pegawai_id, t.tglpresensi::date';
              $cr->addBetweenCondition('t.tglpresensi::date', date('Y-m-01', strtotime($odate)), date('Y-m-t', strtotime($odate)));
              $cr->compare('t.pegawai_id', $pegawai_id);

              $presensi = PresensiT::model()->findAll($cr);
             *
             */
      $data['row'] = $tr;

      //die;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  protected function getHariKerjaPegawai($peg, $tglgaji_awal, $tglgaji_akhir)
  {
    $gol = HariKerjaGolM::model()->findByAttributes(array(
      'kelompokpegawai_id' => $peg->kelompokpegawai_id
    ));
    //die;
    $criteriaJdwal = new CDbCriteria();
    $criteriaJdwal->select = "tgljadwalpegawai, pegawai_id";
    $criteriaJdwal->group = $criteriaJdwal->select;
    $criteriaJdwal->addCondition("pegawai_id = " . $peg->pegawai_id);
    $criteriaJdwal->addBetweenCondition("date(tgljadwalpegawai)", $tglgaji_awal, $tglgaji_akhir);
    $criteriaJdwal->addCondition("shift_id is not null");

    $jadwalPeg = PenjadwalandetailT::model()->findAll($criteriaJdwal);

    $harikerja = 0; //count((array)$presensi);
    $hadir = 0;
    $alpa = 0;
    $cuti = 0;
    $izin = 0;
    $sakit = 0;


    $potongan_terlambat = array();
    if (count((array)$jadwalPeg) > 0) {
      $harikerja = count((array)$jadwalPeg);
    }
    // $periodeTanggal = $this->getTanggalPeriode();
    // hari kerja
    $hari = array('MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU');
    //die;
    /* RSPMC-1910
          if (!empty($gol)) {
          $period = new DatePeriod(
          new DateTime($tglgaji_awal),
          new DateInterval('P1D'),
          new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($tglgaji_akhir))))
          );
          $hari_bersih = array();
          if (!empty($gol->periodeharikerjaawl) && !empty($gol->periodeharikerjaakhir)) {
          $hari_1 = array_keys($hari, trim($gol->periodeharikerjaawl));
          $hari_2 = array_keys($hari, trim($gol->periodeharikerjaakhir));

          if (count((array)$hari_1) > 0 && count((array)$hari_2) > 0) {
          if ($hari_1[0] > $hari_2[0]) {
          $hari_2[0] += 7;
          }

          for($i = $hari_1[0]; $i <= $hari_2[0]; $i++) {
          $val = $i % 7;
          $hari_bersih[$val] = $val;
          }
          // var_dump(count((array)$period), $hari_bersih);
          $tgl = array();
          foreach ($period as $key => $value) {
          $tgl[] = $value->format('Y-m-d w');
          // var_dump($value->format('Y-m-d w'));
          if (in_array($value->format('w'), $hari_bersih)) {
          $harikerja++;
          }
          }
          }
          }
          } */

    // jumlah presensi alpa
    $pres = new KPPresensiT();
    $pres->unsetAttributes();
    $pres->tglpresensi = $tglgaji_awal;
    $pres->tglpresensi_akhir = $tglgaji_akhir;
    $pres->pegawai_id = $peg->pegawai_id;

    $data = $pres->searchInformasiPresensiBaru();

    foreach ($data as $item) {
      if ($item['statuskehadiran_id'] == Params::STATUSKEHADIRAN_ALPHA) {
        $alpa++;
      } else {
        if ($item['statuskehadiran_id'] == Params::STATUSKEHADIRAN_HADIR || $item['statuskehadiran_id'] == Params::STATUSKEHADIRAN_DINAS) {
          $hadir++;
        }
        $terlambat = $item['terlambat_mnt'];

        if ($terlambat > Params::WAKTU_KETERLAMBATAN_2) {
          $potongan_terlambat[] = 1;
        } else if ($terlambat >= Params::WAKTU_KETERLAMBATAN_1) {
          $potongan_terlambat[] = 0.5;
        }

        if ($item['statuskehadiran_id'] == Params::STATUSKEHADIRAN_CUTI) {
          $cuti++;
        } else if ($item['statuskehadiran_id'] == Params::STATUSKEHADIRAN_IZIN) {
          $izin++;
        } else if ($item['statuskehadiran_id'] == Params::STATUSKEHADIRAN_SAKIT) {
          $sakit++;
        }
      }
    }

    return array('harikerja' => $harikerja, 'alpa' => $alpa, 'hadir' => $hadir, 'potongan_terlambat' => $potongan_terlambat, 'cuti' => $cuti, 'izin' => $izin, 'sakit' => $sakit);
  }

  public function actionGetTanggalPeriode()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode = $_POST['periode'];

      $odate = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb("01 " . $periode)));
      $monthAwal = date('m', strtotime($odate)) - 1;
      $konfig = KonfigsystemK::model()->find();
      $day = 0;
      if ($monthAwal < 10) {
        $monthAwal = '0' . $monthAwal;
      }
      if (isset($konfig->cutoff_penggajian)) {
        $day = $konfig->cutoff_penggajian;
      }
      $dayAwal = $day + 1;
      if ($dayAwal < 9) {
        $dayAwal = '0' . $dayAwal;
      }
      $year = date('Y', strtotime($odate));
      $periodeAkhir = date('m-Y', strtotime(MyFormatter::formatDateTimeForDb("01 " . $periode)));
      $tgl_awal = $dayAwal . "-" . $monthAwal . "-" . $year;
      $tgl_akhir = $day . "-" . $periodeAkhir;

      $dateAwal = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($tgl_awal)));
      $dateAkhir = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($tgl_akhir)));

      $data = array('tgl_awal' => MyFormatter::formatDateTimeForUser($dateAwal), 'tgl_akhir' => MyFormatter::formatDateTimeForUser($dateAkhir));
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionApproveMenyetujui($penggajianpeg_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PenggajianpegT::model()->findByPk($penggajianpeg_id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.penggajianpeg_id', $penggajianpeg_id);
    $crkom->order = 'k.ispotongan asc, t.penggajiankomp_id';


    $kom = PenggajiankompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PenggajianpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");


    //
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    //		$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = PenggajianpegT::model()->updateByPk($penggajianpeg_id, array('tgl_menyetujui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMenyetujui', 'penggajianpeg_id' => $penggajianpeg_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    //		if($tolak){
    //			$update = ADPembelianbarangT::model()->updateByPk($rencanakebfarmasi_id,array('statusrencana'=>"DITOLAK"));
    //			if($update){
    //				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    //				$this->redirect(array('menyetujui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1,'ditolak'=>1));
    //			}else{
    //				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
    //			}
    //		}
    $judulLaporan = 'Pengajuan Gaji';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpenggajian);
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'kom' => $kom,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      //				'modDetailBeli'=>$modDetailBeli
    ));
  }

  public function actionprintApproveMenyetujui($penggajianpeg_id)
  {
    $format = new MyFormatter();
    $model = PenggajianpegT::model()->findByPk($penggajianpeg_id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.penggajianpeg_id', $penggajianpeg_id);
    $crkom->order = 'k.ispotongan asc, t.penggajiankomp_id';


    $kom = PenggajiankompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PenggajianpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    //		$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    $judulLaporan = 'Pengajuan Gaji';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpenggajian);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionApproveMengetahui($penggajianpeg_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PenggajianpegT::model()->findByPk($penggajianpeg_id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.penggajianpeg_id', $penggajianpeg_id);
    $crkom->order = 'k.ispotongan asc, t.penggajiankomp_id';


    $kom = PenggajiankompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PenggajianpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = PenggajianpegT::model()->updateByPk($penggajianpeg_id, array('tgl_mengetahui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahui', 'penggajianpeg_id' => $penggajianpeg_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Pengajuan Gaji';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpenggajian);
    $this->render($this->path_view . '_mengetahui', array(
      'format' => $format,
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'kom' => $kom,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      //				'modDetailBeli'=>$modDetailBeli
    ));
  }

  public function actionApproveMengetahuiPT($penggajianpeg_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PenggajianpegT::model()->findByPk($penggajianpeg_id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.penggajianpeg_id', $penggajianpeg_id);
    $crkom->order = 'k.ispotongan asc, t.penggajiankomp_id';


    $kom = PenggajiankompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PenggajianpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = PenggajianpegT::model()->updateByPk($penggajianpeg_id, array('tgl_mengetahuipt' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahuiPT', 'penggajianpeg_id' => $penggajianpeg_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Pengajuan Gaji';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpenggajian);
    $this->render($this->path_view . '_mengetahuipt', array(
      'format' => $format,
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'kom' => $kom,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      //				'modDetailBeli'=>$modDetailBeli
    ));
  }

  public function actionPrintApproveMengetahui($penggajianpeg_id)
  {
    $format = new MyFormatter();

    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));

    $model = PenggajianpegT::model()->findByPk($penggajianpeg_id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.penggajianpeg_id', $penggajianpeg_id);
    $crkom->order = 'k.ispotongan asc, t.penggajiankomp_id';


    $kom = PenggajiankompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PenggajianpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");

    $judulLaporan = 'Pengajuan Gaji';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpenggajian);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintApproveMengetahuiPT($penggajianpeg_id)
  {
    $format = new MyFormatter();

    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));

    $model = PenggajianpegT::model()->findByPk($penggajianpeg_id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.penggajianpeg_id', $penggajianpeg_id);
    $crkom->order = 'k.ispotongan asc, t.penggajiankomp_id';


    $kom = PenggajiankompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PenggajianpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");

    $judulLaporan = 'Pengajuan Gaji';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpenggajian);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionbatalPengajuanGaji()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $pengajuangaji_id = isset($_POST['pengajuangaji_id']) ? $_POST['pengajuangaji_id'] : null;
        $pesan = '';
        $status = false;
        $findPenggajianKomT = PenggajiankompT::model()->findAllByAttributes(array('penggajianpeg_id' => $pengajuangaji_id));
        if (count((array)$findPenggajianKomT) > 0) {
          foreach ($findPenggajianKomT as $findKompT) {
            $modPembjasadetailT = PembjasadetailT::model()->findAllByAttributes(array('penggajiankomp_id' => $findKompT->penggajiankomp_id));
            if (count((array)$modPembjasadetailT) > 0) {
              foreach ($modPembjasadetailT as $jasadtl) {
                PembjasadetailT::model()->updateByPk($jasadtl->pembjasadetail_id, array('penggajiankomp_id' => null));
              }
            }

            $modPembjasaperawatT = PembjasaperawatT::model()->findAllByAttributes(array('penggajianpeg_id' => $pengajuangaji_id));
            if (count((array)$modPembjasaperawatT) > 0) {
              foreach ($modPembjasaperawatT as $jasaperawat) {
                PembjasaperawatT::model()->updateByPk($jasaperawat->pembjasaperawat_id, array('penggajianpeg_id' => null));
              }
            }
          }
        }

        $deletePenggajianKomT = PenggajiankompT::model()->deleteAllByAttributes(array('penggajianpeg_id' => $pengajuangaji_id));

        if ($deletePenggajianKomT) {
          $modPengajianpegT = PenggajianpegT::model()->deleteByPk($pengajuangaji_id);

          if ($modPengajianpegT) {
            $transaction->commit();
            $status = true;
            $pesan = "Pengajuan gaji berhasil dibatalkan";
          } else {
            $transaction->rollback();
            $status = false;
            $pesan = "Pengajuan gaji gagal dibatalkan!";
          }
        } else {
          $transaction->rollback();
          $status = false;
          $pesan = "Pengajuan gaji gagal dibatalkan!";
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "Pengajuan gaji gagal dibatalkan!";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionApproveAll()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $dataArray = array();
      $format = new MyFormatter();
      $model = array();
      $type_approve = null;

      if (isset($_POST['GJPenggajianpegT'])) {
        $type_approve = $_POST['type_approve'];
        $criteria = new CDbCriteria;
        $periodegaji = MyFormatter::formatMonthForDB($_POST['GJPenggajianpegT']['periodegaji']);
        $criteria->with = 'pegawai';
        if (!empty($_POST['GJPenggajianpegT']['nomorindukpegawai'])) {
          $criteria->compare("LOWER(pegawai.nomorindukpegawai)", strtolower($_POST['GJPenggajianpegT']['nomorindukpegawai']), true);
        }
        if (!empty($_POST['GJPenggajianpegT']['nama_pegawai'])) {
          $criteria->compare("LOWER(pegawai.nama_pegawai)", strtolower($_POST['GJPenggajianpegT']['nama_pegawai']), true);
        }

        if (!empty($_POST['GJPenggajianpegT']['kelompokpegawai_id'])) {
          $criteria->compare("pegawai.kelompokpegawai_id", $_POST['GJPenggajianpegT']['kelompokpegawai_id']);
        }

        if (!empty($_POST['GJPenggajianpegT']['jabatan_id'])) {
          $criteria->compare("pegawai.jabatan_id", $_POST['GJPenggajianpegT']['jabatan_id']);
        }

        $criteria->compare('LOWER(pegawai.kategoripegawaiasal)', strtolower($_POST['GJPenggajianpegT']['kategoripegawaiasal']));

        $criteria->addCondition("(case when periodegaji is null then tglpenggajian else periodegaji end)::date between '" .
          $periodegaji . "-01' and '" . date('Y-m-t', strtotime($periodegaji . '-01')) . "'");


        if ($type_approve == 'mengetahuirs') {
          $criteria->addCondition('tgl_mengetahui is null');
        } else if ($type_approve == 'mengetahuipt') {
          $criteria->addCondition('tgl_mengetahuipt is null');
        } else if ($type_approve == 'menyetujui') {
          $criteria->addCondition('tgl_menyetujui is null');
        }

        if ($_POST['GJPenggajianpegT']['status'] == 1) {
          $criteria->addCondition('pengeluaranumum_id is null');
        } else if ($_POST['GJPenggajianpegT']['status'] == 2) {
          $criteria->addCondition('pengeluaranumum_id is not null');
        }
        $criteria->order = 'pegawai.nama_pegawai';
        $model = PenggajianpegT::model()->findAll($criteria);
      }
      $sukseData = null;
      if (isset($_GET['approve'])) {
        if ($_GET['approve'] == true) {
          $type_approve = $_GET['type_approve'];
          $indexApp = 0;

          if (count((array)$_GET['id']) > 0) {
            foreach ($_GET['id'] as $data) {
              $modelData = PenggajianpegT::model()->findByPk($data);
              $modelUpdate = null;
              if ($type_approve == 'mengetahuirs') {
                $modelUpdate = PenggajianpegT::model()->updateByPk($data, array('tgl_mengetahui' => date("Y-m-d H:i:s")));
              } else if ($type_approve == 'mengetahuipt') {
                $modelUpdate = PenggajianpegT::model()->updateByPk($data, array('tgl_mengetahuipt' => date("Y-m-d H:i:s")));
              } else if ($type_approve == 'menyetujui') {
                $modelUpdate = PenggajianpegT::model()->updateByPk($data, array('tgl_menyetujui' => date("Y-m-d H:i:s")));
              }

              if (isset($modelUpdate)) {
                $indexApp += 1;
              } else {
                if ($indexApp < 0) {
                  $indexApp = 0;
                } else {
                  $indexApp -= 1;
                }
              }
              $model[] = $modelData;
            }
            if ($indexApp == count((array)$_GET['id'])) {
              $sukseData = true;
            }
          }
        }
      }


      $dataArray['form'] = $this->renderPartial($this->path_view . '_approveAll', array(
        'format' => $format,
        'model' => $model,
        'suksesForm' => $sukseData,
        'type_approve' => $type_approve,
      ), true);
      $dataArray['sukses'] = 1;

      echo json_encode($dataArray);
      Yii::app()->end();
    }
  }

  public function actionPrintApproveAll()
  {
    $format = new MyFormatter();
    $model = array();
    $type_approve = null;
    if (isset($_GET['id']) && count((array)$_GET['id']) > 0) {
      foreach ($_GET['id'] as $data) {

        $modelData = PenggajianpegT::model()->findByPk($data);
        $model[] = $modelData;
      }
      $type_approve = (isset($_GET['type_approve']) ? $_GET['type_approve'] : null);
    }

    if (isset($_GET['GJPenggajianpegT'])) {
      $modelgaji = new GJPenggajianpegT('search');
      $modelgaji->unsetAttributes();  // clear any default values
      $modelgaji->attributes = $_GET['GJPenggajianpegT'];
      $modelgaji->status = $_GET['GJPenggajianpegT']['status'];
      $modelgaji->periodegaji = MyFormatter::formatMonthForDB($modelgaji->periodegaji);

      $modelgaji->kategoripegawaiasal = !empty($_GET['GJPenggajianpegT']['kategoripegawaiasal']) ? $_GET['GJPenggajianpegT']['kategoripegawaiasal'] : '';

      $modelgaji->nomorindukpegawai = !empty($_GET['GJPenggajianpegT']['nomorindukpegawai']) ? $_GET['GJPenggajianpegT']['nomorindukpegawai'] : '';
      $modelgaji->nama_pegawai = !empty($_GET['GJPenggajianpegT']['nama_pegawai']) ? $_GET['GJPenggajianpegT']['nama_pegawai'] : '';
      $modelgaji->kelompokpegawai_id = !empty($_GET['GJPenggajianpegT']['kelompokpegawai_id']) ? $_GET['GJPenggajianpegT']['kelompokpegawai_id'] : '';
      $modelgaji->jabatan_id = !empty($_GET['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : '';

      $prov = $modelgaji->search();
      $prov->criteria->order = 'pegawai.nama_pegawai asc';
      $prov->pagination = false;
      $model = $prov->data;
    }

    $judulLaporan = 'Pengajuan Gaji';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printApproveAll', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $appmenyet = false;

      if (isset($type_approve)) {
        if ($type_approve == 'menyetujui') {
          $appmenyet = true;
        }
      }

      if ($appmenyet) {
        $this->render($this->path_view . 'printApprvAllExcelMenyetujui', array('format' => $format, 'model' => $model, 'judulLaporan' => "Data Pegawai", 'caraPrint' => $caraPrint));
      } else {
        $this->render($this->path_view . 'printExcel', array('format' => $format, 'model' => $model, 'judulLaporan' => "Data Pegawai", 'caraPrint' => $caraPrint));
      }
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'periode'=> "", 'colspan'=>10),true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 30, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printApproveAll', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintPenghasilanBulanan()
  {
    $format = new MyFormatter();
    $model = array();

    if (isset($_GET['id']) && count((array)$_GET['id']) > 0) {
      foreach ($_GET['id'] as $data) {

        $modelData = PenggajianpegT::model()->findByPk($data);
        $model[] = $modelData;
      }
    }

    if (isset($_GET['GJPenggajianpegT'])) {
      $modelgaji = new GJPenggajianpegT('search');
      $modelgaji->unsetAttributes();  // clear any default values
      $modelgaji->attributes = $_GET['GJPenggajianpegT'];
      $modelgaji->status = $_GET['GJPenggajianpegT']['status'];
      $modelgaji->periodegaji = MyFormatter::formatMonthForDB($modelgaji->periodegaji);
      //$model->kategoripegawaiasal = !empty($_GET['GJPenggajianpegT']['kategoripegawaiasal']) ? $_GET['GJPenggajianpegT']['kategoripegawaiasal'] : '';

      $modelgaji->nomorindukpegawai = !empty($_GET['GJPenggajianpegT']['nomorindukpegawai']) ? $_GET['GJPenggajianpegT']['nomorindukpegawai'] : '';
      $modelgaji->nama_pegawai = !empty($_GET['GJPenggajianpegT']['nama_pegawai']) ? $_GET['GJPenggajianpegT']['nama_pegawai'] : '';
      $modelgaji->kelompokpegawai_id = !empty($_GET['GJPenggajianpegT']['kelompokpegawai_id']) ? $_GET['GJPenggajianpegT']['kelompokpegawai_id'] : '';
      $modelgaji->jabatan_id = !empty($_GET['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : '';

      $prov = $modelgaji->search();
      $prov->criteria->order = 'pegawai.nama_pegawai asc';
      $prov->pagination = false;
      $model = $prov->data;
    }

    $judulLaporan = 'Penghasilan Bulanan';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printPenghasilanBulanan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printPenghasilanBulanan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printPenghasilanBulanan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintPenghasilan()
  {
    $format = new MyFormatter();
    $model = array();

    if (isset($_GET['id']) && count((array)$_GET['id']) > 0) {
      foreach ($_GET['id'] as $data) {

        $modelData = PenggajianpegT::model()->findByPk($data);
        $model[] = $modelData;
      }
    }

    if (isset($_GET['GJPenggajianpegT'])) {
      $modelgaji = new GJPenggajianpegT('search');
      $modelgaji->unsetAttributes();  // clear any default values
      $modelgaji->attributes = $_GET['GJPenggajianpegT'];
      $modelgaji->status = $_GET['GJPenggajianpegT']['status'];
      $modelgaji->periodegaji = MyFormatter::formatMonthForDB($modelgaji->periodegaji);
      //            $modelgaji->isimport = true;
      //$model->kategoripegawaiasal = !empty($_GET['GJPenggajianpegT']['kategoripegawaiasal']) ? $_GET['GJPenggajianpegT']['kategoripegawaiasal'] : '';

      $modelgaji->nomorindukpegawai = !empty($_GET['GJPenggajianpegT']['nomorindukpegawai']) ? $_GET['GJPenggajianpegT']['nomorindukpegawai'] : '';
      $modelgaji->nama_pegawai = !empty($_GET['GJPenggajianpegT']['nama_pegawai']) ? $_GET['GJPenggajianpegT']['nama_pegawai'] : '';
      $modelgaji->kelompokpegawai_id = !empty($_GET['GJPenggajianpegT']['kelompokpegawai_id']) ? $_GET['GJPenggajianpegT']['kelompokpegawai_id'] : '';
      $modelgaji->jabatan_id = !empty($_GET['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : '';

      $prov = $modelgaji->search();
      $prov->criteria->compare("isimport", 'true');
      $prov->criteria->order = 'pegawai.nama_pegawai asc';
      $prov->pagination = false;
      $model = $prov->data;
    }

    $judulLaporan = 'Data Penghasilan';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printPenghasilan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printPenghasilan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printPenghasilan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintPemotongan()
  {
    $format = new MyFormatter();
    $model = array();

    if (isset($_GET['id']) && count((array)$_GET['id']) > 0) {
      foreach ($_GET['id'] as $data) {

        $modelData = PenggajianpegT::model()->findByPk($data);
        $model[] = $modelData;
      }
    }

    if (isset($_GET['GJPenggajianpegT'])) {
      $modelgaji = new GJPenggajianpegT('search');
      $modelgaji->unsetAttributes();  // clear any default values
      $modelgaji->attributes = $_GET['GJPenggajianpegT'];
      $modelgaji->status = $_GET['GJPenggajianpegT']['status'];
      $modelgaji->periodegaji = MyFormatter::formatMonthForDB($modelgaji->periodegaji);

      //$model->kategoripegawaiasal = !empty($_GET['GJPenggajianpegT']['kategoripegawaiasal']) ? $_GET['GJPenggajianpegT']['kategoripegawaiasal'] : '';

      $modelgaji->nomorindukpegawai = !empty($_GET['GJPenggajianpegT']['nomorindukpegawai']) ? $_GET['GJPenggajianpegT']['nomorindukpegawai'] : '';
      $modelgaji->nama_pegawai = !empty($_GET['GJPenggajianpegT']['nama_pegawai']) ? $_GET['GJPenggajianpegT']['nama_pegawai'] : '';
      $modelgaji->kelompokpegawai_id = !empty($_GET['GJPenggajianpegT']['kelompokpegawai_id']) ? $_GET['GJPenggajianpegT']['kelompokpegawai_id'] : '';
      $modelgaji->jabatan_id = !empty($_GET['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : '';

      $prov = $modelgaji->search();
      $prov->criteria->order = 'pegawai.nama_pegawai asc';
      $prov->pagination = false;
      $model = $prov->data;
    }

    $judulLaporan = 'Pemotongan PPh';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printPemotongan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printPemotongan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printPemotongan', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionExportPenggajian()
  {
    $format = new MyFormatter();
    $model = array();

    if (isset($_GET['id']) && count((array)$_GET['id']) > 0) {
      foreach ($_GET['id'] as $data) {

        $modelData = PenggajianpegT::model()->findByPk($data);
        $model[] = $modelData;
      }
    }

    if (isset($_GET['GJPenggajianpegT'])) {
      $modelgaji = new GJPenggajianpegT('search');
      $modelgaji->unsetAttributes();  // clear any default values
      $modelgaji->attributes = $_GET['GJPenggajianpegT'];
      $modelgaji->status = $_GET['GJPenggajianpegT']['status'];
      $modelgaji->periodegaji = MyFormatter::formatMonthForDB($modelgaji->periodegaji);

      $modelgaji->nomorindukpegawai = !empty($_GET['GJPenggajianpegT']['nomorindukpegawai']) ? $_GET['GJPenggajianpegT']['nomorindukpegawai'] : '';
      $modelgaji->nama_pegawai = !empty($_GET['GJPenggajianpegT']['nama_pegawai']) ? $_GET['GJPenggajianpegT']['nama_pegawai'] : '';
      $modelgaji->kelompokpegawai_id = !empty($_GET['GJPenggajianpegT']['kelompokpegawai_id']) ? $_GET['GJPenggajianpegT']['kelompokpegawai_id'] : '';
      $modelgaji->jabatan_id = !empty($_GET['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : '';

      $prov = $modelgaji->search();
      $prov->criteria->compare("isimport", 'true');
      // $prov->criteria->addCondition('t.pengeluaranumum_id IS NOT NULL');
      $prov->criteria->order = 'pegawai.nama_pegawai asc';
      $prov->pagination = false;
      $model = $prov->data;
    }

    $judulLaporan = 'Penggajian';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printPenggajian', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printPenggajian', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printPenggajian', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionFormulir($penggajianpeg_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modelpeg = KPPenggajianpegT::model()->findByPk($penggajianpeg_id);
    $model = PembetulanpajakT::model()->findAllByAttributes(array('pegawai_id' => $modelpeg->pegawai_id, 'tglpajak' => $modelpeg->tglpenggajian));
    $modPem = new PegawaiM();
    if (!empty($modelpeg->pemotong_id)) {
      $modPem = PegawaiM::model()->findByPk($modelpeg->pemotong_id);
    }
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'formulir', array(
        'format' => $format,
        'modelpeg' => $modelpeg,
        'model' => $model,
        'modPem' => $modPem,
        'profil' => $profil,
        'caraPrint' => $caraPrint,
      ));
    } else {
      $this->render($this->path_view . 'formulir', array(
        'format' => $format,
        'modelpeg' => $modelpeg,
        'model' => $model,
        'modPem' => $modPem,
        'profil' => $profil,
      ));
    }
  }

  public function actionFormulirPrint()
  {

    $format = new MyFormatter();
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);

    $pegawai_id = $_GET['pegawai_id'];
    $tahun = $_GET['tahun'];
    $masa_1 = $_GET['masa_1'];
    $masa_2 = $_GET['masa_2'];

    $tglAwal = $tahun . '-' . $masa_1 . '-01';
    $caritglakhir = $tahun . '-' . $masa_2 . '-01';
    $tglAkhir = date("Y-m-t", strtotime($caritglakhir));

    $criteria = new CDbCriteria;
    $criteria->addBetweenCondition('DATE(periodegaji)', $tglAwal, $tglAkhir);
    $criteria->addCondition('pegawai_id = ' . $pegawai_id);
    $modelpeg = KPPenggajianpegT::model()->findAll($criteria);
    $modGaji = new KPPenggajianpegT();

    $modPegawai = PegawaiM::model()->findByPk($pegawai_id);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('formulirPrint', array(
        'format' => $format,
        'modelpeg' => $modelpeg,
        'modGaji' => $modGaji,
        'profil' => $profil,
        'masa_1' => $masa_1,
        'masa_2' => $masa_2,
        'modPegawai' => $modPegawai,
        'caraPrint' => $caraPrint,
      ));
    }
  }

  public function actionKirimEmail()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }



    $id = $_POST['id'];
    $modDetail = PenggajiankompT::model()->findAll('penggajianpeg_id = ' . $id . '');
    $model = PenggajianpegT::model()->find('penggajianpeg_id = ' . $id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);

    $tandabuktikueluarT = null;

    if (!empty($model->pengeluaranumum_id)) {
      $pengeluaranumum = PengeluaranumumT::model()->findByPk($model->pengeluaranumum_id);

      if (isset($pengeluaranumum)) {
        $tandabuktikueluarT = TandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id' => $pengeluaranumum->tandabuktikeluar_id));
      }
    }


    if (empty($modelpegawai->alamatemail) || trim($modelpegawai->alamatemail) == "") {
      $ok = 0;
      $msg = "Email pegawai tidak ditemukan.";
      echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
      Yii::app()->end();
    }

    $judulLaporan = "Slip Gaji Bulan " . MyFormatter::formatMonthForUser($model->periodegaji);

    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');     // Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');          // Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    //$mpdf->useOddEven = 2;
    $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tandabuktikueluarT' => $tandabuktikueluarT), true));
    $result = $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'S');
    $judulFile = $judulLaporan . '_' . date('Y-m-d') . '.pdf';

    $ok = 1;
    $msg = "";


    $res = $this->kirimEmail($modelpegawai->alamatemail, $model, $modDetail, $modelpegawai, $judulLaporan, $judulFile, $result);
    echo CJSON::encode($res);
  }

  public function actionKirimSemuaEmail()
  {
    if (!Yii::app()->request->isAjaxRequest || !isset($_POST['GJPenggajianpegT'])) {
      Yii::app()->end();
    }

    $model = new GJPenggajianpegT('search');
    $model->unsetAttributes();
    $model->attributes = $_POST['GJPenggajianpegT'];
    $model->status = $_POST['GJPenggajianpegT']['status'];
    $model->periodegaji = MyFormatter::formatMonthForDB($model->periodegaji);

    //$model->kategoripegawaiasal = !empty($_GET['GJPenggajianpegT']['kategoripegawaiasal']) ? $_GET['GJPenggajianpegT']['kategoripegawaiasal'] : '';

    $model->nomorindukpegawai = !empty($_POST['GJPenggajianpegT']['nomorindukpegawai']) ? $_GET['GJPenggajianpegT']['nomorindukpegawai'] : '';
    $model->nama_pegawai = !empty($_POST['GJPenggajianpegT']['nama_pegawai']) ? $_GET['GJPenggajianpegT']['nama_pegawai'] : '';
    $model->kelompokpegawai_id = !empty($_POST['GJPenggajianpegT']['kelompokpegawai_id']) ? $_GET['GJPenggajianpegT']['kelompokpegawai_id'] : '';
    $model->jabatan_id = !empty($_POST['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : '';

    $prov = $model->search();
    $prov->pagination = false;

    $kirim = 0;
    $total = 0;

    $ok = 1;
    $msg = "";

    foreach ($prov->data as $item) {
      if (empty($item->pengeluaranumum_id)) {
        continue;
      }

      $modDetail = PenggajiankompT::model()->findAll('penggajianpeg_id = ' . $item->penggajianpeg_id . '');
      $modelpegawai = GJPegawaiM::model()->findByPk($item->pegawai_id);

      $total++;

      if (empty($modelpegawai->alamatemail) || trim($modelpegawai->alamatemail) == "") {
        continue;
      }


      if (!empty($model->pengeluaranumum_id)) {
        $pengeluaranumum = PengeluaranumumT::model()->findByPk($model->pengeluaranumum_id);

        if (isset($pengeluaranumum)) {
          $tandabuktikueluarT = TandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id' => $pengeluaranumum->tandabuktikeluar_id));
        }
      }

      $judulLaporan = "Slip Gaji Bulan " . MyFormatter::formatMonthForUser($model->periodegaji);
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');     // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');          // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tandabuktikueluarT' => $tandabuktikueluarT), true));
      $result = $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'S');
      $judulFile = $judulLaporan . '_' . date('Y-m-d') . '.pdf';

      $res = $this->kirimEmail($modelpegawai->alamatemail, $model, $modDetail, $modelpegawai, $judulLaporan, $judulFile, $result);

      if ($res['ok'] == 1) {
        $kirim++;
      }
    }

    if ($total > 0) {
      $msg = "Slip gaji sudah dikirim ke " . $kirim . " dari " . $total . " Pegawai.";
    } else {
      $msg = "Tidak slip gaji yang dikirim ke Pegawai.";
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }
  
  
  public function actionKirimWA()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }



    $id = $_POST['id'];
    $modDetail = PenggajiankompT::model()->findAll('penggajianpeg_id = ' . $id . '');
    $model = PenggajianpegT::model()->find('penggajianpeg_id = ' . $id);
    $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);

    $tandabuktikueluarT = null;

    if (!empty($model->pengeluaranumum_id)) {
      $pengeluaranumum = PengeluaranumumT::model()->findByPk($model->pengeluaranumum_id);

      if (isset($pengeluaranumum)) {
        $tandabuktikueluarT = TandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id' => $pengeluaranumum->tandabuktikeluar_id));
      }
    }

    
    $no_mobile = $modelpegawai->nomobile_pegawai;
    if (empty($no_mobile)) {
        $ok = 0;
        $msg = "No. Mobile pegawai tidak ditemukan.";
        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
        Yii::app()->end();
    }
    
    // var_dump($model->attributes); die;

    
    $str = "Bapak/Ibu ((nama_pegawai))\n\n";
    $str .= "Kami dari Kepegawaian ((nama_rs)), berikut kami kirimkan slip gaji untuk periode ((periode)).\n\n";
    $str .= "Terimakasih";
    
    $str = str_replace('((nama_pegawai))', $modelpegawai->namaLengkap, $str);
    $str = str_replace('((periode))', MyFormatter::formatMonthForUser($model->periodegaji), $str);
    $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);
    //$str = str_replace('')
    
    $judulLaporan = "Slip Gaji".$modelpegawai->pegawai_id."_".MyFormatter::formatMonthForUser($model->periodegaji);
    $judulLaporan = str_replace(" ", "_", $judulLaporan);
    $judulLaporan = str_replace(".", "_", $judulLaporan);
    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');     // Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');          // Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    //$mpdf->useOddEven = 2;
    $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => 'PDF', 'tandabuktikueluarT' => $tandabuktikueluarT), true));
    
    $nama_file = $judulLaporan.".pdf";
    
    $result = $mpdf->Output("uploads/".$nama_file, 'F');
    
    
    
//    var_dump(Params::pathUploads().$nama_file); die;
    
    //$path = 
    
    // $judulFile = $judulLaporan . '_' . date('Y-m-d') . '.pdf';
    $wa = new WhatsApp();
    $res = $wa->kirimFile($no_mobile, $str, Params::pathUploads().$nama_file, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
    
//    echo($res); die;
    

    
    


    $ok = 1;
    $msg = "Slip gaji berhasil dikirim";
    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  protected function kirimEmail($alamat, $model, $detail, $pegawai, $judulLaporan, $judulFile, $result)
  {

    $res = array(
      'email' => $alamat,
      'ok' => 1,
      'msg' => '',
    );


    $this->email = MyMail::setup();
    /*
          $this->email->isSMTP();
          // $this->email->SMTPDebug = 2;
          $this->email->Debugoutput = 'html';
          $this->email->Host = 'smtp.gmail.com';
          $this->email->Port = '587';
          $this->email->SMTPSecure = 'tls';
          $this->email->SMTPAuth = true;
          $this->email->Username = 'pii.deni.prg@gmail.com';
          $this->email->Password = 'piranti08';
         *
         */

    $this->email->addAddress($alamat, $pegawai->nama_pegawai);
    $this->email->Subject = $judulLaporan;
    $this->email->AltBody = "Testers";
    $this->email->Body = "Slip Gaji untuk bulan " . MyFormatter::formatMonthForUser($model->periodegaji);
    $this->email->msgHTML = "Test 123";
    $this->email->AddStringAttachment($result, $judulFile, 'base64', 'application/pdf');

    if (!$this->email->send()) {
      $res['ok'] = 0;
      $res['msg'] = $this->email->ErrorInfo;
    }

    return $res;
  }
}
