<?php

/**
 * Model untuk Master tanda gejala di Sistem Administrator
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage models
 * @category model
 */
class SATandagejalaM extends TandagejalaM {

    public $diagnosakep_nama, $diagnosakep_id, $aktif, $tandagejaladet_aktif, $kelompoktandagejala, $subkelompoktandagejala, $tandagejaladet_id;
    public $jenistandagejala_id, $jenistandagejala_nama, $subjenistandagejala_nama, $tandagejala_daftar_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tandagejala_id' => 'ID',
            'diagnosakep_id' => 'Diagnosa Keperawatan',
            'tandagejala_indikator' => 'Indikator',
            'tandagejala_aktif' => 'Aktif',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

//        if (!empty($this->diagnosakep_id)) {
//            $criteria->addCondition('t.diagnosakep_id = ' . $this->diagnosakep_id);
//        }
        $criteria->compare('tandagejala_aktif', isset($this->tandagejala_aktif) ? $this->tandagejala_aktif : true);
        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->select = 't.*, diagnosakep_m.diagnosakep_nama, kelompoktandagejaladaftar_m.jenistandagejala_id, tandagejala_daftar_m.tandagejala_daftar_nama, jenistandagejala_m.jenistandagejala_nama, jenistandagejala_m.subjenistandagejala_nama';
        $criteria->join = 'LEFT JOIN kelompoktandagejaladaftar_m ON kelompoktandagejaladaftar_m.kelompoktandagejaladaftar_id = t.kelompoktandagejaladaftar_id '
                        . 'LEFT JOIN tandagejala_daftar_m ON tandagejala_daftar_m.tandagejala_daftar_id = kelompoktandagejaladaftar_m.tandagejala_daftar_id '
                        . 'LEFT JOIN jenistandagejala_m ON jenistandagejala_m.jenistandagejala_id = kelompoktandagejaladaftar_m.jenistandagejala_id '
                        . 'LEFT JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = t.diagnosakep_id';
        if (!empty($this->jenistandagejala_id)) {
            $criteria->addCondition('kelompoktandagejaladaftar_m.jenistandagejala_id = ' . $this->jenistandagejala_id);
        }
        $criteria->compare('LOWER(tandagejala_daftar_m.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        $criteria->compare('LOWER(diagnosakep_m.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->select = 't.*, diagnosakep_m.diagnosakep_nama, kelompoktandagejaladaftar_m.jenistandagejala_id, tandagejala_daftar_m.tandagejala_daftar_nama, jenistandagejala_m.jenistandagejala_nama, jenistandagejala_m.subjenistandagejala_nama';
        $criteria->join = 'LEFT JOIN kelompoktandagejaladaftar_m ON kelompoktandagejaladaftar_m.kelompoktandagejaladaftar_id = t.kelompoktandagejaladaftar_id '
                        . 'LEFT JOIN tandagejala_daftar_m ON tandagejala_daftar_m.tandagejala_daftar_id = kelompoktandagejaladaftar_m.tandagejala_daftar_id '
                        . 'LEFT JOIN jenistandagejala_m ON jenistandagejala_m.jenistandagejala_id = kelompoktandagejaladaftar_m.jenistandagejala_id '
                        . 'LEFT JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = t.diagnosakep_id';
        if (!empty($this->jenistandagejala_id)) {
            $criteria->addCondition('kelompoktandagejaladaftar_m.jenistandagejala_id = ' . $this->jenistandagejala_id);
        }
        $criteria->compare('LOWER(tandagejala_daftar_m.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        $criteria->compare('LOWER(diagnosakep_m.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
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

?>