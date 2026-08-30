<?php

/**
 * This is the model class for table "penilaianpegawaidet_t".
 *
 * The followings are the available columns in table 'penilaianpegawaidet_t':
 * @property integer $penilaianpegawaidet_id
 * @property integer $kompetensi_id
 * @property integer $indikatorperilaku_id
 * @property integer $jenispenilaian_id
 * @property integer $penilaianpegawai_id
 * @property integer $penilaianpegdet_socre
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KPPenilaianpegawaidetT extends PenilaianpegawaidetT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenilaianpegawaidetT the static model class
	 */
        public $point;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}