<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'persetujuanumumisi-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textAreaRow($model,'persetujuan_isi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>


	<?php echo $form->checkBoxRow($model,'isaktif'); ?>


	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
