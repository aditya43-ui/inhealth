<?php 
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header'=>'Ruangan',
                    'value'=> '$data->ruanganasal_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;color:black;font-weight:bold'),
                    'footer'=>'JUMLAH',
                ),
                array(
                    'header'=>'JML',
                    'value'=> '$data->jmlkonsulgizi',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                    'footer'=>'@_@',

                ),
                array(
                    'header' => 'Rata-Rata Sehari',
                    'value' => '"-"',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                    'footerHtmlOptions'=>array('style'=>'text-align:center;color:black;font-weight:bold'),
                    'footer'=>0,
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>