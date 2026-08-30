<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kecamatan-add-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'kabupaten_id',array(), array()); ?>
	
	<?php echo $form->textFieldRow($model,'kecamatan_nama',array('size'=>30,'maxlength'=>30)); ?>
	
	<?php echo $form->textFieldRow($model,'kecamatan_namalainnya',array('size'=>30,'maxlength'=>30)); ?>
	
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                   Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

function loadKabupaten()
{
    var idProp = $('#fieldsetPasien').find('select[name$="[propinsi_id]"]').val();
    var idKab = $('#fieldsetPasien').find('select[name$="[kabupaten_id]"]').val();
    $('#dialogAddKecamatan div.divForFormKecamatan #KecamatanM_kabupaten_id').val(idKab);
    $.post("<?php echo $this->createUrl('getListKabupaten')?>", { idProp: idProp, idKab: idKab },
        function(data){
            $('#dialogAddKecamatan div.divForFormKecamatan #KecamatanM_kabupaten_id').html(data.listKabupaten);
    }, "json");
}

loadKabupaten();
    
</script>