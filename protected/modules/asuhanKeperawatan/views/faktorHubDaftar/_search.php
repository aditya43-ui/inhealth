<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'faktorHubDaftar-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?= CHtml::label('Nama Kondisi Klinis Terkait', 'faktorhub_daftar_nama', ['class' => 'col-sm-3']) ?>
            <div class="controls">
                <?= $form->textField($model, 'faktorhub_daftar_nama', array('placeholder' => 'Nama Kondisi Klinis Terkait',)) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?= CHtml::label('Nama Lain Kondisi Klinis Terkait', 'faktorhub_daftar_namalain', ['class' => 'col-sm-3']) ?>
            <div class="controls">
                <?= $form->textField($model, 'faktorhub_daftar_namalain', array('placeholder' => 'Nama Lain Kondisi Klinis Terkait',)) ?>
            </div>
        </div>
        <div class="control-group">
            <?= CHtml::label('', 'faktorhub_daftar_aktif', ['class' => 'col-sm-3']) ?>
            <div class="controls">
                <?= $form->checkBox($model, 'faktorhub_daftar_aktif', []) ?>
                <label for="FaktorhubDaftarM_faktorhub_daftar_aktif">Aktif</label>
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