<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppkecamatan-m-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'kecamatan_nama'),
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'kecamatan_id',array('class'=>'span5')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kabupaten_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->KabupatenItems, 'kabupaten_id', 'kabupaten_nama'), array('class' => 'span3 form-control', 'style' => 'width:160px', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kecamatan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kecamatan_nama', array('placeholder' => 'Kecamatan', 'class' => 'span3 form-control hurufs-only', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kecamatan_namalainnya', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kecamatan_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3 form-control hurufs-only', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'kecamatan_aktif', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kecamatan_aktif', array('id' => 'rkecamatan_aktif', 'checked' => 'checked')); ?> <label for="rkecamatan_aktif">Aktif</label>
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