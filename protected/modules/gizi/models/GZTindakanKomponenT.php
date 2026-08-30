<?php

/**
 * This is the model class for table "tindakankomponen_t".
 *
 * The followings are the available columns in table 'tindakankomponen_t':
 * @property integer $tindakankomponen_id
 * @property integer $tindakanpelayanan_id
 * @property integer $komponentarif_id
 * @property double $tarif_tindakankomp
 * @property double $tarifcyto_tindakankomp
 * @property double $subsidiasuransikomp
 * @property double $subsidipemerintahkomp
 * @property double $subsidirumahsakitkomp
 * @property double $iurbiayakomp
 */
class GZTindakanKomponenT extends TindakankomponenT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankomponenT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}