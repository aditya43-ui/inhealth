<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'alatscanwajah-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'alatscanwajah_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textAreaRow($model,'user_ip',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'alat_ip',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 numbers-only')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
