<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sazatgizi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'zatgizi_nama'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onClick' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'zatgizi_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 30, 'onKeyPress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'namaLain(this)')); ?>
<?php echo $form->textFieldRow($model, 'zatgizi_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 30, 'onKeyPress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'zatgizi_satuan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
<div>
    <?php echo $form->checkBoxRow($model, 'zatgizi_aktif', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/ZatgiziM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Zat Gizi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/sistemAdministrator/ZatgiziM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAZatgiziM_zatgizi_namalainnya').value = nama.value.toUpperCase();
    }
</script>