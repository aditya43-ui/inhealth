<?php

/**
 * This is the model class for table "ptkp_m".
 *
 * The followings are the available columns in table 'ptkp_m':
 * @property integer $ptkp_id
 * @property string $tglberlaku
 * @property string $statusperkawinan
 * @property integer $jmltanggunan
 * @property double $wajibpajak_thn
 * @property double $wajibpajak_bln
 * @property boolean $berlaku
 */
class KPPinjamanPegT extends PinjamanpegT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PtkpM the static model class
	 */
	public $idpinjaman;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}