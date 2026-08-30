

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sashift-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SAShiftM_shift_nama',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'shift_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'shift_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php //echo $form->textFieldRow($model,'shift_jamawal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'shift_jamawal', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'shift_jamawal',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 ),
                    )); ?>
                    <?php echo $form->error($model, 'shift_jamawal'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'shift_jamakhir', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'shift_jamakhir',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 'onFocus'=>"compare();",),
                    )); ?>
                    <?php echo $form->error($model, 'shift_jamakhir'); ?>
                </div>
            </div>
            <?php //echo $form->textFieldRow($model,'shift_jamakhir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.shiftM.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
		<?php
$content = $this->renderPartial('../tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
 <script>
     function compare(){
         var endDateTextBox = $('#SAShiftM_shift_jamakhir');
         var dateText = $('#SAShiftM_shift_jamawal').val();
        if (endDateTextBox.val() != '') {
            var testStartDate = new Date(dateText);
            var testEndDate = new Date(endDateTextBox.val());
            if (testStartDate > testEndDate)
                endDateTextBox.val(dateText);
        }
        else {
            endDateTextBox.val(dateText);
        } 
     }

 </script>