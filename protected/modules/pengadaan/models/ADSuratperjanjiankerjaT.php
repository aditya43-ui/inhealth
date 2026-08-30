<?php

/**
 * Extend model dari tabel "suratperjanjiankerja_t".
 *
 * @author Andyka Putra <andykaputra@.com>
 * @author Andyka Putra <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
class ADSuratperjanjiankerjaT extends SuratperjanjiankerjaT {

    public $tanggal_awal, $tanggal_akhir;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SuratperjanjiankerjaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian pada informasi spk
     * Filter berdasarkan suratperjanjiankerjaasal_id is null untuk menampilkan SPK utama 
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->select = 't.*, supplier_m.supplier_nama';
        $criteria->join = 'LEFT JOIN supplier_m ON supplier_m.supplier_id = t.supplier_id';
        $criteria->addBetweenCondition('DATE(tglsuratperjanjian)',$this->tanggal_awal,$this->tanggal_akhir,true);
        $criteria->compare('LOWER(namapekerjaan)', strtolower($this->namapekerjaan), true);
        $criteria->compare('LOWER(nosuratperjanjiankerja)', strtolower($this->nosuratperjanjiankerja), true);
        $criteria->compare('LOWER(nomor_dokumen)', strtolower($this->nomor_dokumen), true);
        $criteria->compare('LOWER(supplier_m.supplier_nama)', strtolower($this->supplier_nama), true);
        $criteria->addCondition('suratperjanjiankerjaasal_id is null and pejabatpembuatkomitmen_id = '.Yii::app()->user->getState('pegawai_id'));
        
        $criteria->order = "tglsuratperjanjian desc";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian pada informasi spk (print)
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, supplier_m.supplier_nama';
        $criteria->join = 'LEFT JOIN supplier_m ON supplier_m.supplier_id = t.supplier_id';
        $criteria->addBetweenCondition('DATE(tglsuratperjanjian)',$this->tanggal_awal,$this->tanggal_akhir,true);
        $criteria->compare('LOWER(namapekerjaan)', strtolower($this->namapekerjaan), true);
        $criteria->compare('LOWER(nosuratperjanjiankerja)', strtolower($this->nosuratperjanjiankerja), true);
        $criteria->compare('LOWER(nomor_dokumen)', strtolower($this->nomor_dokumen), true);
        $criteria->compare('LOWER(supplier_m.supplier_nama)', strtolower($this->supplier_nama), true);
        $criteria->addCondition('suratperjanjiankerjaasal_id is null and pejabatpembuatkomitmen_id = '.Yii::app()->user->getState('pegawai_id'));
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }
}
