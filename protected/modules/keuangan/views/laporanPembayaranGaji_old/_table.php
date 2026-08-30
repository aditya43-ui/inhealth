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
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
	    'name'=>'nokaskeluar',
	    'value'=>'$data->nokaskeluar',
	),
	array(
	    'name'=>'periodegaji',
	    'value'=>'MyFormatter::formatDateTimeForUser($data->periodegaji)',
	),
	array(
	    'name'=>'pegawai_nip',
	    'value'=>'$data->pegawai_nip',
	),
	array(
	    'name'=>'pegawai_nama',
	    'value'=>'$data->pegawai_nama',
	),
	array(
	    'name'=>'totalterima',
	    'value'=>'number_format($data->totalterima)',
	),
	array(
	    'name'=>'totalpotongan',
	    'value'=>'number_format($data->totalpotongan)',
	),
	array(
	    'name'=>'penerimaanbersih',
	    'value'=>'number_format($data->penerimaanbersih)',
	),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>