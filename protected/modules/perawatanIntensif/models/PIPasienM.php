<?php

class PIPasienM extends PasienM
{
        public $umur;
        public $tgl_pendaftaran,$no_pendaftaran;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}