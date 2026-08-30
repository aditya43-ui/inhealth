<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pppendidikan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#PPPendidikanM_pendidikan_nama',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pendidikan_nama', array('placeholder' => 'Pendidikan', 'class' => 'span3 angkahuruf-only form-control', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'pendidikan_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3  angkahuruf-only form-control', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pendidikan_urutan', array('placeholder' => '00', 'class' => 'span1 form-control numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'style' => 'text-align:right;')); ?>
        <?php echo $form->checkBoxRow($model, 'pendidikan_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class=entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/pendidikanM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Pendidikan', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/pendaftaranPenjadwalan/PendidikanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
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
        document.getElementById('PPPendidikanM_pendidikan_namalainnya').value = nama.value.toUpperCase();
    }
</script>