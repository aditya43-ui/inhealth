<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jenisjurnal-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisjurnal_nama', array('placeholder' => 'Nama Jenis Jurnal', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisjurnal_namalain', array('placeholder' => 'Nama Lain Jenis Jurnal', 'class' => 'span3', 'maxlength' => 100)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'jenisjurnal_aktif', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenisjurnal_aktif', array('placeholder' => 'Nama Lain Jenis Jurnal', 'checked' => 'checked')); ?> <label for="AKJenisjurnalM_jenisjurnal_aktif">Aktif</label>
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