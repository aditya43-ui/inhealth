<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzbahandiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#BahandietM_bahandiet_nama',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<!-- <p class="help-block">Bagian dengan tanda <span class="required">*</span> harus diisi.</p> -->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'bahandiet_nama', array('placeholder' => 'Nama Bahan Diet', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'size' => 60, 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'bahandiet_namalain', array('placeholder' => 'Nama Lain Bahan Diet', 'onkeypress' => "return $(this).focusNextInputField(event);", 'size' => 60, 'maxlength' => 100)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'bahandiet_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'bahandiet_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/bahandietM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Bahan Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('bahandietM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('BahandietM_bahandiet_namalain').value = nama.value.toUpperCase();
    }
</script>