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
        <?php echo $form->textFieldRow($model, 'supplier_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_nama', array('placeholder' => 'Nama Supplier', 'class' => 'span3', 'maxlength' => 100)); ?>

    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'supplier_alamat', array('placeholder' => 'Alamat', 'rows' => 3, 'cols' => 20, 'class' => 'span3')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'supplier_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'supplier_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
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
<?php //echo $form->textFieldRow($model,'supplier_id',array('class'=>'span5')); 
?>

<?php //echo $form->textFieldRow($model,'supplier_namalain',array('class'=>'span5','maxlength'=>100));  
?>

<!--
<?php
echo $form->dropDownListRow($model, 'supplier_propinsi', CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'), array(
    'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
    'empty' => '-- Pilih --',
));
?>
<?php
echo $form->dropDownListRow($model, 'supplier_kabupaten', CHtml::listData($model->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'), array(
    'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
    'empty' => '-- Pilih --',
));
?>  
-->
<?php //echo $form->textFieldRow($model,'supplier_telp',array('class'=>'span5','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'supplier_fax',array('class'=>'span5','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'supplier_kodepos',array('class'=>'span5','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'supplier_npwp',array('class'=>'span5','maxlength'=>100)); 
?>

<?php //echo $form->textFieldRow($model,'supplier_website',array('class'=>'span5','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'supplier_email',array('class'=>'span5','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'supplier_cp',array('class'=>'span5','maxlength'=>100)); 
?>
<?php $this->endWidget(); ?>