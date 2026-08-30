<?php
$this->breadcrumbs=array(
	'Personalscoring Ts'=>array('index'),
	$model->personalscoring_id=>array('view','id'=>$model->personalscoring_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PersonalscoringT', 'url'=>array('index')),
	array('label'=>'Create PersonalscoringT', 'url'=>array('create')),
	array('label'=>'View PersonalscoringT', 'url'=>array('view', 'id'=>$model->personalscoring_id)),
	array('label'=>'Manage PersonalscoringT', 'url'=>array('admin')),
);
?>

<h1>Update PersonalscoringT <?php echo $model->personalscoring_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>