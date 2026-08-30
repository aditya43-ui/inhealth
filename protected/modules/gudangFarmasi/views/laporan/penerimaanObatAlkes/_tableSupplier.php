<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $data = $model->searchLaporanPenerimaanObatAlkesSupplier();
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
		
		$itemCss = 'table border';
    } else{
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 

$data2 = $model->searchLaporanPenerimaanObatAlkesSupplier();
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
	//'extraRowColumns'=> array('supplier_id'),
	'columns'=>array( 
//                array(
//                    'value'=>'$data->no',
//                    'header'=>'No.',
//                    'filter'=>false,
//                ),	 
        array(
			'header' => 'No.',
			'value' => $row
		),
		array(
			'header'=>'Tgl. Terima',
			'name'=>'noterima',
			'type'=>'raw',
			'value'=>'MyFormatteR::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterima)))'
		),
		array(
			'header'=>'No. Terima',
			'name'=>'noterima',
			'type'=>'raw',
			'value'=>'$data->noterima',
		),
		array(
			'header'=>'No. Faktur',
			'name'=>'noterima',
			'type'=>'raw',
            'value'=>function($data) {
                $faktur = FakturpembelianT::model()->findByAttributes(array(
                    'penerimaanbarang_id'=>$data->penerimaanbarang_id,
                ));
                
                if (empty($faktur)) {
                    return "-";
                }
                
                return $faktur->nofaktur;
            },
		),
        array(
			'header'=>'Supplier',
            'name'=>'supplier_nama',
			'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight: bold;','colspan'=>5),
            'footer'=>"Total",
        ),
		array(
			'header'=>'Total Harga Netto',
			'type'=>'raw',
			'value'=>'number_format($data->harganettoper, 0, ",", ".")',                    
			'htmlOptions'=>array('style'=>'text-align:right'),
			'name'=>'harganettoper',
            'footer'=>'sum(harganettoper)',
            'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
		),
		array(
			'header'=>'Total Keringanan',
			'type'=>'raw',
			'value'=>'number_format($data->jmldiscount, 0, ",", ".")',                    
			'htmlOptions'=>array('style'=>'text-align:right'),
			'name'=>'jmldiscount',
            'footer'=>'sum(jmldiscount)',
            'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
		), 
		array(
			'header'=>'Total PPN',
			'type'=>'raw',
			'value'=>'number_format($data->hargappn, 0, ",", ".")',
			'htmlOptions'=>array('style'=>'text-align:right'),
			'name'=>'hargappn',
            'footer'=>'sum(hargappn)',
            'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
			
		),  
		array(
			'header'=>'Total Harga Bruto',
			'type'=>'raw',
			'value'=>'number_format($data->totalharga, 0, ",", ".")',                    
			'htmlOptions'=>array('style'=>'text-align:right'),
			'name'=>'totalharga',
            'footer'=>MyFormatter::formatNumberForPrint($total),
            'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
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