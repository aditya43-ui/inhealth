<?php
$this->breadcrumbs=array(
	'Personalscoring Ts',
);

$this->menu=array(
	array('label'=>'Create PersonalscoringT', 'url'=>array('create')),
	array('label'=>'Manage PersonalscoringT', 'url'=>array('admin')),
);
?>

<h1>Personalscoring Ts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
