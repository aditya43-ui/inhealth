<?php
$this->breadcrumbs=array(
	'Sapaketpelayanan Ms',
);

$arrMenu = array();
	array_push($arrMenu,array('label'=>Yii::t('mds','List').' Paket Pelayanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
	(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Paket Pelayanan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>$this->path_view.'_view',
)); ?>
<?php $this->widget('UserTips',array('type'=>'list'));?>