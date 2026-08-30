<?php
class BDBukuregisterpasienV extends BukuregisterpasienV
{
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $tgl_awal;
        public $tgl_akhir;
        public $pendidikan_id, $suku_id;
        public $tahun, $bulan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BukuregisterpasienV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}