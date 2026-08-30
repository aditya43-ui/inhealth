<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sacara-bayar-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'carabayar_nama'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'carabayar_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SACaraBayarM_carabayar_namalainnya','')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'carabayar_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SACaraBayarM_metode_pembayaran','SACaraBayarM_carabayar_nama')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'metode_pembayaran', array('placeholder' => 'Metode Pembayaran', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'carabayar_loket', array('placeholder' => 'Loket', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SACaraBayarM_metode_pembayaran','SACaraBayarM_carabayar_nama')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'carabayar_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'carabayar_nourut', array('placeholder' => 'No. Urut', 'class' => 'span3 numbers-only', 'onkeypress' => "return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Kode Jenis Penjamin INACBG", 'kode_carabayar_inacbg', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php echo $form->textField($model, 'kode_carabayar_inacbg', array('placeholder' => 'Kode Jenis Penjamin INACBG', 'class' => 'span3',  'maxlength' => 10)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Jenis Penjamin INACBG", 'nama_carabayar_inacbg', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php echo $form->textField($model, 'nama_carabayar_inacbg', array('placeholder' => 'Nama Jenis Penjamin INACBG', 'class' => 'span3', 'maxlength' => 50)); ?>
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
        Yii::app()->createUrl($this->module->id . '/caraBayarM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Penjamin', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/sistemAdministrator/CaraBayarM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>

</div>

<?php $this->endWidget(); ?>