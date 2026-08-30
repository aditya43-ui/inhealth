<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzzatgizi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#zatgiziM_zatgizi_nama',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'zatgizi_nama', array('placeholder' => 'Nama Zat Gizi', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 30)); ?>
        <?php echo $form->textFieldRow($model, 'zatgizi_satuan', array('placeholder' => 'Satuan', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 10)); ?>
    </div>

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'zatgizi_namalainnya', array('placeholder' => 'Nama Lain Zat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 30)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'zatgizi_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'zatgizi_aktif'); ?>
                <label for="ZatgiziM_zatgizi_aktif">Aktif</label>
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
        Yii::app()->createUrl($this->module->id . '/ZatgiziM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Zat Gizi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('ZatgiziM/admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => 'frame')),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('ZatgiziM_zatgizi_namalainnya').value = nama.value.toUpperCase();
    }
</script>