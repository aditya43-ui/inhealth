<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'nursestation-m-search',
	'type'=>'horizontal',
)); ?>

	<?php // echo $form->textFieldRow($model,'nursestation_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'nursestation_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'nursestation_namalain',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'nursestation_lokasi',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'nursestation_telp',array('class'=>'span3','maxlength'=>50)); ?>

	<?php // echo $form->textFieldRow($model,'nursestation_pj_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->checkBoxRow($model,'nursestation_akitf'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
