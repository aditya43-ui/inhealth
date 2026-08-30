<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrintRekap();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableRekap();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableRekapLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
				'header'=>'Total Pasien',
                'value'=>'$data->GetTotalPasien()',
            ), 
		    array(
			   'header'=>'Total ETT', 
			   'value'=>'$data->GetTotalETT()',
			), 
		    array(
			   'header'=>'Total IVL', 
			   'value'=>'$data->GetTotalIVL()',
			), 
		    array(
			   'header'=>'Total CVC', 
			   'value'=>'$data->GetTotalCVC()',
			), 
		    array(
			   'header'=>'Total UC', 
			   'value'=>'$data->GetTotalUC()',
			), 
		    array(
			   'header'=>'Total VAP', 
			   'value'=>'$data->GetTotalVAP()',
			), 
		    array(
			   'header'=>'Total IAD', 
			   'value'=>'$data->GetTotalIAD()',
			), 
		    array(
			   'header'=>'Total PLEB', 
			   'value'=>'$data->GetTotalPLEB()',
			), 
		    array(
			   'header'=>'Total ISK', 
			   'value'=>'$data->GetTotalISK()',
			),
            array(
			   'header'=>'Total CDL', 
			   'value'=>'$data->GetTotalCDL()',
			),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>