<?php
/*$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Lokasi Rak', 'url'=>$this->createUrl('/rekamMedis/lokasiRak/admin'), 'active'=>true),
        array('label'=>'Sub Rak', 'url'=>$this->createUrl('/rekamMedis/lokasiRak/admin'),),
        array('label'=>'Warna Nomor', 'url'=>$this->createUrl('/rekamMedis/warnaNomor/admin'),),
        ),
));*/ 
?>

<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(        
        array('label'=>'Lokasi Rak', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'/rekamMedis/lokasiRak/admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])), 
        array('label'=>'Sub Rak', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rekamMedis/subRak/admin&modul_id='.Yii::app()->session['modul_id'])),
    	array('label'=>'Warna Nomor', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rekamMedis/warnaNomor/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Warna Dokumen', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rekamMedis/warnadokrmM/admin&modul_id='.Yii::app()->session['modul_id'])),
    ),
));
?>