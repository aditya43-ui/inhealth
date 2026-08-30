<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'monitoringrawatjalan-v-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pasien_id'); ?>
		<?php echo $form->textField($model,'pasien_id'); ?>
		<?php echo $form->error($model,'pasien_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'namadepan'); ?>
		<?php echo $form->textField($model,'namadepan',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'namadepan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nama_pasien'); ?>
		<?php echo $form->textField($model,'nama_pasien',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nama_pasien'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nama_bin'); ?>
		<?php echo $form->textField($model,'nama_bin',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'nama_bin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jeniskelamin'); ?>
		<?php echo $form->textField($model,'jeniskelamin',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'jeniskelamin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'no_rekam_medik'); ?>
		<?php echo $form->textField($model,'no_rekam_medik',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'no_rekam_medik'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pendaftaran_id'); ?>
		<?php echo $form->textField($model,'pendaftaran_id'); ?>
		<?php echo $form->error($model,'pendaftaran_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'no_pendaftaran'); ?>
		<?php echo $form->textField($model,'no_pendaftaran',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'no_pendaftaran'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tgl_pendaftaran'); ?>
		<?php echo $form->textField($model,'tgl_pendaftaran'); ?>
		<?php echo $form->error($model,'tgl_pendaftaran'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'no_urutantri'); ?>
		<?php echo $form->textField($model,'no_urutantri',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'no_urutantri'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'statusperiksa'); ?>
		<?php echo $form->textField($model,'statusperiksa',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'statusperiksa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'statuspasien'); ?>
		<?php echo $form->textField($model,'statuspasien',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'statuspasien'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kunjungan'); ?>
		<?php echo $form->textField($model,'kunjungan',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'kunjungan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'umur'); ?>
		<?php echo $form->textField($model,'umur',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'umur'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'carabayar_id'); ?>
		<?php echo $form->textField($model,'carabayar_id'); ?>
		<?php echo $form->error($model,'carabayar_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'carabayar_nama'); ?>
		<?php echo $form->textField($model,'carabayar_nama',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'carabayar_nama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'penjamin_id'); ?>
		<?php echo $form->textField($model,'penjamin_id'); ?>
		<?php echo $form->error($model,'penjamin_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'penjamin_nama'); ?>
		<?php echo $form->textField($model,'penjamin_nama',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'penjamin_nama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ruangan_id'); ?>
		<?php echo $form->textField($model,'ruangan_id'); ?>
		<?php echo $form->error($model,'ruangan_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ruangan_nama'); ?>
		<?php echo $form->textField($model,'ruangan_nama',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'ruangan_nama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instalasi_id'); ?>
		<?php echo $form->textField($model,'instalasi_id'); ?>
		<?php echo $form->error($model,'instalasi_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instalasi_nama'); ?>
		<?php echo $form->textField($model,'instalasi_nama',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'instalasi_nama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jeniskasuspenyakit_id'); ?>
		<?php echo $form->textField($model,'jeniskasuspenyakit_id'); ?>
		<?php echo $form->error($model,'jeniskasuspenyakit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jeniskasuspenyakit_nama'); ?>
		<?php echo $form->textField($model,'jeniskasuspenyakit_nama',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'jeniskasuspenyakit_nama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kelaspelayanan_id'); ?>
		<?php echo $form->textField($model,'kelaspelayanan_id'); ?>
		<?php echo $form->error($model,'kelaspelayanan_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kelaspelayanan_nama'); ?>
		<?php echo $form->textField($model,'kelaspelayanan_nama',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'kelaspelayanan_nama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pembayaranpelayanan_id'); ?>
		<?php echo $form->textField($model,'pembayaranpelayanan_id'); ?>
		<?php echo $form->error($model,'pembayaranpelayanan_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alihstatus'); ?>
		<?php echo $form->checkBox($model,'alihstatus'); ?>
		<?php echo $form->error($model,'alihstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pasienbatalperiksa_id'); ?>
		<?php echo $form->textField($model,'pasienbatalperiksa_id'); ?>
		<?php echo $form->error($model,'pasienbatalperiksa_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!--form-->