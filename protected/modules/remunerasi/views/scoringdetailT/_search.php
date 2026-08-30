<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'scoringdetail_id'); ?>
		<?php echo $form->textField($model,'scoringdetail_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kelrem_id'); ?>
		<?php echo $form->textField($model,'kelrem_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'personalscoring_id'); ?>
		<?php echo $form->textField($model,'personalscoring_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'indexing_id'); ?>
		<?php echo $form->textField($model,'indexing_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'index_personal'); ?>
		<?php echo $form->textField($model,'index_personal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ratebobot_personal'); ?>
		<?php echo $form->textField($model,'ratebobot_personal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'score_personal'); ?>
		<?php echo $form->textField($model,'score_personal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!--search-form-->