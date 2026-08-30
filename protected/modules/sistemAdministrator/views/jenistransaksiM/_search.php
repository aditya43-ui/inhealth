<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenistransaksi-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'jenistransaksi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'namatransaksi',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'namatransaksilainnnya',array('class'=>'span3','maxlength'=>100)); ?>

	<?php // echo $form->textFieldRow($model,'akundebit',array('class'=>'span3 numbers-only')); ?>

	<?php // echo $form->textFieldRow($model,'akunkredit',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->checkBoxRow($model,'jenistransaksi_aktif'); ?>

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
