<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintLaporanPaket();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchLaporanPaket();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		array(
		   'header'=>'No.',
		   'value' => $row,
		),
		array(
		   'header'=>'Tipe Paket',
		   'value' => '$data->tipepaket_nama',
		),
		array(
		   'header'=>'Nama Pemeriksaan',
		   'value' => '$data->daftartindakan_nama',
		),array(
		   'header'=>'Ruangan',
		   'value' => '$data->ruangan_nama',
		),
		array(
		   'header'=>'Kelas Pelayanan',
		   'value' => '$data->kelaspelayanan_nama',
		),array(
		   'header'=>'Total Tarif',
		   'value' => 'number_format($data->tarifpaket)',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>