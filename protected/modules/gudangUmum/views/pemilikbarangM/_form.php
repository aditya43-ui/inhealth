<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapemilikbarang-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'pemilikbarang_kode'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php //Echo CHtml::hiddenField('tempKode', $model->pemilikbarang_kode); 
?>
<?php echo $form->textFieldRow($model, 'pemilikbarang_kode', array('class' => 'span1 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,)); ?>
<?php echo $form->textFieldRow($model, 'pemilikbarang_nama', array('class' => 'span2', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textFieldRow($model, 'pemilikbarang_namalainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php //echo $form->checkBoxRow($model,'pemilikbarang_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/pemilikbarangM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('gudangUmum.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Pemilik Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangUmum/pemilikbarangM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAPemilikbarangM_pemilikbarang_namalainnya').value = nama.value.toUpperCase();
    }
</script>