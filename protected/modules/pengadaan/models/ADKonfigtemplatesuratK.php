<?php

/**
 * model yang digunakan untuk mengakses tabel konfigtemplatesurat
 * @package      application.modules.pengadaan
 * @subpackage   models  
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link      <http://.com>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class ADKonfigtemplatesuratK extends KonfigtemplatesuratK {

    /**
     * untuk mengenerate fungsi - fungsi active provider yii
     * @param type $className
     * @return type
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchTemplatePengadaan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = " JOIN jenissurat_m js ON js.jenissurat_id = t.jenissurat_id ";
        $criteria->addCondition('t.jenissurat_id != '.Params::JENISSURAT_TUGAS);
        $criteria->addCondition('js.modul_id = '.Params::MODUL_ID_PENGADAAN);
        $criteria->compare('t.jenissurat_id', $this->jenissurat_id);
        $criteria->compare('t.konfigtemplatesurat_id', $this->konfigtemplatesurat_id);
        $criteria->compare('t.LOWER(konfigtemplatesurat_nama)', strtolower($this->konfigtemplatesurat_nama), true);
        $criteria->compare('t.LOWER(nama_lain)', strtolower($this->nama_lain), true);
        $criteria->compare('t.LOWER(keterangan)', strtolower($this->keterangan), true);
        $criteria->compare('t.LOWER(konfigtemplatesurat_isi)', strtolower($this->konfigtemplatesurat_isi), true);
        $criteria->compare('t.konfigtemplatesurat_aktif', $this->konfigtemplatesurat_aktif);
        $criteria->compare('t.urutan', $this->urutan);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data cetak template surat
     * @return \CActiveDataProvider
     */
    public function searchPrintTemplatePengadaan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('jenissurat_id != '.Params::JENISSURAT_TUGAS);
        $criteria->compare('jenissurat_id', $this->jenissurat_id);
        $criteria->compare('konfigtemplatesurat_id', $this->konfigtemplatesurat_id);
        $criteria->compare('LOWER(konfigtemplatesurat_nama)', strtolower($this->konfigtemplatesurat_nama), true);
        $criteria->compare('LOWER(nama_lain)', strtolower($this->nama_lain), true);
        $criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
        $criteria->compare('LOWER(konfigtemplatesurat_isi)', strtolower($this->konfigtemplatesurat_isi), true);
        $criteria->compare('konfigtemplatesurat_aktif', $this->konfigtemplatesurat_aktif);
        $criteria->compare('urutan', $this->urutan);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }

}
