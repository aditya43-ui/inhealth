<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
        array('label'=>Yii::t('mds','Manage').' User ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
	array('label'=>Yii::t('mds','List').' User', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>Yii::t('mds','Create').' User', 'icon'=>'file', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		'user_id',
		'username',
		'password',
		'pegawai_id',
		'email',
		'last_login',
		/*
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
		*/
		array(
                        'header'=>'Lihat',
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
		),
		array(
                        'header'=>'Ubah',
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
		),
		array(
                        'header'=>'Hapus',
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php $content = $this->renderPartial('../tips/master',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>