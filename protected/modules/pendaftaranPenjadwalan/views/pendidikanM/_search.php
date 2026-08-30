<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pppendidikan-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'pendidikan_nama', array('placeholder' => 'Pendidikan', 'class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pendidikan_nama', array('placeholder' => 'Pendidikan', 'placeholder' => 'Nama Lainnya', 'class' => 'span3 form-control angkahuruf-only', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pendidikan_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3 form-control angkahuruf-only', 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'pendidikan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pendidikan_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
            </div>
        </div>
        <?php //echo $form->checkBoxRow($model,'pendidikan_aktif',array('checked'=>'checked'));  
        ?>
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