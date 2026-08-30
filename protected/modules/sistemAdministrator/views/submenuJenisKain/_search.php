<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sabahanlinen-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'bahanlinen_nama', array('placeholder' => 'Bahan Linen', 'class' => 'span3', 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'bahanlinen_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 200)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'suhurekomendasi', array('placeholder' => 'Suhu Rekomendasi', 'class' => 'span3', 'maxlength' => 10)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'bahanlinen_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'bahanlinen_aktif', array('checked' => 'bahanlinen_aktif')); ?> <label for="SABahanlinenM_bahanlinen_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<?php //echo $form->textFieldRow($model,'bahanlinen_id',array('class'=>'span3')); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>