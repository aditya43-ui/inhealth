<div class="col-sm-6">
	<?php echo $form->textFieldRow($model,'noverifkasiberkasmcu',array('class'=>'span3','readonly'=>true)); ?>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'tglberkasmcumasuk', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php   
				$model->tglberkasmcumasuk = (!empty($model->tglberkasmcumasuk) ? date('d/m/Y H:i:s',  strtotime($model->tglberkasmcumasuk)) : null);
				$this->widget('MyDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'tglberkasmcumasuk',
					'mode'=>'datetime',
					'options'=> array(
						'showOn' => false,
						'maxDate' => 'd',
						'yearRange'=> "-150:+0",
					),
					'htmlOptions'=>array('class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
					),
				)); 
			?>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<div class="control-group">
		<?php echo $form->LabelEx($model,'petugasverifikasi_id',array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo $form->hiddenField($model,'petugasverifikasi_id'); ?>
			<?php $this->widget('MyJuiAutoComplete',array(
					  'model'=>$model,
					  'attribute'=>'petugasverifikasi_nama',
					  'value'=>'',
					  'sourceUrl'=> $this->createUrl('AutocompletePetugasVerifikasi'),
					  'options'=>array(
						 'showAnim'=>'fold',
						 'minLength' => 2,
						 'focus'=> 'js:function( event, ui ) {
							  $(this).val( ui.item.value);
							  $("#'.CHtml::activeId($model,'petugasverifikasi_id').'").val(ui.item.pegawai_id);
							  return false;
						  }',
					  ),
						'tombolDialog'=>array('idDialog'=>'dialogPetugas'),
						'htmlOptions'=>array('placeholder'=>'Nama Petugas','rel'=>'tooltip','title'=>'Ketik Nama Petugas untuk mencari Petugas Verifikasi',
							'onkeyup'=>"return $(this).focusNextInputField(event)",
							'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'petugasverifikasi_id') . '").val(""); '),
		  )); ?>
		</div>
	</div>	
</div>
<?php 
//========= Dialog buat cari data Petugas Verifikasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPetugas',
    'options'=>array(
        'title'=>'Pencarian Petugas Verifikasi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPetugasVerifikasi = new KUPegawaiM('search');
$modPetugasVerifikasi->unsetAttributes();
if(isset($_GET['KUPegawaiM'])) {
    $modPetugasVerifikasi->attributes = $_GET['KUPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugasverifikasi-grid',
	'dataProvider'=>$modPetugasVerifikasi->search(),
	'filter'=>$modPetugasVerifikasi,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectPetugas",
							"onClick" => "
									$(\"#'.CHtml::activeId($model,'petugasverifikasi_id').'\").val(\"$data->pegawai_id\");
									$(\"#'.CHtml::activeId($model,'petugasverifikasi_nama').'\").val(\"$data->NamaLengkap\");
									$(\"#dialogPetugas\").dialog(\"close\"); 
									return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'filter'=>  CHtml::activeTextField($modPetugasVerifikasi, 'nomorindukpegawai'),
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPetugasVerifikasi, 'gelardepan'),
			'value'=>'$data->gelardepan',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPetugasVerifikasi, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
		),
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPetugasVerifikasi, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		),
		array(
			'header'=>'Alamat Pegawai',
			'filter'=>  CHtml::activeTextField($modPetugasVerifikasi, 'alamat_pegawai'),
			'value'=>'$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Petugas Verifikasi dialog =============================
?>
