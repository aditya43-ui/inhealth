<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kelompokfaktorrisiko-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Faktor Risiko', 'jenisfaktorrisiko_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model, 'jenisfaktorrisiko_id', CHtml::listData($model->JenisFaktorItems, 'jenisfaktorrisiko_id', 'jenisfaktorrisiko_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Risiko", 'faktorrisiko_daftar_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model, 'faktorrisiko_daftar_id', CHtml::listData($model->FaktorRisikoItems, 'faktorrisiko_daftar_id', 'faktorrisiko_daftar_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Status", 'kelompokfaktorrisikodaftar_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropdownList($model, 'kelompokfaktorrisikodaftar_aktif', array(0 => 'Tidak Aktif', 1 => 'Aktif'), array('empty' => '-- Pilih --', 'class' => 'span3')) ?>
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