<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kelurahan-add-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

        <?php echo $form->dropDownListRow($model,'kecamatan_id',array(), array('empty'=>'-- Pilih Kecamatan --',)); ?>
	
	<?php echo $form->textFieldRow($model,'kelurahan_nama',array('size'=>25,'maxlength'=>25)); ?>
	
	<?php echo $form->textFieldRow($model,'kelurahan_namalainnya',array('size'=>25,'maxlength'=>25)); ?>
	
	<?php echo $form->textFieldRow($model,'kode_pos',array('size'=>15,'maxlength'=>15)); ?>
	
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                   Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">
function loadKecamatan()
{
    var idProp = $('#fieldsetPasien').find('select[name$="[propinsi_id]"]').val();
    var idKab = $('#fieldsetPasien').find('select[name$="[kabupaten_id]"]').val();
    var idKec = $('#fieldsetPasien').find('select[name$="[kecamatan_id]"]').val();
    $('#dialogAddKelurahan div.divForFormKelurahan #KelurahanM_kecamatan_id').val(idKec);
    $.post("<?php echo $this->createUrl('getListKecamatan')?>", { idKab: idKab, idKec:idKec },
        function(data){
            $('#dialogAddKelurahan div.divForFormKelurahan #KelurahanM_kecamatan_id').html(data.listKecamatan);
    }, "json");    
}

loadKecamatan();
</script>