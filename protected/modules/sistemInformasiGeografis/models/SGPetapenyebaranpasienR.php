<?php

/**
 * This is the model class for table "petapenyebaranpasien_r".
 *
 * The followings are the available columns in table 'petapenyebaranpasien_r':
 * @property integer $petapenyebaranpasien_id
 * @property string $tanggal
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $jumlah
 */
class SGPetapenyebaranpasienR extends PetapenyebaranpasienR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PetapenyebaranpasienR the static model class
	 */
	public $tgl_awal,$tgl_akhir;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $typerumah,$is_typerumah;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}