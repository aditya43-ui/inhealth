<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'perhitunganem-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'perhitunganem_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'invperalatan_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'res_fungsi_nama',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'res_fungsi_nilai',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'res_klinis_nama',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'res_klinis_nilai',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'res_pemeliharaan_nama',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'res_pemeliharaan_nilai',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'res_insiden_nama',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'res_insiden_nilai',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'nilai_em',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'frekuensi_inspeksi',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textAreaRow($model,'perhitunganem_ket',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
