<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenis-kelas-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SAJenisKelasM_jeniskelas_nama',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskelas_nama', array('placeholder' => 'Jenis Kelas', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return nextFocus(this,event,'SAJenisKelasM_jeniskelas_namalainnya','')", 'maxlength' => 25)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskelas_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAJenisKelasM_jeniskelas_aktif','SAJenisKelasM_jeniskelas_nama')", 'maxlength' => 25)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'jeniskelas_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jeniskelas_aktif'); ?> <label for="SAJenisKelasM_jeniskelas_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jenisKelasM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Kelas', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jenisKelasM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
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
        document.getElementById('SAJenisKelasM_jeniskelas_namalainnya').value = nama.value.toUpperCase();
    }
</script>