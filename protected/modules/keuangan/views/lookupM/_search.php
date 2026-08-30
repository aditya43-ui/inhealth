<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sakonfigfarmasi-k-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lookup_name', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'lookup_value', array('placeholder' => 'Value', 'class' => 'span3', 'maxlength' => 200)); ?>
        <?php echo $form->checkBoxRow($model, 'lookup_aktif', array('checked' => 'lookup_aktif')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lookup_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'lookup_urutan', array('placeholder' => 'Urutan', 'class' => 'span3', 'maxlength' => 7)); ?>
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