<?php
class KUFakturpembeliantopembayaranV extends FakturpembeliantopembayaranV
{
	public $tgl_awal, $tgl_akhir, $checklist, $jmldibayarkan, $sisahutang, $keterangan, $bayarke;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}

?>
