<?php 
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'laporan-grid',
	'dataProvider'=>$model->searchLaporan(),
	//	'filter'=>$model,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'mergeHeaders'=>array(
	array(
		'name'=>'<p style="margin: 0; text-align: center;">Biaya</p>',
		'start'=>7, //indeks kolom 3
		'end'=>11, //indeks kolom 4
	),
	),
	'columns'=>array(
		 array(
			'header' => 'No.',
			'type'=>'raw',
			'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
		),
		array(
			'header'=>'Pelatihan',
			'name'=>'namapelatihan',
		),
		
		array(
			'header'=>'Tgl. Pelatihan',
			'name'=>'realisasi_tglawal',
			'type'=>'raw',
			'value'=>function($data) {
				return MyFormatter::formatDateTimeForUser($data->realisasi_tglawal).'<br>'.
				MyFormatter::formatDateTimeForUser($data->realisasi_tglakhir);
			}
		),
				
		array(
			'header'=>'Waktu',
			'name'=>'total_jam',
			'type'=>'raw',
			'value'=>function($data) {
				$selisih = (strtotime($data->realisasi_tglakhir) - strtotime($data->realisasi_tglawal)) / (24 * 3600);
				return $selisih * $data->total_jam;
			}
		),
		array(
			'header'=>'Nama Peserta',
			'name'=>'nama_pegawai',
			'value'=>'$data->gelardepan.$data->nama_pegawai.(empty($data->gelarbelakang_nama) ? "" : $data->gelarbelakang_nama)'
		),
		'jabatan_nama',
		'tempat',
		array(
			'header'=>'Pelatihan',
			'name'=>'biaya_pelatihan',
			'value'=>'MyFormatter::formatNumberForPrint($data->biaya_pelatihan)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
		),
		array(
			'header'=>'Transport',
			'name'=>'biaya_transportasi',
			'value'=>'MyFormatter::formatNumberForPrint($data->biaya_transportasi)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
		),
		array(
			'header'=>'Penginapan',
			'name'=>'biaya_penginapan',
			'value'=>'MyFormatter::formatNumberForPrint($data->biaya_penginapan)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
		),
		array(
			'header'=>'Penginapan',
			'name'=>'biaya_penginapan',
			'value'=>'MyFormatter::formatNumberForPrint($data->biaya_perjalanandinas)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
		),
		array(
			'header'=>'Lain-Lain',
			'name'=>'biaya_lainlain',
			'value'=>'MyFormatter::formatNumberForPrint($data->biaya_lainlain)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
		),
		array(
			'header'=>'Jumlah',
			'type'=>'raw',
			'value'=>function($data) {
				$total = $data->biaya_pelatihan + $data->biaya_transportasi + $data->biaya_penginapan +
						$data->biaya_penginapan + $data->biaya_lainlain;
				
				return MyFormatter::formatNumberForPrint($total);
			},
			'htmlOptions'=>array('style'=>'text-align: right;'),
		),
		'keterangan_diklat',
		
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>