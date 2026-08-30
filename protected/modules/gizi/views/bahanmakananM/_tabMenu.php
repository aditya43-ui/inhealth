<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Golongan Bahan Makanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'gizi/golBahanMakananM/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Jenis Bahan Makanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'gizi/JenisBahanMakanan/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Kelompok Bahan Makanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'gizi/KelompokBahanMakanan/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Bahan Makanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'gizi/bahanMakananM/admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),
    	array('label'=>'Zat Bahan Makanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'gizi/zatBahanMakananM/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Jadwal Makan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'gizi/jadwalMakanM/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Jenis Makanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'gizi/jenismakananM/admin&modul_id='.Yii::app()->session['modul_id'])),
    ),
    /*'items'=>array(
        array('label'=>'Bahan Makanan', 'url'=>$this->CreateUrl('/gizi/bahanMakananM/admin'), 'active'=>true),
        array('label'=>'Zat Bahan Makanan', 'url'=>$this->CreateUrl('/gizi/zatBahanMakananM/admin'),),
        array('label'=>'Jadwal Makan', 'url'=>$this->CreateUrl('/gizi/jadwalMakanM/admin'),),
        array('label'=>'Golongan Bahan Makanan', 'url'=>$this->CreateUrl('/gizi/golBahanMakananM/admin'),),
    ),*/
)); 
?>