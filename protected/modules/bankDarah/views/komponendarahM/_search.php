<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'komponendarah-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Komponen Darah', 'namakomponendrh', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'namakomponendrh', array('placeholder' => 'Nama Komponen Darah', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Singkatan', 'singkatan_komp', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'singkatan_komp', array('placeholder' => 'Singkatan', 'rows' => 2, 'cols' => 50, 'class' => 'span3 hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Kantong Darah', 'jeniskantongdarah_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropdownList($model, 'jeniskantongdarah_id', CHtml::listData($model->JeniskantongdarahItems, 'jeniskantongdarah_id', 'nama_jenis'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'komponendarah_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'komponendarah_aktif', array('id' => 'aktif', 'checked' => 'komponendarah_aktif')); ?> <label for="aktif">Aktif</label>
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