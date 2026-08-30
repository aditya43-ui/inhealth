<?php
class KPPertukaranjadwaldetT extends PertukaranjadwaldetT
{
	public $nama_pegawai,$nomorindukpegawai,$shiftasal_id,$penjadwalan_id,$penjadwalandetail_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}