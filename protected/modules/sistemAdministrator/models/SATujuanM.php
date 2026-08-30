<?php

/**
 * Model untuk Master tujuan di Sistem Administrator
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage models
 * @category model
 */
class SATujuanM extends TujuanM {

    public $diagnosakep_nama, $aktif, $luarankeperawatan_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TujuanM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->with = array('luarankeperawatan');
        $criteria->compare('t.tujuan_id', $this->tujuan_id);
//		$criteria->compare('t.diagnosakep_id', $this->diagnosakep_id, true);
        $criteria->compare('LOWER(luarankeperawatan.luarankeperawatan_nama)', strtolower($this->luarankeperawatan_nama), true);
        $criteria->compare('LOWER(t.tujuan_nama)', strtolower($this->tujuan_nama), true);
        $criteria->compare('t.tujuan_aktif',isset($this->tujuan_aktif)?$this->tujuan_aktif:true);
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
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * search pada print
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}
