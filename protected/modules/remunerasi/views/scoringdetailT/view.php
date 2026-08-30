<?php
$this->breadcrumbs=array(
	'Scoringdetail Ts'=>array('index'),
	$model->scoringdetail_id,
);

$this->menu=array(
	array('label'=>'List ScoringdetailT', 'url'=>array('index')),
	array('label'=>'Create ScoringdetailT', 'url'=>array('create')),
	array('label'=>'Update ScoringdetailT', 'url'=>array('update', 'id'=>$model->scoringdetail_id)),
	array('label'=>'Delete ScoringdetailT', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->scoringdetail_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ScoringdetailT', 'url'=>array('admin')),
);
?>

<h1>View ScoringdetailT #<?php echo $model->scoringdetail_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'scoringdetail_id',
		'kelrem_id',
		'personalscoring_id',
		'indexing_id',
		'index_personal',
		'ratebobot_personal',
		'score_personal',
	),
)); ?>
