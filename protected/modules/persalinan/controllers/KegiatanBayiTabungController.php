<?php

class KegiatanBayiTabungController extends MyAuthController
{
  public function actionIndex($pendaftaran_id)
  {
    $modPendaftaran = PSPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $format = new MyFormatter();

    $modPeriksaKehamilan = PSPeriksakeHamilanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($modPeriksaKehamilan)) {
      $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
      $urlDaftarPasien =  Yii::app()->createAbsoluteUrl($module . '/DaftarPasien/index'); //
      Yii::app()->user->setFlash('error', 'Harap Isi Persalinan Terlebih Dahulu.');
      $this->redirect($urlDaftarPasien);
    }
    $modRiwayatBayiTabung = new PSKegBayiTabungT;
    $modRiwayatBayiTabung->pasien_id = $modPasien->pasien_id;

    $cekKegiatanBayiTabung = PSKegBayiTabungT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($cekKegiatanBayiTabung)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya
      $modKegiatanBayiTabung = $cekKegiatanBayiTabung;
    } else {
      ////Jika Pasien Belum Pernah Bayi Tabung
      $modKegiatanBayiTabung = new PSKegBayiTabungT;
    }
    $modKegiatanBayiTabung->tglkegbayitabung = date('Y-m-d H:i:s');

    if (isset($_POST['PSKegBayiTabungT'])) {
      $modKegiatanBayiTabung->attributes = $_POST['PSKegBayiTabungT'];
      $modKegiatanBayiTabung->tglkehamilan = $format->formatDateTimeForDb($_POST['PSKegBayiTabungT']['tglkehamilan']);
      $modKegiatanBayiTabung->tglkegbayitabung = $format->formatDateTimeForDb($_POST['PSKegBayiTabungT']['tglkegbayitabung']);
      $modKegiatanBayiTabung->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modKegiatanBayiTabung->pasien_id = $modPasien->pasien_id;
      $modKegiatanBayiTabung->pendaftaran_id = $modPendaftaran->pendaftaran_id;


      if ($modKegiatanBayiTabung->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      } else {
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }

    $modKegiatanBayiTabung->tglkegbayitabung = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modKegiatanBayiTabung->tglkegbayitabung, 'yyyy-MM-dd hh:mm:ss')
    );

    $modKegiatanBayiTabung->tglkehamilan = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modKegiatanBayiTabung->tglkehamilan, 'yyyy-MM-dd'),
      'medium',
      null
    );


    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
      'modKegiatanBayiTabung' => $modKegiatanBayiTabung,
      'modPeriksaKehamilan' => $modPeriksaKehamilan,
      'modRiwayatBayiTabung' => $modRiwayatBayiTabung
    ));
  }
}
