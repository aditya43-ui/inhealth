<?php

/**
 * This is the model class for table "kompetensi_m".
 *
 * The followings are the available columns in table 'kompetensi_m':
 * @property integer $kompetensi_id
 * @property string $kompetensi_nama
 * @property string $kompetensi_namalain
 * @property boolean $kompetensi_aktif
 */
class SAKompetensiM extends KompetensiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KompetensiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getKompetensiItems()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('kompetensi_aktif = true');
		$criteria->order = "kompetensi_nama";
		return self::model()->findAll($criteria);
	}
}