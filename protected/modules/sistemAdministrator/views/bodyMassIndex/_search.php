<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmbody-mass-index-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'bodymassindex_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'bmi_range',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'bmi_minimum',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'bmi_maksimum',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'bmi_sign',array('class'=>'span3','maxlength'=>2)); ?>

	<?php echo $form->textAreaRow($model,'bmi_defenisi',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'bmi_pesan',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'bodymassindex_aktif',array('checked'=>'$data->subrak_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
