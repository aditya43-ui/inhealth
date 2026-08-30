<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'scoringdetail-t-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'kelrem_id'); ?>
		<?php echo $form->textField($model,'kelrem_id'); ?>
		<?php echo $form->error($model,'kelrem_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'personalscoring_id'); ?>
		<?php echo $form->textField($model,'personalscoring_id'); ?>
		<?php echo $form->error($model,'personalscoring_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'indexing_id'); ?>
		<?php echo $form->textField($model,'indexing_id'); ?>
		<?php echo $form->error($model,'indexing_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'index_personal'); ?>
		<?php echo $form->textField($model,'index_personal'); ?>
		<?php echo $form->error($model,'index_personal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ratebobot_personal'); ?>
		<?php echo $form->textField($model,'ratebobot_personal'); ?>
		<?php echo $form->error($model,'ratebobot_personal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'score_personal'); ?>
		<?php echo $form->textField($model,'score_personal'); ?>
		<?php echo $form->error($model,'score_personal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!--form-->