<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'konfigemail_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'konfigemail_host',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'konfigemail_port',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->checkBoxRow($model,'konfigemail_smtp_auth'); ?>

	<?php echo $form->textFieldRow($model,'konfigemail_username',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'profilrs_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'konfigemail_smtp_secure',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->checkBoxRow($model,'konfigemail_ishtml'); ?>

	<div class="actions">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
