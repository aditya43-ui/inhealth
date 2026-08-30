
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    $rows = '$row+1';
} else {
    $rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
}
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => ''));

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => false,
    'dataProvider' => $model->searchJenisPengeluaranPrint(),
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => $rows,
        ),
        array(
            'header' => 'Kode',
            'name' => 'jenispengeluaran_kode',
            'value' => '$data->jenispengeluaran_kode',
        ),
        array(
            'header' => 'Jenis Pengeluaran',
            'name' => 'jenispengeluaran_nama',
            'value' => '$data->jenispengeluaran_nama',
        ),
        /*array(
			'header'=>'Nama Lain',
			'name'=>'jenispengeluaran_namalain',
			'value'=>'$data->jenispengeluaran->jenispengeluaran_namalain',
		),*/
        array(
            'header' => 'Rekening Debit',
            'type' => 'raw',
            'value' => '$this->grid->owner->renderPartial("_rekPengeluaranD",array("saldonormal"=>"D","jenispengeluaran_id"=>$data->jenispengeluaran_id),true)',
        ),
        array(
            'header' => 'Rekening Kredit',
            'type' => 'raw',
            'value' => '$this->grid->owner->renderPartial("_rekPengeluaranK",array("saldonormal"=>"K","jenispengeluaran_id"=>$data->jenispengeluaran_id),true)',
        ),
        array(
            'header' => 'Status',
            'value' => '($data->jenispengeluaran_aktif = 1 ) ? "Aktif" : "Tidak Aktif" ',
        ),
    ),
));
?>