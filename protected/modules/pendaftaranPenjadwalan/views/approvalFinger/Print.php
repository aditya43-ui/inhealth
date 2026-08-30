
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
            'header' => 'Tanggal SEP',
            'type' => 'raw',
            'value' => 'isset($data->sep->tglsep) ? $data->sep->tglsep : ""',
        ),
        array(
            'header' => 'No. SEP',
            'type' => 'raw',
            'value' => 'isset($data->sep->nosep)? $data->sep->nosep : ""',
        ),
        array(
            'header' => 'No. Peserta',
            'type' => 'raw',
            'value' => '$data->no_kartu_bpjs',
        ),
        array(
            'header' => 'No. Pendaftaran',
            'type' => 'raw',
            'value' => '$data->pendaftaran->no_pendaftaran',
        ),
        array(
            'header' => 'No. RM',
            'type' => 'raw',
            'value' => '$data->pendaftaran->pasien->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien/Peserta',
            'type' => 'raw',
            'value' => '$data->pendaftaran->pasien->nama_pasien',
        ),
        array(
            'header' => 'Jenis Pelayanan',
            'type' => 'raw',
            'value' => '($data->jenis_pelayanan==2)? "Rawat Jalan" : "Rawat Inap"',
        ),
        array(
            'header' => 'Approve',
            'type' => 'raw',
            'value' => '($data->is_approval==TRUE)? "Sudah Approve" : "Belum"',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'SEP',
            'type' => 'raw',
            'value' => 'empty($data->sep_id)? "SEP belum dibuat" : "SEP sudah dibuat"',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        ),
    ),
));
?>