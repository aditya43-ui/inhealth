<?php
$this->breadcrumbs = array(
    'Sagelar Belakang Ms',
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Gelar Belakang ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
//                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Gelar Belakang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
(Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Gelar Belakang', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>

<?php $this->widget('UserTips', array('type' => 'list')); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Gelar Belakang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/gelarBelakangM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>