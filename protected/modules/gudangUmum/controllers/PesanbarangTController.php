<?php

//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); //RND-6398

class PesanbarangTController extends MyAuthController
{
  private $_valid;

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.pesanbarangT.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * untuk menampilkan barang dari autocomplete
   */
  public function actionAutoCompleteBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
      $criteria->order = 't.barang_id';
      $models = BarangM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->barang_nama;
        $returnVal[$i]['value'] = $model->barang_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAjaxGetPesanBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idBarang = $_POST['idBarang'];
      $jumlah = $_POST['jumlah'];
      $satuan = $_POST['satuan'];

      $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($idBarang);
      $modDetail = new PesanbarangdetailT();
      $modDetail->barang_id = $idBarang;
      $modDetail->satuanbarang = $satuan;
      $modDetail->qty_pesan = $jumlah;

      $tr = $this->renderPartial($this->path_view . '_detailPesanBarang', array('modBarang' => $modBarang, 'modDetail' => $modDetail), true);
      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($id = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Barang";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new GUPesanbarangT;
    $modDetails = array();
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->nopemesanan = MyGenerator::noPemesananBarang();
    $model->tglpesanbarang = date('d M Y H:i:s');
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->pegpemesan_id = $modLogin->pegawai_id;
    if (!empty($model->pegpemesan_id))
      $model->pegpemesan_nama = $modLogin->pegawai->nama_pegawai;
    $model->ruanganpemesan_id = Yii::app()->user->getState('ruangan_id');

    //$model->instalasi_id = $model->ruanganpemesan->instalasi->instalasi_id;                
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GUDANG_UMUM) {
      // $model->instalasi_id = Params::INSTALASI_ID_LOGISTIK;
      // $model->ruangantujuan_id = Params::RUANGAN_ID_GUDANG_UMUM;
      $instalasi_id = Params::INSTALASI_ID_LOGISTIK; //Yii::app()->user->getState('instalasi_id')
    } else {
      $model->instalasi_id = Params::INSTALASI_ID_LOGISTIK;
      $model->ruangantujuan_id = Params::RUANGAN_ID_GUDANG_UMUM;
      $instalasi_id = Params::INSTALASI_ID_LOGISTIK; //Yii::app()->user->getState('instalasi_id')
    }
    if (isset($id)) {
      $modelPesan = GUPesanbarangT::model()->findByPk($id);
      $model->nopemesanan = MyGenerator::noPemesananBarang();
      if (!empty($modelPesan)) {
        $model = $modelPesan;
        $model->instalasi_id = $model->ruanganpemesan->instalasi->instalasi_id;
        $model->pegpemesan_nama = $model->pegawaipemesan->nama_pegawai;
        $model->pegmengetahui_nama = isset($model->pegawaimengetahui->nama_pegawai) ? $model->pegawaimengetahui->nama_pegawai : null;
        $modDetails = GUPesanbarangdetailT::model()->findAll('pesanbarang_id = ' . $id);
      }
    }

