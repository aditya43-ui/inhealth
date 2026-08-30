<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        // array('label'=>'Anamnesis Diet', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesisDiet/index')),
        // array('label'=>'Asesmen Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenGizi/index')),
        //array('label'=>'Periksa Fisik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisikGZ/index')),
        //array('label'=>'Jenis Diet', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/jenisDiet/index')),
        array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/CPPTRK/index', 'class' => 'tabulasi_asuhan')),
        array('label'=>'Jawaban Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanGizi/jawabanKonsul')),
    ),
));
?>