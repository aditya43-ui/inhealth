<?php

/**
 * Model extend untuk kelompoktandagejaladaftar_m
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASKelompoktandagejaladaftarM extends KelompoktandagejaladaftarM {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompoktandagejaladaftarM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Master kelompok tandagejala
     * @return \CActiveDataProvider
     */
    public function searchTandaGejala() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, daftar.tandagejala_daftar_nama';
        $criteria->join = 'JOIN tandagejala_daftar_m as daftar ON t.tandagejala_daftar_id = daftar.tandagejala_daftar_id ';
        $criteria->compare('LOWER(daftar.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        if (!empty($this->jenistandagejala_id)) {
            $criteria->addCondition('t.jenistandagejala_id = ' . $this->jenistandagejala_id);
        }
        $criteria->compare('jenistandagejaladaftar_aktif',isset($this->jenistandagejaladaftar_aktif)?$this->jenistandagejaladaftar_aktif:true);
        $criteria->order = 't.kelompoktandagejaladaftar_id DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Master kelompok tandagejala
     * @return \CActiveDataProvider
     */
    public function searchTandaGejalaPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, daftar.tandagejala_daftar_nama';
        $criteria->join = 'JOIN tandagejala_daftar_m as daftar ON t.tandagejala_daftar_id = daftar.tandagejala_daftar_id ';
        $criteria->compare('LOWER(daftar.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        if (!empty($this->jenistandagejala_id)) {
            $criteria->addCondition('t.jenistandagejala_id = ' . $this->jenistandagejala_id);
        }
        $criteria->compare('jenistandagejaladaftar_aktif',isset($this->jenistandagejaladaftar_aktif)?$this->jenistandagejaladaftar_aktif:true);
        $criteria->order = 't.kelompoktandagejaladaftar_id DESC';
        $criteria->limit = -1;
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Set data dropdown jenis tanda gejala
     * @return array $data option untuk dropdown
     */
    public static function getDropDownJenis() {
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "jenistandagejala_nama ASC";
        $models = JenistandagejalaM::model()->findAll($criteria);
        if (count($models) > 0) {
            foreach ($models as $model) {
                $data[$model->jenistandagejala_id] = $model->jenistandagejala_nama . " - " . $model->subjenistandagejala_nama;
            }
        }
        return $data;
    }

}
