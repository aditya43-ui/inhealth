<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'biayalembur_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'biayalembur_nilai',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'biayalembur_nilailibur',array('class'=>'span3')); ?>

	<?php echo $form->checkBoxRow($model,'biayalembur_aktif'); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 numbers-only')); ?>

	<div class="actions">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
