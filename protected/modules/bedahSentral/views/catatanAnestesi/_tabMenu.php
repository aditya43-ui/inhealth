<?php 

$module = '/'.$this->module->id;

$menu_list = array(
    array('label'=>'Daftar Tilik Keselamatan Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/daftarTilikKeselamatan/index')),
    array('label'=>'Asesmen Pra Induksi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenPraInduksi/index')),
    array('label'=>'Durante Operasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/duranteOperasi/index')),
    array('label'=>'Data Akhir Anestesi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/dataAkhirAnestesi/create')),
);


$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$menu_list
));
?>