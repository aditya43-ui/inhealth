<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'agsumberanggaran-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'sumberanggarannama',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'sumberanggarannamalain',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->checkBoxRow($model,'sumberanggaran_aktif'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
		<?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
); ?>
	</div>

<?php $this->endWidget(); ?>
