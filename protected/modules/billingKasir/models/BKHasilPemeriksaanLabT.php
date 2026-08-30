<?php

/**
 * This is the model class for table "hasilpemeriksaanlab_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanlab_t':
 * @property integer $hasilpemeriksaanlab_id
 * @property integer $pendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property string $nohasilperiksalab
 * @property string $tglhasilpemeriksaanlab
 * @property string $tglpengambilanhasil
 * @property string $hasil_kelompokumur
 * @property string $hasil_jeniskelamin
 * @property string $statusperiksahasil
 * @property string $catatanlabklinik
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class BKHasilPemeriksaanLabT extends HasilpemeriksaanlabT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanlabT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}