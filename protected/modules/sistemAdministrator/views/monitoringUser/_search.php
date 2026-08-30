<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'loginpemakai-k-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pasien_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nama_pemakai',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'katakunci_pemakai',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'lastlogin',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglpembuatanlogin',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglupdatelogin',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'statuslogin'); ?>

	<?php echo $form->textFieldRow($model,'photouser',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'loginpemakai_create',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'loginpemakai_update',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'loginpemakai_aktif'); ?>

	<?php echo $form->textFieldRow($model,'ruanganaktifitas',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'crudaktifitas',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
