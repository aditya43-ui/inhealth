<?php

/**
 * This is the model class for table "pasienbatalpulang_t".
 *
 * The followings are the available columns in table 'pasienbatalpulang_t':
 * @property integer $pasienbatalpulang_id
 * @property integer $pasienpulang_id
 * @property string $tglpembatalan
 * @property string $alasanpembatalan
 * @property string $namauser_otorisasi
 * @property integer $iduser_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class RIPasienBatalPulangT  extends PasienbatalpulangT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienbatalpulangT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}