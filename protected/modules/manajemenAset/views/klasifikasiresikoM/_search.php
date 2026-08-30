<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'klasifikasiresiko-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'klasfikasiresiko_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'kelompokresiko',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'kategori_resiko',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'nilai_resiko',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'jenis_resiko',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textAreaRow($model,'defenisi_resiko',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'resiko_ket',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->checkBoxRow($model,'klasifikasiresiko_aktif'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
