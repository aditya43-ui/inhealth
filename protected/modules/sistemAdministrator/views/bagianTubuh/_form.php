<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabagiantubuh-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#SABagiantubuhM_namabagtubuh',
)); ?>
<br>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<br>
<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'namabagtubuh', array('class' => 'span3', 'placeholder' => 'Bagian Tubuh Manusia', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'bagtubuh_namalain', array('class' => 'span3', 'placeholder' => 'Bagian Tubuh Manusia', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'kordinat_x', array('class' => 'span3 numbers-only', 'placeholder' => 'Koordinat axis X pada gambar tubuh', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'kordinat_y', array('class' => 'span3 numbers-only', 'placeholder' => 'Koordinat axis Y pada gambar tubuh', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div>
            <div class="control-group">
                <?php echo CHtml::label("", 'bagiantubuh_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'bagiantubuh_aktif', array()); ?> <label>Aktif</label>
                </div>
            </div>
            <?php //echo $form->checkBoxRow($model,'bagiantubuh_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        '',
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Bagian Tubuh', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl($this->id . '/admin', array('tab' => 'frame', 'modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function namaLain(nama) {
        document.getElementById('SABagiantubuhM_bagtubuh_namalain').value = nama.value.toUpperCase();
    }
</script>