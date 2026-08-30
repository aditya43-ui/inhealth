<?php

/**
 * This is the model class for table "bagiantubuh_m".
 *
 * The followings are the available columns in table 'bagiantubuh_m':
 * @property integer $bagiantubuh_id
 * @property string $namabagtubuh
 * @property string $bagtubuh_namalain
 * @property double $kordinat_x
 * @property double $kordinat_y
 * @property boolean $bagiantubuh_aktif
 */
class RKBagiantubuhM extends BagiantubuhM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BagiantubuhM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getBagianTubuh() {
		$modBagianTubuh = RKBagiantubuhM::model()->findAll("bagiantubuh_aktif is true ORDER BY namabagtubuh ASC");
		return $modBagianTubuh;
	}
	
}
