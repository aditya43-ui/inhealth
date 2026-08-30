<?php

/**
 * This is the model class for table "ubahhargaobat_r".
 *
 * The followings are the available columns in table 'ubahhargaobat_r':
 * @property integer $ubahhargaobat_id
 * @property integer $obatalkes_id
 * @property integer $sumberdana_id
 * @property integer $loginpemakai_id
 * @property string $tglperubahan
 * @property double $harganettoasal
 * @property double $hargajualasal
 * @property double $harganettoperubahan
 * @property double $hargajualperubahan
 * @property string $alasanperubahan
 * @property string $disetujuioleh
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class GFUbahHargaObatR extends UbahhargaobatR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbahhargaobatR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}