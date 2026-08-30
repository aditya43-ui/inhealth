<?php
class ASPasienpulangrddanriV extends PasienpulangrddanriV
{
	public $kelaspelayanan_id,$kelaspelayanan_nama,$pekerjaan_nama,$pendidikan_nama,$kamarruangan_nokamar,$kamarruangan_nobed;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}