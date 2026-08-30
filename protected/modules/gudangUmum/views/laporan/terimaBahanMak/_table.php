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
				
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
                border-spacing: 0;
                padding: 0;
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
                array(
                    'header'=>'No.',
                    'value' => $row,
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header' => 'Tanggal Penerimaan',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterimabahan)))',
                ),
                array(
                    'header' => 'No. Penerimaan',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->nopenerimaanbahan',
                ),
                array(
                    'header' => 'Tanggal Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'isset($data->tglfaktur)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur))):""',
                ),
                array(
                    'header' => 'No. Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->nofaktur'
                ),
                array(
                    'header' => 'Supplier',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->supplier_nama'
                ),
                array(
                    'header' => 'Pegawai Penerima',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                    'value' => '$data->namaLengkap',                    
                ),
                array(
                    'header' => 'Bahan Makanan',                    
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->namabahanmakanan',
                    //'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold'),
                    //'htmlOptions'=>array('style'=>'text-align:right;'),
                    //'footer'=>'sum(hargasatuan)',
                ),
                array(
                    'header' => 'Jml Terima',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'number_format($data->qty_terima,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;')
                ),
                array(
                    'header' => 'Harga Netto (Rp)',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'number_format($data->harganettobhn,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right'),
                    //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    //'footer'=>'-',
                ),
                array(
                    'header' => 'Subtotal (Rp)',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'number_format($data->totalharganetto,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;')
                    //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    //'footer'=>'-',
                ),                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>