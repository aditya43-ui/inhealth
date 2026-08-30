<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jenis-surat-m-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => false,
));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'jenissurat_nama', array('size' => 60, 'maxlength' => 200)); ?>
<?php echo $form->textFieldRow($model, 'jenissurat_namalain', array('size' => 60, 'maxlength' => 200)); ?>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'is_anastesi_umum'); ?><label> Anestesi Umum</label>
    </div>
</div>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'is_anastesi_separuhbadan'); ?><label> Anestesi Separuh Badan</label>
    </div>
</div>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'is_surat_tindakan_dokter'); ?><label> Persetujuan Tindakan Dokter</label>
    </div>
</div>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'is_surat_tindakan_transfusiresiko'); ?><label> Persetujuan Tindakan Resiko Tinggi/Transfusi</label>
    </div>
</div>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'is_anastesi_sedasi'); ?><label> Sedasi</label>
    </div>
</div>
<?php if (!$model->isNewRecord) : ?>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model, 'jenissurat_aktif'); ?><label> Aktif</label>
        </div>
    </div>
<?php endif; ?>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jenisSuratM/admin'),
        array(
            'class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Surat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jenisSuratM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success')
    );
    ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>