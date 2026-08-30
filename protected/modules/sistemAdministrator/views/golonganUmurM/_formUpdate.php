<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sagolongan-umur-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'golonganumur_nama'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'golonganumur_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
<?php echo $form->textFieldRow($model, 'golonganumur_namalainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
<?php echo $form->textFieldRow($model, 'golonganumur_minimal', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($model, 'golonganumur_maksimal', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
<div>
    <?php echo $form->checkBoxRow($model, 'golonganumur_aktif', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views/tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Golongan Umur', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>

<?php $this->endWidget(); ?>