<?php

/**
 * Model tabel penerimaandarahpmi_t pada module bank darah.
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDPenerimaandarahpmiT extends PenerimaandarahpmiT {

    public $petugas_penerima_nama, $petugas_mengetahui_nama;
    public $tgl_awal, $tgl_akhir;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenerimaandarahpmiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian data dialog untuk detail penerimaan
     * @return \CActiveDataProvider
     */
    public function searchDialogDetail() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->join = 'left join pegawai_m penerima on penerima.pegawai_id = t.petugas_penerima_id '
                . 'left join pegawai_m mengetahui on mengetahui.pegawai_id = t.petugas_mengetahui_id';
        $criteria->compare('penerimaandarahpmi_id', $this->penerimaandarahpmi_id);
        $criteria->compare('permintaandarahpmi_id', $this->permintaandarahpmi_id);
        $criteria->compare('petugas_penerima_id', $this->petugas_penerima_id);
        $criteria->compare('petugas_mengetahui_id', $this->petugas_mengetahui_id);
        $criteria->compare('tgl_penerimaan', $this->tgl_penerimaan, true);
        $criteria->compare('no_penerimaan', $this->no_penerimaan, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('lower(penerima.nama_pegawai)', strtolower($this->petugas_penerima_nama), true);
        $criteria->compare('lower(mengetahui.nama_pegawai)', strtolower($this->petugas_mengetahui_nama), true);
        $criteria->addCondition('is_detailpenerimaan IS FALSE');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Pencarian informasi penerimaan darah PMI
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition('DATE(tgl_penerimaan)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->join = 'left join pegawai_m penerima on penerima.pegawai_id = t.petugas_penerima_id '
                . 'left join pegawai_m mengetahui on mengetahui.pegawai_id = t.petugas_mengetahui_id';
        $criteria->compare('penerimaandarahpmi_id', $this->penerimaandarahpmi_id);
        $criteria->compare('permintaandarahpmi_id', $this->permintaandarahpmi_id);
        $criteria->compare('petugas_penerima_id', $this->petugas_penerima_id);
        $criteria->compare('petugas_mengetahui_id', $this->petugas_mengetahui_id);
        $criteria->compare('no_penerimaan', $this->no_penerimaan, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('lower(penerima.nama_pegawai)', strtolower($this->petugas_penerima_nama), true);
        $criteria->compare('lower(mengetahui.nama_pegawai)', strtolower($this->petugas_mengetahui_nama), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
