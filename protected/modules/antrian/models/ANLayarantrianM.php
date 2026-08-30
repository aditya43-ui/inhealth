<?php

/**
 * This is the model class for table "layarantrian_m".
 *
 * The followings are the available columns in table 'layarantrian_m':
 * @property integer $layarantrian_id
 * @property string $layarantrian_jenis
 * @property string $layarantrian_nama
 * @property string $layarantrian_judul
 * @property string $layarantrian_runningtext
 * @property string $layarantrian_latarbelakang
 * @property integer $layarantrian_maksitem
 * @property integer $layarantrian_itemhigh
 * @property integer $layarantrian_itemwidth
 * @property integer $layarantrian_intrefresh
 * @property boolean $layarantrian_aktif
 *
 * The followings are the available model relations:
 * @property RuanganM[] $ruanganMs
 */
class ANLayarantrianM extends LayarantrianM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LayarantrianM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}