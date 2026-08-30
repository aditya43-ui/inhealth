<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajenisalatsterilisasi-m-search',
    'type' => 'horizontal',
));
?>

<?php //echo $form->textFieldRow($model,'jenisalatmedis_id',array('class'=>'span3')); 
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisalatmedis_nama', array('placeholder' => 'Nama jenis Alat Sterilisasi', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisalatmedis_namalain', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 100)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'jenisalatmedis_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenisalatmedis_aktif', array('checked' => 'checked')); ?> <label for="SAJenisalatsterilisasiM_jenisalatmedis_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>



<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>