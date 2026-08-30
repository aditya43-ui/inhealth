<?php

class RDPasienPulangT extends PasienpulangT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienpulangT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
    * Mengambil daftar semua carakeluar_m
    * @return CActiveDataProvider 
    */
    public function getCarakeluarItems()
    {
        return CarakeluarM::model()->findAllByAttributes(array('carakeluar_aktif'=>true),array('order'=>'carakeluar_nama ASC'));
    }

    /**
    * Mengambil daftar semua kondisikeluar
    * @return CActiveDataProvider 
    */
    public function getKondisikeluarItems($carakeluar_id=null)
    {
         if(!empty($carakeluar_id))
               return KondisiKeluarM::model()->findAllByAttributes(array('carakeluar_id'=>$carakeluar_id,'kondisikeluar_aktif'=>true),array('order'=>'kondisikeluar_nama ASC'));
        else
               return array();
    }
}
?>
