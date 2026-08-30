<?php
Yii::import('rawatJalan.controllers.SurveilansTController');
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.views.*');
/**
 * digunakan untuk transaksi surveilans tab pemeriksaan pasien
 * @author      Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package     application.modules.bedahSentral
 * @subpackage  controllers
 */
class SurveilansTBSController extends SurveilansTController
{
  /**
   * Pencarian Pasien Penunjang untuk transaksi Surveilance.
   * 
   * @param  RJPendaftaranT $model
   * @param  boolean $pagination
   * @return \CActiveDataProvider
   */
  public function searchPasien($model, $pagination = true)
  {
    $this->pageTitle = Yii::app()->name . " - Surveilans";
    $criteria = new CDbCriteria();
    $criteria->join = 'left join pasienpulang_t p on p.pendaftaran_id = t.pendaftaran_id and p.carakeluar_id <> 5 and p.pasienbatalpulang_id is null '
      . 'left join pasienadmisi_t a on a.pasienadmisi_id = t.pasienadmisi_id '
      . 'left join pasien_m pa on pa.pasien_id = t.pasien_id '
      . 'join (select pendaftaran_id, ruangan_id from pasienmasukpenunjang_v group by pendaftaran_id, ruangan_id) r on r.pendaftaran_id = t.pendaftaran_id';
    $criteria->compare('lower(t.no_pendaftaran)', strtolower($model->no_pendaftaran), true);
    $criteria->compare('lower(pa.nama_pasien)', strtolower($model->nama_pasien), true);
    $criteria->compare('lower(pa.jeniskelamin)', strtolower($model->jeniskelamin), true);
    $criteria->compare('lower(pa.no_rekam_medik)', strtolower($model->no_rekam_medik), true);
    // $criteria->addCondition('p.pasienpulang_id is null');

    $criteria->order = 't.tgl_pendaftaran desc';
    $criteria->addCondition("t.statusperiksa not in ('SUDAH PULANG')");
    $criteria->compare('r.ruangan_id', Yii::app()->user->getState('ruangan_id'));

    $prov = new CActiveDataProvider($model, array(
      'criteria' => $criteria,
    ));

    if (!$pagination) {
      $prov->pagination = false;
    }

    return $prov;
  }
}
