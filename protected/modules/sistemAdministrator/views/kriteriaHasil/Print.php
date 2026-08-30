<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'colspan' => 10));

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
            'header' => 'No.',
            'value' => '$row+1',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Luaran Keperawatan',
            'name' => 'luarankeperawatan_id',
            'value' => 'isset($data->kriteriahasil->luarankeperawatan->luarankeperawatan_nama) ? $data->kriteriahasil->luarankeperawatan->luarankeperawatan_nama : " - "',
        ),
        array(
            'header' => 'Kriteria Hasil',
            'name' => 'kriteriahasil_nama',
            'value' => 'isset($data->kriteriahasil->kriteriahasil_nama) ? $data->kriteriahasil->kriteriahasil_nama : " - "',
        ),
        array(
            'header' => 'Indikator',
            'value' => 'isset($data->kriteriahasildet_indikator) ? $data->kriteriahasildet_indikator : " - "',
        ),
        array(
            'header' => 'Status',
            'value' => '($data->kriteriahasildet_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
        ),
    ),
));
?>