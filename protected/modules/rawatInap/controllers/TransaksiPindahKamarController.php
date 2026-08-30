<?php

class TransaksiPindahKamarController extends MyAuthController
{
  public function actionIndex($pendaftaran_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pulang";
    $modPindahKamar = new RIPindahkamarT;
    $modPasienRIV = new RIPasienRawatInapV;

    if (isset($_POST['RIPindahkamarT'])) {

      $modPindahKamar->attributes = $_POST['RIPindahkamarT'];
      $modPasienAdmisi = RIPasienAdmisiT::model()->findByPK($modPindahKamar->pasienadmisi_id);
      $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
      $modPindahKamar->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
      $modPindahKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
      $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
      $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
      $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
      $modPindahKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $modPindahKamar->nopindahkamar = MyGenerator::noMasukKamar($modPindahKamar->ruangan_id);
      if ($modPindahKamar->save()) {
        $modMasukKamar = MasukkamarT::model()->findByPk($modPindahKamar->masukkamar_id);
        $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
        $modMasukKamar->save();
        Yii::app()->user->setFlash('success', "Data " . $modPindahKamar->nopindahkamar . " Berhasil disimpan");
      } else {
        Yii::app()->user->setFlash('error', "Data  gagal disimpan !");
      }
    }
    $this->render('index', array(
      'modPindahKamar' => $modPindahKamar,
      'modPasienRIV' => $modPasienRIV
    ));
  }
}
