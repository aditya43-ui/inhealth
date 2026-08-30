<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'personalscoring-t-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pegawai_id'); ?>
		<?php echo $form->textField($model,'pegawai_id'); ?>
		<?php echo $form->error($model,'pegawai_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'penilaianpegawai_id'); ?>
		<?php echo $form->textField($model,'penilaianpegawai_id'); ?>
		<?php echo $form->error($model,'penilaianpegawai_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tglscoring'); ?>
		<?php echo $form->textField($model,'tglscoring'); ?>
		<?php echo $form->error($model,'tglscoring'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodescoring'); ?>
		<?php echo $form->textField($model,'periodescoring'); ?>
		<?php echo $form->error($model,'periodescoring'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sampaidengan'); ?>
		<?php echo $form->textField($model,'sampaidengan'); ?>
		<?php echo $form->error($model,'sampaidengan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gajipokok'); ?>
		<?php echo $form->textField($model,'gajipokok'); ?>
		<?php echo $form->error($model,'gajipokok'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jabatan'); ?>
		<?php echo $form->textField($model,'jabatan',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'jabatan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pendidikan'); ?>
		<?php echo $form->textField($model,'pendidikan',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'pendidikan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'totalscore'); ?>
		<?php echo $form->textField($model,'totalscore'); ?>
		<?php echo $form->error($model,'totalscore'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
		<?php echo $form->error($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time'); ?>
		<?php echo $form->error($model,'update_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_loginpemakai_id'); ?>
		<?php echo $form->textField($model,'create_loginpemakai_id'); ?>
		<?php echo $form->error($model,'create_loginpemakai_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_loginpemakai_id'); ?>
		<?php echo $form->textField($model,'update_loginpemakai_id'); ?>
		<?php echo $form->error($model,'update_loginpemakai_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_ruangan'); ?>
		<?php echo $form->textField($model,'create_ruangan'); ?>
		<?php echo $form->error($model,'create_ruangan'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!--form-->