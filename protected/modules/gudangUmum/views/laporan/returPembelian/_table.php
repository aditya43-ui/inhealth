<?php 
    $itemCssClass='table table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
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
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass='table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                /*array(
                    'header'=>'No.',
                    'value' => $row,
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),*/
                array(
                    'header' => 'Tanggal Retur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglretur)))',
                ),
                array(
                    'header' => 'No. Penerimaan',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->noretur',
                ),
                array(
                    'header' => 'Alasan Retur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->alasanretur',
                ),
                array(
                    'header' => 'Instalasi <br> / Ruangan',
                    'type' => 'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->instalasi_nama." <br> / ".$data->ruangan_nama'
                ),
                array(
                    'header' => 'Tanggal Terima',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglterima)'
                ),
                array(
                    'header' => 'Tanggal Terima Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglterimafaktur)'
                ),
                array(
                    'header' => 'Tanggal Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)'
                ),     
                array(
                    'header' => 'Tanggal Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                    'value' => '$data->nofaktur'
                ),   
                array(
                    'header' => 'Tanggal Jatuh Tempo',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)'
                ), 
                array(
                    'header' => 'Supplier',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                    'value' => '$data->supplier_nama'
                ), 
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>