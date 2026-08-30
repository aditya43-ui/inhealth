<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	//'id'=>'sadiagnosakeperawatan-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'diagnosa_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'diagnosakeperawatan_kode',array('class'=>'span2','maxlength'=>10)); ?>

	<?php echo $form->textAreaRow($model,'diagnosa_medis',array('rows'=>3, 'cols'=>30, 'class'=>'span3')); ?>

	<?php echo $form->textAreaRow($model,'diagnosa_keperawatan',array('rows'=>3, 'cols'=>30, 'class'=>'span3')); ?>

	<?php //echo $form->textAreaRow($model,'diagnosa_tujuan',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->checkBoxRow($model,'diagnosa_keperawatan_aktif', array('checked'=>'$data->diagnosa_keperawatan_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
