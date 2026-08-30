<?php
/**
 * Model untuk tabel faktorrisiko_daftar_m pada module asuhan keperawatan
 * 
 * @author M Iqbal Laksana <iqballaksana@.com>
 * @subpackage application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASFaktorrisikoDaftarM extends FaktorrisikoDaftarM 
{       
    public $faktorrisikodet_indikator, $faktorrisikodet_id, $diagnosakep_kode, $diagnosakep_nama;
    public $jenisfaktorrisiko_nama, $faktorrisiko_id, $kelompokfaktorrisikodaftar_id;
    public $jenisfaktorrisiko_id;
    public $no;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FaktorrisikoDaftarM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    } 
    
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialog() {

        $criteria = new CDbCriteria;
        $criteria->select = 'faktorrisiko.*, det.faktorrisikodet_indikator, det.faktorrisikodet_id, t.faktorrisiko_daftar_nama, diagnosakep.diagnosakep_nama';
        $criteria->join = 'JOIN faktorrisikodet_m det ON det.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id '
                        . 'JOIN faktorrisiko_m faktorrisiko ON faktorrisiko.faktorrisiko_id = det.faktorrisiko_id '
                        . 'JOIN diagnosakep_m diagnosakep ON diagnosakep.diagnosakep_id = faktorrisiko.diagnosakep_id ';
        $criteria->compare('LOWER(det.faktorrisikodet_indikator)', strtolower($this->faktorrisikodet_indikator), true);
        $criteria->compare('LOWER(t.faktorrisiko_daftar_nama)', strtolower($this->faktorrisiko_daftar_nama), true);
        $criteria->compare('LOWER(diagnosakep.diagnosakep_kode)', strtolower($this->diagnosakep_kode), true);
        $criteria->compare('LOWER(diagnosakep.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
        $criteria->addCondition('t.faktorrisiko_daftar_aktif is true');
        $criteria->order = 'diagnosakep.diagnosakep_kode, diagnosakep.diagnosakep_nama, det.faktorrisikodet_indikator';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialog2() {

        $criteria = new CDbCriteria;
        $criteria->select = 'jenisfaktorrisiko.jenisfaktorrisiko_nama, t.faktorrisiko_daftar_nama, det.kelompokfaktorrisikodaftar_id';
        $criteria->join = 'JOIN kelompokfaktorrisikodaftar_m det ON det.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id '
                        . 'JOIN jenisfaktorrisiko_m jenisfaktorrisiko ON jenisfaktorrisiko.jenisfaktorrisiko_id = det.jenisfaktorrisiko_id';
        $criteria->compare('LOWER(jenisfaktorrisiko.jenisfaktorrisiko_nama)', strtolower($this->jenisfaktorrisiko_nama), true);
        $criteria->compare('LOWER(t.faktorrisiko_daftar_nama)', strtolower($this->faktorrisiko_daftar_nama), true);
        $criteria->addCondition('t.faktorrisiko_daftar_aktif is true');
        $criteria->order = 'jenisfaktorrisiko.jenisfaktorrisiko_urutan';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
