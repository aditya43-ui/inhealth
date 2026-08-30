<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rikasuspenyakitdiagnosa-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->DropDownListRow($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJeniskasuspenyakitItems(), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'diagnosa_nama', array('placeholder' => 'Diagnosa Nama',)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'diagnosa_kode', array('placeholder' => 'Kode',)); ?>
        <?php echo $form->textFieldRow($model, 'diagnosa_namalainnya', array('placeholder' => 'Nama Lain',)); ?>
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