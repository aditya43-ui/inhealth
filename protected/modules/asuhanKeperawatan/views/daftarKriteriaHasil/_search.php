<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jenisintervensi-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Nama Kriteria Hasil</label>
            <div class="controls">
                <?php echo $form->textField($model, 'kriteriahasil_daftar_nama', array('placeholder' => 'Nama Kriteria Hasil', 'class' => 'span3', 'maxlength' => 10)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Nama Lain Kriteria Hasil</label>
            <div class="controls">
                <?php echo $form->textField($model, 'kriteriahasil_daftar_namalain', array('placeholder' => 'Nama Lain Kriteria Hasil', 'class' => 'span3', 'maxlength' => 10)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kriteriahasil_daftar_aktif', array('checked' => 'kriteriahasil_daftar_aktif')); ?>
                <label for="ASKriteriahasilDaftarM_kriteriahasil_daftar_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>