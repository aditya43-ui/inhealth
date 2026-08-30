
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'ID',
            'value' => '$data->golongangaji_id',
        ),
        array(
            'header' => 'Golongan',
            'value' => '$data->golonganpegawai->golonganpegawai_nama'
        ),
        array(
            'header' => 'Golongan',
            'value' => '$data->masakerja',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Jumlah Gaji (Rp)',
            'value' => 'MyFormatter::formatNumberForPrint($data->jmlgaji)',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Jenis Golongan',
            'value' => '$data->jenisgolongan'
        ),
        array(
            'header' => 'Aktif',
            'type' => 'raw',
            'value' => '(($data->golongangaji_aktif==TRUE)? "Aktif" : "Tidak Aktif")',
        ),

    ),
));
?>