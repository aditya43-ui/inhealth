<?php

/**
 * This is the model class for table "lokasiobat_m".
 *
 * The followings are the available columns in table 'lokasiobat_m':
 * @property integer $lokasiobat_id
 * @property string $lokasiobat_nama
 * @property string $lokasiobat_namalain
 * @property boolean $lokasiobat_aktif
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class GFLokasiobatM extends LokasiobatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasiobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getLokasiObatItems()
    {
		return LokasiobatM::model()->findAll("lokasiobat_aktif=TRUE");
    }
}