

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'slotbed-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SASotbedM_instalasi',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
            <?php echo $form->dropDownListRow($model,'jadwal_hari', $listHari ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'- Pilih -')); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'jadwal_mulai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jadwal_mulai',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 ),
                    )); ?> <?php echo $form->error($model, 'jadwal_mulai'); ?>
                   
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'jadwal_tutup', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jadwal_tutup',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 'onFocus'=>"compare();",),
                    )); ?><?php echo $form->error($model, 'jadwal_tutup'); ?>
                    
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'maximumantrian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
           
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
$content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
$this->widget('TipsMasterData',array('type'=>'transaksi','content'=>$content));  ?>
	
	</div>

<?php $this->endWidget(); ?>

<?php
$jscript = <<< JS

function compare()
{
    var endDateTextBox = $('#SASotbedM_jadwal_tutup');
    var dateText = $('#SASotbedM_jadwal_mulai').val();
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
?>