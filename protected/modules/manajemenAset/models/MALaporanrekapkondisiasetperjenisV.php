<?php

class MALaporanrekapkondisiasetperjenisV extends LaporanrekapkondisiasetperjenisV
{
    public $no, $tgl_awal, $tgl_akhir;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }        
	    
}
?>
