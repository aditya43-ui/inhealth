<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gfpabrik-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pabrik_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pabrik_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'pabrik_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->checkBoxRow($model, 'pabrik_aktif'); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'pabrik_alamat', array('placeholder' => 'Alamat', 'rows' => 3, 'cols' => 20, 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'pabrik_propinsi', array('placeholder' => 'Provinsi', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'pabrik_kabupaten', array('placeholder' => 'Kabupaten', 'class' => 'span3', 'maxlength' => 100)); ?>
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