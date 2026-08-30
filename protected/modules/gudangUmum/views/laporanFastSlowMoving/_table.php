
        <?php
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $fast ? $model->searchLaporanFastMoving() : $model->searchLaporanSlowMoving();
  $data->pagination = false;
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  
  Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
  
  $itemCssClass='table border';
  
} else{
  $data = $fast ? $model->searchLaporanFastMoving() : $model->searchLaporanSlowMoving();
}
?>

<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
	'itemsCssClass'=>$itemCssClass,
	'template'=>$template,
	// 'mergeColumns'=>array('nopenerimaan'),
	'columns'=>array(
        array(
            'header'=>'Kode Barang',
            'name'=>'barang_kode',
        ),
        array(
            'header'=>'Nama Barang',
            'name'=>'barang_nama',
        ),
        array(
            'header'=>'Satuan',
            'name'=>'barang_satuan',
        ),
        array(
            'header'=>'Jumlah Mutasi',
            'name'=>'qtystok_out',
        ),
        array(
            'header'=>'Sisa Stok',
            'name'=>'qtystok_akhir',
        ),
        array(
            'header'=>'Type Barang',
            'name'=>'barang_type',
        ),
	),
)); ?>
