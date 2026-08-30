<?php

$itemCssClass='table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
    }

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
    $itemCssClass='table border';
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 6));
}
$this->widget($table, array(
    'id' => 'indikatorevaluasi-m-grid',
    'enableSorting' => false,
    'dataProvider' => $model->search(),
    'template' => $template,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$row+1',
        ),
        'kode_indikator',
        'nama_indikator',
        'golongan_indikator',
        array(
            'name' => 'standar_nilai',
            'value' => '$data->standar_nilai." %"',
        ),
        array(
            'header' => 'Status',
            'value' => '($data->is_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
        ),
    ),
));
?>