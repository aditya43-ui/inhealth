<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppbuat-janji-poli-t-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'buatjanjipoli_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'tglbuatjanji',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'harijadwal',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'tgljadwal',array('class'=>'span3')); ?>

	<?php echo $form->checkBoxRow($model,'byphone'); ?>

	<?php echo $form->textAreaRow($model,'keteranganbuatjanji',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
