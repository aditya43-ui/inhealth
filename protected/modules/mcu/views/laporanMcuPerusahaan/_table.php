<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintNew();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableNew();
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
		'no_rekam_medik',    
		'NamaNamaBIN',
		'jeniskelamin',
		'umur',
		'alamat_pasien',
		'statuspasien',
		'statusmasuk',
		'kunjungan',
		'statuspasien',
		array(
		   'name'=>'Penjamin',
		   'type'=>'raw',
		   'value'=>'$data->penjamin_nama',
		   'htmlOptions'=>array('style'=>'text-align: left')
		),     
		array(
			'header'=>'Resume Hasil',
			'type'=>'raw',
			'value'=>'""',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>