
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $rows = '$row+1';
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}
?>  

<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penjaminpasien-m-grid',
    'dataProvider' => $model->searchRekeningPenjaminPrint(),
    //	'filter'=>$model,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => $rows,
        ),
        array(
            'header' => 'Jenis Penjamin',
            'type' => 'raw',
            'value'=>'$data->carabayar->carabayar_nama',  
        ),
        array(
            'header' => 'Penjamin',
            'type' => 'raw',
            'value'=>'$data->penjamin_nama',  
        ),
        array(
            'header' => 'Rekening Debit',
            'name' => 'rekening_debit',
            'type' => 'raw',
            'filter' => false,
            'value' => '$this->grid->owner->renderPartial("_rekPenjaminD",array("saldonormal"=>"D","penjamin_id"=>$data->penjamin_id),true)',
        ),
        array(
            'header' => 'Rekening Kredit',
            'name' => 'rekeningKredit',
            'type' => 'raw',
            'filter' => false,
            'value' => '$this->grid->owner->renderPartial("_rekPenjaminK",array("saldonormal"=>"K","penjamin_id"=>$data->penjamin_id),true)',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>