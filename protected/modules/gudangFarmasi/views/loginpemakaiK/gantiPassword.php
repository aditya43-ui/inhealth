<div class="white-container">
    <legend class="rim2">Ganti <b>Kata Kunci</b></legend>
<style>
    .password_strength {
        margin-left: 10px;
        padding: 5px;
        border-radius: 3px;
    }
    .password_strength_1 {
	background-color: #fcb6b1;
    }
    .password_strength_2 {
        background-color: #fccab1;
    }
    .password_strength_3 {
        background-color: #fcfbb1;
    }
    .password_strength_4 {
        background-color: #dafcb1;
    }
    .password_strength_5 {
        background-color: #bcfcb1;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/passchecker/js/jquery.password_strength.js'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js/passchecker/css/style.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'loginpemakai-k-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#LoginpemakaiK_old_password',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>

    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

    <?php 
                echo $form->errorSummary($model); 
    ?>
    <?php
                echo $form->textFieldRow($model,'nama_pemakai',array('readonly'=>true));
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model,'old_password',array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo $form->passwordField($model,'old_password',array('value'=>'','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200)); ?><?php echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array('class' => 'btn btn-danger', 'data-title'=>Yii::t('mds','Tips'), 'data-content'=>Yii::t('mds','fill this field in case to change the password'), 'rel'=>'popover')); ?>
            <?php echo $form->error($model,'old_password'); ?>
        </div>
    </div>
        
    <?php  
                echo $form->passwordFieldRow($model,'new_password',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200,'onblur'=>'cekPassLama(this);'));
                echo $form->passwordFieldRow($model,'new_password_repeat',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'onblur'=>'cekPassBaru(this);'));
                echo CHtml::hiddenfield('prevUrl',$prevUrl);
    ?>
    <div class="form-actions">
                            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                 array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)')); ?>
                            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                                                Yii::app()->request->getUrlReferrer(), 
                                                                array('class' => 'btn btn-default',
                                                                 'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
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
<script type="text/javascript">
function cekPassLama(obj){
	var pass_lama = $('#<?php echo CHtml::activeId($model,'old_password'); ?>').val();
	var pass_baru = $(obj).val();
	if(pass_baru == pass_lama){
		myAlert('Kata Kunci baru tidak boleh sama dengan Kata Kunci lama');
	}
}	
function cekPassBaru(obj){
	var pass_baru = $('#<?php echo CHtml::activeId($model,'new_password'); ?>').val();
	var pass_baru_repeat = $(obj).val();
	if(pass_baru_repeat != pass_baru){
		myAlert('ulang Kata Kunci harus sama dengan Kata Kunci baru');
	}
}

$(document).ready(function() {
        $('#LoginpemakaiK_new_password').password_strength();
});
</script>
?>