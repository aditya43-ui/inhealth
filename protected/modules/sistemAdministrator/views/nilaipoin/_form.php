<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'nilaipoin-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SAPangkatM_golonganpegawai_id',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));

$model->nilaipoin_tgl = MyFormatter::formatDateTimeForUser($model->nilaipoin_tgl);
$model->nilaipoin_tgl_sd = MyFormatter::formatDateTimeForUser($model->nilaipoin_tgl_sd);
?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nilaipoin_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'nilaipoin_tgl',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'nilaipoin_nama', array('placeholder' => 'Nama', 'onkeyup' => 'namaLain(this);', 'class' => 'span3', 'maxlength' => 100)); ?>

        <?php echo $form->textFieldRow($model, 'nilaipoin_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nilaipoin_tgl_sd', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'nilaipoin_tgl_sd',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'nilaipoin_jumlah', array('placeholder' => 'Poin', 'class' => 'span3 numbers-only')); ?>

        <?php if (!$model->isNewRecord) { ?>
            <div class="control-group">
                <?php echo CHtml::label("", 'nilaipoin_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'nilaipoin_aktif', array()); ?> <label>Aktif</label>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Nilai Point', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ) . "&nbsp";

    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function namaLain(obj) {
        var nama = $("#<?php echo CHtml::activeId($model, 'nilaipoin_nama') ?>").val();

        $("#<?php echo CHtml::activeId($model, 'nilaipoin_namalain') ?>").val(nama.toUpperCase());
    }
</script>