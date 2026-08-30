<?php 
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchInformasi();
        $data->pagination = false;
        $data->criteria->limit = -1;
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
    
    $total = 0;
    $prov = $model->searchInformasi();
    $prov->pagination = false;
    $prov->criteria->limit = -1;
    
    foreach ($prov->data as $item) {
        $total += $item->totalharga;
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'columns'=>array( 
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>'Total Pengeluaran',
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;',
                        'colspan'=>8,
                    ),
                    'value' => $data->pagination ? '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1' : '$row+1',
                ),
                array(
                    'name'=>'tglpengeluaran',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpengeluaran))',
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'nopengeluaran',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'jenispengeluaran.jenispengeluaran_nama',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'kelompoktransaksi',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'volume',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'satuanvol',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array('name'=>'hargasatuan',
                    'header'=>'Harga Satuan',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->hargasatuan)',
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array('name'=>'totalharga',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalharga)',
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($total),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;',
                    ),
                ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>