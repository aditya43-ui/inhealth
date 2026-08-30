<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppgolonganumur-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#' . CHtml::activeId($model, 'golonganumur_nama'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'golonganumur_nama', array('class' => 'span3 form-control custom-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25, 'placeholder' => 'Jenis Golongan Umur')); ?>
        <?php echo $form->textFieldRow($model, 'golonganumur_namalainnya', array('class' => 'span3 form-control custom-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25, 'placeholder' => 'Usia')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'golonganumur_minimal', array('style' => '', 'class' => 'span3 form-control numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'placeholder' => 'Umur Minimal')); ?>
        <?php echo $form->textFieldRow($model, 'golonganumur_maksimal', array('style' => '', 'class' => 'span3 form-control numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'placeholder' => 'Umur Maksimal')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'placeholder' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/golonganumurM/admin'),
        array(
            'class' => 'btn btn-default', 'placeholder' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Golongan Umur', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/pendaftaranPenjadwalan/golonganumurM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success')
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>