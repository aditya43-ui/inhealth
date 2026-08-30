<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sabarang-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenisbarang_id', CHtml::listData(JenisbarangM::model()->findAll('jenisbarang_aktif = true order by jenisbarang_nama'), 'jenisbarang_id', 'jenisbarang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>

        <div class="control-group">
            <?php echo CHtml::label("Tipe Barang", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_type', array('placeholder' => 'Tipe Barang', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'barang_statusregister', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'barang_statusregister', array('checked' => 'barang_statusregister')) ?> <label for="SABarangM_barang_statusregister">Status Register</label>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Kode Barang", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_kode', array('placeholder' => 'Kode Barang', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Barang", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_nama', array('placeholder' => 'Nama Barang', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'barang_merk', array('placeholder' => 'Merk', 'class' => 'span3', 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'barang_statusregister', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'barang_aktif', array('checked' => 'barang_aktif')) ?> <label for="SABarangM_barang_aktif">Aktif</label>
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