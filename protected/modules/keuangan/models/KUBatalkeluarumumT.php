<?php

/**
 * This is the model class for table "batalkeluarumum_t".
 *
 * The followings are the available columns in table 'batalkeluarumum_t':
 * @property integer $batalkeluarumum_id
 * @property integer $pengeluaranumum_id
 * @property integer $ruangan_id
 * @property integer $tandabuktikeluar_id
 * @property string $tglbatalkeluar
 * @property string $alasanbatalkeluar
 * @property string $user_name_otoritasi
 * @property integer $user_id_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KUBatalkeluarumumT extends BatalkeluarumumT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalkeluarumumT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}