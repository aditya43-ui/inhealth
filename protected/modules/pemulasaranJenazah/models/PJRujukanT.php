<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class PJRujukanT extends RujukanT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
         * Mengambil daftar semua asalrujukan
         * @return CActiveDataProvider 
    */
    public static function getAsalRujukanItems()
    {
        return AsalrujukanM::model()->findAllByAttributes(array('asalrujukan_aktif'=>true),array('order'=>'asalrujukan_nama'));
    }
    
    /**
     * Mengambil daftar semua kabupaten berdasarkan propinsi
     * @return CActiveDataProvider 
     */
    public function getRujukanDariItems($asalrujukan_id=null)
    {
        if(!empty($asalrujukan_id))
            return RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id,),array('order'=>'namaperujuk'));
        else {
            return array();
        }
    }
}
?>
