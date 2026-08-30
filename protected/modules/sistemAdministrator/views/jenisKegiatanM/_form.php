<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenis-kegiatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
    'focus' => '#SAJenisKegiatanM_jeniskegiatan_nama',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskegiatan_kode', array('placeholder' => 'Kode Jenis Kegiatan', 'class' => 'span3 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
        <?php echo $form->textFieldRow($model, 'jeniskegiatan_nama', array('placeholder' => 'Nama Jenis Kegiatan', 'class' => 'span3 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jeniskegiatan_ruangan', LookupM::getItems('jeniskegiatan'), array('empty' => '-- Pilih --', 'class' => 'span3 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
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
        Yii::app()->createUrl($this->module->id . '/' . $this->id . '/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Kegiatan', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',

    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAKomponenUnitM_komponenunit_namalainnya').value = nama.value.toUpperCase();
    }
</script>