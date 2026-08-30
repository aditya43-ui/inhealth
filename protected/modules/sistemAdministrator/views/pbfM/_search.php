<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gfpbf-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pbf_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 20)); ?>
        <?php echo $form->checkBoxRow($model, 'pbf_aktif', array('checked' => 'pbf_aktif')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pbf_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo CHtml::hiddenfield('SAPbfM[pbf_singkatan]'); ?>
        <?php echo CHtml::hiddenfield('SAPbfM[pbf_alamat]'); ?>
        <?php echo CHtml::hiddenfield('SAPbfM[pbf_propinsi]'); ?>
    </div>
</div>
<div class="row">
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