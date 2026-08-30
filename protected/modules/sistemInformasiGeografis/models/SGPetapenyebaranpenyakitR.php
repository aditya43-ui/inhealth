<?php

/**
 * This is the model class for table "petapenyebaranpenyakit_r".
 *
 * The followings are the available columns in table 'petapenyebaranpenyakit_r':
 * @property integer $petapenyebaranpenyakit_id
 * @property string $tanggal
 * @property integer $diagnosa_id
 * @property string $diagnosa_nama
 * @property integer $jumlah
 */
class SGPetapenyebaranpenyakitR extends PetapenyebaranpenyakitR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PetapenyebaranpenyakitR the static model class
	 */
	public $tgl_awal,$tgl_akhir, $kelompokkodediagnosa;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $diagnosa_kode,$diagnosa_nama,$typerumah;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}