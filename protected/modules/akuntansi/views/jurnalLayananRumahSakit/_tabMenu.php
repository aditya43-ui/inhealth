<?php
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jurnal Piutang Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'setTabJurPiutang','onclick'=>'setTab(this);', 'tab'=>$this->getUrlJurnalPiutang())),
        // array('label'=>'Jurnal Pembayaran Tagihan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'myAlert("Belum Berfungsi")', 'tab'=>'')),
    ),
));
?>
