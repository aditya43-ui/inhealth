<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabahansterilisasi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_nama', array('placeholder' => 'Nama Bahan Sterilisasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_jumlah', array('placeholder' => 'Jumlah', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

</div>
<div class="col-sm-6">
    <?php echo $form->dropdownListRow($model, 'bahansterilisasi_satuan', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_warna', array('placeholder' => 'Warna', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_maksuhu', array('placeholder' => 'Maksimal Suhu °C', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

    <div class="control-group">
        <?php echo CHtml::label("", 'bahansterilisasi_aktif', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'bahansterilisasi_aktif'); ?> <label for="SABahansterilisasiM_bahansterilisasi_aktif">Aktif</label>
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Master Bahan Sterilisasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>
<?php $this->endWidget(); ?>