<?php 
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        echo "<style>                    
                    .table thead:first-child{
                        border-top:1px solid #000;        
                    }

                    thead th{
                        background:none;
                        color:#333;
                        border:1px solid #333;
                    }
                    
                    .a tbody td{
                        border:1px solid #333;
                    }
                    
                    .a{
                        box-shadow:none;
                    }

                    .table tbody tr:hover td, .table tbody tr:hover th {
                        background-color: none;                        
                    }
            </style>";
        $itemsCssClass='table a';
		$row = '$row+1';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-bordered datatable';
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'columns'=>array( 
	    array(
		'header' => 'No.',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
				'value' => $row
	    ),
		array(
                    'header'=>'Tanggal Faktur/<br>No Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'type' => 'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglfaktur)." / ".$data->nofaktur ',
                ),                
                array(
                    'header'=>'Nama Supplier',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'$data->supplier->supplier_nama',
                ),
                array(
                    'header'=>'Tanggal Jatuh Tempo',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
                ),
                array(
                    'header'=>'Keterangan Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => '$data->keteranganfaktur',
                ),
//                'totharganetto',
                array(
                    'header'=>'Total Harga Netto',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totharganetto,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
//                'jmldiscount',
                array(
                    'header'=>'Jumlah Keringanan',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->jmldiscount,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
//                'biayamaterai',
//                'totalpajakpph',
                array(
                    'header'=>'Total Pajak Pph',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totalpajakpph,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
//                'totalpajakppn',
                array(
                    'header'=>'Total Pajak Ppn',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totalpajakppn,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
//                'totalhargabruto', 
                array(
                    'header'=>'Total Harga Bruto',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totalhargabruto,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>