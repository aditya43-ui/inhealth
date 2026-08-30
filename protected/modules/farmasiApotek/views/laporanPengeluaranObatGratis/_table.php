<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL") {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
    'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        array(
                'header' => 'No.',
                'value' => '$row+1',
                'footer'=>'Jumlah',
                'footerHtmlOptions'=>array('colspan'=>9, 'style'=>'text-align:right;'),
        ),
        array(
                'header' => 'Tanggal Penjualan',
                'value'=>'date("d/m/Y",strtotime($data->tglpenjualan))',
        ),
        array(
                'header' => 'Tanggal Permohonan',
                'value'=>'date("d/m/Y",strtotime($data->permohonanoa_tgl))',
        ),
        array(
                'header' => 'Nama',
                'name' => 'pemohon_nama'
        ),
        array(
                'header' => 'Intansi',
                'name' => 'nama_rumahsakit'
        ),
        array(
                'header' => 'No. Surat',
                'name' => 'permohonanoa_nomor'
        ),
        array(
                'header' => 'Nama Obat',
                'name' => 'obatalkes_nama'
        ),
        array(
                'name'=>'qty_oa',
                'type'=>'raw',
                'header'=>'Jumlah',
                'value'=>'number_format($data->qty_oa)',
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
                'name'=>'hargasatuan_oa',
                'type'=>'raw',
                'header'=>'Harga Satuan',
                'value'=>'MyFormatter::formatUang($data->hargasatuan_oa)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
                'name'=>'hargajual_oa',
                'type'=>'raw',
                'header'=>'Total',
                'value'=>'MyFormatter::formatUang($data->hargajual_oa)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(hargajual_oa)',
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
        ),
	),
)); ?>