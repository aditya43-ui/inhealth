<?php
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchPembelianBarangPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchPembelianBarang();
}
?>
<?php $this->widget($table, array(
    'id'=>'laporan-grid',
    'dataProvider'=>$data,
    'itemsCssClass'=>'table table-striped table-condensed',
    'template'=>$template,
    'mergeColumns'=>array('nopembelian'),
	'columns'=>array(
        array(
            'header'=>'No.',
            'value' => $row,
            'type'=>'raw',
        ),
       'nopembelian',
       array(
           'header'=>'Sumber Dana',
           'value'=>'(isset($data->sumberdana_id) ? $data->sumberdana->sumberdana_nama : "")',
           'type'=>'raw',
       ),
       array(
           'header'=>'Nama Supplier',
           'value'=>'(isset($data->supplier_id) ? $data->supplier->supplier_nama : "")',
           'type'=>'raw',
       ),
       array(
           'header'=>'Tanggal Permintaan',
           'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpembelian))',
           'type'=>'raw',
       ),
       array(
           'header'=>'Tanggal Dikirim',
           'value'=>'date("d/m/Y H:i:s",strtotime($data->tgldikirim))',
           'type'=>'raw',
           'footer'=>'<b><right>Total:</right></b>',
           'footerHtmlOptions'=>array('style'=>'text-align:right;'),
       ),
       array(
           'header'=>'Total Permintaan<br/>Pembelian',
           'value'=>'number_format($data->hargabeli * $data->jmlbeli,0,"",",")',
           'type'=>'raw',
           'headerHtmlOptions'=>array('style'=>'text-align:right;'),
           'htmlOptions'=>array('style'=>'text-align:right;'),
           'footerHtmlOptions'=>array('style'=>'text-align:right;'),
           'footer'=>number_format($model->getTotalharga()),
       ),
       array(
           'header'=>'Pegawai Mengetahui',
           'value'=>'(isset($data->mengetahui->nama_pegawai) ? $data->mengetahui->nama_pegawai : "")',
           'type'=>'raw',
       ),
       array(
           'header'=>'Pegawai Menyetujui',
           'value'=>'(isset($data->menyetujui->nama_pegawai) ? $data->menyetujui->nama_pegawai : "")',
           'type'=>'raw',
       ),
       array(
           'header'=>'Pegawai Pemesan',
           'value'=>'(isset($data->pemesan->nama_pegawai) ? $data->pemesan->nama_pegawai : "")',
           'type'=>'raw',
       ),
            
    ),
)); ?>