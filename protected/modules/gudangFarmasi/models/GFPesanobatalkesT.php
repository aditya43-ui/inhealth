<?php

class GFPesanobatalkesT extends PesanobatalkesT
{   
    public $instalasitujuan_id,$pegawaimengetahui_nama,$pegawaipemesan_nama;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}