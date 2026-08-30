<?php

/**
 * This is the model class for table "kondisipasienanestesi_t".
 *
 * The followings are the available columns in table 'kondisipasienanestesi_t':
 * @property integer $kondisipasienanestesi_id
 * @property integer $intraanestesi_id
 * @property integer $pascaanestesi_id
 * @property string $tglpemantauan
 * @property string $jammulai
 * @property string $jamselesai
 * @property integer $menitke
 * @property double $oksigen_liter
 * @property double $ventilasi_mmhg
 * @property string $sirkulasi
 * @property string $suhu
 * @property string $perfusijaringan
 *
 * The followings are the available model relations:
 * @property IntraanestesiT $intraanestesi
 * @property PascaanestesiT $pascaanestesi
 */
class ATKondisipasienanestesiT extends KondisipasienanestesiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KondisipasienanestesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}