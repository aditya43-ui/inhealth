<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Rencana Anestesi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>'anestesi/RencanaAnestesiT/index')),
        array('label'=>'Evaluasi Pra-Induksi / Sedasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>'anestesi/EvaluasiPrainduksiT/index')),
//        array('label'=>'Rencana Tindakan Dan Obat Alkes', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>'anestesi/RencanaTindakanObat/index')),
//        array('label'=>'Informasi Tindakan Anestesi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=true);', 'tab'=>'anestesi/InformasiTindakanAnestesi/index')),
//        array('label'=>'Persetujuan Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>'anestesi/PersetujuanTindakanAnastesi/index')),
        array('label'=>'Daftar Titik Keselamatan Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>'anestesi/daftarTitikKeselamatan/index')),
        array('label'=>'Induksi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>'anestesi/Induksi/index')),
    ),
));
?>