<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sisamakananpasien-t-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'sisamakananpasien_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'pasienadmisi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'hariperawatke',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'auditor_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'tgl_audit',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jam_audit',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jenisdiet_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'tipediet_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'jml_jenismenu',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'jml_4dan5',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'auditscore_persen',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'kesimpulan',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 numbers-only')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
