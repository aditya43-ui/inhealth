<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rdtriase-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'triase_nama', array('placeholder' => 'Nama Triase', 'class' => 'span3', 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'triase_namalainnya', array('placeholder' => 'Nama Lain Triase', 'class' => 'span3', 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'warna_triase', array('placeholder' => 'Warna Triase', 'class' => 'span3', 'maxlength' => 10)); ?>
            <?php echo $form->textFieldRow($model, 'kode_warnatriase', array('placeholder' => 'Kode Warna Triase', 'class' => 'span3', 'maxlength' => 12)); ?>
    </div>
    <div class="col-sm-6">
            <?php echo $form->textAreaRow($model, 'keterangan_triase', array('placeholder' => 'Keterangan Triase', 'rows' => '6',  'class' => 'span4', 'maxlength' => 100)); ?>
            <?php echo $form->checkBoxRow($model, 'triase_aktif', array('checked' => true)); ?>
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