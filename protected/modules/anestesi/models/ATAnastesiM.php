<?php

/**
 * This is the model class for table "anastesi_m".
 *
 * The followings are the available columns in table 'anastesi_m':
 * @property integer $anastesi_id
 * @property integer $jenisanastesi_id
 * @property string $anastesi_nama
 * @property string $anastesi_namalainnya
 * @property boolean $anastesi_aktif
 * @property integer $daftartindakan_id
 *
 * The followings are the available model relations:
 * @property TindakananestesiT[] $tindakananestesiTs
 * @property PasienanastesiT[] $pasienanastesiTs
 * @property TypeanastesiM[] $typeanastesiMs
 * @property JenisanastesiM $jenisanastesi
 * @property DaftartindakanM $daftartindakan
 */
class ATAnastesiM extends AnastesiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnastesiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}