<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'ubahkelaspelayanan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )
);
?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true)); ?>
<?php echo $form->textFieldRow($model, 'no_pendaftaran', array('readonly' => true)); ?>
<div class="control-group">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np', 'np', array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Kelas Pelayanan Lama', 'kp', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('kp', 'kp', array('readonly' => true)); ?>
    </div>
</div>
<?php
echo $form->dropDownListRow(
    $model,
    'kelaspelayanan_id',
    CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif' => true)), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
    array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")
);
?>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPendaftaran() {
        var pendaftaran_id = $('#temp_idPendaftaranKP').val();
        $.post("<?php echo ($menu == 'RD' ? $this->createUrl('getDataPendaftaranRD') : $this->createUrl('getDataPendaftaranRJ')); ?>", {
                pendaftaran_id: pendaftaran_id
            },
            function(data) {
                $('#PendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
                $('#PendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
                $('#np').val(data.nama_pasien);
                $('#kp').val(data.kelaspelayanan_nama);
            },
            "json");
    }
    loadDataPendaftaran();
</script>