<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
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
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }


$dataTotal = $model->searchPrint();
$dataTotal->pagination = false;
$total = 0;

foreach ($dataTotal->data as $item) {
    $total += $item->jml_tarif_tindakan;
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
                'header'=>'NO. URUT',
                'value' => $row,
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footer' => 'Subtotal',
                'footerHtmlOptions' => array(
                    'style'=>'font-weight: bold',
                    'colspan'=>6
                ),
             ),
             array(
                'name' => 'no_pendaftaran',
                'header'=>'NO. BILLING',
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footer' => false,
                'footerHtmlOptions' => array(
                    'hidden'=>true
                ),
              ),
              array(
                 'name' => 'no_nota',
                 'header'=>'NO. NOTA',
                 'headerHtmlOptions' => array('style' => 'text-align: center;'),
                 'footer' => false,
                 'footerHtmlOptions' => array(
                     'hidden'=>true
                 ),
 
              ),
              array(
                 'name' => 'nama_pasien',
                 'header'=>'NAMA PASIEN',
                 'headerHtmlOptions' => array('style' => 'text-align: center;'),
                 'footer' => false,
                 'footerHtmlOptions' => array(
                     'hidden'=>true
                 ),
 
              ),
              array(
                 'name' => 'carabayar_nama',
                 'header'=>'CARA BAYAR',
                 'headerHtmlOptions' => array('style' => 'text-align: center;'),
                 'footer' => false,
                 'footerHtmlOptions' => array(
                     'hidden'=>true
                 ),
 
              ),
              array(
                'name' => 'penjamin_nama',
                'header'=>'PENJAMIN',
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footerHtmlOptions' => array(
                    'hidden'=>true
                ),

             ),
              array(
                'name' => 'tarif_tindakan',
                'header'=>'JUMLAH',
                'value' => 'MyFormatter::formatNumberForPrint($data->jml_tarif_tindakan)',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footer'=>MyFormatter::formatNumberForPrint($total),
                'footerHtmlOptions' => array('style' => 'text-align: right; font-weight: bold;'),
              ),

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>