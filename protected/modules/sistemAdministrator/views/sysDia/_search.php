<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmsys-dia-search',
        'type'=>'horizontal',
)); ?>

<div class="row">
	<div class="col-sm-6">
		<?php //echo $form->textFieldRow($model,'sysdia_id',array('class'=>'span3')); ?>

		<?php //echo $form->textFieldRow($model,'kelompokumur_id',array('class'=>'span3')); ?>
		<?php echo $form->dropDownListRow($model,'kelompokumur_id',CHtml::listData($model->KelompokUmurItems, 'kelompokumur_id', 'kelompokumur_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		<?php echo $form->textFieldRow($model,'systolic_min',array('class'=>'span3 integer2')); ?>

		<?php echo $form->textFieldRow($model,'systolic_max',array('class'=>'span3 integer2')); ?>
		<?php //echo $form->checkBoxRow($model,'sysdia_aktif',array('checked'=>'$data->sysdia_aktif')); ?>
		<div class="control-group">
			<?php echo CHtml::label("",'',array('class' => 'control-label')); ?>
			<div class="controls">                            
				<?php echo $form->checkBox($model,'sysdia_aktif',array('checked' => 'sysdia_aktif')).' Aktif'; ?>
			</div>
        </div>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'diastolic_min',array('class'=>'span3 integer2')); ?>

		<?php echo $form->textFieldRow($model,'diastolic_max',array('class'=>'span3 integer2')); ?>

		<?php //echo $form->textFieldRow($model,'sysdia_range',array('class'=>'span3','maxlength'=>100)); ?>

		<?php //echo $form->textFieldRow($model,'sysdia_nama',array('class'=>'span3','maxlength'=>100)); ?>

		<?php //echo $form->textAreaRow($model,'sysdia_desc',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>

<?php
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>