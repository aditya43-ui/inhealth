<?php
$this->breadcrumbs=array(
	'Scoringdetail Ts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ScoringdetailT', 'url'=>array('index')),
	array('label'=>'Manage ScoringdetailT', 'url'=>array('admin')),
);
?>

<h1>Create ScoringdetailT</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>