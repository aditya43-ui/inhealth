<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saalatsterilisasi-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'alatmedis_id',array('class'=>'span3')); ?>
        <?php echo $form->dropdownListRow($model, 'instalasi_id', CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
        <?php echo $form->dropdownListRow($model, 'jenisalatmedis_id', CHtml::listData($model->JenisalatmedisItems, 'jenisalatmedis_id', 'jenisalatmedis_nama'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_namalain', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'alatmedis_noaset', array('placeholder' => 'No. Aset', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_nama', array('placeholder' => 'Nama Alat Sterilisasi', 'class' => 'span3', 'maxlength' => 100)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'alatmedis_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'alatmedis_aktif', array('checked' => 'checked')); ?> <label for="SAAlatsterilisasiM_alatmedis_aktif">Aktif</label>
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