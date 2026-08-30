<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajenisformlab-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisform_nama', array('class' => 'span3', 'placeholder' => 'Nama')); ?>
        <?php echo $form->textFieldRow($model, 'jenisform_namalainnya', array('class' => 'span3', 'maxlength' => 30, 'placeholder' => 'Nama Lainnya')); ?>
       
        <div class="control-group">
            <?php echo CHtml::label("", 'jenisform_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenisform_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'jenisform_kelompok', array('class' => 'span3', 'maxlength' => 100, 'placeholder' => 'Kelompok')); ?>
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