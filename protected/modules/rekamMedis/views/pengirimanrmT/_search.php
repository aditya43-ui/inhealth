<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rkpengirimanrm-t-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'pengirimanrm_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'peminjamanrm_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'kembalirm_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pasien_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'dokrekammedis_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nourut_keluar',array('class'=>'span5','maxlength'=>5)); ?>

	<?php echo $form->textFieldRow($model,'tglpengirimanrm',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'kelengkapandokumen'); ?>

	<?php echo $form->textFieldRow($model,'petugaspengirim',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'printpengiriman'); ?>

	<?php echo $form->textFieldRow($model,'ruanganpengirim_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
