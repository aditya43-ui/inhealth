<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kpjamkerja-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'shift_id', CHtml::listData(ShiftM::model()->findAll(array('order' => 'shift_nama')), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>
        <?php echo $form->textFieldRow($model, 'jamkerja_nama', array('placeholder' => 'Nama Jam Kerja', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'jammasuk', array('placeholder' => 'Jam Masuk', 'class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jampulang', array('placeholder' => 'Jam Pulang', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'jamisitrahat', array('placeholder' => 'Jam Isitrahat', 'class' => 'span3')); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'jamkerja_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jamkerja_aktif', array('checked' => 'checked')); ?>
                <label for="KPJamkerjaM_jamkerja_aktif">Aktif</label>
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