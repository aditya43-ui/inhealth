<?php
$this->breadcrumbs=array(
	'Scoringdetail Ts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ScoringdetailT', 'url'=>array('index')),
	array('label'=>'Create ScoringdetailT', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('scoringdetail-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Scoringdetail Ts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'scoringdetail-t-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'scoringdetail_id',
		'kelrem_id',
		'personalscoring_id',
		'indexing_id',
		'index_personal',
		'ratebobot_personal',
		/*
		'score_personal',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
