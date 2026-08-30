<?php

class SAPeralatansterilisasiM extends PeralatansterilisasiM
{
     public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchDialogBarang()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->addCondition("jenisperalatan = '".Params::JENIS_PERALATAN_BARANG."'");
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchDialogLinen()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->addCondition("jenisperalatan = '".Params::JENIS_PERALATAN_LINEN."'");
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchDialogAlatMedis()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->addCondition("jenisperalatan = '".Params::JENIS_PERALATAN_ALATMEDIS."'");
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}