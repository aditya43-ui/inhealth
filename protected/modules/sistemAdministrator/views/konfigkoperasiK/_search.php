<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'konfigkoperasi-k-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'konfigkoperasi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'persjasasimpanan',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'persjasapinjaman',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'persdanapengurus',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'persdanakaryawan',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'persdanapendidikan',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'persdanasosial',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'persdanacadangan',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'persbiayaprovisasi',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'persjasadeposito',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'pimpinankoperasi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'penguruskoperasi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'bendaharakoperasi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'bendaharars_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->checkBoxRow($model,'status_aktif'); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 numbers-only')); ?>

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
