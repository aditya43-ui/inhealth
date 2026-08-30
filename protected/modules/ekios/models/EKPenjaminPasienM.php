<?php

/**
 * This is the model class for table "penjaminpasien_m".
 *
 * The followings are the available columns in table 'penjaminpasien_m':
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property string $penjamin_nama
 * @property string $penjamin_namalainnya
 * @property boolean $penjamin_aktif
 */
class EKPenjaminPasienM extends PenjaminpasienM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EKPenjaminPasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}