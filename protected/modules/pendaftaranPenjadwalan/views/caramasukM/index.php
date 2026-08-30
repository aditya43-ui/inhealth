<?php $this->renderPartial('_tab'); ?>
<?php
$this->breadcrumbs=array(
	'Ppcaramasuk Ms',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list'));?>