<?php 
     $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $mod = $model->searchLaporanPrint();
        $template = "{items}";
        $sort = false;
  
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
        $mod = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'laporan-grid',
	'dataProvider'=>$mod,
        'template'=>$template,
        'enableSorting'=>$sort,
        //'mergeHeaders'=>array(
          //  array(
            //    'name'=>'<p style="margin: 0; text-align: center;">Tarif</p>',
              //  'start'=>8, //indeks kolom 3
                //'end'=>9, //indeks kolom 4
            //),
        //),
        'itemsCssClass'=>$itemCssClass,
	'columns' => array(
		array(
                    'header' => 'No.',
                    'headerHtmlOptions' => array('style' => 'text-align:left;'),
                    'value' => $row,
                    'footerHtmlOptions' => array('colspan'=>6,'style' => 'text-align:right;'),
                    'footer' =>' '
		),		
		array(
			'header' => 'Tgl. Faktur/<br> No Faktur',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))."/ <br>".$data->nopenerimaan',
		),      
		array(
                    'header' => 'Tgl. Jatuh Tempo',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
		),
		array(
                    'header' => 'Umur Utang',
                    'type' => 'raw',
                    'value' => '$data->umurHutang',
                    'footer' => '<b>Total Utang :</b>',	
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
		),		
		array(
                    'header' => 'Keterangan Faktur',
                    'type' => 'raw',
                    'value' => '$data->keterangan_persediaan',
		),
		array(
					'header'=>'Status Bayar',
					'type' => 'raw',
					'value' => function($data){
							if (empty($data->bayarkesupplier_id)){
								return Params::STATUSBAYAR_BELUM_LUNAS;
							}else{
								return Params::STATUSBAYAR_LUNAS;
							}
					}
				),
		array(
			'header' => 'Supplier',
			'value' => '$data->supplier_nama'
		),
                array(
			'header' => 'Total Harga Bruto',
			'value' => 'MyFormatter::formatNumberForPrint($data->totalhargabruto)',
			'footer' => 'sum(totalhargabruto)',
			'footerHtmlOptions' => array('style' => 'text-align:right;'),
			'htmlOptions' => array('style'=>'text-align: right;'),
			'name'=>'totalhargabruto'
		),		
		array(
                    'header' => 'Total Keringanan',
                   'name' => 'discount',
                  //  'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->discount)',
                    'footer' => 'sum(discount)',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
                    'header' => 'Total PPh',
                    'name' => 'pajakpph',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pajakpph)',
                    'footer' => 'sum(pajakpph)',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
                    'header' => 'Pajak PPN',
                    'name' => 'pajakppn',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pajakppn)',
                    'footer' => 'sum(pajakppn)',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
                    'header' => 'Total Harga Netto',
                    'name' => 'totalharga',                    
                    'value' => 'MyFormatter::formatNumberForPrint($data->totalharga)',
                    //'footer'=>"<b>Rp".number_format($model->getTotalharga(),0,"",".")."</b>",
					'footer'=>'sum(totalharga)',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'htmlOptions' => array('style'=>'text-align: right;'),
					//''
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?> 
<script>
	$('.integer').each(function () {
		formatNumber();
	});
</script>