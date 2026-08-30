<?php

$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$itemsCssClass='table table-striped table-condensed';
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
    $itemsCssClass='table border';
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
            'header' => 'No. Rekam Medik',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) {
                return $data->namadepan.$data->nama_pasien;
            }
            //'value' => '$data->gelardepan.$data->nama_pegawai.", ".$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Jenis',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->jenisdiet_nama'
        ),
        array(
            'header' => 'Jenis Diet',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->menudiet_nama'
        ),
//                array(
//                    'header' => 'No. Gizi',
//                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
//                    'value' => '$data->no_masukpenunjang',
//                ),
        array(
            'header' => 'Jumlah',
            'headerHtmlOptions' => array('style' => 'text-align: right;vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => 'number_format($data->jml_kirim,0,"",".")',
        ),
        array(
            'header' => 'Ruangan',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => '$data->ruangan_nama',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
        ),
        array(
            'header' => 'Tanggal Transaksi',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
        ),
        array(
            'header' => 'Tanggal Pemberian',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
        ),
        array(
            'header' => 'Jam Pemberian',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$data->jeniswaktu_jam',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
        ),
//                array(
//                    'header' => 'Hari',
//                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
//                    'value' => 'date("l,strtotime($data->tglkirimmenu")',
//                ),
        array(
            'header' => 'Waktu',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$data->jeniswaktu_nama',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>