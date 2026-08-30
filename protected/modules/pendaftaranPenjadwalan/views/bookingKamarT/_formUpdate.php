<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppbooking-kamar-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td style="vertical-align:top">
            <div class="control-group">

                <?php echo $form->labelEx($model, 'no_pendaftran', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('no_pendaftaran', (isset($model->pendaftaran->no_pendaftaran) ? $model->pendaftaran->no_pendaftaran : ""), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => TRUE)); ?>

                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'bookingkamar_no', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => TRUE)); ?>
            <?php
            echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --',
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('GetKamarRuangan', array('encode' => false, 'namaModel' => 'PPBookingKamarT')),
                    'update' => '#PPBookingKamarT_kamarruangan_id',),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownKelasPelayanan', array('encode' => false, 'namaModel' => get_class($model))),
                    'update' => '#' . CHtml::activeId($model, 'kelaspelayanan_id')),
                'onchange' => 'clearKelasPelayanan()'));
            ?>
            <?php
            echo $form->dropDownListRow($model, 'kamarruangan_id', CHtml::listData($model->getKamarRuangan(), 'kamarruangan_id', 'kamarruangan_nokamar'), array('empty' => '-- Pilih --',
                'onkeypress' => "return $(this).focusNextInputField(event)",
            ));
            ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayanan(), 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <div class='control-group'>
                <?php echo $form->labelEx($model, 'tglbookingkamar', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglbookingkamar',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'minDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php echo $form->error($model, 'tglbookingkamar'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'statusbooking', LookupM::getItems('statusbooking'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textAreaRow($model, 'keteranganbooking', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>

    </tr>
    <tr>
        <td>
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/bookingKamarT/admin'), array('class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                ?>
                <?php //$this->widget('UserTips', array('type' => 'transaksi')); ?>
            </div>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>

<?php
$idKelasPelayan = CHtml::activeId($model, 'kelaspelayanan_id');
$js = <<< JS

function clearKelasPelayanan()
{
    $("#${idKelasPelayan}").html('<option value="">-- Pilih --</option>');
}

JS;
Yii::app()->clientScript->registerScript('javaScript', $js, CClientScript::POS_HEAD);
?>