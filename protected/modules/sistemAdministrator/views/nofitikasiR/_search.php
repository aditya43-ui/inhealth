<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'nofitikasi-r-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'nofitikasi_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'instalasi_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'modul_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglnotifikasi',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'judulnotifikasi',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textAreaRow($model,'isinotifikasi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->checkBoxRow($model,'isread'); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'lamahrnotif',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
