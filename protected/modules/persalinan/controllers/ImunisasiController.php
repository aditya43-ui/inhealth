<?php

class ImunisasiController extends MyAuthController
{
  public function actionIndex($pendaftaran_id)
  {
    $modPendaftaran = PSPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modJadwalTTBumil = new PSJadwalTTBumilM;
    $format = new MyFormatter();

    $modPeriksaKehamilan = PSPeriksakeHamilanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($modPeriksaKehamilan)) {
      $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
      $urlDaftarPasien =  Yii::app()->createAbsoluteUrl($module . '/DaftarPasien/index'); //
      Yii::app()->user->setFlash('error', 'Harap Isi Persalinan Terlebih Dahulu.');
      $this->redirect($urlDaftarPasien);
    }
    $modRiwayatImunisasi = new PSPasienImunisasiT;
    $modRiwayatImunisasi->pasien_id = $modPasien->pasien_id;

    $cekPasienImunisasi = PSPasienImunisasiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($cekPasienImunisasi)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya
      $modPasienImunisasi = $cekPasienImunisasi;
    } else {
      ////Jika Pasien Belum Pernah Bayi Tabung
      $modPasienImunisasi = new PSPasienImunisasiT;
    }
    $modPasienImunisasi->tglimunisasi = date('Y-m-d');

    if (isset($_POST['PSPasienImunisasiT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasienImunisasi->attributes = $_POST['PSPasienImunisasiT'];
        $modPasienImunisasi->tglimunisasi = $format->formatDateTimeForDb($_POST['PSPasienImunisasiT']['tglimunisasi']);
        $modPasienImunisasi->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPasienImunisasi->pasien_id = $modPasien->pasien_id;
        $modPasienImunisasi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPasienImunisasi->periksakehamilan_id = $modPeriksaKehamilan->periksakehamilan_id;

        if ($modPasienImunisasi->save()) {
          $modPeriksaKehamilan->pasienimunisasi_id = $modPasienImunisasi->pasienimunisasi_id;
          if ($modPeriksaKehamilan->save()) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modPasienImunisasi->tglimunisasi = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPasienImunisasi->tglimunisasi, 'yyyy-MM-dd'),
      'medium',
      null
    );


    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
      'modPasienImunisasi' => $modPasienImunisasi,
      'modPeriksaKehamilan' => $modPeriksaKehamilan,
      'modRiwayatImunisasi' => $modRiwayatImunisasi,
      'modJadwalTTBumil' => $modJadwalTTBumil
    ));
  }
  /**
   * menampilkan nama diagnosa dari diagnosa_id
   */
  public function actionGetNamaDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['namaDiagnosa'] = DiagnosaM::model()->findByPk($_POST['idDiagnosa'])->diagnosa_nama;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
