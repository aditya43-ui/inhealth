<?php

/**
 * This is the model class for table "satuankecil_m".
 *
 * The followings are the available columns in table 'satuankecil_m':
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property string $satuankecil_namalain
 * @property boolean $satuankecil_aktif
 */
class GUBidangM extends BidangM
{
   public $bidang;
   public $bidangNama;
   /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SatuankecilM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getSubKelompokItems()
    {
        return SubkelompokM::model()->findAll('subkelompok_aktif = true ORDER BY subkelompok_nama');
    }

}