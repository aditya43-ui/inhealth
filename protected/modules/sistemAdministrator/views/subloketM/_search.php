<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'subloket-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'subloket_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'loket_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'subloket_nama',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'subloket_namalain',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'subloket_singkatan',array('class'=>'span3')); ?>

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
