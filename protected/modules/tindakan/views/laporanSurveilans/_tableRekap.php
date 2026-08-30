<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$itemCssClass='table table-striped table-condensed';
    if (isset($caraPrint)){
        $data = $model->searchPrintRekap();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';}
        echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
          $itemCssClass='table border';
    } else{
        $data = $model->searchTableRekap();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableRekapLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
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
			   'header'=>'Total PVC', 
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
			   'header'=>'Total PO', 
			   'value'=>'$data->GetTotalPO()',
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
            array(
			   'header'=>'Total IDO', 
			   'value'=>'$data->GetTotalIDO()',
			),
          
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>