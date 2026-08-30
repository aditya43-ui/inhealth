<?php

class SASubkegiatanprogramM extends SubkegiatanprogramM {
	public $subprogramkerja_id,$programkerja_id,$programkerja_kode,$subprogramkerja_kode,$kegiatanprogram_kode;
	
        public $rekeningdebit_nama, $rekeningkredit_nama;
        
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/*
	 * untuk master anggaran (sub kegiatan program) drop down Nama Rekening Debit Akuntansi
	 */
	public function getRekDebit()
	{
		return Rekening5M::model()->findAllByAttributes(array('rekening5_nb'=>'D','rekening5_aktif'=>true),array('order'=>'nmrekening5 ASC'));
	}
	/*
	 * untuk master anggaran (sub kegiatan program) drop down Nama Rekening Kredit Akuntansi
	 */
	public function getRekKredit()
	{
		return Rekening5M::model()->findAllByAttributes(array('rekening5_nb'=>'K','rekening5_aktif'=>true),array('order'=>'nmrekening5 ASC'));
	}
}

