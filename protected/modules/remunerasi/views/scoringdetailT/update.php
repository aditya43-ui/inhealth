<?php
$this->breadcrumbs=array(
	'Scoringdetail Ts'=>array('index'),
	$model->scoringdetail_id=>array('view','id'=>$model->scoringdetail_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ScoringdetailT', 'url'=>array('index')),
	array('label'=>'Create ScoringdetailT', 'url'=>array('create')),
	array('label'=>'View ScoringdetailT', 'url'=>array('view', 'id'=>$model->scoringdetail_id)),
	array('label'=>'Manage ScoringdetailT', 'url'=>array('admin')),
);
?>

<h1>Update ScoringdetailT <?php echo $model->scoringdetail_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>