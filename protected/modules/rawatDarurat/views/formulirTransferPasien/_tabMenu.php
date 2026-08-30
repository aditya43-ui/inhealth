<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Lembar Transfer 1', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlLembarTransfer())),
        array('label'=>'Kategori & Kondisi Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>' cekInputLembarTransfer(this);', 'tab'=>$this->getUrlTransferKondisiPasien())),
    ),
));
?>