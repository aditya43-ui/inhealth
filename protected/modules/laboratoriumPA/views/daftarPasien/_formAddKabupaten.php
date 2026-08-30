<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kabupaten-add-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#KabupatenM_propinsi_id',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'propinsi_id',  CHtml::listData($modProp, 'propinsi_id', 'propinsi_nama'),array('empty'=>'-- Pilih Propinsi --',)); ?>
	
	<?php echo $form->textFieldRow($model,'kabupaten_nama',array('size'=>25,'maxlength'=>25)); ?>
	
	<?php echo $form->textFieldRow($model,'kabupaten_namalainnya',array('size'=>25,'maxlength'=>25)); ?>
	
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                   Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    var idProp = $('#fieldsetPasien').find('select[name$="[propinsi_id]"]').val();
    $('#dialogAddKabupaten div.divForFormKabupaten #KabupatenM_propinsi_id').val(idProp);
</script>