<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajeniskegiatanlab-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskegiatanlab_kode', array('class' => 'span3', 'maxlength' => 10, 'placeholder' => 'Kode')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'jeniskegiatanlab_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jeniskegiatanlab_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskegiatanlab1', array('class' => 'span3', 'maxlength' => 500, 'placeholder' => 'Nama Pemeriksaan')); ?>
        <?php echo $form->textFieldRow($model, 'jeniskegiatanlab2', array('class' => 'span3', 'maxlength' => 500, 'placeholder' => 'Nama Pemeriksaan')); ?>
        <?php echo $form->textFieldRow($model, 'jeniskegiatanlab3', array('class' => 'span3', 'maxlength' => 500, 'placeholder' => 'Nama Pemeriksaan')); ?>
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