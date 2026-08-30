<?php

/**
 * This is the model class for table "riwayatkeluarga_r".
 *
 * The followings are the available columns in table 'riwayatkeluarga_r':
 * @property integer $riwayatkeluarga_id
 * @property integer $anamesa_id
 * @property string $nama_riwayat_keluarga
 * @property string $status_riwayat_keluarga
 */
class MCRiwayatkeluargaR extends RiwayatkeluargaR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatkeluargaR the static model class
	 */
	public $darah_tinggi,$kanker,$asma,$ambeien,$jantung,$tbc,$stroke,$diabetes_melitus,$gangguan_jiwa,$penyakit_kuning,$kelainan_darah,$lainnya_label,$lainnya;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}