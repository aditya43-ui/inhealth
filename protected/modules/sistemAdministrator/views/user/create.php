
<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
        array('label'=>Yii::t('mds','Create').' User ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
	array('label'=>Yii::t('mds','List').' User', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>Yii::t('mds','Manage').' User', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>