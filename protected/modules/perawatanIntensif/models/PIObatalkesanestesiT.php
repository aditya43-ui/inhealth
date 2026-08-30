<?php

/**
 * This is the model class for table "obatalkesanestesi_t".
 *
 * The followings are the available columns in table 'obatalkesanestesi_t':
 * @property integer $obatalkesanestesi_id
 * @property integer $praanestesi_id
 * @property integer $intraanestesi_id
 * @property integer $obatalkespasien_id
 * @property integer $ruangan_id
 * @property integer $qty_oa
 * @property double $hargasatuan_oa
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PraanestesiT $praanestesi
 * @property IntraanestesiT $intraanestesi
 * @property ObatalkespasienT $obatalkespasien
 * @property RuanganM $ruangan
 */
class PIObatalkesanestesiT extends ObatalkesanestesiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesanestesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}