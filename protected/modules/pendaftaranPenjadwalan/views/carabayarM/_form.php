<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppcarabayar-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);',
    ),
    'focus' => '#' . CHtml::activeId($model, 'carabayar_nama'),
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'carabayar_nama', array('placeholder' => 'Nama', 'class' => 'form-control span3 hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'carabayar_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'form-control span3 hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'metode_pembayaran', array('placeholder' => 'Metode Pembayaran', 'class' => 'form-control span3 hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'carabayar_loket', array('placeholder' => 'Loket', 'class' => 'form-control span3 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php //echo $form->checkBoxRow($model,'carabayar_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'carabayar_singkatan', array('placeholder' => 'Singkatan', 'class' => 'form-control span3 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 1)); ?>
        <?php echo $form->textFieldRow($model, 'carabayar_nourut', array('placeholder' => 'No. Urut', 'class' => 'form-control span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;', 'maxlength' => 4)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Tanggungan Asuransi", 'issubsidiasuransi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'issubsidiasuransi'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tanggungan Pemerintah", 'issubsidipemerintah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'issubsidipemerintah'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tanggungan Rumah Sakit", 'issubsidirs', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'issubsidirs'); ?>
            </div>
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
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/carabayarM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Penjamin', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/pendaftaranPenjadwalan/carabayarM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success')
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('PPCarabayarM_carabayar_namalainnya').value = nama.value.toUpperCase();
    }
</script>