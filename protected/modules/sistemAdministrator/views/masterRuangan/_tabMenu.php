<?php 
$controller = Yii::app()->controller->id; 
$module = Yii::app()->controller->module->id; 

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pegawai Ruangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlPegawaiRuangan())),
    	array('label'=>'Kelas Ruangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKelasRuangan())),
        array('label'=>'Kasus Penyakit Ruangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKasusPenyakitRuangan())),
        array('label'=>'Kasus Penyakit Diagnosa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKasusPenyakitDiagnosa())),
        array('label'=>'Tindakan Ruangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlTindakanRuangan())),
    ),
));
?>