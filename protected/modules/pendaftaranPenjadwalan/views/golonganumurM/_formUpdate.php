<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppgolonganumur-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#' . CHtml::activeId($model, 'golonganumur_nama'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'golonganumur_nama', array('class' => 'span3 form-control custom-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25, 'placeholder' => 'Jenis Golongan Umur')); ?>
        <?php echo $form->textFieldRow($model, 'golonganumur_namalainnya', array('class' => 'span3 form-control custom-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25, 'placeholder' => 'Usia')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'golonganumur_minimal', array('style' => '', 'class' => 'span3 form-control numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Umur Minimal')); ?>
        <?php echo $form->textFieldRow($model, 'golonganumur_maksimal', array('style' => '', 'class' => 'span3 form-control numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Umur Maksimal')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'golonganumur_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'golonganumur_aktif', array('checked' => 'checked', 'id' => 'aktif')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<!--<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'golonganumur_nama', array('class' => 'span3 form-control custom-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25, 'placeholder' => 'Jenis Golongan Umur')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'golonganumur_namalainnya', array('class' => 'span3 form-control custom-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25, 'placeholder' => 'Usia')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'golonganumur_minimal', array('style' => '', 'class' => 'span3 form-control numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Umur Minimal')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'golonganumur_maksimal', array('style' => '', 'class' => 'span3 form-control numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Umur Maksimal')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label("", 'golonganumur_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'golonganumur_aktif', array('checked' => 'checked', 'id' => 'aktif')); ?> <label for="aktif">Aktif</label>
                </div>
            </div>

        </td>
    </tr>

</table>-->



<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/golonganumurM/admin'), array(
        'class' => 'btn btn-default', 'title' => 'Ulang',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Golongan Umur', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('/pendaftaranPenjadwalan/golonganumurM/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
    ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>