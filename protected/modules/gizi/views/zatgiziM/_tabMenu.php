<?php
/*$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Zat Gizi', 'url'=>$this->createUrl('/gizi/zatgiziM/admin'), 'active'=>true),
        array('label'=>'Tipe Diet', 'url'=>$this->createUrl('/gizi/tipeDietM/admin'), ),
        array('label'=>'Jenis Diet', 'url'=>$this->createUrl('/gizi/jenisdietM/admin'), ),
        array('label'=>'Diet', 'url'=>$this->createUrl('/gizi/dietM/admin'), ),
        array('label'=>'Menu Diet', 'url'=>$this->createUrl('/gizi/menuDietM/admin'),),
        array('label'=>'Zat Menu Diet', 'url'=>$this->createUrl('/gizi/zatMenuDietM/admin'),),
        array('label'=>'Bahan Diet', 'url'=>$this->createUrl('/gizi/bahandietM/admin'), ),
        array('label'=>'Jenis Waktu', 'url'=>$this->createUrl('/gizi/jenisWaktuM/admin'),),
        array('label'=>'Bahan Menu Diet', 'url'=>$this->createUrl('/gizi/bahanMenuDietM/admin'),),
    ),*/
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Tipe Diet', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/gizi/tipeDietM/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Jenis Diet', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/gizi/jenisdietM/admin&modul_id='.Yii::app()->session['modul_id'])),
    	array('label'=>'Diet', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/gizi/dietM/admin&modul_id='.Yii::app()->session['modul_id'])),    	
        array('label'=>'Menu Normal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/gizi/bahandietM/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Menu Diet', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/gizi/menuDietM/admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Bahan Menu Diet', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/gizi/bahanMenuDietM/admin&modul_id='.Yii::app()->session['modul_id'])),    	                
        array('label'=>'Zat Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/gizi/zatgiziM/admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),    	                
//    	array('label'=>'Zat Menu Diet', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/gizi/zatMenuDietM/admin&modul_id='.Yii::app()->session['modul_id'])),        
//        array('label'=>'Zat Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/gizi/zatgiziM/admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),    	
    	array('label'=>'Jenis Waktu', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/gizi/jenisWaktuM/admin&modul_id='.Yii::app()->session['modul_id'])),    	        
    ),
)); 
?>