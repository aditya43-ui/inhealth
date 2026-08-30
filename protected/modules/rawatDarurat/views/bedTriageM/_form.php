<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<style>
    .float3, .float2, .integer2, .integer-decimal {
        text-align: right;
    }

</style>
<?php
$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);

$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp. ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero' => true,
        'allowZero' => true,
        'precision' => 0,
    )
));

$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.number',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'precision' => 2,
    )
));
?>
<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bed-triage-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'bed_triage_id'),
        ));
?>
<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'bed_triage_id'); ?>
        <?php
        echo $form->textFieldRow($model, 'no_bed', array('placeholder' => '', 'class' => 'span3',
            'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'disabled' => false
        ));
        ?>
        <div class="control-group ">
            <div class="controls">
                <?php echo $form->labelEx($model, 'is_aktif', array('class' => 'control-label')) ?>
                <div class="radio inline">
                    <div class="form-inline">
                        <?php echo $form->checkBox($model, 'is_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label class="control-label"> Aktif</label>
                    </div>
                </div>
                <?php echo $form->error($model, 'is_aktif'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'keterangan', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => false)); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bed Triage', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
