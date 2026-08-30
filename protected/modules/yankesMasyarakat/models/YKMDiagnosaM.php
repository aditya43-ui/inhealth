<?php
/**
 * Load data diagnosa untuk modul pelayanan kesehatan masyarakat
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 * @category model
 */
class YKMDiagnosaM extends DiagnosaM{
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosaM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * Load data dialog
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

