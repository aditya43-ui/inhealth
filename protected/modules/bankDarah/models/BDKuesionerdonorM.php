<?php

/**
 * This is the model class for table "kuesionerdonor_m".
 *
 * The followings are the available columns in table 'kuesionerdonor_m':
 * @property integer $kuesionerdonor_id
 * @property integer $kuesioner_urutan
 * @property string $kuesioner_desc
 * @property boolean $kuesioner_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SeleksikuesionerT[] $seleksikuesionerTs
 */
class BDKuesionerdonorM extends KuesionerdonorM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KuesionerdonorM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}