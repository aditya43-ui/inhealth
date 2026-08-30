<?php
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->search();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->search();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            'type' => 'raw',
        ),
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->nama_pegawai',
            'type' => 'raw',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'type' => 'raw',
        ),
        array(
            'header' => 'Kategori Pegawai',
            'value' => '$data->kategoripegawai',
            'type' => 'raw',
        ),
        array(
            'header' => 'Jenis Kelamin',
            'value' => '$data->jeniskelamin',
            'type' => 'raw',
        ),
        array(
            'header' => 'STA',
            'value' => '$data->kodeptkp',
            'type' => 'raw',
        ),
        array(
            'header' => 'Gaji',
            'value' => 'number_format($data->totalterima)',
            'type' => 'raw',
        ),
        array(
            'header' => 'Jumlah',
            'value' => 'number_format($data->gajipertahun)',
            'type' => 'raw',
        ),
        array(
            'header' => 'Biaya Jabatan',
            'value' => 'number_format($data->biayajabatan)',
            'type' => 'raw',
        ),
        array(
            'header' => 'JHT / Pensiun',
            'value' => 'number_format($data->potonganpensiun)',
            'type' => 'raw',
        ),
        array(
            'header' => 'Jumlah',
            'value' => 'number_format($data->potonganpensiun + $data->biayajabatan)',
            'type' => 'raw',
        ),
        array(
            'header' => 'Penghasilan Netto',
            'value' => 'number_format($data->gajikotor)',
            'type' => 'raw',
            'footerHtmlOptions' => array('colspan' => 1, 'style' => 'text-align:right;font-style:italic;'),
            'footer' => 'JUMLAH',
        ),
        array(
            'header' => 'PTKP',
            'value' => 'number_format($data->ptkppertahun)',
            'type' => 'raw',

        ),
        array(
            'header' => 'PKP',
            'value' => 'number_format($data->pkp)',
            'type' => 'raw',
        ),
        array(
            'header' => 'PPh 21 per bulan',
            'value' => 'number_format($data->pph21perbulan)',
            'type' => 'raw',
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => number_format($model->getTotalPph21('pph21perbulan'), 0, "", "."),
            'htmlOptions' => array(
                'style' => 'text-align:center',
                'class' => 'integer',
            ),
        ),
    ),
)); ?> 
