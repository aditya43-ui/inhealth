<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kujenis-pengeluaran-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#KUJenispengeluaranM_jenispengeluaran_kode',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenispengeluaran_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'KUJenispengeluaranM_jenispengeluaran_kode','')", 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'jenispengeluaran_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return nextFocus(this,event,'KUJenispengeluaranM_jenispengeluaran_nama','')", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'jenispengeluaran_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'KUJenispengeluaranM_jenispengeluaran_namalain','KUJenispengeluaranM_jenispengeluaran_namalain')", 'maxlength' => 100)); ?>
        <?php echo $form->checkBoxRow($model, 'jenispengeluaran_aktif', array('onkeypress' => "return nextFocus(this,event,'btn_simpan','KUJenispengeluaranM_jenispengeluaran_aktif')")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'persenpph_21', array('placeholder' => '00', 'class' => 'span1 angkacoma-only', 'onkeypress' => "return nextFocus(this,event,'KUJenispenerimaanM_jenispenerimaan_namalain','KUJenispenerimaanM_jenispenerimaan_namalain')", 'maxlength' => 50, 'style' => 'text-align: right;')); ?>
        <?php echo $form->textFieldRow($model, 'persenpph_23', array('placeholder' => '00', 'class' => 'span1 angkacoma-only', 'onkeypress' => "return nextFocus(this,event,'KUJenispenerimaanM_jenispenerimaan_namalain','KUJenispenerimaanM_jenispenerimaan_namalain')", 'maxlength' => 50, 'style' => 'text-align: right;')); ?>
        <?php echo $form->textFieldRow($model, 'persenpph_22', array('placeholder' => '00', 'class' => 'span1 angkacoma-only', 'onkeypress' => "return nextFocus(this,event,'KUJenispenerimaanM_jenispenerimaan_namalain','KUJenispenerimaanM_jenispenerimaan_namalain')", 'maxlength' => 50, 'style' => 'text-align: right;')); ?>

    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jenisPengeluaranM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Pengeluaran Umum', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jenisPengeluaranM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('KUJenispengeluaranM_jenispengeluaran_namalain').value = nama.value.toUpperCase();
    }
</script>