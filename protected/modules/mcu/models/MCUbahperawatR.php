<?php
/**
 * -digunkanakan untuk meload data di tabel ubahperawat_r
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 */
class MCUbahperawatR extends UbahperawatR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbahdokterR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}