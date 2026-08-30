<?php

/**
 * This is the model class for table "bahansterilisasi_m".
 *
 * The followings are the available columns in table 'bahansterilisasi_m':
 * @property integer $bahansterilisasi_id
 * @property string $bahansterilisasi_nama
 * @property string $bahansterilisasi_namalain
 * @property string $bahansterilisasi_jumlah
 * @property string $bahansterilisasi_satuan
 * @property string $bahansterilisasi_warna
 * @property string $bahansterilisasi_maksuhu
 * @property boolean $bahansterilisasi_aktif
 */
class SABahansterilisasiM extends BahansterilisasiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BahansterilisasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}