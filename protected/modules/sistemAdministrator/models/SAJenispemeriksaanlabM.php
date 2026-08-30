<?php

/**
 * This is the model class for table "jenispemeriksaanlab_m".
 *
 * The followings are the available columns in table 'jenispemeriksaanlab_m':
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_kode
 * @property integer $jenispemeriksaanlab_urutan
 * @property string $jenispemeriksaanlab_nama
 * @property string $jenispemeriksaanlab_namalainnya
 * @property string $jenispemeriksaanlab_kelompok
 * @property boolean $jenispemeriksaanlab_aktif
 */
class SAJenispemeriksaanlabM extends JenispemeriksaanlabM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispemeriksaanlabM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}