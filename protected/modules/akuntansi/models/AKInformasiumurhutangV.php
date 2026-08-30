<?php
class AKInformasiumurhutangV extends InformasiumurhutangV
{
    public $tgl_awal, $tgl_akhir;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchInformasi()
    {
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition("date(tglfaktur)", $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->supplier_id)){
            $criteria->addCondition("supplier_id = ".$this->supplier_id);
        }

        $criteria->addCondition("syaratbayar_id = ".Params::SYARAT_CARABAYAR_KREDIT);
        $criteria->compare("LOWER(nofaktur)", strtolower($this->nofaktur), TRUE);
        $criteria->compare("LOWER(supplier_nama)", strtolower($this->supplier_nama), TRUE);
        $criteria->addCondition('sisa > 0');
        $criteria->order = "tglfaktur DESC";
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}

?>