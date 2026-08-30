<?php
$this->breadcrumbs=array(
	'Konfigemail Ks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List KonfigemailK','url'=>array('index')),
	array('label'=>'Create KonfigemailK','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('konfigemail-k-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Konfigemail Ks</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'konfigemail-k-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'konfigemail_id',
		'konfigemail_host',
		'konfigemail_port',
		'konfigemail_smtp_auth',
		'konfigemail_username',
		'konfigemail_password',
		/*
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'profilrs_id',
		'konfigemail_smtp_secure',
		'konfigemail_ishtml',
		*/
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
