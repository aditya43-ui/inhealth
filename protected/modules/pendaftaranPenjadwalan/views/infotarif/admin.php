<?php
$this->breadcrumbs=array(
	'Pptindakanruangan Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pptindakanruangan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->
<?php if ($model->search() == null){
    $model->search = 0;
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pptindakanruangan-m-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                        'name'=>'ruangan_id',
                        'value'=>'$data->ruangan_id',
                        'filter'=>false,
                ),
            array(
                        'name'=>'ruangan_id',
                        'value'=>'$data->daftartindakan->tariftindakan->harga_tariftindakan',
                        'filter'=>false,
                ),
		
		
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
		),
		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

