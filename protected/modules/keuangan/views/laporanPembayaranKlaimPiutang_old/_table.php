<?php 
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchLaporan();
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
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-striped table-condensed';
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
                    'name'=>'tglpembayaranklaim',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpembayaranklaim))',
                ),
                array(
                    'name'=>'nopembayaranklaim',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'$data->nopembayaranklaim',
                ),
		array(
                    'name'=>'totalbayar',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totalbayar)',
                ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>