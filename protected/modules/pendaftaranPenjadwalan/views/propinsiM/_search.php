<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pppropinsi-m-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'propinsi_nama'),
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'propinsi_id',array('class'=>'span5')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'propinsi_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'propinsi_nama', array('placeholder' => 'Provinsi', 'class' => 'span3 hurufs-only form-control', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'propinsi_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3 hurufs-only form-control', 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'propinsi_aktif', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'propinsi_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
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