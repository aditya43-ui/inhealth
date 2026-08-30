<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sasubjenispemeriksaanlab-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'subjenis_pl_nama', array('class' => 'span3', 'maxlength' => 10, 'placeholder' => 'Sub-Jenis')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'subjenis_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'subjenis_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'subjenis_pl_namalainnya', array('class' => 'span3', 'maxlength' => 10, 'placeholder' => 'Nama Lain')); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'title' => 'Cari')
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