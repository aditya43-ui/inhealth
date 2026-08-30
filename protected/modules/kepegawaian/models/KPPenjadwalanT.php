<?php
class KPPenjadwalanT extends PenjadwalanT
{
	public $kelompokpegawai_id,$instalasi_id,$ruangan_id,$mengetahui_nama,$menyetujiu_nama;
	public $shift_id,$shift_nama,$pola_shift,$nama_pegawai,$pegawai_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getKelompokpegawaiItems()
	{
		return KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = TRUE ORDER BY kelompokpegawai_nama asc');
	}
}