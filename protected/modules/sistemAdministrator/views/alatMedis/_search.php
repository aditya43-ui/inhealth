<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saalatmedis-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Instalasi", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropdownList($model, 'instalasi_id', CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Alat Medis", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropdownList($model, 'jenisalatmedis_id', CHtml::listData($model->JenisalatmedisItems, 'jenisalatmedis_id', 'jenisalatmedis_nama'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Aset", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'alatmedis_noaset', array('placeholder' => 'No. Aset', 'class' => 'numbers-only span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'Program Studi Aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'alatmedis_aktif', array('checked' => 'alatmedis_aktif')) ?>
                <label for="SAAlatmedisM_alatmedis_aktif">Aktif Alat Medis</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Nama Alat Medis", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'alatmedis_nama', array('placeholder' => 'Nama Alat Medis', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Lain", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'alatmedis_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Kode", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'alatmedis_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 2)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'alatmedis_format', array('placeholder' => 'Format', 'class' => 'span3', 'maxlength' => 10)); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>