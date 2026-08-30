<?php
$this->breadcrumbs=array(
	'Ppbuat Janji Poli Ts',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PPBuatJanjiPoliT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PPBuatJanjiPoliT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PPBuatJanjiPoliT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>$this->path_view.'_view',
)); ?>

<?php 
$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.janjiPoli',array(),true);
$this->widget('UserTips',array('type'=>'list','content'=>$content));?>