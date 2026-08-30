<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sareportbugs-r-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'kodebugs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'judul_bugs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'link_bugs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
        <?php echo $form->textFieldRow($model, 'type_bugs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'file_bugs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
        <?php echo $form->textFieldRow($model, 'line_bugs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textAreaRow($model, 'pesan_bugs', array('rows' => 5, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'prioritas_bugs', LookupM::getItems('prioritas_bugs'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width:140px;')); ?>
        <?php //echo $form->textFieldRow($model,'create_login_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'create_pegawai_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'create_instalasi_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'create_ruangan_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->dropDownListRow($model, 'create_modul_id', CHtml::listData(ModulK::model()->findAll(), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width:180px;')); ?>
    </div>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'create_datetime', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->create_datetime = (!empty($model->create_datetime) ? date("d/m/Y H:i:s", strtotime($model->create_datetime)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'create_datetime',
                    'mode' => 'datetime',
                    'options' => array(
                        //                                    'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                )); ?>
                <?php echo $form->error($model, 'create_datetime'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'create_hostname_pc', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'create_browser_pc', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 255)); ?>
        <?php echo $form->textFieldRow($model, 'create_login_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 150)); ?>
        <div>
            <?php echo $form->checkBoxRow($model, 'isajax_bugs', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-cancel"></i>')),
        'javascript:void(0);',
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Monitoring Error dan Bugs', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>

    <?php
    $content = $this->renderPartial('tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>