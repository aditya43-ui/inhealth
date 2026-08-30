<?php

/**
 * This is the model class for table "pemakaianobatdetail_t".
 *
 * The followings are the available columns in table 'pemakaianobatdetail_t':
 * @property integer $pemakaianobatdetail_id
 * @property integer $satuankecil_id
 * @property integer $pemakaianobat_id
 * @property integer $obatalkes_id
 * @property string $qty_satuanpakai
 * @property double $harga_satuanpakai
 * @property double $harganetto_satuanpakai
 * @property string $ket_obatpakai
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class FAPemakaianobatdetailT extends PemakaianobatdetailT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianobatdetailT the static model class
	 */
	public $jmlstok,$subtotal,$stokobatalkes_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}