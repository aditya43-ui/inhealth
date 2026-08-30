<?php
/**
* model yang digunakan untuk mengakses tabel Rencanaumumpengadaandet_t, pada modul pengadaan
* @package      application.modules.pengadaan
* @subpackage   models  
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @link      <http://piindonesia.co.id>
* @link      <http://172.9.1.15/simpp/docs/>
*/
class ADRencanaumumpengadaandetT extends RencanaumumpengadaandetT
{
    /**
     * untuk mengenerate fungsi - fungsi active provider yii
     * @param type $className
     * @return type
     */    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }    
    
    public function searchDialogNotaDinasPPTK(){
        $criteria = new CDbCriteria();
        
        if (!empty($this->rencanaumumpengadaan_id)) {
            $criteria->addCondition('rencanaumumpengadaan_id = '.$this->rencanaumumpengadaan_id);
        } else {
            $criteria->addCondition('rencanaumumpengadaan_id is null');
        }
        
        $criteria->compare('lower(rencanaumumpengadaandet_nama)', strtolower($this->rencanaumumpengadaandet_nama),true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}