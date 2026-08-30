<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'lbkelkumurhasillab-m-search',
    'type' => 'horizontal',
));
?>

<?php //echo $form->textFieldRow($model,'kelkumurhasillab_id',array('class'=>'span3'));  
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kelkumurhasillabnama', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Kelompok Umur Hasil Lab.')); ?>
        <?php echo $form->textFieldRow($model, 'umurminlab', array('class' => 'span3 numbers-only', 'placeholder' => '00')); ?>
        <?php echo $form->textFieldRow($model, 'umurmakslab', array('class' => 'span3 numbers-only', 'placeholder' => '00')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'satuankelumur', array('class' => 'span3', 'maxlength' => 20, 'placeholder' => 'Satuan Kelompok Umur')); ?>
        <?php echo $form->textFieldRow($model, 'kelkumurhasillab_urutan', array('class' => 'span1 numbers-only', 'placeholder' => '00', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'kelkumurhasillab_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelkumurhasillab_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Kelompok Umur Hasil Laboratorium Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t(
        'mds',
        '{icon} Search',
        array(
            '{icon}' => '<i class="entypo-search"></i>'
        )
    ), array(
        'class' => 'btn btn-primary',
        'type' => 'submit',
        'title' => 'Cari'
    )); ?>
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