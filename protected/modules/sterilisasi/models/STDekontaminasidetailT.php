<?php
class STDekontaminasidetailT extends DekontaminasidetailT
{
	public $bahansterilisasi_nama,$ruangan_nama,$barang_nama;
	public $penerimaansterilisasi_no,$penerimaansterilisasi_tgl,$maininput,$checklist,$peralatansterilisasi_nama;
        public $peralatansterilisasi_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}