<div class="white-container">
    <legend class="rim2">Ganti <b>Kata Kunci</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'loginpemakai-k-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#LoginpemakaiK_old_password',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php 
                echo $form->errorSummary($model); 
    ?>
    <?php
                echo $form->textFieldRow($model,'nama_pemakai',array('readonly'=>true));
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model,'old_password',array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo $form->passwordField($model,'old_password',array('value'=>'','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200)); ?><?php echo CHtml::link('<i class="icon-info-sign icon-white"></i>', '#', array('class'=>'btn btn-primary', 'data-title'=>Yii::t('mds','Tips'), 'data-content'=>Yii::t('mds','fill this field in case to change the password'), 'rel'=>'popover')); ?>
            <?php echo $form->error($model,'old_password'); ?>
        </div>
    </div>

    <?php  
                echo $form->passwordFieldRow($model,'new_password',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200));
                echo $form->passwordFieldRow($model,'new_password_repeat',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50));
                echo CHtml::hiddenfield('prevUrl',$prevUrl);
    ?>
    <div class="form-actions">
                            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                 array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)')); ?>
                            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                                Yii::app()->request->getUrlReferrer(), 
                                                                array('class'=>'btn btn-danger',
                                                                 'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<?php
$js = <<< JSCRIPT
   kosongkanPassword();
       
   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_old_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
   }

JSCRIPT;
Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);
?>