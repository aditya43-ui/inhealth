
<?php 
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>12));  

$this->widget($table,array(
	'id'=>'obatalkespenjamin-vp-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchInformasiHargaObatPenjaminPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'mergeColumns' => array('obatalkes_id','jenisobatalkes_id','carabayar_id','penjamin_id'),
	'columns' => array(
		array(
			'header' => 'No.',
			'value' => '($this->grid->dataProvider->pagination) ?
				($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
				: ($row+1)',
			'type' => 'raw',
			'htmlOptions' => array('style' => 'text-align:right;'),
		),
		array(
			'header' => 'Nama Obat Alkes',
			'name' => 'obatalkes_id',
			'value' => '$data->obatalkes_nama',
		),
		array(
			'header' => 'Jenis Obat Alkes',
			'name' => 'jenisobatalkes_id',
			'value' => '$data->jenisobatalkes_nama',
		),
		array(
			'header' => 'Jenis Penjamin',
			'name' => 'carabayar_id',
			'value' => '$data->carabayar_nama',
		),
		array(
			'header' => 'Penjamin',
			'name' => 'penjamin_id',
			'value' => '$data->penjamin_nama',
		),
		array(
			'header' => 'Harga Netto (Rp)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->harganetto,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Keringanan Pembelian (%)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->discount,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'PPN (%)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->ppn_persen,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'HPP (Rp)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->hpp,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Margin (%)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->persmargin,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Harga Jual (Rp)',
			'type' => 'raw',
			'value' => function ($data){
				$marginrp = round((($data->hpp * $data->persmargin)/100),2);

				$hargaJual = round(($data->hpp + $marginrp),2);
				return MyFormatter::formatNumberForPrint($hargaJual,2);
			},
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Biaya Administrasi (Rp)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->biayaadministrasi,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Keringanan Penjualan (%)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->persdiskon,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Keringanan Penjualan (Rp)',
			'type' => 'raw',
			'value' => function ($data){
				$marginrp = round((($data->hpp * $data->persmargin)/100),2);
				$hargaJual = round(($data->hpp + $marginrp),2);
				$diskonPenjRp = round(((($hargaJual + $data->biayaadministrasi)  * $data->persdiskon)/100),2);

				return MyFormatter::formatNumberForPrint($diskonPenjRp,2);
			},
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Total Harga (Rp)',
			'type' => 'raw',
			'value' => function ($data){
				$marginrp = round((($data->hpp * $data->persmargin)/100),2);
				$hargaJual = round(($data->hpp + $marginrp),2);
				$diskonPenjRp = round(((($hargaJual + $data->biayaadministrasi)  * $data->persdiskon)/100),2);
				$total_harga = round(($hargaJual  + $data->biayaadministrasi - $diskonPenjRp),2);
				return MyFormatter::formatNumberForPrint($total_harga,2);
			},
			'htmlOptions'=>array('style'=>'text-align: right')
		),
	),
)); 
?>