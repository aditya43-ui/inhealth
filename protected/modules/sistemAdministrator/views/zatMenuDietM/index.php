<?php
$this->breadcrumbs = array(
    'Zat Menu Diet Ms',
);

$this->menu = array(
    array('label' => 'Create ZatMenuDietM', 'url' => array('create')),
    //	array('label'=>'Manage ZatMenuDietM', 'url'=>array('admin')),
);
?>

<h1>Zat Menu Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Zat Menu Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/ZatMenuDietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>