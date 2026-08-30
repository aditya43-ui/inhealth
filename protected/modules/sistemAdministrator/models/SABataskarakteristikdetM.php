<?php

/**
 * Model untuk BataskarakteristikdetM di Sistem Administrator
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage models
 * @category model
 */
class SABataskarakteristikdetM extends BataskarakteristikdetM {

    public $bataskarakteristik_nama, $diagnosakep_id, $diagnosakep_nama, $aktif;

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
            'bataskarakteristikdet_id' => 'ID',
            'bataskarakteristik_id' => 'Batas Karakteristik',
            'bataskarakteristikdet_indikator' => 'Indikator',
            'bataskarakteristikdet_aktif' => 'Aktif',
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
        $criteria->select = 'bataskarakteristik.*,t.*,diagnosakep.*';
//		$criteria->with = array('bataskarakteristik');
        $criteria->join = 'JOIN bataskarakteristik_m AS bataskarakteristik ON bataskarakteristik.bataskarakteristik_id = t.bataskarakteristik_id';
        $criteria->join .= ' JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = bataskarakteristik.diagnosakep_id';
        $criteria->compare('bataskarakteristik.bataskarakteristik_id', $this->bataskarakteristik_id);
        $criteria->compare('bataskarakteristik.diagnosakep_id', $this->diagnosakep_id, true);
        $criteria->compare('LOWER(diagnosakep.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
        $criteria->compare('LOWER(bataskarakteristik.bataskarakteristik_nama)', strtolower($this->bataskarakteristik_nama), true);
        $criteria->compare('bataskarakteristikdet_id', $this->bataskarakteristikdet_id, true);
        $criteria->compare('LOWER(bataskarakteristikdet_indikator)', strtolower($this->bataskarakteristikdet_indikator), true);
        $criteria->compare('bataskarakteristikdet_aktif', $this->bataskarakteristikdet_aktif);
        $criteria->compare('faktorpenyebab_daftar_id',$this->faktorpenyebab_daftar_id);

        if ($this->aktif != NULL) {

            if ($this->aktif == 1) {
                $criteria->addCondition('t.bataskarakteristikdet_aktif = TRUE');
            }
            if ($this->aktif == 0) {
                $criteria->addCondition('t.bataskarakteristikdet_aktif = FALSE');
            }
        }
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
        $sort = new CSort();
        $sort->attributes = array(
            'varSort1' => array(
                'asc' => "bataskarakteristik.bataskarakteristik_nama asc",
                'desc' => "bataskarakteristik.bataskarakteristik_nama desc"
            ),
        );

        $sort->defaultOrder = array(
            'varSort1' => false
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    /**
     * Pencarian master penyebab
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

    /**
     * untuk emndapatkan data faktor penyebab
     * @return type
     */
    public function getFaktorPenyebabItems() {
        return FaktorpenyebabDaftarM::model()->findAll('faktorpenyebab_daftar_aktif=TRUE ORDER BY faktorpenyebab_daftar_nama');
    }

}

?>
