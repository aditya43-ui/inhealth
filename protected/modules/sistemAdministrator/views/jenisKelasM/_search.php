<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajenis-kelas-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskelas_nama', array('placeholder' => 'Jenis Kelas', 'class' => 'span3', 'maxlength' => 25)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskelas_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 25)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'jeniskelas_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jeniskelas_aktif', array('checked' => 'checked')); ?> <label for="SAJenisKelasM_jeniskelas_aktif">Aktif</label>
            </div>
        </div>
    </div>

</div>

<?php //echo $form->textFieldRow($model,'jeniskelas_id',array('class'=>'span5'));  
?>

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