<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('storeeddetail-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Pengembalian Obat dan Alkes Expired Date</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pengembalian Obat dan Alkes Exspired Date</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'storeeddetail-t-grid',
            'dataProvider' => $model->searchInformasi(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                ),
                array(
                    'name' => 'obatalkes_id',
                    'type' => 'raw',
                    'value' => '$data->obatalkes_nama',
                ),
                array(
                    'header' => 'Supplier',
                    'type' => 'raw',
                    'value' => '$data->supplier_nama',
                ),
                array(
                    'name' => 'tglkadaluarsa',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
                ),
                array(
                    'name' => 'qtystoked',
                    'type' => 'raw',
                    'value' => '$data->qtystoked',
                ),
                array(
                    'name' => 'satuankecil_id',
                    'type' => 'raw',
                    'value' => '$data->satuankecil_nama',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial('search', array('model' => $model, 'format' => $format)); ?>
</div>