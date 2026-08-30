<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'alatfinger-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#AlatfingerM_namaalat',
));
?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'namaalat', array('placeholder' => 'Nama Alat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'ipfinger', array('placeholder' => 'IP Alat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'keyfinger', array('placeholder' => 'Key Alat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'lokasifinger', array('placeholder' => 'Lokasi Alat', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->radioButtonListRow($model, 'is_fingerprint', array(1 => "Ya", 0 => "Tidak"), array('uncheckValue' => null, 'template' => '<i class="radio-inline">{input}{label}</i>', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->radioButtonListRow($model, 'is_facerecognition', array(1 => "Ya", 0 => "Tidak"), array('uncheckValue' => null, 'template' => '<i class="radio-inline">{input}{label}</i>', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model, 'keterangan', array('placeholder' => 'Keterangan', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'alat_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'alat_aktif'); ?>
                <label for="SAAlatfingerM_alat_aktif">Aktif</label>
            </div>
        </div>

    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/alatfingerM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Alat Finger / Face Recognition', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>