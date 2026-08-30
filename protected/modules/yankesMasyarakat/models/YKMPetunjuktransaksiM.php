<?php
/**
 * Model untuk petunjuktransaksi_m di modul pelayanan kesehatan masyarakat 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 * @category model
 */
class YKMPetunjuktransaksiM extends PetunjuktransaksiM {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosaM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * menampilkan semua petunjuktransaksi_type
     * @return models
     */
    public static function getAllPetunjuk() {
        $criteria = new CDbCriteria();
        $criteria->order = "petunjuktransaksi_type";
        $criteria->addCondition("petunjuktransaksi_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        return $models;
    }

}
