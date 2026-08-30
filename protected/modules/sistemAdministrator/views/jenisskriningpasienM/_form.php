<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jenisskriningpasien-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">

    <?php echo $form->textFieldRow($model, 'jenisskriningpasien_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 255)); ?>
    <?php echo $form->textFieldRow($model, 'jenisskriningpasien_namalainnya', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 255)); ?>
    
    <?php if (!$model->isNewRecord): ?>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'isaktif'); ?> <label>Aktif</label>

            </div>
        </div>
    <?php endif; ?>
        

</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('create'),
            array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Skrining Pasien', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>
<?php $this->endWidget(); ?>
