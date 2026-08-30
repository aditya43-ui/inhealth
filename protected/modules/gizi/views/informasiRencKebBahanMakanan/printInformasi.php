
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

    if ($caraPrint=='EXCEL') {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));      
    } else {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

    }
    
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
    'id' => 'rencana-m-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'name' => 'renkebbahanmakanan_tgl',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->renkebbahanmakanan_tgl)',
        ),
        'renkebbahanmakanan_no',
        array(
            'name' => 'ro_bahanmakanan_bulan',
            'value' => '$data->ro_bahanmakanan_bulan',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Sumber Dana',
            'type'=>'raw',
            'value' => '$data->sumberdana_nama',
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'type' => 'raw',
            'value' => 'InformasirenkebbahanmakananV::pegawaimengetahui($data->pegmengetahui_id)',
        ),
        array(
            'header' => 'Pegawai Menyetujui',
            'type' => 'raw',
            'value' => 'InformasirenkebbahanmakananV::pegawaimengetahui($data->pegmenyetujui_id)',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>