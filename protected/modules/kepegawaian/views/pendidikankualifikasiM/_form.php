<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapendidikankualifikasi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#KPPendidikankualifikasiM_pendkualifikasi_kode',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Kode Pendidikan Kualifikasi', 'Kode Pendidikan Kualifikasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pendkualifikasi_kode', array('placeholder' => 'Kode Pendidikan Kualifikasi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Kualifikasi Pendidikan <span class="required">*</span>', 'Nama Kualifikasi Pendidikan', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pendkualifikasi_nama', array('placeholder' => 'Nama Kualifikasi Pendidikan', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Kualifikasi Pendidikan Lainnya', 'Nama Kualifikasi Pendidikan Lainnya', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pendkualifikasi_namalainnya', array('placeholder' => 'Nama Kualifikasi Pendidikan Lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'pendidikan_id', CHtml::listData(PendidikanM::model()->findAll('pendidikan_aktif = true'), 'pendidikan_id', 'pendidikan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jmlkeblaki', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jmlkeblaki', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                <?php echo CHtml::label('Orang', 'Orang') ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jmlkebperempuan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jmlkebperempuan', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                <?php echo CHtml::label('Orang', 'Orang') ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pendkualifikasi_aktif', array('checked' => 'checked')); ?>
                <label for="KPPendidikankualifikasiM_pendkualifikasi_aktif">Aktif</label>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'pendkualifikasi_keterangan', array('placeholder' => 'Keterangan', 'rows' => 6, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<?php //echo $form->checkBoxRow($model,'pendkualifikasi_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);",'checked'=>true)); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/pendidikankualifikasiM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kualifikasi Pendidikan', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',));
    $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('KPPendidikankualifikasiM_pendkualifikasi_namalainnya').value = nama.value.toUpperCase();
    }
</script>