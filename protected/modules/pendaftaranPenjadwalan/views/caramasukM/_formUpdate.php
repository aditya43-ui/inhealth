<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppcaramasuk-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
    'focus' => '#' . CHtml::activeId($model, 'caramasuk_nama'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'caramasuk_nama', array('class' => 'form-control span3 hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Cara Masuk')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'caramasuk_namalainnya', array('class' => 'form-control span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Cara Masuk Lainnya')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'caramasuk_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'caramasuk_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>

<!--<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'caramasuk_nama', array('class' => 'form-control span3 hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Cara Masuk')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'caramasuk_namalainnya', array('class' => 'form-control span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Cara Masuk Lainnya')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label("", 'caramasuk_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'caramasuk_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
                </div>
            </div>

        </td>
    </tr>
</table>-->

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/caramasukM/admin'), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Cara Masuk ', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('/pendaftaranPenjadwalan/caramasukM/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php
    $tips = array(
        '0' => 'simpan2',
        '1' => 'ulang'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('PPCaramasukM_caramasuk_namalainnya').value = nama.value.toUpperCase();
    }
</script>