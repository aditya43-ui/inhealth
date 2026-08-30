<?php
$this->breadcrumbs = array(
  'Sakelompok Umur Ms',
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Kelompok Umur ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
//                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Umur', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
(Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelompok Umur', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView', array(
  'dataProvider' => $dataProvider,
  'itemView' => '_view',
)); ?>

<?php $this->widget('UserTips', array('type' => 'list')); ?>