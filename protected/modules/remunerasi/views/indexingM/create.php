<fieldset class="box">
    <legend class="rim">Tambah Indexing</legend>
<?php
$this->breadcrumbs=array(
	'SaIndexing Ms'=>array('index'),
	'Create',
);

//$arrMenu = array();
              //  array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Indexing ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAGelarBelakangM', 'icon'=>'list', 'url'=>array('index'))) ;
              //  (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Indexing', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php //echo $this->renderPartial('_tabMenu',array()); ?>
<?php echo $this->renderPartial('_form', array('model'=>$model, 'det'=>$det)); ?>
</fieldset>