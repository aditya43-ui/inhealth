<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'psinterpretasiskor-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'intepretasi_nama',array('class'=>'span3','maxlength'=>100)); ?>
		<?php echo $form->checkBoxRow($model,'interpretasiskor_aktif', array('checked'=>'$data->interpretasiskor_aktif')); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'interpretasijmlskor',array('class'=>'span3','maxlength'=>50)); ?>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>
