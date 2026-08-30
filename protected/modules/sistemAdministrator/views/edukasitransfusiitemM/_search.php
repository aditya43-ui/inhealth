<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'edukasitransfusiitem-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'edukasitransfusiitem_nama', array('placeholder' => 'Nama', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'edukasitransfusiitem_urutan', array('placeholder' => 'Urutan', 'class' => 'span3 numbers-only')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'edukasitransfusiitem_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'edukasitransfusiitem_aktif', array('checked' => 'checked')); ?>
                <label for="EdukasitransfusiitemM_edukasitransfusiitem_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'edukasitransfusiitem_deskripsi', array('placeholder' => 'Deskripsi', 'rows' => 4, 'cols' => 50, 'class' => '')); ?>
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