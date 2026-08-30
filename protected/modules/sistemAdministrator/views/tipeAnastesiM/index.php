<?php
$this->breadcrumbs = array(
    'Tipe Anastesi Ms',
);

$this->menu = array(
    array('label' => 'Create TipeAnastesiM', 'url' => array('create')),
);
?>

<h1>Tipe Anastesi Ms</h1>

<?php $this->widget('ext.bootstrap.widgets.BootListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Tipe Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/TipeAnastesiM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>