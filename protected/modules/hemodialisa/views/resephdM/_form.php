<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'resephd-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'resephd_nama')
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class = "col-sm-12">
        <div class="control-group">
                <?php echo CHtml::label("Nama Paket HD <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
            <div class="controls">
        <?php echo $form->textField($model, 'resephd_nama', array('class' => 'span3', 'maxlength' => 200)); ?>
            </div>
        </div>
            <?php //echo $form->textFieldRow($model,'resephd_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));  ?>
            <?php // echo $form->textAreaRow($model,'resephd_desc',array('rows'=>2, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <div class="control-group ">
                <?php echo $form->labelEx($model, 'resephd_desc', array('class' => 'control-label')) ?>
            <div class="controls">
<?php echo $form->textArea($model, 'resephd_desc', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("", "", array('class' => 'control-label')); ?>
            <div class="controls">
        <?php echo $form->checkBox($model, 'resephd_aktif', array('checked' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label>Aktif</label>
            </div>
        </div>
<?php // echo $form->checkBoxRow($model,'resephd_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'));
        ?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Paket HD', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
<?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
