<?php

/**
 * This is the model class for table "rakpenyimpanan_m".
 *
 * The followings are the available columns in table 'rakpenyimpanan_m':
 * @property integer $rakpenyimpanan_id
 * @property integer $lokasipenyimpanan_id
 * @property string $rakpenyimpanan_label
 * @property string $rakpenyimpanan_kode
 * @property string $rakpenyimpanan_nama
 * @property string $rakpenyimpanan_namalain
 * @property boolean $rakpenyimpanan_aktif
 */
class SARakpenyimpananM extends RakpenyimpananM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RakpenyimpananM the static model class
	 */
	public $lokasipenyimpanan_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getLokasipenyimpananItems()
		{
			 return LokasipenyimpananM::model()->findAll('lokasipenyimpanan_aktif=TRUE ORDER BY lokasipenyimpanan_nama');
		}
}