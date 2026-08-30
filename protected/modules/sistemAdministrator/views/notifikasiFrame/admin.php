<?php
$this->breadcrumbs = array(
    'Notifikasi' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('notifikasi-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="search-form">
    <?php $this->renderPartial('_search', array(
        'model' => $model
    )); ?>
</div>
<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'notifikasi-grid',
    'dataProvider' => $model->searchFrame(),
    //	 'filter'=>$model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'rowCssClassExpression' => '$data->isread?"":"notif-active"',
    'columns' => array(
        // array(
        //         'header'=>'No.',
        //         'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
        //         'type'=>'raw',
        //         'htmlOptions'=>array('style'=>'text-align:right;'),
        // ),
        array(
            'header' => 'Notifikasi',
            'value' => '"<span><b>".$data->judulnotifikasi."</b><span class=\"pull-right\">".MyFormatter::formatDateTimeForUser($data->create_time)."</span><br>".$data->isinotifikasi."</span>"',
            'type' => 'raw',
        ),
        // array(
        //     'name'=>'isinotifikasi',
        //     'type'=>'raw',
        // ),
        // array(
        //     'name'=>'create_time',
        //     'value'=>'MyFormatter::formatDateTimeForUser($data->create_time)',
        //     'filter'=>false,
        // ),
        // array(
        //     'name'=>'update_time',
        //     'value'=>'MyFormatter::formatDateTimeForUser($data->update_time)',
        //     'filter'=>false,
        // ),
        array(
            'header' => Yii::t('zii', 'View'),
            'name' => 'isread',
            'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->createUrl("/sistemAdministrator/notifikasiFrame/view",array("id"=>$data->nofitikasi_id)),
						array("class"=>"", 
							"rel"=>"tooltip",
							"title"=>"Lihat Notifikasi",
						))',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width:60px'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
<style type="text/css">
    .notif-active {
        background-color: #f5C1f7 !important;
    }
</style>