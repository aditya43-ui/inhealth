<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gfsupplier-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Kode", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'supplier_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 10)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Supplier", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'supplier_nama', array('placeholder' => 'Nama Supplier', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <?php echo $form->checkBoxRow($model, 'supplier_aktif', array('checked' => '$data->supplier_aktif')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Alamat", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'supplier_alamat', array('placeholder' => 'Alamat', 'rows' => 4, 'cols' => 50, 'class' => 'span3')); ?>
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