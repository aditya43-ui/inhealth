<?php
Yii::import('sistemAdministrator.controllers.DokumenRekamMedisController');
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.views.dokumenRekamMedis');
class PembuatanDokumenRKController extends DokumenRekamMedisController
{
  public $path_view_rm = 'rekamMedis.views.pembuatanDokumenRK.';
  public $path_tips = 'rekamMedis.views.tips.';

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($pasien_id = null, $tipe = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pembuatan Berkas Rekam Medis";
    $format = new MyFormatter();
    $model = new SADokrekammedisM;
    $model->nodokumenrm = '-- Otomatis --';
    $model->tglmasukrak = date('y-m-d');
    $model->warnadokrm_id = $tipe;

    //tanggal inaktif dan tanggal pemusnahan
    $model->tgl_in_aktif = date("Y-m-d", strtotime("+5 year"));
    $model->tglpemusnahan = date("Y-m-d", strtotime("+2 year", strtotime($model->tgl_in_aktif)));
    // Uncomment the following line if AJAX validation is needed

    if (isset($_GET['id'])) {
      $model = SADokrekammedisM::model()->findByPk($_GET['id']);
    }

    if (!empty($pasien_id)) {

      $pasien = PasienM::model()->findByPk($pasien_id);

      $cek = DokrekammedisM::model()->findByAttributes(array('pasien_id' => $pasien->pasien_id));
      if (empty($cek)) {
        $model->nama_pasien = $pasien->nama_pasien;
        $model->nomortertier = substr($pasien->no_rekam_medik, 0, 2);
        $model->nomorsekunder = substr($pasien->no_rekam_medik, 2, 2);
        $model->nomorprimer = substr($pasien->no_rekam_medik, 4, 2);
        $model->pasien_id = $pasien->pasien_id;
        $model->tglrekammedis = $pasien->tgl_rekam_medik;
      } else {
        $pasien = new PasienM;
      }

      //var_dump($pasien->no_rekam_medik);
      //var_dump($model->attributes);die;
    } else {
      $pasien = new PasienM;
    }

    if (isset($_POST['SADokrekammedisM'])) {
      $model->attributes = $_POST['SADokrekammedisM'];
      $model->nodokumenrm = MyGenerator::noDokumenRM();
      $model->tglrekammedis = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglrekammedis']);
      $model->tglmasukrak = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglmasukrak']);
      $model->tglkeluarakhir = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglkeluarakhir']);
      $model->tglmasukakhir = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglmasukakhir']);
      $model->tgl_in_aktif = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tgl_in_aktif']);
      $model->tglpemusnahan = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglpemusnahan']);
      $model->create_time = $format->formatDateTimeForDb($model->create_time);
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;

      if ($model->save()) {
        $pasien = PasienM::model()->findByPk($model->pasien_id);
        $pasien->dokrekammedis_id = $model->dokrekammedis_id;
        $pasien->save();

        $peg = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));

        /*
                                $judul = 'Pencatatan Berkas Rekam Medis';
                    
                                $isi = (!empty($peg)?$peg->pegawai->namaLengkap:$peg->nama_pemakai)." sudah mencatatkan berkas rekam medis untuk pasien ".$pasien->nama_pasien." dengan nomor rekam medik ".$pasien->no_rekam_medik;

                                $modul = RuanganM::model()->findByPk(Params::RUANGAN_ID_REKAM_MEDIS);
                                CustomFunction::broadcastNotif($judul, $isi, array(
                                    array('instalasi_id'=> Params::INSTALASI_ID_RM, 'ruangan_id'=> Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id'=> $modul->modul_id),                                    
                                    array('instalasi_id'=> Params::INSTALASI_ID_RM, 'ruangan_id'=> Params::RUANGAN_ID_LOKET, 'modul_id'=> Params::MODUL_ID_PENDAFTARAN),                                    
                                ));     
				*/

        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'id' => $model->dokrekammedis_id, 'sukses' => 1));
      }
    }

    $this->render($this->path_view_rm . 'create', array(
      'model' => $model,
      'pasien' => $pasien,
      'tipe' => $tipe,
    ));
  }

  /**
   * untuk print data pembuatan dokumen rekam medis baru
   */
  public function actionPrintDokumen($dokrekammedis_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $model = SADokrekammedisM::model()->findByPk($dokrekammedis_id);
    $modPasien = RKPasienM::model()->findByPk($model->pasien_id);

    $judul_print = 'Pembuatan Dokumen Rekam Medis Baru';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view_rm . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modPasien' => $modPasien,
    ));
  }
}
