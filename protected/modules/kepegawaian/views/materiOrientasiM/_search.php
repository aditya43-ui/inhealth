<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'materiorientasi-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Nama Materi Orientasi", 'materiorientasi_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'materiorientasi_nama', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Lainnya", 'materiorientasi_namalainnya', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'materiorientasi_namalainnya', array('class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Jenis Orientasi", 'jenisorientasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model,'jenisorientasi',LookupM::getItems('jenisorientasi'), array('empty'=>'Pilih','class'=>'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'materiorientasi_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'materiorientasi_aktif', array('checked' => 'materiorientasi_aktif', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <label>Aktif</label>
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