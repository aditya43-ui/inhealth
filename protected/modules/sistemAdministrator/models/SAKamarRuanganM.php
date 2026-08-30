<?php

/**
 * This is the model class for table "kamarruangan_m".
 *
 * The followings are the available columns in table 'kamarruangan_m':
 * @property integer $kamarruangan_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property string $kamarruangan_nokamar
 * @property integer $kamarruangan_jmlbed
 * @property string $kamarruangan_nobed
 * @property boolean $kamarruangan_status
 * @property boolean $kamarruangan_aktif
 */
class SAKamarRuanganM extends KamarruanganM
{
        public $kamarTerpakai, $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KamarruanganM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * Menampilkan data status kamar dari lookup_m
         */
        public function getKeteranganKamarItems()
        {
            return LookupM::model()->findAllByAttributes(array('lookup_type'=>'keterangankamar', 'lookup_aktif'=>true),array('order'=>'lookup_urutan'));
        }

}