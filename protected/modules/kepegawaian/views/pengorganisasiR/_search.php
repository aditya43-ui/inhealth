<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kppengorganisasi-r-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'pengorganisasi_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pengorganisasi_nama',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'pengorganisasi_kedudukan',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'pengorganisasi_lamanya',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'pengorganisasi_tahun',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pengorganisasi_tempat',array('class'=>'span5','maxlength'=>30)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
