<style>
    .table th a {
        color: black !important;
    }
</style>
<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrintLaporanStokInventaris();
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

    $itemCssClass = 'table border table-striped';
} else {
    $data = $model->searchLaporanStokInventaris();
}
?>

<?php $this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'itemsCssClass' => $itemCssClass,
    'template' => $template,
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Stok Awal</p>',
            'start' => 3, //indeks kolom 3
            'end' => 4, //indeks kolom 4
        ),
        array(
            'name' => '<p style="margin: 0; text-align: center;">Stok Masuk</p>',
            'start' => 5, //indeks kolom 3
            'end' => 6, //indeks kolom 4
        ),
        array(
            'name' => '<p style="margin: 0; text-align: center;">Stok Keluar</p>',
            'start' => 7, //indeks kolom 3
            'end' => 8, //indeks kolom 4
        ),
        array(
            'name' => '<p style="margin: 0; text-align: center;">Stok Akhir</p>',
            'start' => 9, //indeks kolom 3
            'end' => 10, //indeks kolom 4
        ),
    ),
    // 'mergeColumns'=>array('nopenerimaan'),
    'columns' => array(
        // 'jenisbarang_nama',
        array(
            'header' => 'Kode Barang',
            'name' => 'barang_kode',
            'footer' => ''
        ),
        array(
            'header' => 'Nama Barang',
            'name' => 'barang_nama',
            'footer' => ''
        ),
        array(
            'header' => 'Satuan',
            'name' => 'barang_satuan',
            'footer' => ''
        ),
        array(
            'header' => 'Qty',
            'name' => 'qtystok_awal',
            'htmlOptions' => array('style' => 'text-align: right'),
            'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;', 'colspan' => 3)
        ),
        array(
            'header' => 'Nilai',
            'name' => 'nilaistok_awal',
            'value' => 'MyFormatter::formatNumberForPrint($data->nilaistok_awal)',
            'htmlOptions' => array('style' => 'text-align: right'),
            'footer' => 'sum(nilaistok_awal)',
            'footerHtmlOptions' => array('style' => 'text-align: right;', 'colspan' => 2)
        ),

        array(
            'header' => 'Qty',
            'name' => 'qtystok_in',
            'htmlOptions' => array('style' => 'text-align: right'),
            //'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Nilai',
            'name' => 'nilaistok_in',
            'value' => 'MyFormatter::formatNumberForPrint($data->nilaistok_in)',
            'htmlOptions' => array('style' => 'text-align: right'),
            'footer' => 'sum(nilaistok_in)',
            'footerHtmlOptions' => array('style' => 'text-align: right;', 'colspan' => 2)
        ),

        array(
            'header' => 'Qty',
            'name' => 'qtystok_out',
            'htmlOptions' => array('style' => 'text-align: right'),
            //'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Nilai',
            'name' => 'nilaistok_out',
            'value' => 'MyFormatter::formatNumberForPrint($data->nilaistok_out)',
            'htmlOptions' => array('style' => 'text-align: right'),
            'footer' => 'sum(nilaistok_out)',
            'footerHtmlOptions' => array('style' => 'text-align: right;', 'colspan' => 2)
        ),

        array(
            'header' => 'Qty',
            'name' => 'qtystok_akhir',
            'htmlOptions' => array('style' => 'text-align: right'),
            //'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Nilai',
            'name' => 'nilaistok_akhir',
            'value' => 'MyFormatter::formatNumberForPrint($data->nilaistok_akhir)',
            'htmlOptions' => array('style' => 'text-align: right'),
            'footer' => 'sum(nilaistok_akhir)',
            'footerHtmlOptions' => array('style' => 'text-align: right;', 'colspan' => 2)
        ),

        /*
        'ruangantujuan_nama',
        'barang_nama',
        array(
            'name'=>'qty_mutasi',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            ),
        ),
        'satuanbrg'
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