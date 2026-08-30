<?php

class RKRl33KegiatangigimulutV extends Rl33KegiatangigimulutV
{
        public $tgl_awal, $tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode;
        public $tahun;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl33KegiatangigimulutV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}