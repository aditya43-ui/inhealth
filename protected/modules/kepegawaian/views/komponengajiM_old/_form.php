<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'komponengaji-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#KomponengajiM_nourutgaji',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'nourutgaji', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'komponengaji_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo $form->textFieldRow($model, 'komponengaji_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textFieldRow($model, 'komponengaji_singkt', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
<div>
    <?php echo $form->radioButtonRow($model, 'penerimaan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'name' => "komponen")); ?>
    <?php echo $form->radioButtonRow($model, 'ispotongan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'name' => "komponen")); ?>
</div>
<?php // echo $form->radioButtonRow($model,'komponengaji_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);", 'name'=>"komponen")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/komponengajiM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Komponen Gaji', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('komponengajiM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>