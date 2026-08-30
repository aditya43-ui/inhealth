<?php

/**
 * This is the model class for table "uraiankeluarumum_t".
 *
 * The followings are the available columns in table 'uraiankeluarumum_t':
 * @property integer $uraiankeluarumum_id
 * @property integer $pengeluaranumum_id
 * @property string $uraiantransaksi
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 */
class BKUraiankeluarumumT extends UraiankeluarumumT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UraiankeluarumumT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}