<?php

/**
 * This is the model class for table "kirimsamplelab_t".
 *
 * The followings are the available columns in table 'kirimsamplelab_t':
 * @property integer $kirimsamplelab_id
 * @property integer $pengambilansample_id
 * @property integer $labklinikrujukan_id
 * @property string $nokirimsample
 * @property string $tglkirimsample
 * @property string $tglterimahasilsample
 * @property string $keterangan_kirim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class LBKirimSampleLabT extends KirimsamplelabT
{

	public $isKirimSample;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimsamplelabT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}