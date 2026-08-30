<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sapemeriksaanlab-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAll("jenispemeriksaanlab_aktif = TRUE ORDER BY jenispemeriksaanlab_urutan ASC"), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanlab_urutan', array('class' => 'span3', 'placeholder' => 'Urutan')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Uraian Tindakan', 'daftartindakan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'daftartindakan_nama', array('class' => 'span3', 'placeholder' => 'Uraian Tindakan')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'pemeriksaanlab_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pemeriksaanlab_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pemeriksaanlab_kode', array('class' => 'span3', 'maxlength' => 10, 'placeholder' => 'Kode')); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanlab_nama', array('class' => 'span3', 'maxlength' => 500, 'placeholder' => 'Nama Pemeriksaan')); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanlab_namalainnya', array('class' => 'span3', 'maxlength' => 500, 'placeholder' => 'Nama Lainnya')); ?>
        <?php echo $form->dropDownListRow($model, 'formathasilperiksa', ['umum' => 'UMUM', 'khusus' => 'KHUSUS'], array('id'=> 'per','class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 1));?> 
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