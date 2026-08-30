<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchLaporanPrint();
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
        $data = $model->searchLaporan();
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
               'header'=>'NO.',
               'value' => $row,
               'headerHtmlOptions' => array('style' => 'text-align: center;')

            ),

            array(
                'name' => 'no_pendaftaran',
                'header'=>'NO. BILLING',
                'headerHtmlOptions' => array('style' => 'text-align: center;')

             ),

             array(
                'name' => 'nopembayaran',
                'header'=>'NO. BUKTI',
                'headerHtmlOptions' => array('style' => 'text-align: center;')
 
             ),

             array(
                'name' => 'nama_pasien',
                'header'=>'NAMA PASIEN',
                'headerHtmlOptions' => array('style' => 'text-align: center;')

             ),
              
             array(
                'name' => 'totalbiayatindakan',
                'header'=>'JUMLAH',
                'value' =>  '"Rp. " . MyFormatter::formatNumberForPrint($data->totalbiayatindakan)',
                'htmlOptions' => array('style' => 'text-align: right; width: 250px;'),
                'headerHtmlOptions' => array('style' => 'text-align: center;')

             ),

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>