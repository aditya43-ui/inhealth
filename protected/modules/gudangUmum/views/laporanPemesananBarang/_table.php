<style>
    .table th a {
        color: black !important;
    }
</style>
<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrintLaporan();
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

    $itemCssClass = 'table border';
} else {
    $data = $model->searchLaporan();
}
?>

<?php $this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'itemsCssClass' => $itemCssClass,
    'template' => $template,
    'mergeColumns' => array('ruanganpemesan_nama', 'ruangantujuan_nama', 'nopemesanan', 'tglpesanbarang'),
    'extraRowColumns' => array('ruanganpemesan_nama'),
    // 'mergeColumns'=>array('nopenerimaan'),
    'columns' => array(
        array(
            'name' => 'ruanganpemesan_nama',
            'htmlOptions' => array(
                'style' => 'display:none;',
            ),
            'headerHtmlOptions' => array(
                'style' => 'display:none;',
            )
        ),
        // 'ruangantujuan_nama',
        'nopemesanan',
        array(
            'name' => 'tglpesanbarang',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanbarang)',
        ),
        'barang_nama',
        array(
            'name' => 'qty_pesan',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
        ),
        'satuanbarang',
        array(
            'header' => 'Status Mutasi<br>Pesanan',
            'name' => 'mutasibrg_id',
            'value' => function ($data) {
                return empty($data->mutasibrg_id) ? "Belum Dimutasi" : "Sudah Dimutasi";
            }
        ),
        /*
		array(
		   'header'=>'No.',
		   'value' => $row,
		   'type'=>'raw',
		),
		'nopenerimaan',
		array(
			'header'=>'Tanggal Terima',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime(MyFormatter::formatDateTimeForDb($data->tglterima))))',
		),
		array(
			'header'=>'Nama Supplier',
			'type'=>'raw',
			'value'=>'(isset($data->supplier->supplier_id) ? $data->supplier->supplier_nama : "")',
		),
		array(
			 'header'=>'No. Pembelian',
			 'type'=>'raw',
			 'value'=>'(isset($data->pembelianbarang->nopembelian) ? $data->pembelianbarang->nopembelian : "")',
			 'footerHtmlOptions'=>array('style'=>'text-align:right;'),
			 'footer'=>'<b><right>Total:</right></b>',
		 ),
		array(
		   'header'=>'Total Harga (Rp)',
		   'type'=>'raw',
		   'value'=>'number_format($data->totalharga,0,"",".")',
		   'headerHtmlOptions'=>array('style'=>'text-align:right;'),
		   'htmlOptions'=>array('style'=>'text-align:right;'),
		   'footer'=>number_format($model->getTotalharga(),0,"","."),
		   'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
	   ),
		array(
			'header'=>'Pegawai Penerima',
			'type'=>'raw',
			'value'=>'(isset($data->penerima->nama_pegawai) ? $data->penerima->nama_pegawai : "")',
		),
		array(
			 'header'=>'Pegawai Mengetahui',
			 'type'=>'raw',
			 'value'=>'(isset($data->mengetahui->nama_pegawai) ? $data->mengetahui->nama_pegawai : "")',
		 ),
		array(
			'header'=>'Ruangan',
			'type'=>'raw',
			'value'=>'(isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "")',
		),
         * 
         */
    ),
)); ?>