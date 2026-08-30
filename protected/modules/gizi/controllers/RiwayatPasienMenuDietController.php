<?php
class RiwayatPasienMenuDietController extends MyAuthController
{
  public $path_view = 'gizi.views.riwayatPasienMenuDiet.';

  public function actionIndex($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = GZPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }

  public function actionRiwayatAnamnesa($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modAnamnesa = GZAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $this->render('riwayatAnamnesa', array(
      'modAnamnesa' => $modAnamnesa
    ));
  }

  public function actionRiwayatPemeriksaanFisik($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPemeriksaanFisik = GZPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'create_time DESC'));
    $this->render('riwayatPemeriksaanFisik', array(
      'modPemeriksaanFisik' => $modPemeriksaanFisik
    ));
  }

  public function actionRiwayatLaboratorium($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modRiwayatKirimKeUnitLain = GZPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_LAB));
    $modUnitLain = PasienKirimKeUnitLainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_LAB));
    $idPenunjang = empty($modUnitLain) ? null : $modUnitLain->pasienmasukpenunjang_id;
    $modTindakan = TindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $idPenunjang));
    $idTindakan = array();
    foreach ($modTindakan as $tindakan) {
      $idTindakan[] = $tindakan->tindakanpelayanan_id;
    }
    if (!empty($idTindakan)) {
      $criteria = new CDbCriteria();
      $criteria->addInCondition('tindakanpelayanan_id', $idTindakan);
      $modHasil = DetailhasilpemeriksaanlabT::model()->findAll($criteria);
    } else {
      $modHasil = array();
    }

    $this->render('riwayatLaboratorium', array(
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modHasil' => $modHasil
    ));
  }

  public function actionRiwayatRadiologi($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modRiwayatKirimKeUnitLain = GZPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_RAD));
    $modUnitLain = PasienKirimKeUnitLainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_RAD));
    $idPenunjang = empty($modUnitLain) ? null : $modUnitLain->pasienmasukpenunjang_id;
    $modTindakan = TindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $idPenunjang));
    $idTindakan = array();
    foreach ($modTindakan as $tindakan) {
      $idTindakan[] = $tindakan->tindakanpelayanan_id;
    }
    if (!empty($idTindakan)) {
      $criteria = new CDbCriteria();
      $criteria->addInCondition('tindakanpelayanan_id', $idTindakan);
      $modHasil = HasilpemeriksaanradT::model()->findAll($criteria);
    } else {
      $modHasil = array();
    }

    $this->render('riwayatRadiologi', array(
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modHasil' => $modHasil
    ));
  }

  public function actionRiwayatDiagnosis($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $listMorbiditas = GZPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $this->render('riwayatDiagnosis', array(
      'listMorbiditas' => $listMorbiditas
    ));
  }

  public function actionRiwayatBedahSentral($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modRiwayatKirimKeUnitLain = GZPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BEDAH), 'pasienmasukpenunjang_id IS NULL');
    $this->render('riwayatBedahSentral', array(
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain
    ));
  }
}
