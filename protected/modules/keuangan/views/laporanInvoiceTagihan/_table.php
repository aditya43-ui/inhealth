<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTabel();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $row = '$row+1';
    $sort = false;
    $data = $model->cariPrint();  
    $template = "{items}";
    if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-bordered datatable',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $row,
            ),
            array(
                'header'=>'No. Invoice',
                'type'=>'raw',
                'value'=>'$data->invoicetagihan_no',
            ),
            array(
                'header'=>'Tanggal Invoice',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->invoicetagihan_tgl)',
            ),
            array(
                'header'=>'Dari',
                'type'=>'raw',
                'value'=>'$data->namapenagih',
            ),
            array(
                'header'=>'Perihal',
                'type'=>'raw',
                'value'=>'$data->perihal_tagihan',
            ),
            array(
                'header'=>'Rekanan',
                'type'=>'raw',
                'value'=>'$data->rekanan_tagihan',
            ),
            array(
                'header'=>'Total Tagihan',
                'type'=>'raw',
				'htmlOptions' => array('style' => 'text-align: right;'),
                'value'=>'number_format($data->total_tagihan,0,"",".")',
            ),
            array(
               'name'=>'Tanggal Verifikasi',
               'type'=>'raw',
               'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_verfikasi_tagihan)',
            ),
			array(
               'name'=>'Nama Verifikator',
               'type'=>'raw',
               'value'=>'$data->verifikator_nama',
            ),
			array(
               'name'=>'Status Verifikasi',
               'type'=>'raw',
               'value'=>'$data->status_verifikasi',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>