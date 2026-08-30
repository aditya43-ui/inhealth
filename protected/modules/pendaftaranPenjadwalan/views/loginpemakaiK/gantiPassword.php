<div class="white-container">
    <legend class="rim2">Ganti <b>Kata Kunci</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'loginpemakai-k-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#LoginpemakaiK_old_password',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>

    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

    <?php
    echo $form->errorSummary($model);
    ?>
    <?php
    echo $form->textFieldRow($model, 'nama_pemakai', array('class' => 'span4', 'readonly' => true));
    ?>
    <div class="control-group">
            <?php echo $form->labelEx($model, 'old_password', array('class' => 'control-label required')); ?>
        <div class="controls">
<?php echo $form->passwordField($model, 'old_password', array('value' => '', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 200)); ?><?php echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array('class' => 'btn btn-primary', 'data-title' => Yii::t('mds', 'Tips'), 'data-content' => Yii::t('mds', 'fill this field in case to change the password'), 'rel' => 'popover')); ?>
<?php echo $form->error($model, 'old_password'); ?>
        </div>
    </div>

    <?php
    echo $form->passwordFieldRow($model, 'new_password', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 200));
    echo $form->passwordFieldRow($model, 'new_password_repeat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50));
    echo CHtml::hiddenfield('prevUrl', $prevUrl);
    ?>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->request->getUrlReferrer(), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        ?>
        <?php
        $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>

    $(document).ready(function ()
    {
        kosongkanPassword();
    }
    );
    function kosongkanPassword() {
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_old_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
    }
</script>
<?php
//Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);
?>