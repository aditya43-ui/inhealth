<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakelompok-tindakan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#SAKelompokTindakanM_kelompoktindakan_nama',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kelompoktindakan_nama', array('placeholder' => 'Kelompok Tindakan', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'kelompoktindakan_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelex($model, 'Cyto <span class="required">*</span>', array('class' => "control-label required")) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kelompoktindakan_persencyto', array('placeholder' => '00', 'value' => 0, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> %
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'kelompoktindakan_urutan', array('placeholder' => '00', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
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
        Yii::app()->createUrl($this->module->id . '/kelompokTindakanM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kelompok Tindakan', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('KelompokTindakanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAKelompokTindakanM_kelompoktindakan_namalainnya').value = nama.value.toUpperCase();
    }
</script>