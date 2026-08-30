<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sapemeriksaanlabalat-m-search',
    'type' => 'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'pemeriksaanlabalat_id',array('class'=>'span3')); 
?>

<div class="col-sm-6">
    <?php echo $form->dropdownListRow($model, 'alatmedis_id', CHtml::listData($model->AlatmedisItems, 'alatmedis_id', 'alatmedis_nama'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
    <?php echo $form->textFieldRow($model, 'pemeriksaanlabalat_kode', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Kode')); ?>
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'pemeriksaanlabalat_nama', array('class' => 'span3', 'maxlength' => 200, 'placeholder' => 'Nama Alat Lab.')); ?>
    <?php echo $form->textFieldRow($model, 'pemeriksaanlabalat_namalain', array('class' => 'span3', 'maxlength' => 200, 'placeholder' => 'Nama Lain')); ?>
</div>

<?php //echo $form->checkBoxRow($model,'pemeriksaanlabalat_aktif', array('checked'=>'pemeriksaanlabalat_aktif')); 
?>
<div class="control-group">
    <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->checkBox($model, 'pemeriksaanlabalat_aktif', array('id' => 'aktif', 'checked' => 'pemeriksaanlabalat_aktif')) . ' <label for="aktif">Aktif</label>'; ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
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
); ?></div>

<?php $this->endWidget(); ?>