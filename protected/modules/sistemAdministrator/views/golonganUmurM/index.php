<?php
$this->breadcrumbs = array(
    'Sagolongan Umur Ms',
);

$this->menu = array(
    array('label' => Yii::t('mds', 'List') . ' Golongan Umur ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')),
    //	array('label'=>Yii::t('mds','Create').' Golongan Umur', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','Manage').' Golongan Umur', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>

<?php $this->widget('UserTips', array('type' => 'list')); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Golongan Umur', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/GolonganUmurM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>