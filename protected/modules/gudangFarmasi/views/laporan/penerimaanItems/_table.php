<?php

/**
 * menampilkan daftar data
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchLaporanPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchLaporan();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php $this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'mergeColumns' => array('supplier_id', 'noterima', 'total'),
    'extraRowColumns' => array('supplier_id'),
    'columns' => array(
        //                array(
        //                    'value'=>'$data->no',
        //                    'header'=>'No.',
        //                    'filter'=>false,
        //                ),	                            
        array(
            'header' => 'Nama Supplier',
            'name' => 'supplier_id',
            'type' => 'raw',
            'value' => '$data->supplier_nama',
        ),
        array(
            'header' => 'No. Penerimaan',
            'name' => 'noterima',
            'type' => 'raw',
            'value' => '$data->noterima'
        ),
        array(
            'header' => 'Tanggal Penerimaan',
            'name' => 'tglterima',
            'type' => 'raw',
            'value' => '$data->tglterima'
        ),
        array(
            'header' => 'Obat Alkes',
            'type' => 'raw',
            'value' => '$data->nama_obat',
        ),
        array(
            'header' => 'Harga Satuan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->harganetto)',
        ),
        array(
            'header' => 'Jumlah',
            'name' => 'jumlahterima',
            'type' => 'raw',
            'value' => '$data->jumlahterima'
        ),
        array(
            'header' => 'Sub Total (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->harganetto*$data->jumlahterima)',
        ),
        array(
            'header' => 'Total (Rp)',
            'type' => 'raw',
            'name' => 'total',
            'value' => 'number_format($data->totalharga)',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>