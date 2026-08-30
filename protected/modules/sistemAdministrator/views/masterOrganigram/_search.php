<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kporganigram-m-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'organigram_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'organigram_kode',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'organigram_unitkerja',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'organigram_formasi',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'organigram_pelaksanakerja',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'organigram_keterangan',array('class'=>'span3','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'organigram_periode',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'organigram_sampaidengan',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'organigramasal_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>

	<?php echo $form->checkBoxRow($model,'organigram_aktif'); ?>

	<?php echo $form->textFieldRow($model,'organigram_urutan',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span3')); ?>

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
