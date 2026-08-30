<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'salab-klinik-rujukan-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'labklinikrujukan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'labklinikrujukan_nama',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textAreaRow($model,'labklinikrujukan_alamat',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'labklinikrujukan_telp',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'labklinikrujukan_mobile',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'labklinikrujukan_dokterpj',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->checkBoxRow($model,'labklinikrujukan_aktif'); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
