<?php

/**
 * Model untuk tabel permintaandarah_t hanya untuk modul bank darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDPermintaandarahT extends PermintaandarahT {

    public $tgl_awal, $tgl_akhir, $pegpemesan_nama, $no_hp_pegpemesan, $dpjp_nama, $singkatan_komp, $jml;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PermintaandarahT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian riwayat permintaan darah
     * @return \CActiveDataProvider
     */
    public function searchRiwayagt() {

        $criteria = new CDbCriteria;
        $criteria->select = 't.pendaftaran_id, t.no_permintaandarah, t.tglpermintaan, t.permintaandarah_id, t.dpjp_id, det.singkatan_komp, count(det.jml_kantong) as jml';
        $criteria->join = 'LEFT JOIN permintaandarahdet_t as det ON t.permintaandarah_id = det.permintaandarah_id';
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->group = 't.pendaftaran_id, t.no_permintaandarah, t.tglpermintaan, t.permintaandarah_id, det.singkatan_komp';
        $criteria->order = ('t.tglpermintaan DESC');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}
