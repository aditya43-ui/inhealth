<?php 
$module = '/'.$this->module->id;
$tabulasi_list = array();

if(Yii::app()->user->getState("instalasi_id") != Params::INSTALASI_ID_IBS){
    $tabulasi_list = array_merge($tabulasi_list, array(
        array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/CPPTRK/index')),
         array('label'=>'Pengkajian Resiko Jatuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/PengkajianResikoJatuh/index')),
                array('label'=>'Pengkajian Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/PengkajianNyeri/create'))
        )
    );
}

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=> $tabulasi_list,
));
?>