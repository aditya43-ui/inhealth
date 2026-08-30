<?php
$this->breadcrumbs=array(
	'Bank Ms',
);

$arrMenu = array();
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bank', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bank', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php 
    $this->widget('ext.bootstrap.widgets.BootListView',array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
    )); 
?>

<?php $this->widget('UserTips',array('type'=>'list'));?>