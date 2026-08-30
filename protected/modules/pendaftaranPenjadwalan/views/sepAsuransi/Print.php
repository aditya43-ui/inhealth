
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
            'value' => 'isset($data->tglsep) ? MyFormatter::formatDateTimeForUser($data->tglsep) : ""',
        ),
        array(
            'header' => 'No. SEP',
            'type' => 'raw',
            'value' => '$data->nosep',
        ),
        array(
            'header' => 'No. Peserta',
            'type' => 'raw',
            'value' => '$data->nokartuasuransi',
        ),
        array(
            'header' => 'No. Pendaftaran',
            'type' => 'raw',
            'value' => '$data->no_pendaftaran',
        ),
        array(
            'header' => 'No. RM',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien/Peserta',
            'type' => 'raw',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Jenis Pelayanan',
            'type' => 'raw',
            'value' => '($data->jnspelayanan==2)? "Rawat Jalan" : "Rawat Inap"',
        ),
        array(
            'header' => 'Laka Lantas',
            'type' => 'raw',
            'value' => '($data->lakalantas==1)? "YA" : "TIDAK"',
        ),

    ),
));
?>