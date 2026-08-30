<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
    'id'=>'rdkondisi-pulang-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'asalrujukan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'asalrujukan_nama',array('class'=>'span3','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'asalrujukan_institusi',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->checkBoxRow($model,'asalrujukan_aktif',array('checked'=>true)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
