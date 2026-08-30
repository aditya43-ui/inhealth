<?php
class GJRekaptrenpengahasilansetahunV extends RekaptrenpengahasilansetahunV
{

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function getJabatanItems()
    {
        return JabatanM::model()->findAll('jabatan_aktif=TRUE ORDER BY jabatan_nama');
    }
    
    public function criteriaLaporan()
        {
                $criteria=new CDbCriteria;
                $criteria->addCondition("periodegaji = ".$this->periodegaji."");
                $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('jabatan_id',$this->jabatan_id);
                return $criteria;
        }
        
        public function searchLaporan()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteriaLaporan(),
                        'sort'=>array(
                            'defaultOrder'=>'nama_pegawai',
                        ),
                        'pagination'=>array(
                            'pageSize'=>10,
                        )
                ));
        }
        
        public function searchPrintLaporan()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteriaLaporan(),
                        'sort'=>array(
                            'defaultOrder'=>'nama_pegawai',
                        ),
                        'pagination'=>false
                ));
        }
}