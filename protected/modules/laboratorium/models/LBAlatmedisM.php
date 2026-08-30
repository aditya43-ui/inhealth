<?php

class LBAlatmedisM extends AlatmedisM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlatmedisM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * menampilkan semua data alat medis khusus lab
	 * @return type
	 */
	public static function getAlatLabItems()
	{
		return self::model()->findAll('alatmedis_aktif=TRUE AND instalasi_id ='.Params::INSTALASI_ID_LAB.'ORDER BY alatmedis_nama');
	}

}