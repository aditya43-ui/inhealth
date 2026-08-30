<?php

class RencanaLemburTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'buat';
  public $path_view = 'application.modules.kepegawaian.views.rencanaLemburT.';
  public $modul_sk = "";
  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionBuat($id = null, $sukses = '', $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Lembur";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $modRencanaLembur = new KPRencanaLemburT();
    $modRencanaLembur->norencana = '-- Otomatis --';
    $rencana = array();
    $namanama = "";
    // Uncomment the following line if AJAX validation is needed
    $konfig = ApprovalotorisasiM::model()->find();

    $modRencanaLembur->menyetujui_id = $konfig->bagiankepegawaian_id;
    $modRencanaLembur->menyetujui_nama = PegawaiM::model()->findByPk($modRencanaLembur->menyetujui_id)->namaLengkap;
    
    if (!empty($id)) {
      $modRencanaLembur = KPRencanaLemburT::model()->getModel($id);
      $rencana = $modRencanaLembur->detail;

      $modRencanaLembur->pemberitugas_nama = (!empty($modRencanaLembur->pemberitugas_id) ? PegawaiM::model()->findByPk($modRencanaLembur->pemberitugas_id)->nama_pegawai : "");
      $modRencanaLembur->menyetujui_nama = (!empty($modRencanaLembur->menyetujui_id) ? PegawaiM::model()->findByPk($modRencanaLembur->menyetujui_id)->nama_pegawai : "");
      $modRencanaLembur->mengetahui_nama = (!empty($modRencanaLembur->mengetahui_id) ? PegawaiM::model()->findByPk($modRencanaLembur->mengetahui_id)->nama_pegawai : "");
    } else {
      $modRencanaLembur->tglrencana = date('d M Y H:i:s');
    }

    if (isset($_POST['KPRencanaLemburT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRencanaLembur = KPRencanaLemburT::model()->saveRencanaLembur($_POST['KPRencanaLemburT']);

        // var_dump($modRencanaLembur->attributes); die;
        // var_dump($modRencanaLembur->ok); die;

        if ($modRencanaLembur->ok) {
          $this->broadcastNotifRencana($modRencanaLembur);



          $transaction->commit();
          $this->redirect(array('buat', 'id' => $modRencanaLembur->rencanalembur_id, 'sukses' => 1));
        } else {
          foreach ($nama as $i => $val) {
            $namanama .= "<br>" . $i . ". " . $nama[$i];
          }
          Yii::app()->user->setFlash('error', "Data rencana lembur Gagal disimpan");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(951);

    $this->render($this->path_view . 'buat', array(
      'modRencanaLembur' => $modRencanaLembur,
      'rencana' => $rencana,
      'sukses' => $sukses,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function broadcastNotifRencana($model)
  {
    $judul = "Rencana Lembur";

    $isi = "";
    $isi .= MyFormatter::formatDateTimeForUser($model->tglrencana) . '<br/>';
    $isi .= Yii::app()->user->getState('ruangan_nama') . '<br/>';
    $isi .= $model->norencana;

    $ruangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_KEPEGAWAIAN);

    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPEGAWAIAN) {
      $tujuan = array(
        array(
          'instalasi_id' => $ruangan->instalasi_id,
          'ruangan_id' => $ruangan->ruangan_id,
          'modul_id' => Params::MODUL_ID_KEPEGAWAIAN,
        ),
      );
    } else {
      $tujuan = array(
        array(
          'instalasi_id' => $ruangan->instalasi_id,
          'ruangan_id' => $ruangan->ruangan_id,
          'modul_id' => Params::MODUL_ID_KEPEGAWAIAN,
        ),
        array(
          'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
          'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
          'modul_id' => Yii::app()->user->getState('modul_id'),
        ),
      );
    }

    CustomFunction::broadcastNotif($judul, $isi, $tujuan);
  }



  /**
   * Manages all models.
   */
  public function actionInformasi($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Lembur";
    $modRencanaLembur = new KPRencanaLemburT('searchInformasiRencanaLembur');
    $modRencanaLembur->unsetAttributes();  // clear any default values

    if (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_KEPEGAWAIAN) {
      $modRencanaLembur->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    if (isset($_GET['KPRencanaLemburT'])) {
      $modRencanaLembur->attributes = $_GET['KPRencanaLemburT'];
      $modRencanaLembur->tgl_awal = $_GET['KPRencanaLemburT']['tgl_awal'];
      $modRencanaLembur->tgl_akhir = $_GET['KPRencanaLemburT']['tgl_akhir'];
    } else {
      $modRencanaLembur->tgl_awal = date('d M Y');
      $modRencanaLembur->tgl_akhir = date('d M Y');
    }
    
    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(948);

    $this->render($this->path_view . 'informasi', array(
      'modRencanaLembur' => $modRencanaLembur,
      'linkHalaman' => $linkHalaman
    ));
  }

  /**
   * Untuk melihat detail transaksi rencana lembur
   */
  public function actionLihatDetail($id)
  {
    $this->layout = '//layouts/iframe';

    $modRencanaLembur = KPRencanaLemburT::model()->getModel($id);
    $modRencanaLemburDetail = $modRencanaLembur->detail;
    $format = new MyFormatter;
    $modRencanaLembur->tglrencana = $format->formatDateTimeId($modRencanaLembur->tglrencana);

    $this->render($this->path_view . 'lihatdetail', array(
      'modRencanaLembur' => $modRencanaLembur, 'modDetail' => $modRencanaLemburDetail,
      'id' => $id,
    ));
  }


  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    //		$model=KPRencanaLemburT::model()->findByPk($id);
    $model = KPRencanaLemburT::model()->findAllByAttributes(array('norencana' => $id));
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rencana-lembur-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * Digunakan pada
   * @category Transaksi Rencana Lembur 
   */
  public function actionMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->addCondition('pegawai_aktif is true');
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Digunakan pada 
   * @category Transaksi Rencana Lembur 
   */
  public function actionMenyetujui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->addCondition('pegawai_aktif is true');
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Digunakan pada 
   * @category Transaksi Rencana Lembur 
   */
  public function actionPegawaiLembur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->addCondition('pegawai_aktif is true');
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  /**
   * Untuk transaksi rencana lembur pegawai
   */
  public function actionGetPegawaiLembur()
  {

    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    Yii::app()->clientScript->scriptMap['*.js'] = false;
    Yii::app()->clientScript->scriptMap['*.css'] = false;

    $modRencanaLembur = new KPRencanaLemburT;

    $pegawailembur_id = $_POST['pegawailembur_id'];
    $modPegawai = PegawaiM::model()->findAllByAttributes(array(
      'pegawai_id' => $pegawailembur_id
    ));

    $tr = '';
    foreach ($modPegawai as $pegawai) {
      $tr .= $this->renderPartial($this->path_view . '_rowPegawai', array(
        'modPegawai' => $pegawai,
        'modRencanaLembur' => $modRencanaLembur,
        'pegawailembur_id' => $pegawai->pegawai_id,
      ), true);
    }

    echo json_encode(array('tr' => $tr));
  }


  public function actionPrint($id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $model = KPRencanaLemburT::model()->getModel($id);
    $rencana = $model->detail;


    $judul_print = '<h3>Rencana Lembur<h3>';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }



    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'rencana' => $rencana,
      'caraPrint' => $caraPrint
    ));
  }

  //======================== Ajax Status Rencana ========================
  public function actionSetSetuju()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $id = $_POST['id'];
    $ok = 1;
    $msg = "Rencana Lembur telah Disetujui";

    if (!KPRencanaLemburT::model()->updateByPk($id, array(
      'statusrencana' => Params::STATUS_RENCANA_LEMBUR_DISETUJUI
    ))) {
      $ok = 0;
      $msg = "Error ketika menyetujui Rencana Lembur";
    } else {
      $this->setNotifKonfirmasi($id, "Rencana Lembur Disetujui.");
    }



    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  public function actionSetTolak()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $id = $_POST['id'];
    $alasan = $_POST['alasan'];
    $ok = 1;
    $msg = "Rencana Lembur telah ditolak.";

    if (!KPRencanaLemburT::model()->updateByPk($id, array(
      'statusrencana' => Params::STATUS_RENCANA_LEMBUR_DITOLAK,
      'alasan_tolakbatal' => $alasan,
    ))) {
      $ok = 0;
      $msg = "Error ketika melakukan penolakan Rencana Lembur";
    } else {
      $this->setNotifKonfirmasi($id, "Rencana Lembur Ditolak.", $alasan);
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }


  public function actionSetBatal()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $id = $_POST['id'];
    $alasan = $_POST['alasan'];
    $ok = 1;
    $msg = "Rencana Lembur telah dibatalkan.";

    if (!KPRencanaLemburT::model()->updateByPk($id, array(
      'statusrencana' => Params::STATUS_RENCANA_LEMBUR_BATAL,
      'alasan_tolakbatal' => $alasan,
    ))) {
      $ok = 0;
      $msg = "Error ketika melakukan pembatalan Rencana Lembur";
      //} else {
      //    $this->setNotifKonfirmasi($id, "Rencana Lembur Dibatalkan.", $alasan, Yii::app()->user->getState('ruangan_id'));
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  private function setNotifKonfirmasi($id, $judul, $alasan = "", $ruangan_id = null)
  {
    $model = KPRencanaLemburT::model()->findByPk($id);

    $isi = "";
    $isi .= MyFormatter::formatDateTimeForUser($model->tglrencana) . '<br/>';
    $isi .= Yii::app()->user->getState('ruangan_nama') . '<br/>';
    $isi .= $model->norencana;

    if (!empty($alasan)) {
      $isi .= '<br />Alasan : ' . $model->alasan_tolakbatal;
    }

    if (empty($ruangan_id)) $ruangan_id = $model->create_ruangan;

    $ruangan = RuanganM::model()->findByPk($ruangan_id);

    $tujuan = array(
      array(
        'instalasi_id' => $ruangan->instalasi_id,
        'ruangan_id' => $ruangan->ruangan_id,
        'modul_id' => $ruangan->modul_id,
      ),
    );

    CustomFunction::broadcastNotif($judul, $isi, $tujuan);
  }

  public function actionApproveMenyetujui($rencanalembur_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = KPRencanaLemburT::model()->findByAttributes(array('rencanalembur_id' => $rencanalembur_id));
    $modDetail = RencanalemburdetT::model()->findAllByAttributes(array('rencanalembur_id' => $rencanalembur_id));
    if ($approve) {
      $update = KPRencanaLemburT::model()->updateByPk($rencanalembur_id, array('tgl_menyetujui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMenyetujui', 'rencanalembur_id' => $rencanalembur_id, 'sukses' => 1));
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
    $judulLaporan = 'Rencana Lembur';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($model->tglrencana)));
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetail' => $modDetail
    ));
  }

  public function actionPrintApproveMenyetujui($rencanalembur_id)
  {
    $format = new MyFormatter();
    $model = KPRencanaLemburT::model()->findByAttributes(array('rencanalembur_id' => $rencanalembur_id));
    $modDetail = RencanalemburdetT::model()->findAllByAttributes(array('rencanalembur_id' => $rencanalembur_id));
    $judulLaporan = 'Rencana Lembur';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglrencana);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionApprovePemberiTugas($rencanalembur_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $model = KPRencanaLemburT::model()->findByAttributes(array('rencanalembur_id' => $rencanalembur_id));
    $modDetail = RencanalemburdetT::model()->findAllByAttributes(array('rencanalembur_id' => $rencanalembur_id));
    if ($approve) {
      $update = KPRencanaLemburT::model()->updateByPk($rencanalembur_id, array('tgl_pemberitugas' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('approvePemberiTugas', 'rencanalembur_id' => $rencanalembur_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Rencana Lembur';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($model->tglrencana)));
    $this->render($this->path_view . '_pemberiTugas', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetail' => $modDetail
    ));
  }

  public function actionPrintApprovePemberiTugas($rencanalembur_id)
  {
    $format = new MyFormatter();

    $model = KPRencanaLemburT::model()->findByAttributes(array('rencanalembur_id' => $rencanalembur_id));
    $modDetail = RencanalemburdetT::model()->findAllByAttributes(array('rencanalembur_id' => $rencanalembur_id));

    $judulLaporan = 'Rencana Lembur';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglrencana);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printPemberiTugas', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printPemberiTugas', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printPemberiTugas', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
