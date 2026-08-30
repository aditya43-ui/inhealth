<?php
$this->breadcrumbs=array(
	'Scoringdetail Ts',
);

$this->menu=array(
	array('label'=>'Create ScoringdetailT', 'url'=>array('create')),
	array('label'=>'Manage ScoringdetailT', 'url'=>array('admin')),
);
?>

<h1>Scoringdetail Ts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
