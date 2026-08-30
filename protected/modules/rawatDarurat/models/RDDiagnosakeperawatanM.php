<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RDDiagnosakeperawatanM extends DiagnosakeperawatanM
{
    public $diagnosa_nama;
    public $diagnosakeperawatan_kode;
    public $kriteriahasil_nama;
    public $kriteriahasil_id;
    public $diagnosakeperawatan_medis;
        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return DiagnosatindakanM the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
        public function searchPrint()
                {
                        // Warning: Please modify the following code to remove attributes that
                        // should not be searched.

                        $criteria=new CDbCriteria;
						
						if(!empty($this->diagnosakeperawatan_id)){
							$criteria->addCondition("diagnosakeperawatan_id = ".$this->diagnosakeperawatan_id);				
						}
                        $criteria->compare('LOWER(diagnosakeperawatan_kode)',strtolower($this->diagnosakeperawatan_kode),true);
                        $criteria->compare('LOWER(diagnosa_medis)',strtolower($this->diagnosa_medis),true);
                        $criteria->compare('LOWER(diagnosa_keperawatan)',strtolower($this->diagnosa_keperawatan),true);
                        $criteria->compare('LOWER(diagnosa_tujuan)',strtolower($this->diagnosa_tujuan),true);
                        $criteria->compare('diagnosa_keperawatan_aktif',isset($this->diagnosa_keperawatan_aktif)?$this->diagnosa_keperawatan_aktif:true);
                        $criteria->compare('LOWER(diagnosa.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
        //                $criteria->addCondition('diagnosa_keperawatan_aktif is true');
                        $criteria->with=array('diagnosa');
                        $criteria->limit=-1; 

                        return new CActiveDataProvider($this, array(
                                'criteria'=>$criteria,
                                'pagination'=>false,
                        ));
                }
}

?>
