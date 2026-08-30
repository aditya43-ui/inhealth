<?php
/**
 * Model extend untuk indikatorimplkepdet_m
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.asuhanKeperawatan.models
 * @subpackage models
 * @category model
 */
class SAIndikatorimplkepdetM extends IndikatorimplkepdetM {

    public $diagnosakep_nama, $diagnosakep_id, $diagnosakep, $aktif, $jenistindakan, $jenisintervensi_id;

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
            'indikatorimplkepdet_id' => 'ID',
            'implementasikep_id' => 'Implementasi Keperawatan',
            'indikatorimplkepdet_indikator' => 'Indikator',
            'indikatorimplkepdet_aktif' => 'Aktif',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;
        $criteria->select = 'implementasikep.*,t.*, intv.jenisintervensi_id';
        $criteria->join = 'JOIN implementasikep_m AS implementasikep ON implementasikep.implementasikep_id = t.implementasikep_id
                           JOIN jenisintervensi_m AS intv ON intv.jenisintervensi_id = implementasikep.jenisintervensi_id';

        if (!empty($this->jenisintervensi_id)) {
            $criteria->addCondition(" intv.jenisintervensi_id = '" . $this->jenisintervensi_id . "' ");
        }

        $criteria->compare('jenistindakan', $this->jenistindakan, true);
        $criteria->compare('LOWER(indikatorimplkepdet_indikator)', strtolower($this->indikatorimplkepdet_indikator), true);
        $criteria->compare('indikatorimplkepdet_aktif', isset($this->indikatorimplkepdet_aktif) ? $this->indikatorimplkepdet_aktif : true);

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data cetak 
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}

?>
