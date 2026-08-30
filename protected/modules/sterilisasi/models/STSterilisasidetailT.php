<?php
class STSterilisasidetailT extends SterilisasidetailT
{
	public $ruangan_id,$ruangan_nama,$barang_nama,$penerimaansterilisasi_tgl,$penerimaansterilisasi_no;
	public $checklist,$bahansterilisasi_nama,$maininput;
	public $tgl_awal,$tgl_akhir,$instalasi_id,$sterilisasi_no,$instalasi_nama, $pengajuansterlilisasi_id;
    public $keadaanperalatan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}