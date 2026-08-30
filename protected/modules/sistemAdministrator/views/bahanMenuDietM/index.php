<?php
$this->breadcrumbs = array(
    'Bahan Menu Diet Ms',
);

$this->menu = array(
    array('label' => 'Create BahanMenuDietM', 'url' => array('create')),
    //	array('label'=>'Manage BahanMenuDietM', 'url'=>array('admin')),
);
?>

<h1>Bahan Menu Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Bahan Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/BahanMenuDietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>