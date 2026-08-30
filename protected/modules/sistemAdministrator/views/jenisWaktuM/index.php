<?php
$this->breadcrumbs = array(
    'Jenis Waktu Ms',
);

$this->menu = array(
    array('label' => 'Create JenisWaktuM', 'url' => array('create')),
    //	array('label'=>'Manage JenisWaktuM', 'url'=>array('admin')),
);
?>

<h1>Jenis Waktu Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Jenis Waktu', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/JenisWaktuM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>