    if (isset($_POST['GUPesanbarangT'])) {
      // var_dump($_POST);
      $model->attributes = $_POST['GUPesanbarangT'];
      if (count((array)$_POST['PesanbarangdetailT']) > 0) {
        $modDetails = $this->validasiTabularInput($_POST['PesanbarangdetailT'], $model);
        if ($model->validate()) {
          $transaction = Yii::app()->db->beginTransaction();
          try {
            $success = true;
            $model->nopemesanan = MyGenerator::noPemesananBarang();
            if ($model->save()) {
              $modDetails = $this->validasiTabularInput($_POST['PesanbarangdetailT'], $model);

              foreach ($modDetails as $i => $data) {
                if ($data->qty_pesan > 0) {
                  if ($data->save()) {
                  } else {
                    $success = false;
                  }
                }
              }
            } else {
              $success = false;
            }

            //                                    RND-6398
            //                                    $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
            //                                    $params['create_time'] = date( 'Y-m-d H:i:s');
            //                                    $params['create_loginpemakai_id'] = Yii::app()->user->id;
            //                                    $params['instalasi_id'] = 14;
            //                                    $params['modul_id'] = 17;
            //                                    $ruangan = RuanganM::model()->findByPk($model->ruanganpemesan_id);
            //                                    $params['isinotifikasi'] = $ruangan->ruangan_nama . '-' . $model->nopemesanan;
            //                                    $params['create_ruangan'] = Yii::app()->user->getState('ruangan_id');;
            //                                    $params['judulnotifikasi'] = 'Pesan Barang';
            //                                    $nofitikasi = NotifikasiRController::insertNotifikasi($params);
            // NOTIF
            $this->simpanNotifPesanBarang($model);
            if ($success == true) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', ' Data ' . $model->nopemesanan . ' berhasil disimpan.');
              $this->redirect(array('index', 'id' => $model->pesanbarang_id, 'sukses' => 1));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan  ");
            }
          } catch (Exception $ex) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan  " . MyExceptionMessage::getMessage($ex, true));
          }
        }
      } else {
        $model->validate();
        Yii::app()->user->setFlash('error', ' Data detail barang harus diisi.');
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(406);

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'modDetail' => $modDetails, 'linkHalaman' => $linkHalaman
    ));
  }

  public function simpanNotifPesanBarang($model)
  {
    $ruangan = RuanganM::model()->findByPk($model->ruangantujuan_id);
    $asal = RuanganM::model()->findByPk($model->ruanganpemesan_id);
    $judul = 'Pemesanan Barang';

    $isi = "Pemesan : " . $asal->ruangan_nama . "<br/>No. Pemesanan : ";
    $isi .= CHtml::link($model->nopemesanan, Yii::app()->createUrl('/gudangUmum/pesanbarangT/detailPesanBarang', array(
      'id' => $model->pesanbarang_id,
    )), array('target' => '_blank'));

    // var_dump($isi); die;
    // var_dump($isi); die;
    //var_dump($ruangan->attributes); die;
    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
    ));

    //var_dump($ok); die;
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi2($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (empty($models)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          if (count((array)$models) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
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


    if (isset($_POST['GUPesanbarangT'])) {
      $model->attributes = $_POST['GUPesanbarangT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pesanbarang_id));
      }
    }

    $this->render('update', array(
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
  //	public function actionIndex()
  //	{
  //		$dataProvider=new CActiveDataProvider('GUPesanbarangT');
  //		$this->render('index',array(
  //			'dataProvider'=>$dataProvider,
  //		));
  //	}

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new GUPesanbarangT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GUPesanbarangT']))
      $model->attributes = $_GET['GUPesanbarangT'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GUPesanbarangT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gupesanbarang-t-form') {
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

  public function actionPrint()
  {
    $model = new GUPesanbarangT;
    $format = new MyFormatter;
    if (!empty($_GET['id'])) {
      $model->pesanbarang_id = $_GET['id'];
      $judulLaporan = 'Data Pemesanan Barang';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'PrintTransaksi', array('model' => $model, 'judul_print' => $judulLaporan, 'caraPrint' => $caraPrint));
      }
    } else {


      if (isset($_GET['GUPesanbarangT'])) {
        $model->attributes = $_GET['GUPesanbarangT'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUPesanbarangT']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUPesanbarangT']['tgl_akhir']);
      }

      $format = new MyFormatter();
      $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

      $judulLaporan = 'Data Pemesanan Barang';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($_REQUEST['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        ////$mpdf->useOddEven = 2;  

        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
        $mpdf->WriteHTML($formatkonten, 1);

        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output();
      }
    }
  }

  //$data = diisi POST request yang ingin d validasi; tipe:array();
  //$model = Nama model yang akan divalidate
  protected function validasiTabularInput($datas, $model)
  {
    $valid = true;
    foreach ($datas as $i => $data) {
      $modDetail[$i] = new PesanbarangdetailT();
      $modDetail[$i]->attributes = $data;
      $modDetail[$i]->pesanbarang_id = $model->pesanbarang_id;
      $valid = $modDetail[$i]->validate() && $valid;
    }
    $this->_valid = $valid;
    return $modDetail;
  }

  public function actionInformasi($linkHalaman = null)
  {
    //                
    $model = new GUPesanbarangT('searchInformasi');
    $format = new MyFormatter();
    // $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GUPesanbarangT'])) {
      $model->attributes = $_GET['GUPesanbarangT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUPesanbarangT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUPesanbarangT']['tgl_akhir']);
      // $model->ruanganpemesan_id=Yii::app()->user->getState('ruangan_id');
    } else {
      //$model->ruanganpemesan_id=Yii::app()->user->getState('ruangan_id');
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('gudangUmum.views.pesanbarangT._table', array('model' => $model), true);
    } else {
      if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(402);
      $this->render('gudangUmum.views.pesanbarangT.informasi', array(
        'model' => $model, 'format' => $format, 'linkHalaman' => $linkHalaman
      ));
    }
  }

  public function actionInformasiGudang()
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Barang";
    //                
    $format = new MyFormatter();
    $model = new GUPesanbarangT('search');
    //		$model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['GUPesanbarangT'])) {
      $model->attributes = $_GET['GUPesanbarangT'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
      $model->instalasi_id = $_GET['GUPesanbarangT']['instalasi_id'];
    }

    $this->render('gudangUmum.views.pesanbarangT.informasiGudang', array(
      'model' => $model,
      'format' => $format,
    ));
  }

  public function actionDetailPesanBarang($id)
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'Data Pemesanan Barang';
    $modPesan = PesanbarangT::model()->findByPk($id);
    $modDetailPesan = PesanbarangdetailT::model()->findAllByAttributes(array('pesanbarang_id' => $modPesan->pesanbarang_id));

    $this->render('gudangUmum.views.pesanbarangT.detailInformasi', array(
      'judulLaporan' => $judulLaporan,
      'modPesan' => $modPesan,
      'modDetailPesan' => $modDetailPesan
    ));
  }

  // public function actionPrint($id){
  //     $this->layout='//layouts/printWindows'; 
  //     $caraPrint = $_REQUEST['caraPrint'];
  //     $judulLaporan='Data Pemesanan Barang';
  //     $modPesan = PesanbarangT::model()->findByPk($id);
  //     $modDetailPesan = PesanbarangdetailT::model()->findAllByAttributes(array('pesanbarang_id'=>$modPesan->pesanbarang_id));
  //     $this->render('gudangUmum.views.pesanbarangT.detailInformasi', array(
  //         'judulLaporan'=>$judulLaporan,
  //         'modPesan'=>$modPesan,
  //         'modDetailPesan'=>$modDetailPesan,
  //         'caraPrint'=>$caraPrint,
  //     ));
  // }


  public function actionPrintInformasi($caraPrint)
  {
    $format = new MyFormatter();
    $model = new GUPesanbarangT('search');
    //		$model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['GUPesanbarangT'])) {
      $model->attributes = $_GET['GUPesanbarangT'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
      $model->instalasi_id = $_GET['GUPesanbarangT']['instalasi_id'];
    }

    $this->printFunction($model, $caraPrint, "Informasi Pemesanan Barang", "gudangUmum.views.pesanbarangT.printInformasi");
  }

  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    } else if ($caraPrint == "CSV") {
      CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
    }
  }
}
