<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfatc-m-form',
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
        <?php echo CHtml::activeHiddenField($model, 'lookup_type', array('class' => 'span3', 'value' => 'kelas_rumahsakit')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Nama Kepemilikan Rumah Sakit <span class="required">*</span>', 'lookup_name', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'lookup_value',
                    LookupM::getItems('namakepemilikanrs'),
                    array(
                        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'inputRequire span3'
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Kelas Rumah Sakit <span class="required">*</span>', 'lookup_name', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'lookup_name', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Urutan <span class="required">*</span>', 'lookup_urutan', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'lookup_urutan', array('class' => 'span1', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status', 'lookup_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'lookup_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
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
        Yii::t('mds', '{icon} Pengaturan Kelas Rumah Sakit', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>