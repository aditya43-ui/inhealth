<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'salookup-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'lookup_name'),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lookup_type', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event );", 'maxlength' => 100, 'readOnly' => true)); ?>
        <?php echo $form->textFieldRow($model, 'lookup_name', array('class' => 'span3', 'onkeyup' => 'keyNameToVal(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'lookup_value', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lookup_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'lookup_urutan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div>
            <?php echo $form->checkBoxRow($model, 'lookup_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Satuan Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>

<script>
    function keyNameToVal(obj) {
        var value = $(obj).val();
        $('#<?php echo CHtml::activeId($model, 'lookup_value') ?>').val(value);
    }
</script>