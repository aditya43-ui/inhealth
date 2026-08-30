<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rekperiod-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#AKRekperiodM_deskripsi',
));
?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'perideawal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; 
                ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'perideawal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //                                                        'minDate' => 'd',
                        //                                                            'maxDate'=>$minDate,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'sampaidgn', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; 
                ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'sampaidgn',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //                                                        'minDate' => 'd',
                        //                                                            'maxDate'=>$minDate,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'deskripsi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'deskripsi', array('placeholder' => 'Deskripsi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/rekperiodM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Rekening Periode', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>