<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppgolonganumur-m-search',
    'focus' => '#' . CHtml::activeId($model, 'golonganumur_nama'),
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'golonganumur_id',array('class'=>'span5')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'golonganumur_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'golonganumur_nama', array('class' => 'span3 form-control', 'maxlength' => 50, 'placeholder' => 'Jenis Golongan Umur')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'golonganumur_namalainnya', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'golonganumur_namalainnya', array('class' => 'span3 form-control', 'maxlength' => 50, 'placeholder' => 'Usia')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'golonganumur_minimal', array('class' => 'span3 form-control', 'placeholder' => 'Umur Minimal')); ?>
        <?php echo $form->textFieldRow($model, 'golonganumur_maksimal', array('class' => 'span3 form-control', 'placeholder' => 'Umur Maksimal')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'golonganumur_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'golonganumur_aktif', array('checked' => 'checked', 'id' => 'aktif')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>


<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'title' => 'Cari')
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