<?php // $this->renderPartial('_tab'); ?>
<?php
$this->breadcrumbs=array(
	'Pppekerjaan Ms'=>array('index'),
	'Create',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>