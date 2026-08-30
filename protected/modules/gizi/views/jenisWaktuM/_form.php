<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzjeniswaktu-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#JenisWaktuM_jeniswaktu_nama',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<?php $waktu = explode(':', $model->jeniswaktu_jam);
?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniswaktu_nama', array('placeholder' => 'Nama Jenis Waktu', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'size' => 50, 'maxlength' => 50)); ?>
        <div class="control-label">Jam <span class="required">*</span></div>
        <div class="controls">
            <?php echo CHtml::textField('jam', (!empty($model->jeniswaktu_jam) ? $waktu[0] : ""), array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'size' => 20, 'maxlength' => 2, 'placeholder' => "00")); ?> :
            <?php echo CHtml::textField('menit', (!empty($model->jeniswaktu_jam) ? $waktu[1] : ""), array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'size' => 20, 'maxlength' => 2, 'placeholder' => "00")); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniswaktu_namalain', array('placeholder' => 'Nama Lain', 'onkeypress' => "return $(this).focusNextInputField(event);", 'size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'urutan', array('placeholder' => 'Urutan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'size' => 50, 'maxlength' => 50, 'class'=>'numbers-only span1')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'jeniswaktu_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jeniswaktu_aktif'); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>


<?php //echo $form->textFieldRow($model,'jeniswaktu_nourut',array('class'=>'span2','style'=>'width:50px;'));  
?>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jenisWaktuM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Waktu', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jenisWaktuM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script>
    $("#jam").keypress(function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    });
    $("#menit").keypress(function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    });

    function namaLain(nama) {
        document.getElementById('JenisWaktuM_jeniswaktu_namalain').value = nama.value.toUpperCase();
    }
</script>