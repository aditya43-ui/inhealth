<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saalatmedis-m-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'caramasuk_nama'),
));
?>

<?php echo $form->textFieldRow($model, 'caramasuk_nama', array('placeholder' => 'Cara Masuk', 'class' => 'span3', 'maxlength' => 50)); ?>

<div class="control-group">
    <?php echo CHtml::label("", 'caramasuk_aktif', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->checkBox($model, 'caramasuk_aktif', array('checked' => 'checked')); ?> <label for="SACaraMasukM_caramasuk_aktif">Aktif</label>
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