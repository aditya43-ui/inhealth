<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'zatgiziM-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'zatgizi_nama', array('placeholder' => 'Nama Zat Gizi', 'class' => 'span3', 'size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->textFieldRow($model, 'zatgizi_satuan', array('placeholder' => 'Satuan', 'class' => 'span3', 'size' => 10, 'maxlength' => 10)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'zatgizi_namalainnya', array('placeholder' => 'Nama Lain Zat', 'class' => 'span3', 'size' => 30, 'maxlength' => 30)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'zatgizi_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'zatgizi_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>

</div>

<?php /* echo $form->label($model,'zatgizi_id'); */ ?>
<?php /* echo $form->textField($model,'zatgizi_id'); */ ?>

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

<!--search-form-->