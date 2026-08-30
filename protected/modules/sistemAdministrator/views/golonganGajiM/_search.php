<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'golongan-gaji-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'golonganpegawai_id', CHtml::listData(SAGolonganPegawaiM::model()->findAll('golonganpegawai_aktif = true ORDER BY golonganpegawai_nama'), 'golonganpegawai_id', 'golonganpegawai_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')) ?>
        <?php echo $form->textFieldRow($model, 'masakerja', array('placeholder' => 'Masa Kerja', 'class' => 'span3 numbers-only', 'maxlength' => 15, 'style' => 'text-align:right;')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jmlgaji', array('placeholder' => 'Jumlah Gaji', 'class' => 'span3 numbers-only', 'maxlength' => 20, 'style' => 'text-align:right;')); ?>
        <?php echo $form->textFieldRow($model, 'jenisgolongan', array('placeholder' => 'Jenis Golongan', 'class' => 'span3 custom-only', 'maxlength' => 50)); ?>
        <?php echo $form->checkBoxRow($model, 'golongangaji_aktif', array('checked' => 'golongangaji_aktif')); ?>
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