<?php

/**
 * This is the model class for table "jenistarif_m".
 *
 * The followings are the available columns in table 'jenistarif_m':
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property string $jenistarif_namalainnya
 * @property boolean $jenistarif_aktif
 */
class SAJenisTarifM extends JenistarifM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
