<?php 
$module = '/'.$this->module->id;
$instalasi_id=Yii::app()->user->getState('instalasi_id');
$namaInstalasi = InstalasiM::model()->findByPk($instalasi_id);
$modInstalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState("instalasi_id"));
$init = $modInstalasi->instalasi_singkatan;




$menu_list = array(
    array('label'=>'Asesmen Radiologi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'radiologi/AsesmenRadiologi/index')),
    array('label'=>'CPPT', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/CPPTRK/index')),
    array('label'=>'Konsultasi Poli', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/konsulPoli/index')),
    array('label'=>'Reseptur', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/reseptur/index')),
);

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$menu_list,
    'htmlOptions'=>[
        'id'=>'tab-periksa'
    ]
));
?>