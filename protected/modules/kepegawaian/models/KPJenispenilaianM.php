<?php

/**
 * This is the model class for table "jenispenilaian_m".
 *
 * The followings are the available columns in table 'jenispenilaian_m':
 * @property integer $jenispenilaian_id
 * @property integer $jabatan_id
 * @property string $jenispenilaian_nama
 * @property string $jenispenilaian_namalain
 * @property string $jenispenilaian_sifat
 * @property boolean $jenispenilaian_aktif
 */
class KPJenispenilaianM extends JenispenilaianM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispenilaianM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getJenisPenilaianItems()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('jenispenilaian_aktif = true');
		$criteria->order = "jenispenilaian_nama";
		return self::model()->findAll($criteria);
	}
	
}