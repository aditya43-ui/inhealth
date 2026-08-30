<?php
$this->breadcrumbs = array(
    'Tipe Diet Ms',
);

$this->menu = array(
    array('label' => 'Create TipeDietM', 'url' => array('create')),
    //	array('label'=>'Manage TipeDietM', 'url'=>array('admin')),
);
?>

<h1>Tipe Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Tipe Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/TipeDietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>