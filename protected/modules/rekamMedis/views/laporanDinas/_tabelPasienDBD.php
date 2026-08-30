

<?php 

if (empty($is_print)) $is_print = false;

$prov = $model->searchTable();

if ($is_print) {
	$prov->pagination = false;
	$prov = $model->searchTablePrint();
?>
<style>
	
	.table {
		border-collapse: collapse;
	}
	.table td, .table th {
		border: 1px solid black;
	}
	
</style>
<?php
}

$row = $is_print ? '$row+1' : '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$prov,
	'template'=>$is_print?"{items}":"{summary}\n{items}\n{pager}",
	'enableSorting'=>!$is_print,
		'itemsCssClass'=>'table table-striped table-condensed',
		'columns'=>array(
			array(
					'header' => 'No.',
					'value' => $row,
			),
			'no_rekam_medik',
			array(
				'name'=>'nama_pasien',
				'header'=>'Nama Pasien',
				'value'=>'$data->namadepan.$data->nama_pasien',
			),
			'alamat_pasien',
			'umur',
			array(
				'name'=>'tgl_pendaftaran',
				'value'=>'date("d/m/Y", strtotime($data->tgl_pendaftaran))',
			),
			array(
				'name'=>'tglmasukpenunjang',
				'value'=>'date("d/m/Y", strtotime($data->tglmasukpenunjang))',
			),
			array(
				'name'=>'total_trombosit',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;'),
			),
			array(
				'name'=>'total_hematokrit',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;'),
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>