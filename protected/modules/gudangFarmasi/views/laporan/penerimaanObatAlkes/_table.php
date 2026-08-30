<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $data = $model->searchLaporanPenerimaanObatAlkes();
    $sort = true;
    $header_noterima = "No. Penerimaan"; //;'<div style="cursor:pointer;" onclick="printByPenerimaan(\'PRINT\')" title="Print Group Berdasarkan Penerimaan"> No. Penerimaan <icon class="entypo-print"></icon></div>';
    $header_obatalkes = "Nama Obat dan Alkes"; //'<div style="cursor:pointer;" onclick="printByObat(\'PRINT\')" title="Print Group Berdasarkan Obat"> Obat Alkes <icon class="entypo-print"></icon></div>';
	$itemCss = 'table table-striped table-bordered table-condensed';
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
		$row = '$row+1';
        $header_noterima = "No. Penerimaan";
        $header_obatalkes = "Nama Obat dan Alkes";
        $template = "{items}";
        $sort = false;
        $data->pagination = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
		if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
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
		$itemCss = 'table border';
				
    } else{
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 

$data2 = $model->searchLaporanPenerimaanObatAlkes();
$total = 0;

$data2->pagination = false;

foreach ($data2->data as $item) {
    $total += $item->totalharga;
}

$this->widget($table,array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>$itemCss,
	'mergeColumns'=>array('noterima', 'tglterima'),
	//'extraRowColumns'=> array('supplier_id'),
	'columns'=>array( 
//                array(
//                    'value'=>'$data->no',
//                    'header'=>'No.',
//                    'filter'=>false,
//                ),	 
        /*
		array(
			'header'=>$header_noterima,
			'name'=>'noterima',
			'type'=>'raw',
			'value'=>'$data->noterima',
		),
         * 
         */
		 array(
			'header' => 'No.',
			'value' => $row
		),
		array(
			'header'=>'Tgl. Terima',
			'name'=>'noterima',
			'type'=>'raw',
			'value'=>'MyFormatteR::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur)))'
		),
		array(
			'header'=>'Kode Obat dan Alkes',
			'type'=>'raw',
			'value'=>'$data->obatalkes_kode',
		),
		array(
			'header'=>$header_obatalkes,
			'type'=>'raw',
			'value'=>'$data->nama_obat',
		),
		array(
			'header'=>'Jumlah Terima',
			'name'=>'jumlahterima',
			'type'=>'raw',
			'value'=>'$data->jumlahterima',                    
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		array(
			'header'=>'Harga Netto',
			'type'=>'raw',
			'value'=>'number_format($data->harganettoper, 0, ",", ".")',                    
			'htmlOptions'=>array('style'=>('text-align: right;')),
		),
		array(
			'header'=>'Keringanan (Rp)',
			'type'=>'raw',
			'value'=>'number_format($data->jmldiscount, 0, ",", ".")',                    
			'htmlOptions'=>array('style'=>'text-align:right'),
		), 
		array(
			'header'=>'HPP',
			'type'=>'raw',
			'value'=>'number_format($data->hpp, 0, ",", ".")',
			'htmlOptions'=>array('style'=>'text-align:right'),
			'footerHtmlOptions'=>array('style'=>('text-align: right;font-weight: bold;')),
            'footer'=>"Total",
		),  
		array(
			'header'=>'Subtotal',
			'type'=>'raw',
			'value'=>'number_format($data->totalharga, 0, ",", ".")',                    
			'htmlOptions'=>array('style'=>('text-align: right;')),
            'footer'=>MyFormatter::formatNumberForPrint($total),
            'footerHtmlOptions'=>array('style'=>('text-align: right;font-weight: bold;')),
		), 
            
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php 
$urlPrintDetail = $this->createUrl('laporan/PrintLaporanPenerimaanObatAlkesDetail');
$urlPrintByObat = $this->createUrl('laporan/PrintLaporanPenerimaanObatAlkesByObat');
$urlPrintByPenerimaan = $this->createUrl('laporan/PrintLaporanPenerimaanObatAlkesByPenerimaan');
?>
<script>
    function printDetail(caraPrint){
        window.open("<?php echo $urlPrintDetail; ?>/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=1024px, scrollbars=yes');
    }
    function printByObat(caraPrint){
        window.open("<?php echo $urlPrintByObat; ?>/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=1024px, scrollbars=yes');
    }
    function printByPenerimaan(caraPrint){
        window.open("<?php echo $urlPrintByPenerimaan; ?>/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=1024px, scrollbars=yes');
    }
</script>