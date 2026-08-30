<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'modelantrian-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'modelantrian_kode', array('placeholder' => 'Antrian Kode', 'class' => 'span3', 'maxlength' => 5)); ?>
        <?php echo $form->textFieldRow($model, 'modelantrian_nama', array('placeholder' => 'Antrian Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'modelantrian_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span3', 'maxlength' => 10)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'modelantrian_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'modelantrian_aktif', array('checked' => 'checked')); ?> <label for="ModelantrianM_modelantrian_aktif">Aktif</label>
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