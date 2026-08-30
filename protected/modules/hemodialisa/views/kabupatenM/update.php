<?php 
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
//        array('label'=>'Propinsi',  'url'=>$this->createUrl('/hemodialisa/propinsiM')),
//        array('label'=>'Kabupaten', 'url'=>'', 'active'=>true),
//        array('label'=>'Kecamatan', 'url'=>$this->createUrl('/hemodialisa/kecamatanM')),
//        array('label'=>'Kelurahan', 'url'=>$this->createUrl('/hemodialisa/kelurahanM')),
//    ),
//)); ?>

<?php
$this->breadcrumbs=array(
	'Sakabupaten Ms'=>array('index'),
	$model->kabupaten_id=>array('view','id'=>$model->kabupaten_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kabupaten ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
             
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kabupaten', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
