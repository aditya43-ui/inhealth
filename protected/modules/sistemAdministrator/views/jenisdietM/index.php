<?php
$this->breadcrumbs = array(
    'Jenisdiet Ms',
);

$this->menu = array(
    array('label' => 'Create JenisdietM', 'url' => array('create')),
    //	array('label'=>'Manage JenisdietM', 'url'=>array('admin')),
);
?>

<h1>Jenisdiet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Jenis Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/JenisdietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>