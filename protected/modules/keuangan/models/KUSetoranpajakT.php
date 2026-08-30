<?php
class KUSetoranpajakT extends SetoranpajakT
{
    public $pajak_id, $pajak_nama, $tgl_awal, $tgl_akhir, $jenispengeluaran_id, $jenispengeluaran_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}

?>