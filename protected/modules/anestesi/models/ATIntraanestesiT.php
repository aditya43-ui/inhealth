<?php

/**
 * This is the model class for table "intraanestesi_t".
 *
 * The followings are the available columns in table 'intraanestesi_t':
 * @property integer $intraanestesi_id
 * @property integer $pasienanastesi_id
 * @property integer $praanestesi_id
 * @property integer $ruangan_id
 * @property integer $kamarruangan_id
 * @property string $nointraanestesi
 * @property string $tglintraanestesi
 * @property integer $dokter_id
 * @property integer $perawat1_id
 * @property integer $perawat2_id
 * @property string $tekniksedasi
 * @property string $tglpuasa
 * @property boolean $isdarurat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TindakananestesiT[] $tindakananestesiTs
 * @property KondisipasienanestesiT[] $kondisipasienanestesiTs
 * @property ObatalkesanestesiT[] $obatalkesanestesiTs
 * @property PasienanastesiT $pasienanastesi
 * @property PraanestesiT $praanestesi
 * @property RuanganM $ruangan
 * @property KamarruanganM $kamarruangan
 * @property PegawaiM $dokter
 * @property PegawaiM $perawat1
 * @property PegawaiM $perawat2
 * @property PascaanestesiT[] $pascaanestesiTs
 */
class ATIntraanestesiT extends IntraanestesiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntraanestesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}