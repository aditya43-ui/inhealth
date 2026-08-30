<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sapemeriksaan-rad-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'daftartindakan_id', CHtml::listData(DaftartindakanM::model()->findAll("daftartindakan_aktif = TRUE ORDER BY daftartindakan_nama ASC"), 'daftartindakan_id', 'daftartindakan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanrad_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 20)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'pemeriksaanrad_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pemeriksaanrad_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenispemeriksaanrad_id', CHtml::listData(JenispemeriksaanradM::model()->findAll("jenispemeriksaanrad_aktif = TRUE ORDER BY jenispemeriksaanrad_nama"), 'jenispemeriksaanrad_id', 'jenispemeriksaanrad_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanrad_nama', array('placeholder' => 'Nama Pemeriksaan', 'class' => 'span3', 'maxlength' => 20)); ?>
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