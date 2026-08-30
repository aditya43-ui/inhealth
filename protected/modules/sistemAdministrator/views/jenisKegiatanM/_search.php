<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajenis-kegiatan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskegiatan_kode', array('placeholder' => 'Kode Jenis Kegiatan', 'class' => 'span3 custom-only', 'maxlength' => 25)); ?>
        <?php echo $form->textFieldRow($model, 'jeniskegiatan_nama', array('placeholder' => 'Nama Jenis Kegiatan', 'class' => 'span3 custom-only', 'maxlength' => 100)); ?>

    </div>

    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jeniskegiatan_ruangan', LookupM::getItems('jeniskegiatan'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'jeniskegiatan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jeniskegiatan_aktif', array('checked' => 'jeniskegiatan_aktif')); ?> <label for="SAJenisKegiatanM_jeniskegiatan_aktif">Aktif</label>
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