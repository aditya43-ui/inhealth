<?php

/**
 * This is the model class for table "pasienpulang_t".
 *
 * The followings are the available columns in table 'pasienpulang_t':
 * @property integer $pasienpulang_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglpasienpulang
 * @property string $carakeluar_id
 * @property string $kondisikeluar_id
 * @property string $ruanganakhir_id
 * @property string $penerimapasien
 * @property integer $lamarawat
 * @property string $satuanlamarawat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PJPasienpulangT extends PasienpulangT
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
            return CarakeluarM::model()->findAllByAttributes(array('carakeluar_aktif'=>true),array('order'=>'carakeluar_nama'));
        }

        /**
        * Mengambil daftar semua kondisikeluar
        * @return CActiveDataProvider 
        */
        public function getKondisikeluarItems($carakeluar_id=null)
        {
             if(!empty($carakeluar_id))
                   return KondisiKeluarM::model()->findAllByAttributes(array('carakeluar_id'=>$carakeluar_id,'kondisikeluar_aktif'=>true),array('order'=>'kondisikeluar_nama'));
            else
                   return array();
        }
}