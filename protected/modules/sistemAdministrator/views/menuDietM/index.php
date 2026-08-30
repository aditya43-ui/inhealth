<?php
$this->breadcrumbs = array(
    'Menu Diet Ms',
);

$this->menu = array(
    array('label' => 'Create MenuDietM', 'url' => array('create')),
    //	array('label'=>'Manage MenuDietM', 'url'=>array('admin')),
);
?>

<h1>Menu Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Menu Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/MenuDietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>