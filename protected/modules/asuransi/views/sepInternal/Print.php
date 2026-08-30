
<?php
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
}

echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => ''));

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => false,
    'dataProvider' => $model->searchPrint(),
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                : ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'No. Rujukan Internal/ No. SEP Rujukan',
            'type' => 'raw',
            'value' => '$data->nosurat_rujukaninternal." / ".$data->nosep',
        ),
        array(
            'header' => 'Tanggal Rujukan Internal',
            'type' => 'raw',
            'value' => '(isset($data->tglkonsulpoli) ? MyFormatter::formatDateTimeForUser($data->tglkonsulpoli) : "")',
        ),
        array(
            'header' => 'No. Sep / Tanggal SEP',
            'type' => 'raw',
            'value' => '$data->nosep_utama." / ".(isset($data->tglsep_utama) ? MyFormatter::formatDateTimeForUser($data->tglsep_utama) : "")',
        ),
        array(
            'header' => 'No. Peserta',
            'type' => 'raw',
            'value' => '$data->nokartuasuransi',
        ),
        array(
            'header' => 'No. Pendaftaran / No. Rekam Medik',
            'type' => 'raw',
            'value' => '$data->no_pendaftaran." / ".$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien (Peserta)',
            'type' => 'raw',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Dokter DPJP Tujuan',
            'type' => 'raw',
            'value' => function($data) {
                return $data->gelardepan.$data->nama_pegawai.", ".$data->gelarbelakang_nama;
            }
        ),
        array(
            'header' => 'Ruangan Asal',
            'type' => 'raw',
            'value' => '$data->ruanganasal_nama',
        ),
        array(
            'header' => 'Ruangan Tujuan',
            'type' => 'raw',
            'value' => '$data->ruangantujuan_nama',
        ),
        array(
            'header' => 'Ruangan Tujuan',
            'type' => 'raw',
            'value' => '($data->lakalantas==1)? "YA" : "TIDAK"',
        ),
        array(
            'header' => 'Diagnosa',
            'type' => 'raw',
            'value' => '$data->nama_diagnosaawal',
        ),

    ),
));
?>