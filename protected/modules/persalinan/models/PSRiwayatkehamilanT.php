<?php

class PSRiwayatkehamilanT extends RiwayatkehamilanT
{
        public $tambah_anak_ke;
        public $tambah_keterangan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
                
	}

}