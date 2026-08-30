<div class="block-tabel">
	<table class="items table table-striped table-condensed table-bordered" id="tabel-penjadwalan">
		<thead>
			<tr>
				<th rowspan="2">Pilih
					<?php echo CHtml::checkBox('check_semua', true, array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkSemuaPegawai()', 'checked' => 'checked')) ?>
				</th>
				<th rowspan="2">Kelompok Pegawai</th>
				<th rowspan="2">Nama Pegawai<br>
					<?php //echo CHtml::activeHiddenField($model, 'pegawai_id')
					?>
					<?php /*$this->widget('MyJuiAutoComplete',array(
						'model'=>$model,
						'attribute'=>'nama_pegawai',
						'source'=>'js: function(request, response) {
									   $.ajax({
										   url: "'.$this->createUrl('AutocompletePegawai').'",
										   dataType: "json",
										   data: {
											   pegawai_id: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
						'options'=>array(
						   'showAnim'=>'fold',
						   'minLength' => 2,
						   'focus'=> 'js:function( event, ui ) {
								$(this).val( ui.item.label);
								return false;
							}',
						   'select'=>'js:function( event, ui ) {
								$("#pegawai_id").val(ui.item.pegawai_id); 
								getPenjadwalan();
								return false;
							}',

						),
						'tombolDialog'=>array("idDialog"=>'dialogDaftarPegawai'),
						'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2'),
					));*/ ?>
				</th>
				<th rowspan="2" id="bulan" style="text-align:center;">Tanggal</th>
			</tr>
			<tr id="bulan-tgl"></tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id' => 'dialogDaftarPegawai',
	'options' => array(
		'title' => 'Pencarian Pegawai Mengetahui',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 500,
		'resizable' => false,
	),
));

$modPegawai = new KPPegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['KPPegawaiM'])) {
	$modPegawai->attributes = $_GET['KPPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'shiftpegawaimengetahui-grid',
	'dataProvider' => $modPegawai->search(),
	'filter' => $modPegawai,
	'template' => "{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
								$(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
								$(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->NamaLengkap\");
								getPenjadwalan();
								$(\"#dialogDaftarPegawai\").dialog(\"close\"); 
								return false;
							"))',
		),
		array(
			'header' => 'NIP',
			'value' => '$data->nomorindukpegawai',
		),
		array(
			'header' => 'Gelar Depan',
			'filter' =>  CHtml::activeTextField($modPegawai, 'gelardepan'),
			'value' => '$data->gelardepan',
		),
		array(
			'header' => 'Nama Pegawai',
			'filter' =>  CHtml::activeTextField($modPegawai, 'nama_pegawai'),
			'value' => '$data->nama_pegawai',
		),
		array(
			'header' => 'Gelar Belakang',
			'filter' =>  CHtml::activeTextField($modPegawai, 'gelarbelakang_nama'),
			'value' => '$data->gelarbelakang_nama',
		),
		array(
			'header' => 'Alamat Pegawai',
			'filter' =>  CHtml::activeTextField($modPegawai, 'alamat_pegawai'),
			'value' => '$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>