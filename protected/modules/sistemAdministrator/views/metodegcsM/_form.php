<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'metodegcs-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'metodegcs_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
        <?php echo $form->textFieldRow($model, 'metodegcs_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'metodegcs_nilai', array('placeholder' => 'Nilai', 'class' => 'span2 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <?php if (!$model->isNewRecord) : ?>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'metodegcs_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <label for="MetodegcsM_metodegcs_aktif">Aktif</label>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Metode CGS', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>