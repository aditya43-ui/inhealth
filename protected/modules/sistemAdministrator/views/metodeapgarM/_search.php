<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'psmetodeapgar-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'akronim',array('class'=>'span3','maxlength'=>50)); ?>
		<?php echo $form->checkBoxRow($model,'metodeapgar_aktif', array('checked'=>'$data->metodeapgar_aktif')); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'kriteria',array('class'=>'span3','maxlength'=>100)); ?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>
