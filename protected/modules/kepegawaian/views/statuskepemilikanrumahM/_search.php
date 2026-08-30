<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search-t-statuskepemilikanrumah',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'statuskepemilikanrumah_nama', array('placeholder' => 'Status Kepemilikan Rumah', 'size' => 10, 'maxlength' => 10)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'statuskepemilikanrumah_namalain', array('placeholder' => 'Nama lain', 'size' => 10, 'maxlength' => 10)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'statuskepemilikanrumah_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'statuskepemilikanrumah_aktif', array('checked' => 'checked')); ?>
                <label for="KPStatuskepemilikanrumahM_statuskepemilikanrumah_aktif">Aktif</label>
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