<?php
$this->breadcrumbs = array(
    'Sacara Bayar Ms',
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Jenis Penjamin', 'icon' => 'list', 'url' => array('index')));
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Penjamin', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Penjamin', 'icon'=>'file', 'url'=>array('admin'))) :  '' ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>

<?php $this->widget('UserTips', array('type' => 'list')); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Jenis Penjamin', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/CaraBayarM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>