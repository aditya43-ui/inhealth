<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<div id="div_rs">
    <?php if(isset($caraPrint)){ 
        
    }else{ ?>
            <legend class="rim">Tabel Pendapatan Ruangan Laboratorium- dari RS</legend>
    <?php } ?>
    <?php $this->widget($table,array(
	'id'=>'tablePendapatanRS',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header'=>'No. Lab',
                    'type'=>'raw',
                    'value'=>'$data->no_masukpenunjang',
                    'headerHtmlOptions'=>array('style'=>'text-align:center'),
                ),
                array(
                    'header'=>'Nama',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'text-align:center'),
                ),
                array(
                    'header'=>'Kedatangan',
                    'type'=>'raw',
                    'value'=>'(empty($data->asalrujukan_nama) ? Yii::app()->user->getState("nama_rumahsakit") : $data->asalrujukan_nama)',
                    'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    'footerHtmlOptions'=>array('colspan'=>4,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Jumlah Total',
                ),
                array(
                    'header'=>'Pend. Seharusnya',
                    'type'=>'raw',
                    'name'=>'pend_seharusnya',
                    'value'=>'number_format($data->pend_seharusnya)',
                    'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(pend_seharusnya)',
                ),
                array(
                    'header'=>'Pend. Sebenarnya',
                    'type'=>'raw',
                    'name'=>'pend_sebenarnya',
                    'value'=>'number_format($data->pend_sebenarnya)',
                    'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(pend_sebenarnya)',
                ),
                array(
                    'header'=>'Sisa',
                    'type'=>'raw',
                    'name'=>'sisa',
                    'value'=>'number_format($data->sisa)',
                    'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(sisa)',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>

<div id="div_luar">
    <?php if(isset($caraPrint)){ 
            $dataLuar = $model->searchPrintPendapatanLuar();
    }else{ 
        $dataLuar = $model->searchPendapatanLuar();
   ?>
            <legend class="rim">Tabel Pendapatan Ruangan - dari Luar RS</legend>
    <?php } ?>
    <?php $this->widget($table,array(
            'id'=>'tablePendapatanLuar',
            'dataProvider'=>$dataLuar,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header' => 'No',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                        'header'=>'No. Lab',
                        'type'=>'raw',
                        'value'=>'$data->no_masukpenunjang',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ),
                    array(
                        'header'=>'Nama',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ),
                    array(
                        'header'=>'Kedatangan',
                        'type'=>'raw',
                        'value'=>'(empty($data->asalrujukan_nama) ? "RUMAH SAKIT" : $data->asalrujukan_nama)',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                        'footerHtmlOptions'=>array('colspan'=>4,'style'=>'text-align:right;font-style:italic;'),
                        'footer'=>'Jumlah Total',
                    ),
                    array(
                        'header'=>'Pend. Seharusnya',
                        'type'=>'raw',
                        'name'=>'pend_seharusnya',
                        'value'=>'number_format($data->pend_seharusnya)',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>'sum(pend_seharusnya)',
                    ),
                    array(
                        'header'=>'Pend. Sebenarnya',
                        'type'=>'raw',
                        'name'=>'pend_sebenarnya',
                        'value'=>'number_format($data->pend_sebenarnya)',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>'sum(pend_sebenarnya)',
                    ),
                    array(
                        'header'=>'Sisa',
                        'type'=>'raw',
                        'name'=>'sisa',
                        'value'=>'number_format($data->sisa)',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>'sum(sisa)',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
