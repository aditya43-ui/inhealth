<?php
$itemsCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchReturPenerimaanPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  
if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemsCssClass="table border";
} else{
  $data = $model->searchReturPenerimaan();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
	'itemsCssClass'=>$itemsCssClass,
	'template'=>$template,
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' =>$row,
		),
		array(
			'header'=>'No. Retur Penerimaan',
			'value'=>'$data->noreturterima',
			'type'=>'raw',
		),
		array(
			'header'=>'Tanggal Retur',
			'value'=>'$data->tglreturterima',
			'type'=>'raw',
		),
		array(
			'header'=>'Alasan Retur',
			'value'=>'$data->alasanreturterima',
			'type'=>'raw',
		),
		array(
			'header'=>'Keterangan Retur',
			'value'=>'$data->keterangan_retur',
			'type'=>'raw',
			'footer'=>'<b>Total:</b>',
			'footerHtmlOptions'=>array('style'=>'text-align:right;'),
			'htmlOptions'=>array(
			'style'=>'text-align:right;padding-right:10%;'
			),
		),
		array(
			'header'=>'Total Retur',
			'value'=>'$data->totalretur',
			'headerHtmlOptions'=>array('style'=>'text-align:right;'),
			'htmlOptions'=>array('style'=>'text-align:right;'),
			'footerHtmlOptions'=>array('style'=>('text-align:right;font-weight:bold;')),
			'type'=>'raw',
			'footer'=>number_format($model->getTotalRetur()),
		),
		array(
			'header'=>'Pegawai Retur',
			'value'=>'(isset($data->pegawairetur->nama_pegawai) ? $data->pegawairetur->nama_pegawai : "")',
			'type'=>'raw',
		),
		array(
			'header'=>'Pegawai Mengetahui',
			'value'=>'(isset($data->pegawaimengetahui->nama_pegawai) ? $data->pegawaimengetahui->nama_pegawai : "")',
			'type'=>'raw',
		),
	),
)); ?>