<?php
$this->breadcrumbs=array(
	'Personalscoring Ts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PersonalscoringT', 'url'=>array('index')),
	array('label'=>'Create PersonalscoringT', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('personalscoring-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Personalscoring Ts</h1>

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
	'id'=>'personalscoring-t-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'personalscoring_id',
		'pegawai_id',
		'penilaianpegawai_id',
		'tglscoring',
		'periodescoring',
		'sampaidengan',
		/*
		'gajipokok',
		'jabatan',
		'pendidikan',
		'totalscore',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
