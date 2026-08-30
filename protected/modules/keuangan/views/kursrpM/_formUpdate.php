<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kursrp-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#KUKursrpM_matauang_id',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'matauang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList(
                    $model,
                    'matauang_id',
                    CHtml::listData($model->MataUangItems, 'matauang_id', 'matauang'),
                    array('class' => 'span2', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)
                );
                ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'tglkursrp', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; 
                ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglkursrp',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //                                                        'minDate' => 'd',
                        //                                                                'maxDate'=>$minDate,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'nilai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilai', array('placeholder' => '00', 'class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'rupiah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'rupiah', array('placeholder' => '00', 'class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class='control-group'>
            <label for="" class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kursrp_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <label for="KUKursrpM_kursrp_aktif">Aktif</label>
            </div>
        </div>
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
        Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kurs Rp', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('keuangan.views.tips.tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>