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
            'header' => 'No. Penerimaan',
            'value' => '$data->noren_penerimaan',
            'type' => 'raw',
        ),
        array(
            'header' => 'Tahun Periode',
            'value' => '$data->deskripsiperiode',
            'type' => 'raw',
        ),
        array(
            'header' => 'Bulan Penerimaan',
            'value' => 'MyFormatter::formatMonthForUser(date("m-Y",strtotime($data->tglrenanggaranpen)))',
            'type' => 'raw',
        ),
        array(
            'header' => 'Sumber Anggaran',
            'value' => '$data->sumberanggarannama',
            'type' => 'raw',
        ),
        array(
            'header' => 'Nilai Anggaran (Rp)',
            'value' => 'MyFormatter::formatNumberForPrint($data->nilaipenerimaananggaran)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Nilai Realisasi (Rp)',
            'value' => 'MyFormatter::formatNumberForPrint($data->realisasipenerimaan)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
)); ?>