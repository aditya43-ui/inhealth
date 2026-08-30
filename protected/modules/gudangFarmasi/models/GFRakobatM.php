<?php

/**
 * This is the model class for table "rakobat_m".
 *
 * The followings are the available columns in table 'rakobat_m':
 * @property integer $rakobat_id
 * @property string $rakobat_nama
 * @property string $rakobat_namalain
 * @property string $rakobat_label
 * @property boolean $rakobat_aktif
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class GFRakobatM extends RakobatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RakobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getRakObatItems()
    {
		return RakobatM::model()->findAll("rakobat_aktif=TRUE");
    }
}