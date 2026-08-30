<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchInformasiPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'rencanaumumpengadaan-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row+1',
        ),
        array(
            'header' => 'Nomor&nbsp;dan&nbsp;Tanggal',
            'type' => 'raw',
            'value' => function($data) {
                echo $data->persiapanpengadaan_nomor . " <br> " . MyFormatter::formatDateTimeForUser($data->create_time);
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Nama Pekerjaan',
            'value' => function ($data) {
                echo $data->nama_pekerjaan;
            }
        ),
        array(
            'header' => 'Nilai HPS',
            'value' => function ($data) {
                echo MyFormatter::formatUang($data->total_hps, "Rp.", 2);
            }
        ),
        array(
            'header' => 'Tahun Anggaran',
            'value' => function ($data) {
                echo $data->rencanaumumpengadaan_tahun;
            }
        ),
        array(
            'header' => 'Pejabat Pembuat Komitmen',
            'value' => function ($data) {
                $modPegawai = PegawaiM::model()->findByPk($data->pegppk_id);
                echo $modPegawai->namaLengkap;
            }
        ),
        array(
            'header' => 'Pejabat Pengadaan',
            'value' => function ($data) {
                $modPegawai = PegawaiM::model()->findByPk($data->pegpengadaan_id);
                echo $modPegawai->namaLengkap;
            }
        ),
        array(
            'header' => 'Status',
            'value' => function ($data) {
                echo $data->infoumumpengadaan_status;
            }
        ),
    ),
));
?>