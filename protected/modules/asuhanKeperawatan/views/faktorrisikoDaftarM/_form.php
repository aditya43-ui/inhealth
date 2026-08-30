<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'faktorrisikodaftar-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'programstudi_nama')
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-12">
        <?php echo $form->textAreaRow($model, 'faktorrisiko_daftar_nama', array('class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);", "placeholder" => 'Ketikan Nama Risiko')); ?>
        <?php echo $form->textAreaRow($model, 'faktorrisiko_daftar_namalain', array('class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);", "placeholder" => 'Ketikan Nama Lain Risiko')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'faktorrisiko_daftar_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'faktorrisiko_daftar_aktif', array('checked' => 'faktorrisiko_daftar_aktif')); ?> <label>Aktif</label>
            </div>				
        </div>
    </div>
</div>
<div class="row">
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('admin'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Daftar Faktor Risiko', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php
        $tips = array(
            '0' => 'autocomplete-search',
            '1' => 'simpan',
            '2' => 'ulang',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>