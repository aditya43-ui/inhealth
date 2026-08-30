<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppkabupaten-m-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'propinsi_id'),
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'kabupaten_id',array('class'=>'span5')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'propinsi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'), array('class' => 'span3 form-control', 'style' => 'width:160px', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'kabupaten_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kabupaten_aktif', array('id' => 'rkabupaten_aktif', 'checked' => 'checked')); ?> <label for="rkabupaten_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kabupaten_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kabupaten_nama', array('placeholder' => 'Nama Kota / Kabupaten', 'class' => 'span3 hurufs-only form-control', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kabupaten_namalainnya', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kabupaten_namalainnya', array('placeholder' => 'Nama Lain Kota/Kabupaten', 'class' => 'span3 hurufs-only form-control', 'maxlength' => 50)); ?>
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