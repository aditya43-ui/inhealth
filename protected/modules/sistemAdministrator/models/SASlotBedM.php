<?php

/**
 * This is the model class for table "slotbed_m".
 *
 * The followings are the available columns in table 'slotbed_m':
 * @property integer $slotbed_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property string $slotbed_noslot
 * @property integer $slotbed_jmlbed
 * @property string $slotbed_nobed
 * @property boolean $slotbed_status
 * @property boolean $slotbed_aktif
 */
class SASlotBedM extends SlotbedM
{
        public $slotTerpakai, $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SlotbedM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * Menampilkan data status slot dari lookup_m
         */
        public function getKeteranganSlotItems()
        {
            return LookupM::model()->findAllByAttributes(array('lookup_type'=>'keteranganslot', 'lookup_aktif'=>true),array('order'=>'lookup_urutan'));
        }

}