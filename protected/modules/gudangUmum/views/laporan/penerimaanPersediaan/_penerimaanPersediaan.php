<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPenerimaanPersediaanPrint();
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

    $itemCssClass = 'table border';
} else {
    $data = $model->searchPenerimaanPersediaan();
}

$prov = clone $data;
$prov->pagination = false;

$totals = 0;
foreach ($prov->data as $item) {
    $totals += $item->hargabeli;
}

?>
<?php $this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'itemsCssClass' => $itemCssClass,
    'template' => $template,
    'mergeColumns' => array('supplier_id', 'nopenerimaan', 'pembelianbarang_id', 'tglterima', 'peg_penerima_id', 'peg_mengetahui_id', 'ruanganpenerima_id'),
    //    'extraRowColumns'=> array('supplier_id'),
    'columns' => array(

        array(
            'header' => 'No.',
            'value' => $row,
            'type' => 'raw',
        ),

        array(
            'header' => 'Nama Supplier',

            'type' => 'raw',
            'value' => '(isset($data->supplier->supplier_id) ? $data->supplier->supplier_nama : "")',
            // 'visible'=>false,
        ),
        'nopenerimaan',
        array(
            'header' => 'No. Pembelian',

            'type' => 'raw',
            'value' => '(isset($data->pembelianbarang->nopembelian) ? $data->pembelianbarang->nopembelian : "")',
        ),
        array(
            'header' => 'Tanggal Terima',
            // 'name'=>'tglterima',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime(MyFormatter::formatDateTimeForDb($data->tglterima))))',
        ),
        array(
            'header' => 'Pegawai Penerima',
            //'name'=>'peg_penerima_id',
            'type' => 'raw',
            'value' => '(isset($data->penerima->nama_pegawai) ? $data->penerima->nama_pegawai : "")',
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'type' => 'raw',
            'value' => '(isset($data->mengetahui->nama_pegawai) ? $data->mengetahui->nama_pegawai : "")',
            //'name'=>'peg_mengetahui_id',
        ),
        array(
            'header' => 'Ruangan',
            //'name'=>'peg_mengetahui_id',
            'type' => 'raw',
            'value' => '(isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "")',
        ),
        'barang_kode',
        'barang_nama',
        array(
            'header' => 'Harga Satuan (Rp)',
            'name' => 'hargasatuan',
            'value' => 'number_format($data->hargasatuan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Jumlah',
            'name' => 'jmlterima',
            'value' => '$data->jmlterima',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Satuan',
            'name' => 'satuanbeli',
            'value' => '$data->satuanbeli',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => '<b><right>Total:</right></b>',

        ),
        array(
            'header' => 'Total (Rp)',
            'name' => 'hargabeli',
            'value' => 'number_format($data->hargabeli,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => number_format($totals, 0, "", "."),
            'footerHtmlOptions' => array('style' => ('text-align:right;font-weight:bold;')),
        ),
        /*
		array(
		   'header'=>'Total Harga (Rp)',
		   'type'=>'raw',
		   'value'=>'number_format($data->totalharga,0,"",".")',
		   'headerHtmlOptions'=>array('style'=>'text-align:right;'),
		   'htmlOptions'=>array('style'=>'text-align:right;'),
		   'footer'=>number_format($model->getTotalharga(),0,"","."),
		   'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
	   ),
         * 
         */
    ),
)); ?>