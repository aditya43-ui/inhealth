<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sagolongan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'golongan_kode',array('class'=>'span3 numbers-only','maxlength'=>2)); ?>
		<?php echo $form->checkBoxRow($model,'golongan_aktif',array('checked'=>'golongan_aktif')); ?>		
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'golongan_nama',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model,'golongan_namalainnya',array('class'=>'span3 custom-only','maxlength'=>100)); ?>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>
