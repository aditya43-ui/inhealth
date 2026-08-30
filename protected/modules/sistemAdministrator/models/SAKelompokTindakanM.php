<?php
/**
 * This is the model class for table "kelompoktindakan_m".
 *
 * The followings are the available columns in table 'kelompoktindakan_m':
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property string $kelompoktindakan_namalainnya
 * @property integer $kelompoktindakan_persencyto
 * @property integer $kelompoktindakan_urutan
 * @property boolean $kelompoktindakan_aktif
 */
class SAKelompokTindakanM extends KelompoktindakanM
{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompoktindakanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("kelompoktindakan_aktif = TRUE");
		$criteria->order = "kelompoktindakan_nama ASC";
		
		return self::model()->findAll($criteria);
	}
}
