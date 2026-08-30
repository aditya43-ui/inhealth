<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sop-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Instalasi", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropdownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Dokumen", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'sop_nodokumen', array('placeholder' => 'No. Dokumen', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Revisi", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'sop_norevisi', array('placeholder' => 'No. Revisi', 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Pegawai", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropdownList($model, 'pegawai_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true order by nama_pegawai ASC'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'sop_aktif', array('checked' => 'sop_aktif')) ?>
                <label for="">Aktif </label>
            </div>
        </div>
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