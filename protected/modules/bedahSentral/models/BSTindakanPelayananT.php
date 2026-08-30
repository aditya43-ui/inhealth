<?php

class BSTindakanPelayananT extends TindakanpelayananT
{

	public $tarif_tindakankomp;
	public $operasi_id; //untuk form daftar tindakan pemeriksaan
	public $jenistarif_id; //untuk form daftar tindakan pemeriksaan
	public $totaltariftindakan; //untuk total di lembar status
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanOperasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
}
?>
