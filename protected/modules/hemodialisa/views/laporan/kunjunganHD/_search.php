<div class="search-form" style="">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type' => 'horizontal',
	'id' => 'searchLaporan',
	'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
		));
?>
<style>
	table{
		margin-bottom: 0px;
	}
	.form-actions{
		padding:4px;
		margin-top:5px;
	}
	.nav-tabs>li>a{display:block; cursor:pointer;}
	.nav-tabs > .active a:hover{cursor:pointer;}
</style>
<div class="row-fluid">
	<div class="span8">
		<fieldset class="box2">
			<legend class="rim">Berdasarkan Kunjungan</legend>
			<?php echo CHtml::hiddenField('type', ''); ?>
			<?php //echo CHtml::hiddenField('src', ''); ?>
			<div class = 'control-label'>Tanggal Kunjungan</div>
			<div class="controls">  
				<?php
					$model->tgl_awal = isset($model->tgl_awal) ? MyFormatter::formatDateTimeForUser($model->tgl_awal) : date('d M Y');
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_awal',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
				?>
			</div> 
			<?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
			<div class="controls">  
				<?php
				$model->tgl_akhir = isset($model->tgl_akhir) ? MyFormatter::formatDateTimeForUser($model->tgl_akhir) : date('d M Y');
				$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_akhir',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d'
						),
						'htmlOptions' => array('readonly' => true,
								'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
		</fieldset> 
		
		<fieldset class="box2">
			<legend class="rim">Berdasarkan Pasien</legend>
			<div class="controls">  
				<?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik nama pasien')); ?>
			</div> 
			<div class="controls">   
				<?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik nama pasien')); ?>
			</div>
		</fieldset> 
		
		<div class="span4">
		<div id='searching'>
			<fieldset>
				<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
					'id'=>'kunjungan',
					'slide'=>true,
						'content'=>array(
						'content2'=>array(
							'header'=>'Berdasarkan Jenis Penjamin',
							'isi'=>'<table><tr>
								<td>'.CHtml::hiddenField('filter', 'carabayar',array('disabled'=>'disabled')).'<label>Jenis Penjamin</label></td>
								<td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
									'ajax' => array('type' => 'POST',
								'url' => $this->createUrl('GetPenjaminPasien',array('encode'=>false,'model_nama'=>get_class($model))),
								'update' => '#'.CHtml::activeId($model, 'penjamin_id').''),
																						'onkeypress' => "return $(this).focusNextInputField(event)"
								)).'</td>
									</tr><tr>
								<td><label>Penjamin</label></td><td>'.
								$form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>', 'active'=>false,       
					'active'=>true,
					),
				),
			)); ?>
				
				
			</fieldset>
		</div>
	</div>
	</div>

</div>
<div class="form-actions">
	<?php
	echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan',
		'ajax' => array(
			 'type' => 'GET', 
			 'url' => array("/".$this->route), 
			 'update' => '#tableLaporan',
			 'beforeSend' => 'function(){
								  $("#tableLaporan").addClass("animation-loading");
							  }',
			 'complete' => 'function(){
								  $("#tableLaporan").removeClass("animation-loading");
							  }',
		 ))); 
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
</div>
</div>    
<?php
	$this->endWidget();
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => '')); ?>