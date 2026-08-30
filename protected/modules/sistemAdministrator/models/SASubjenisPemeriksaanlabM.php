<?php

/**
 * This is the model class for table "subjenis_pemeriksaanlab_m".
 *
 * The followings are the available columns in table 'subjenis_pemeriksaanlab_m':
 * @property integer $subjenis_pl_nama
 * @property integer $subjenis_pl_lainnya
 * @property boolean $subjenis_aktif
 */
class SASubjenisPemeriksaanlabM extends SubjenisPemeriksaanlabM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubjenisPemeriksaanlabM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}