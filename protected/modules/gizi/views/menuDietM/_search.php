<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gzmenudiat-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->dropDownListRow($model, 'jenisdiet_id', CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'), array(
            'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'empty' => '-- Pilih --',
        ));
        ?>
        <?php echo $form->textFieldRow($model, 'menudiet_nama', array('class' => 'span3', 'placeholder' => 'Menu Diet', 'size' => 60, 'maxlength' => 200)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'menudiet_namalain', array('placeholder' => 'Nama Lain Menu', 'class' => 'span3', 'size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'jml_porsi', array('placeholder' => '00', 'class' => 'span3')); ?>
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