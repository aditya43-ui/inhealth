<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'sajenis-carabayar-m-search',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'carabayar_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 30)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'metode_pembayaran', array('placeholder' => 'Metode Pembayaran', 'class' => 'span3', 'maxlength' => 30)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'carabayar_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'carabayar_aktif', array('checked' => 'checked')); ?>
                <label for="SACaraBayarM_carabayar_aktif">Aktif</label>
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