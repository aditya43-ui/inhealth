
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rdjadwaldokter-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onSubmit'=>'updateValueJadwal(this);return false;'),
        'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
            <?php echo $form->hiddenField($model, 'jadwaldokter_id'); ?>
            <?php echo $form->dropDownListRow($model,'ruangan_id', $ruangan,
                                                      array('empty'=>'-- Pilih --',
                                                            'onchange'=>"listDokterRuangan(this.value)",
                                                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'pegawai_id', $pegawai ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php //echo $form->hiddenField($model,'jadwaldokter_hari'); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'jadwaldokter_mulai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <div class="input-append">
                        <?php echo $form->textField($model, 'jadwaldokter_mulai', array('onkeypress'=>"return $(this).focusNextInputField(event);", 'class'=>"span2 timePickerTest",'readonly'=>true)); ?>
                        <span class="add-on"><i class="icon-time"></i></span>
                    </div>
                     <?php //echo $form->error($model, 'jadwaldokter_mulai'); ?>
                   
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'jadwaldokter_tutup', array('class'=>'control-label')) ?>
                <div class="controls">
                    <div class="input-append">
                        <?php echo $form->textField($model, 'jadwaldokter_tutup', array('onkeypress'=>"return $(this).focusNextInputField(event);", 'class'=>"span2 timePickerTest",'readonly'=>true)); ?>
                        <span class="add-on"><i class="icon-time"></i></span>
                    </div>                    
                    <?php //echo $form->error($model, 'jadwaldokter_tutup'); ?>
                </div>
            </div>
        
            <div class="control-group">
                <label class='control-label'>Maximum Antrian</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'maximumantrian', array("class"=>'span1 numbersOnly')); ?><?php echo $form->error($model, 'jadwaldokter_tutup'); ?>
                    
                </div>
            </div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                
	</div>

<?php $this->endWidget(); ?>
<?php

$jscript = <<< JS

function compare()
{
    var endDateTextBox = $('#RDJadwaldokterM_jadwaldokter_tutup');
    var dateText = $('#RDJadwaldokterM_jadwaldokter_mulai').val();
    if (endDateTextBox.val() != '') 
    {
        var testStartDate = new Date(dateText);
        var testEndDate = new Date(endDateTextBox.val());
        if (testStartDate > testEndDate)
            endDateTextBox.val(dateText);
    }
    else 
    {
        endDateTextBox.val(dateText);
    } 
}
JS;
Yii::app()->clientScript->registerScript('jsDokter',$jscript, CClientScript::POS_BEGIN);
?>
