<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gzbahanmakanan-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'golbahanmakanan_id', CHtml::listData($model->GolBahanMakananItems, 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)); ?>
        <?php echo $form->dropDownListRow($model, 'sumberdanabhn', CHtml::listData($model->SumberDanaItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)); ?>
        <?php echo $form->textFieldRow($model, 'namabahanmakanan', array('class' => 'span3', 'placeholder' => 'Nama Bahan Makanan', 'size' => 60, 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenisbahanmakanan', CHtml::listData($model->JenisBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)); ?>
        <?php echo $form->dropDownListRow($model, 'kelbahanmakanan', CHtml::listData($model->KelBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'bahanmakanan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'bahanmakanan_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
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