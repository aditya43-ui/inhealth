<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$itemCssClass='table table-bordered table-striped table-condensed';
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
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
  if ($caraPrint == "EXCEL") {
      echo $caraPrint;
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
}
?>
<?php 
$this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
            ),
            'noreturresep',
            array(
                'name'=>'tglretur',
                'type'=>'raw',
                'value'=>'MyFormatter::FormatDateTimeForUser(date("d/m/Y H:i:s",strtotime($data->tglretur)))',
            ),
			array(
				'name' => 'nama_pasien'
			),
            array(
                'header'=>'Jenis Penjualan',
                'type'=>'raw',
                'value'=>'$data->jenispenjualan',
            ),
            'obatalkes_nama',
            array(
                'header'=>'Satuan Kecil',
                'type'=>'raw',
                'value'=>'$data->satuankecil_nama',
                'footerHtmlOptions'=>array('colspan'=>7,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'Total',
            ),
            array(
                'header'=>'Jumlah',
                'type'=>'raw',
                'name'=>'qty_retur',
                'value'=>'number_format($data->qty_retur)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(qty_retur)'
            ),
            array(
                'header'=>'Harga Satuan',
                'name'=>'hargasatuan',
                'value'=>'number_format($data->hargasatuan,0,",",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(hargasatuan)'
            ),
            array(
                'header'=>'Sub Total',
                'name'=>'subtotal',
                'value'=>'number_format($data->subtotal,0,",",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(subtotal)'
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>