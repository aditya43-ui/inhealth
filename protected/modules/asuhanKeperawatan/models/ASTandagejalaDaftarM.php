<?php
/**
 * Model untuk tabel TandagejalaDaftar_m pada module asuhan keperawatan
 * 
 * @author M Iqbal Laksana <iqballaksana@.com>
 * @subpackage application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASTandagejalaDaftarM extends TandagejalaDaftarM 
{       
    public $kelompoktandagejala, $subkelompoktandagejala, $tandagejala_indikator, $tandagejaladet_id, $diagnosakep_kode, $diagnosakep_nama;
    public $tandagejala_id, $kelompoktandagejaladaftar_id;
    public $jenistandagejala_nama, $subjenistandagejala_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TandagejalaDaftarM the static model class
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
        $criteria->select = 'tandagejala.*, det.tandagejala_indikator, det.tandagejaladet_id, t.tandagejala_daftar_nama, diagnosakep.diagnosakep_nama, diagnosakep.diagnosakep_kode';
        $criteria->join = 'JOIN tandagejaladet_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                        . 'JOIN tandagejala_m tandagejala ON tandagejala.tandagejala_id = det.tandagejala_id '
                        . 'JOIN diagnosakep_m diagnosakep ON diagnosakep.diagnosakep_id = tandagejala.diagnosakep_id ';
        $criteria->compare('LOWER(tandagejala.kelompoktandagejala)', strtolower($this->kelompoktandagejala), true);
        $criteria->compare('LOWER(tandagejala.subkelompoktandagejala)', strtolower($this->subkelompoktandagejala), true);
        $criteria->compare('LOWER(det.tandagejala_indikator)', strtolower($this->tandagejala_indikator), true);
        $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        $criteria->compare('LOWER(diagnosakep.diagnosakep_kode)', strtolower($this->diagnosakep_kode), true);
        $criteria->compare('LOWER(diagnosakep.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
        $criteria->addCondition('t.tandagejala_daftar_aktif is true');
        $criteria->order = 'diagnosakep.diagnosakep_kode, diagnosakep.diagnosakep_nama, tandagejala.kelompoktandagejala, tandagejala.subkelompoktandagejala, det.tandagejala_indikator';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialogMayorObjektif() {

        $criteria = new CDbCriteria;
        $criteria->select = 't.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id';
        $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                        . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id';
        $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        $criteria->addCondition('t.tandagejala_daftar_aktif is true');
        $criteria->addCondition("jenistandagejala.subjenistandagejala_nama = 'Objektif' ");
        $criteria->addCondition("jenistandagejala.jenistandagejala_nama = 'Mayor' ");
        $criteria->order = 't.tandagejala_daftar_nama';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialogMayorSubjektif() {

        $criteria = new CDbCriteria;
        $criteria->select = 't.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id';
        $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                        . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id';
        $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        $criteria->addCondition('t.tandagejala_daftar_aktif is true');
        $criteria->addCondition("jenistandagejala.subjenistandagejala_nama = 'Subjektif' ");
        $criteria->addCondition("jenistandagejala.jenistandagejala_nama = 'Mayor' ");
        $criteria->order = 't.tandagejala_daftar_nama';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialogMinorObjektif() {

        $criteria = new CDbCriteria;
        $criteria->select = 't.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id';
        $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                        . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id';
        $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        $criteria->addCondition('t.tandagejala_daftar_aktif is true');
        $criteria->addCondition("jenistandagejala.subjenistandagejala_nama = 'Objektif' ");
        $criteria->addCondition("jenistandagejala.jenistandagejala_nama = 'Minor' ");
        $criteria->order = 't.tandagejala_daftar_nama';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialogMinorSubjektif() {

        $criteria = new CDbCriteria;
        $criteria->select = 't.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id';
        $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                        . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id';
        $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        $criteria->addCondition('t.tandagejala_daftar_aktif is true');
        $criteria->addCondition("jenistandagejala.subjenistandagejala_nama = 'Subjektif' ");
        $criteria->addCondition("jenistandagejala.jenistandagejala_nama = 'Minor' ");
        $criteria->order = 't.tandagejala_daftar_nama';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
