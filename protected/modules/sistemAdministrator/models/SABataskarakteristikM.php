<?php

/**
 * Model untuk BataskarakteristikM di Sistem Administrator
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage models
 * @category model
 */
class SABataskarakteristikM extends BataskarakteristikM {

    public $bataskarakteristikdet_indikator, $diagnosakep_nama, $bataskarakteristikdet_aktif, $bataskarakteristikdet_id, $bataskarakteristikdet;
    public $faktorpenyebab_daftar_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
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
        $criteria->select = 'bataskarakteristik_m.*,bataskarakteristikdetMs.*';
        $criteria->with = array('bataskarakteristikdetMs', 'diagnosakep');
        $criteria->compare('bataskarakteristik_id', $this->bataskarakteristik_id);
        $criteria->compare('diagnosakep_id', $this->diagnosakep_id, true);
        $criteria->compare('LOWER(diagnosakep.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
        $criteria->compare('LOWER(bataskarakteristik_m.bataskarakteristi_nama)', strtolower($this->bataskarakteristi_nama), true);
        $criteria->compare('bataskarakteristikdet_id', $this->bataskarakteristikdet_id, true);
        $criteria->compare('LOWER(bataskarakteristikdetMs.bataskarakteristikdet_indikator)', strtolower($this->bataskarakteristikdet_indikator), true);
        $criteria->compare('bataskarakteristikdetMs.bataskarakteristikdet_aktif', $this->bataskarakteristikdet_aktif);

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
        //  $sort=new CSort();
        //$sort->attributes = array(
        //  'varSort1' => array(
        //    'asc' => "",
        //  'desc' => "tabularlist_chapter DESC, dtd_kode ASC, klasifikasidiagnosa_kode ASC, klasifikasidiagnosa_nama ASC, diagnosa_kode ASC, diagnosa_nama ASC, diagnosa_katakunci ASC"
        // ),
        //);
        // $sort->defaultOrder = array(
        //   'varSort1' => false
        //);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                // 'sort'=>$sort,
        ));
    }

    /**
     * Digunakan untuk pencarian master
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

?>
