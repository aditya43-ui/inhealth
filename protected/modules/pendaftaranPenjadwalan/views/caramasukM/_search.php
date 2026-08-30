<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppcaramasuk-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'caramasuk_id',array('class'=>'span5')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'caramasuk_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'caramasuk_nama', array('class' => 'span3 form-control', 'maxlength' => 50, 'placeholder' => 'Cara Masuk')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'caramasuk_namalainnya', array('class' => 'span3 form-control', 'maxlength' => 50, 'placeholder' => 'Cara Masuk Lainnya')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'caramasuk_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'caramasuk_aktif', array('checked' => 'checked', 'id' => 'aktif')); ?> <label for="aktif">Aktif</label>
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