<?php
class KPPenjadwalandetailT extends PenjadwalandetailT
{
	public $shift_id,$shift_nama,$pola_shift,$ruangan_id;
	public $checklist,$ruangan_nama,$instalasi_nama,$nama_pegawai,$shiftygdiperbolehkan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}