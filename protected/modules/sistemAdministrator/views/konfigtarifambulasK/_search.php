<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'konfigtarifambulas-k-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'konfigtarifambulans_id', array('placeholder' => 'Konfigurasi Tarif Ambulans', 'class' => 'span3 numbers-only')); ?>
        <?php echo $form->textFieldRow($model, 'komponenunit_id', array('placeholder' => 'Komponen Unit', 'class' => 'span3 numbers-only')); ?>
        <?php echo $form->textFieldRow($model, 'tarifjasasarana', array('placeholder' => 'Tarif Jasa', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'jasapengemudi_prosentase', array('placeholder' => '% Jasa Pengemudi', 'class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jasapendamping_prosentase', array('placeholder' => '% Jasa Pendamping', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'jasadokter_persentase', array('placeholder' => '% Jasa Dokter', 'class' => 'span3')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'konfigurasitarifambulans_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'konfigurasitarifambulans_aktif', array('checked' => 'checked')); ?>
                <label for="KonfigtarifambulasK_konfigurasitarifambulans_aktif">Aktif</label>
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