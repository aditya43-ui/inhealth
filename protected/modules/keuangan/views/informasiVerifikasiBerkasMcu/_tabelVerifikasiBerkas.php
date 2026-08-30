<?php 
//echo CHtml::css('#isiScroll{max-height:300px;overflow-y:scroll;margin-bottom:10px;}'); 
?>
<div class="span12">
	<div id='isiScroll'>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'verifikasiberkasmcu-v-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-condensed',
			'columns'=>array(
				array(
					'header'=>'Tgl. Pendaftaran',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
				),
				array(
					'header'=>'No. Pendaftaran/<br>No. Rekam Medis',
					'type'=>'raw',
					'value'=>'$data->no_pendaftaran."/<br>".$data->no_rekam_medik',
				),
				array(
					'header'=>'Nama Pasien/<br>Alias',
					'type'=>'raw',
					'value'=>'$data->nama_pasien."/<br>".$data->nama_bin',
				),
				array(
					'header'=>'Alamat Pasien/<br>RT RW',
					'type'=>'raw',
					'value'=>'$data->alamat_pasien." ".$data->RtRw',
				),
				array(
					'header'=>'Penjamin/<br>Jenis Penjamin',
					'type'=>'raw',
					'value'=>'$data->penjamin_nama."/<br>".$data->carabayar_nama',
				),
				array(
					'header'=>'Dokter Pemeriksa/<br>Kelas Pelayanan',
					'type'=>'raw',
					'value'=>'$data->NamaLengkap."/<br>".$data->kelaspelayanan_nama',
				),
				array(
					'header'=>'Status Periksa',
					'type'=>'raw',
					'value'=>'$data->statusperiksa',
				),
				array(
					'header'=>'No. Surat RS',
					'type'=>'raw',
					'value'=>'$data->nosurat_rs',
				),
				array(
					'header'=>'Nama Rumah Sakit',
					'type'=>'raw',
					'value'=>'$data->rumahsakitrujukan',
				),
				array(
					'header'=>'Status Berkas',
					'type'=>'raw',
					'value'=>'$data->statusverifikasiberkas',
				),
				array(
					'header'=>'Total Tagihan',
					'type'=>'raw',
					'value'=>'MyFormatter::formatNumberForUser($data->tagihan)',
					'htmlOptions'=>array('style'=>'text-align:right;'),
				),					
				array(
					'header'=>'Verifikasi',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-check\"></i>",Yii::app()->controller->createUrl("informasiVerifikasiBerkasMcu/ubahVerifikasi",array("verifikasiberkasmcu_id"=>$data->verifikasiberkasmcu_id,"frame"=>1)),
						array("class"=>"", 
							  "target"=>"iframeVerifikasiBerkas",
							  "onclick"=>"$(\"#dialogVerifikasiBerkas\").dialog(\"open\");",
							  "rel"=>"tooltip",
							  "title"=>"Klik untuk Verifikasi Berkas Pasien MCU",
						))',
					'htmlOptions'=>array('style'=>'text-align:center;'),
				),
			),
			'afterAjaxUpdate'=>'function(id, data){
				jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
					}',
		)); ?> 
	</div>
</div>
<?php 
// Dialog untuk verifikasi berkas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
	'id'=>'dialogVerifikasiBerkas',
	'options'=>array(
		'title'=>'Verifikasi Berkas',
		'autoOpen'=>false,
		'modal'=>true,
		'minWidth'=>900,
		'minHeight'=>450,
		'resizable'=>false,
		'before'
	),
));
?>
<iframe src="" name="iframeVerifikasiBerkas" width="100%" height="450"></iframe>
<?php
$this->endWidget();
//========= end verifikasi berkas Dialog =============================
?>