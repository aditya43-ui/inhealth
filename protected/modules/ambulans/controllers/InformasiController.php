<?php

class InformasiController extends MyAuthController
{
  public function actionIndex()
  {
    $this->render('index');
  }

  //	DIGANTI DENGAN : ambulans/InformasiPemakaianAmbulans/index
  //	public function actionPemakaian()
  //	{
  //            $format = new MyFormatter();
  //            $modPemakaian = new AMPemakaianambulansT();
  //            $modPemakaian->tgl_awal  = date('Y-m-d');
  //            $modPemakaian->tgl_akhir  = date('Y-m-d');
  //            if(isset($_GET['AMPemakaianambulansT'])){
  //                $modPemakaian->unsetAttributes();                
  //                $modPemakaian->attributes = $_GET['AMPemakaianambulansT'];
  //                $modPemakaian->tgl_awal  = $format->formatDateTimeForDb($_GET['AMPemakaianambulansT']['tgl_awal']);
  //                $modPemakaian->tgl_akhir  = $format->formatDateTimeForDb($_GET['AMPemakaianambulansT']['tgl_akhir']);
  //            }
  //            $this->render('pemakaian',array('format'=>$format,'modPemakaian'=>$modPemakaian));
  //	}

  //	DIGANTI DENGAN : ambulans/InformasiPemesananAmbulans/index
  //	public function actionPemesanan()
  //	{
  //            $format = new MyFormatter();
  //            $modPemesanan = new AMPesanambulansT('search');
  //            $modPemesanan->tgl_awal  = date('Y-m-d');
  //            $modPemesanan->tgl_akhir  = date('Y-m-d');
  //            if(isset($_GET['AMPesanambulansT'])){
  //                $modPemesanan->unsetAttributes();
  //                $modPemesanan->attributes = $_GET['AMPesanambulansT'];
  //                $modPemesanan->tgl_awal  = $format->formatDateTimeForDb($_GET['AMPesanambulansT']['tgl_awal']);
  //                $modPemesanan->tgl_akhir  = $format->formatDateTimeForDb($_GET['AMPesanambulansT']['tgl_akhir']);
  //            }
  //            $this->render('pemesanan',array('format'=>$format,'modPemesanan'=>$modPemesanan));
  //	}

  public function actionTarif()
  {
    $modTarif = new AMTarifambulansM('search');
    if (isset($_GET['AMTarifambulansM'])) {
      $modTarif->unsetAttributes();
      $modTarif->attributes = $_GET['AMTarifambulansM'];
    }
    $this->pageTitle = Yii::app()->name . " - Tarif Ambulans";
    $this->render('tarif', array('modTarif' => $modTarif));
  }

  public function actionDaftarPasienRI()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rawat Inap";
    $format = new MyFormatter();
    $model = new AMPasienrawatinapV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;

    if (isset($_REQUEST['AMPasienrawatinapV'])) {
      $model->attributes = $_REQUEST['AMPasienrawatinapV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['AMPasienrawatinapV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['AMPasienrawatinapV']['tgl_akhir']);
      $model->ceklis = $_REQUEST['AMPasienrawatinapV']['ceklis'];
    }

    $this->render('daftarPasienRI', array('model' => $model, 'format' => $format));
  }

  public function actionDaftarPasienRD()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rawat Darurat";
    $format = new MyFormatter();
    $model = new AMInfoKunjunganRDV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;
    if (isset($_REQUEST['AMInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['AMInfoKunjunganRDV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['AMInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['AMInfoKunjunganRDV']['tgl_akhir']);
      $model->ceklis = $_REQUEST['AMInfoKunjunganRDV']['ceklis'];
    }

    $this->render('daftarPasienRD', array('model' => $model, 'format' => $format));
  }

  public function actionDaftarPasienRJ()
  {
    $format = new MyFormatter();
    $model = new AMInfokunjunganrjV('searchDaftarPasien');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;
    //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['AMInfokunjunganrjV'])) {
      $model->attributes = $_GET['AMInfokunjunganrjV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['AMInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['AMInfokunjunganrjV']['tgl_akhir']);
      $model->ceklis = $_GET['AMInfokunjunganrjV']['ceklis'];
    }
    $this->pageTitle = Yii::app()->name . " - Pasien Rawat Jalan";
    $this->render('daftarPasienRJ', array('model' => $model, 'format' => $format));
  }

  public function actionDaftarPasienPulang()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pulang";
    $format = new MyFormatter();
    $model = new AMPasienpulangrddanriV;
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;
    if (isset($_GET['AMPasienpulangrddanriV'])) {
      $model->attributes = $_GET['AMPasienpulangrddanriV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AMPasienpulangrddanriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AMPasienpulangrddanriV']['tgl_akhir']);
      $model->ceklis = $_GET['AMPasienpulangrddanriV']['ceklis'];
    }
    $this->render('daftarPasienPulang', array('model' => $model, 'format' => $format));
  }

  public function actionBatalPakai()
  {
    $model = new AMBatalpakaiambulansT;
    if (isset($_POST['AMBatalpakaiambulansT'])) {
      $pemakaian_id = isset($_POST['AMBatalpakaiambulansT']['pemakaianambulans_id']) ? $_POST['AMBatalpakaiambulansT']['pemakaianambulans_id'] : null;

      $modPemakaiAmbulans = AMPemakaianambulansT::model()->findByPk($pemakaian_id);
      $model->attributes = $_POST['AMBatalpakaiambulansT'];

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->pemakaianambulans_id = $pemakaian_id;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tglpembatalan = MyFormatter::formatDateTimeForDb($_POST['AMBatalpakaiambulansT']['tglpembatalan']);
        $model->alasanpembatalanambulans = $_POST['AMBatalpakaiambulansT']['alasanpembatalanambulans'];
        $model->create_time = $model->tglpembatalan;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = $model->ruangan_id;
        $model->validate();
        $insertBatal = $model->save();
        if ($insertBatal) {
          $updatePemakaian = AMPemakaianambulansT::model()->updateByPk($pemakaian_id, array('batalpakaiambulans_id' => $model->batalpakaiambulans_id));
        }
        if ($insertBatal && $updatePemakaian) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Batal Pemakaian Ambulans.');
          $this->redirect(array('pemakaian'));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formBatalPemakaian', array('model' => $model), true)
      ));
      exit;
    }
  }
}
