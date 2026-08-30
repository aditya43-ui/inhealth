<?php
$this->breadcrumbs = array(
    'SAZatgizi Ms',
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'Pengaturan') . ' Zat Gizi', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Zatgizi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>

<?php $this->widget('UserTips', array('type' => 'list')); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Zat Gizi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/ZatgiziM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-danger',)
); ?>