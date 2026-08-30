
<?php

if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php

if (!empty($caraPrint) && $caraPrint != 'CSV') {

    echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    
    .table{
        box-shadow:none;
        border: 1px solid black;
        border-radius: 0;
    }
    
    .table-bordered {
        border-collapse: collapse;
    }
        
    .table th, .table td {
        border: 1px solid black;
        color: black !important;    
    }
    
    .table-bordered th + th {
        border-left: none;
    }
    
    .table-bordered td + td {
        border-left: none;
    }

    .kertas{
     width:20cm;
     height:12cm;
    }
');

    echo $this->renderPartial('application.views.headerReport.headerRincian', array('judulLaporan' => $judulLaporan));
}

$grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

$prov = $model->searchInformasi();
$prov->pagination = false;
$prov->sort = false;

$this->widget($grid_view, array(
    'id' => 'gupemakaianbarang-t-grid',
    'dataProvider' => $model->searchInformasi(),
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header' => 'Tgl. Retur/<br>No. Retur',
            'type' => 'raw',
            //  	'value'=>'MyFormatter::formatDateTimeForUser($data->tglreturterima)',
            'value' => function($data) {
                return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($data->tglreturterima) . '/<br>' . $data->noreturterima . '</u>', Yii::app()->controller->createUrl("detailInformasi", array("id" => $data->returpenerimaan_id)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Retur Barang", "onclick" => "window.parent.$('#dialogDetail').dialog('open')"));
            }
        ),
        array(
            'header' => 'Tgl. Penerimaan/<br>No Penerimaan',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($data->tglterima) . '/<br>' . $data->nopenerimaan . '</u>', Yii::app()->controller->createUrl("/gudangUmum/TerimapersediaanT/detailTerimaPersediaan", array("id" => $data->terimapersediaan_id, "frame" => 1)), array("target" => "frameDetailTerima", "rel" => "tooltip", "title" => "Klik untuk Detail Penerimaan Barang", "onclick" => "window.parent.$('#dialogDetailTerima').dialog('open')"));
            }
        ),
        array(
            'header' => 'Alasan Retur',
            'value' => '$data->alasanreturterima'
        ),
        array(
            'header' => 'Operator',
            'value' => function($data) {
                return $data->pegretur_gelardepan . ' ' . $data->pegretur_nama . ' ' . $data->pegretur_gelarbelakang;
            }
        ),
        array(
            'header' => 'Mengetahui',
            'value' => function($data) {
                $peg = PegawaiM::model()->findByPk($data->pegreturmengetahui_id);

                if (!empty($peg)) {
                    return $peg->namaLengkap;
                }
            }
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier_nama'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>