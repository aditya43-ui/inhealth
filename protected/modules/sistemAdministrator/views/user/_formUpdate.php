

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
)); 
 ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'username',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>30)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'old_password',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->passwordField($model,'old_password',array('value'=>'','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>30)); ?><?php echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array('class' => 'btn btn-danger', 'data-title'=>Yii::t('mds','Tips'), 'data-content'=>Yii::t('mds','fill this field in case to change the password'), 'rel'=>'popover')); ?>
                    <?php echo $form->error($model,'old_password'); ?>
                </div>
            </div>
            
            <?php echo $form->passwordFieldRow($model,'new_password',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>30)); ?>
            <?php echo $form->passwordFieldRow($model,'new_password_repeat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            <?php echo $form->dropDownListRow($model,'pegawai_id',CHtml::listData($model->getPegawai(),'pegawai_id','pegawai_nama'),array('empty'=>'- Pegawai -','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'email',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
           
            
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                         Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                         array('class' => 'btn btn-danger', 'type'=>'submit')); 
                ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.user.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
                ?>
				<?php
$content = $this->renderPartial('../tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
<?php

$js = <<< JSCRIPT
   kosongkanPassword();
       
   function kosongkanPassword(){
        $('#User_new_password').val('');
        $('#User_old_password').val('');
        $('#User_new_password_repeat').val('');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);
?>