<?php

/**
 * This is the model class for table "pemeriksaangambar_t".
 *
 * The followings are the available columns in table 'pemeriksaangambar_t':
 * @property integer $pemeriksaangambar_id
 * @property integer $gambartubuh_id
 * @property integer $pemeriksaanfisik_id
 * @property integer $bagiantubuh_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglpemeriksaan
 * @property double $kordinat_tubuh_x
 * @property double $kordinat_tubuh_y
 * @property string $keterangan_periksa_gbr
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RIPemeriksaangambarT extends PemeriksaangambarT
{
	public $namabagtubuh;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaangambarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}