<?php
$this->breadcrumbs = array(
    'Diet Ms',
);

$this->menu = array(
    array('label' => 'Create DietM', 'url' => array('create')),
    //	array('label'=>'Manage DietM', 'url'=>array('admin')),
);
?>

<h1>Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/DietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>