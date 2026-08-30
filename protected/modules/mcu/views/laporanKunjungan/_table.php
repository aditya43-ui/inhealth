<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintKunjungan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableKunjungan();
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
			'header'=>'Tanggal Pendaftaran',
			'type'=>'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
		),
		'no_pendaftaran',
		'no_rekam_medik',
		'nama_pasien',
		array(
			'header'=>'Tanggal Lahir',
			'type'=>'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
		),
		'umur',
		'jeniskelamin',
		'alamat_pasien',
		'penjamin_nama',
		'dokter',
		'jeniskasuspenyakit_nama',
		array(
		   'header'=>'Paket Tindakan',
		   'value' => 'number_format($data->pakettindakan)',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
		   'header'=>'Non Paket Tindakan',
		   'value' => 'number_format($data->non_pakettindakan)',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>