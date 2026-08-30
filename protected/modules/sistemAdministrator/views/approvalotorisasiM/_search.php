<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'approvalotorisasi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'kepalagizi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'kepalafarmasi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'kepalaumum_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'kasipersonalia_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'managerumum_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'managerkeuangan_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'direkturrs_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'direkturpt_id',array('class'=>'span3 numbers-only')); ?>

	<div class="actions">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
