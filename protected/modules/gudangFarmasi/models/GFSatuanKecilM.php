<?php

/**
 * This is the model class for table "satuankecil_m".
 *
 * The followings are the available columns in table 'satuankecil_m':
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property string $satuankecil_namalain
 * @property boolean $satuankecil_aktif
 */
class GFSatuanKecilM extends SatuankecilM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SatuankecilM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getItems(){
		$loadData = self::model()->findAll("satuankecil_aktif = TRUE");
		if(count((array)$loadData) > 0){
			return $loadData;
		}else{
			return array();
		}
	}


}