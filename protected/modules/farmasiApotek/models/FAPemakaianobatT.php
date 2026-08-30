<?php

/**
 * This is the model class for table "pemakaianobat_t".
 *
 * The followings are the available columns in table 'pemakaianobat_t':
 * @property integer $pemakaianobat_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $tglpemakaianobat
 * @property string $nopemakaian_obat
 * @property string $untukkeperluan_obat
 * @property string $ket_pemakaianobat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class FAPemakaianobatT extends PemakaianobatT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianobatT the static model class
	 */
	public $totalharga;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}