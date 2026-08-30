<?php

$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$itemsCssClass = 'table table-striped table-condensed';
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrint();
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
    $itemsCssClass = 'table border';
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemsCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'No. Bed',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->kamarruangan_nobed',
        ),
        array(
            'header' => 'Nama',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'No. Pendaftaran',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->no_pendaftaran',
        ),
        array(
            'header' => 'Tanggal Lahir',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
        ),
        array(
            'header' => 'Kelas',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->kelaspelayanan_nama',
            //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
            //'footer' => '-',
        ),
        array(
            'header' => 'Diit',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->menudiet_nama'
        ),
        array(
            'header' => 'Status',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => ''
        ),
        array(
            'header' => 'Pagi',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => ''
        ),
        array(
            'header' => 'Siang',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => ''
        ),
        array(
            'header' => 'Sore',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => ''
        ),
        
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>