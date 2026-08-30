
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'shift-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#ShiftM_shift_nama',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'shift_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'shift_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php //echo $form->textFieldRow($model,'shift_jamawal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'shift_jamawal', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'shift_jamawal',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>

            <?php //echo $form->textFieldRow($model,'shift_jamakhir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'shift_jamakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'shift_jamakhir',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>

            <?php //echo $form->checkBoxRow($model,'shift_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        '', 
                        array('class' => 'btn btn-default',
                              'onclick'=>'if(confirm("'.Yii::t('mds','Do You want to cancel?').'")) location.reload(); return false;')); ?>
                        <?php
                        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Shift', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));

                            $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit4c',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
    </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('ShiftM_shift_namalainnya').value = nama.value.toUpperCase();
    }
</script>