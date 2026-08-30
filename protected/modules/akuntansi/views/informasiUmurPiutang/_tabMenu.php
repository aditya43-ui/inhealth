<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pengajuan Piutang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/akuntansi/informasiUmurPiutang/indexPengajuanPiutang')),    	        
        //array('label'=>'Pasien Piutang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/akuntansi/informasiUmurPiutang/indexPasienPiutang')),        
            ),
)); 
?>
