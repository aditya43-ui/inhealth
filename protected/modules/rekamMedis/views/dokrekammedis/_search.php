<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppdokrekammedis-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'dokrekammedis_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'warnadokrm_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subrak_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'lokasirak_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pasien_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nodokumenrm',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'tglrekammedis',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglmasukrak',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'statusrekammedis',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'tglkeluarakhir',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglmasukakhir',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nomortertier',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'nomorsekunder',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'nomorprimer',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'warnanorm_i',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'warnanorm_ii',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'tgl_in_aktif',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglpemusnahan',array('class'=>'span5')); ?>

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
