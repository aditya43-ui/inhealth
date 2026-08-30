<?php
/**
 * Load data diagnosa untuk modul bank darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDDiagnosaM extends DiagnosaM{
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosaM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * Pencarian dialog berdasarkan diagnosa aktif
     * @return \CActiveDataProvider
     */
    public function searchDialog(){
        $cr = new CDbCriteria;
        $cr->addCondition('t.diagnosa_aktif = true');
        $cr->compare('lower(t.diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $cr->compare('lower(t.diagnosa_namalainnya)', strtolower($this->diagnosa_namalainnya), true);
        $cr->order = 't.diagnosa_nama asc';
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$cr,
        ));
    }
}
    