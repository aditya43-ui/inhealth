<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saslot-bed-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#SASlotBedM_kelaspelayanan_id',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListRow(
    $model,
    'kelaspelayanan_id',
    CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
    array(
        'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
        'empty' => '-- Pilih Kelas Pelayanan --', 'ajax' => array(
            'type' => 'POST',
            'url' => Yii::app()->createUrl('ActionDynamic/GetRuangan', array('encode' => false, 'namaModel' => 'SASlotBedM')),
            'update' => '#SASlotBedM_ruangan_id'  //selector to update
        )
    )
); ?>
<?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($model->RuanganSlotItems, 'ruangan_id', 'ruangan_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih Ruangan --')); ?>
<div class="control-group">
    <div class="control-label">
        <?php echo $form->labelEx($model, 'keterangan_slot'); ?>
    </div>
    <div class="controls">
        <?php echo $form->dropDownList(
            $model,
            'keterangan_slot',
            CHtml::listData($model->KeteranganSlotItems, 'lookup_value', 'lookup_name'),
            array(
                'empty' => '-- Pilih Keterangan Slot --',
                'onkeypress' => "return $(this).focusNextInputField(event)",
            )
        ); ?>
    </div>
</div>
<?php echo $form->textFieldRow($model, 'slotbed_noslot', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'slotbed_jmlbed', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 2)); ?>
<?php echo $form->textFieldRow($model, 'slotbed_nobed', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 2)); ?>
<?php //echo $form->checkBoxRow($model,'slotTerpakai', array('onkeypress'=>"return $(this).focusNextInputField(event);"));
?>
<?php //echo $form->checkBoxRow($model,'slotbed_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>

<div class="control-group">
    <?php echo CHtml::label("", 'slotTerpakai', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->checkBox($model, 'slotTerpakai', array()); ?> <label>Terpakai</label>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("", 'slotbed_aktif', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->checkBox($model, 'slotbed_aktif', array()); ?> <label>Aktif</label>
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
        Yii::app()->createUrl($this->module->id . '/slotBedM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Slot Bed', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',));
    $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>