<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchLaporan();
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
} else {
    $data = $model->searchLaporan();
}
?>
<?php $this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'itemsCssClass' => 'table table-striped table-condensed',
    'template' => $template,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
        ),
        array(
            'header' => 'No. Pengeluaran',
            'value' => '$data->rencanggaranpeng_no',
            'type' => 'raw',
        ),
        array(
            'header' => 'Tahun Periode',
            'value' => '$data->deskripsiperiode',
            'type' => 'raw',
        ),
        array(
            'header' => 'Bulan Pelaksanaan',
            'value' => 'MyFormatter::formatMonthForUser(date("m-Y",strtotime($data->rencanggaranpeng_tgl)))',
            'type' => 'raw',
        ),
        array(
            'header' => 'Unit',
            'value' => '$data->namaunitkerja',
            'type' => 'raw',
        ),
        array(
            'header' => 'Total Nilai Alokasi (Rp)',
            'value' => 'MyFormatter::formatNumberForPrint($data->total_nilairencpeng)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Nilai Yang Disetujui (Rp)',
            'value' => 'MyFormatter::formatNumberForPrint($data->nilaiygdisetujui)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => '(%)',
            'value' => 'MyFormatter::formatNumberForPrint(($data->nilaiygdisetujui / $data->total_nilairencpeng)*100,2)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
)); ?>