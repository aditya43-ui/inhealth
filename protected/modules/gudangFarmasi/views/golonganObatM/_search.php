<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'form_kategoriObt_search',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenfield('ObatAlkesKategori[lookup_value]'); ?>
        <?php echo CHtml::hiddenfield('ObatAlkesKategori[lookup_kode]'); ?>
        <?php echo CHtml::hiddenfield('ObatAlkesKategori[lookup_urutan]'); ?>
        <?php echo $form->textFieldRow($model, 'lookup_name', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->checkBoxRow($model, 'lookup_aktif', array('checked' => 'lookup_aktif')); ?>
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