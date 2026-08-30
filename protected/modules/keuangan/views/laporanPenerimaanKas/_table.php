<?php 
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchInformasi();
        $template = "{items}";
        $sort = false;
//        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        echo "<style>
                .tableRincian thead, th{
                    border: 1px #000 solid;
                }
                .tableRincian{
                    width:100%;
                }
            </style>";
        $itemsCssClass='tableRincian';
    } else{
        $data = $model->searchInformasi();
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
		'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
	    ),
	    array(
                'header'=>'Tgl. Penerimaan',
                'type'=>'raw',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpenerimaan))',
            ),
            array(
                'header'=>'No. Penerimaan',
                'type'=>'raw',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                'value'=>'$data->nopenerimaan',
            ),
            array(
                'header'=>'Kelompok Transaksi',
                'type'=>'raw',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                'value'=>'$data->kelompoktransaksi',
            ),
            array(
                'header'=>'Jenis Penerimaan',
                'type'=>'raw',
                'value'=>'$data->jenispenerimaan->jenispenerimaan_nama',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-style:italic;'),
                'footer'=>'<b>Jumlah Total</b>',
            ),
            array(
                'name'=>'volume',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            ),
//            'satuanvol',
            array(
                'header'=>'Harga',
                'name'=>'hargasatuan',
                'value'=>'number_format($data->hargasatuan,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'htmlOptions'=>array('style'=>'width:100px;text-align:right'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'sum(hargasatuan)',
            ),
            array(
                'header'=>'Total Harga',
                'name'=>'totalharga',
                'value'=>'number_format($data->totalharga,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'htmlOptions'=>array('style'=>'width:100px;text-align:right'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'sum(totalharga)',
            ),
            array(
                'header'=>'Keterangan',
                'type'=>'raw',
                'value'=>'$data->keterangan_penerimaan',
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                'footer'=>'-',
            ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>