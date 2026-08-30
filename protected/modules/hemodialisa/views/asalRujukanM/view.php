<?php 
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
////        array('label'=>'Jadwal Dokter', 'url'=>$this->createUrl('/hemodialisa/jadwaldokterM')),
//        array('label'=>'Transportasi', 'url'=>$this->createUrl('/hemodialisa/transportasiM')),
//        array('label'=>'Keadaan Masuk', 'url'=>$this->createUrl('/hemodialisa/KeadaanMasukM')),
//        array('label'=>'Kondisi Pulang', 'url'=>$this->createUrl('/hemodialisa/KondisiPulangM')),
//        array('label'=>'Rujukan Keluar', 'url'=>$this->createUrl('/hemodialisa/rujukanKeluarM')),
//        array('label'=>'Asal Rujukan', 'url'=>'', 'active'=>true),
//        array('label'=>'Triase', 'url'=>$this->createUrl('/hemodialisa/triaseM')),
//        array('label'=>'Cara Keluar', 'url'=>$this->createUrl('/hemodialisa/CaraKeluarM')),
//    ),
//)); 
?>

<div class="white-container">
    <legend class="rim2">Lihat <b>Asal Rujukan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Saasal Rujukan Ms'=>array('index'),
            $model->asalrujukan_id,
    );

    //$this->menu=array(
    //        array('label'=>Yii::t('mds','View').' Asal Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','Manage').' Asal Rujukan', 'icon'=>'folder-open', 'url'=>array('admin')),
    //);

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'asalrujukan_id',
                    'asalrujukan_nama',
                    'asalrujukan_institusi',
                    'asalrujukan_namalainnya',
                    'asalrujukan_aktif',
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>