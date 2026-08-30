<?php

class RKRl4bMobiditaspasienrjV extends Rl4bMobiditaspasienrjV
{
        public $tgl_awal, $tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}