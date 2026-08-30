<?php
class InformasiStrukturOrganisasiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Struktur Organisasi";
    $model = new KPOrganigramM;
    $model->tgl_awal = date('Y-m-d', strtotime("first day of january"));
    $model->tgl_akhir = date('Y-m-t');

    if (isset($_GET['KPOrganigramM'])) {
      $model->attributes = $_GET['KPOrganigramM'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPOrganigramM']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPOrganigramM']['tgl_akhir']);
      $model->nama_pegawai = $_GET['KPOrganigramM']['nama_pegawai'];
      $model->nomorindukpegawai = $_GET['KPOrganigramM']['nomorindukpegawai'];
    }

    $this->render('index', array('model' => $model));
  }

  public function actionPrint()
  {
    $this->layout = '//layouts/iframe';
    if (isset($_GET['caraPrint'])) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframePolos';
    }

    $criteria = new CDbCriteria();
    $criteria->addCondition("organigram_aktif = TRUE");
    $criteria->order = "organigram_id ASC";
    $organigram = KPOrganigramM::model()->findAll($criteria);

    $modOrgAsal = array();
    foreach ($organigram as $asal) {
      if (!empty($asal->organigramasal_id)) {
        $modOrgAsal["$asal->organigramasal_id"]['organigram_unitkerja'] = $asal->organigramasal->organigram_unitkerja;
        $modOrgAsal["$asal->organigramasal_id"]['pegawai_id'] = $asal->organigramasal->pegawai_id;
        $modOrgAsal["$asal->organigramasal_id"]['nama_pegawai'] = $asal->organigramasal->pegawai->namaLengkap;
        $modOrgAsal["$asal->organigramasal_id"]['organigramasal_id'] = $asal->organigramasal->organigramasal_id;
        $modOrgAsal["$asal->organigramasal_id"]['organigram_id'] = $asal->organigramasal->organigram_id;
      }
    }

    $modOrg = array();
    foreach ($organigram as $org) {
      if (!isset($modOrgAsal["$org->organigram_id"])) {
        $unit_org = $org->organigram_unitkerja . '-' . $org->organigramasal_id;
        $modOrg["$unit_org"]['organigram_unitkerja'] = $org->organigram_unitkerja;
        $modOrg["$unit_org"]['organigramasal_id'] = $org->organigramasal_id;
        $modOrg["$unit_org"]['det']["$org->organigram_id"]['organigram_id'] = $org->organigram_id;
        $modOrg["$unit_org"]['det']["$org->organigram_id"]['pegawai_id'] = $org->pegawai_id;
        $modOrg["$unit_org"]['det']["$org->organigram_id"]['nama_pegawai'] = $org->pegawai->namaLengkap;
      }
    }

    $this->render('organigramBaru', array(
      'modOrganigrams' => $organigram,
      'modOrg' => $modOrg,
      'modOrgAsal' => $modOrgAsal,
    ));
  }
}
