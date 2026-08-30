<?php
class KUPembpiutangbankT extends PembpiutangbankT
{
	public $tgl_awal, $tgl_akhir, $tgljthtempo_awal, $tgljthtempo_akhir, $nopembayaran_srch, $jenispembayaran_id, $bank_id, $ceklis;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}

?>
