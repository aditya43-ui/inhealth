<?php

/**
 * This is the model class for table "detailhasilpemeriksaanlab_t".
 *
 * The followings are the available columns in table 'detailhasilpemeriksaanlab_t':
 * @property integer $detailhasilpemeriksaanlab_id
 * @property integer $hasilpemeriksaanlab_id
 * @property integer $pemeriksaanlab_id
 * @property string $hasilpemeriksaan
 * @property string $nilairujukan
 * @property string $hasilpemeriksaan_satuan
 * @property string $hasilpemeriksaan_metode
 */
class BKDetailHasilPemeriksaanLabT extends DetailhasilpemeriksaanlabT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetailhasilpemeriksaanlabT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}