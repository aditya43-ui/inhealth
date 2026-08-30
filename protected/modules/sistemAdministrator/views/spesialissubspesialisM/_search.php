<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'spesialissubspesialis-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'jenis',array('class'=>'span3','maxlength'=>50)); ?>
		
		<?php echo $form->textFieldRow($model,'spesialissubspesialis_nama',array('class'=>'span3','maxlength'=>200)); ?>
		
		<?php echo $form->textFieldRow($model,'spesialissubspesialis_namalainnya',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'spesialissubspesialis_kode',array('class'=>'span3','maxlength'=>100)); ?>
		
		<?php echo $form->textFieldRow($model,'spesialissubspesialis_kodebpjs',array('class'=>'span3','maxlength'=>100)); ?>
		<?php echo $form->checkBoxRow($model,'spesialissubspesialis_aktif'); ?>
	</div>
</div>
	<?php // echo $form->textFieldRow($model,'spesialissubspesialis_id',array('class'=>'span3 numbers-only')); ?>



	<?php // echo $form->textFieldRow($model,'spesialis_id',array('class'=>'span3 numbers-only')); ?>

	<?php // echo $form->textFieldRow($model,'spesialissubspesialis_urutan',array('class'=>'span3 numbers-only')); ?>


	<?php // echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php // echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php // echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
