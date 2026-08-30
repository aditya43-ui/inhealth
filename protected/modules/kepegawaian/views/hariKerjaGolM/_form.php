<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'golongan-gaji-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
    'focus' => '#KPHariKerjaGolM_harikerjagol_id',
)); ?>
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id', CHtml::listData(KPKelompokpegawaiM::model()->getNonDokter(), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", "empty" => '-- Pilih --')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'periodeharikerjaawl', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'periodeharikerjaawl', CustomFunction::getNamaHari(), array('class' => 'span2  required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
            <div class="controls">
                <label>sampai</label>
            </div>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'periodeharikerjaakhir', CustomFunction::getNamaHari(), array('class' => 'span2  required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/hariKerjaGolM/create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Hari Kerja Pegawai', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('hariKerjaGolM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>