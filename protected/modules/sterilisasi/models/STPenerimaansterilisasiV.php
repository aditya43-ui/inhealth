<?php
class STPenerimaansterilisasiV extends PenerimaansterilisasiV
{
	public $tgl_awal, $tgl_akhir, $pengajuansterlilisasi_id, $pembersihan_id, $dekontaminasi_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}