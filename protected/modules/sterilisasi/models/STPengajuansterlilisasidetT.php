<?php

class STPengajuansterlilisasidetT extends PengajuansterlilisasidetT{
	public $namaPeralatan, $namaLinen;
	public $checklist,$status_penerimaan, $ruangan_id;  
         public $keadaan;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
}