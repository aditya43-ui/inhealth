<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'komponengaji-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nourutgaji', array('placeholder' => 'No. Urut Gaji', 'class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'komponengaji_kode', array('placeholder' => 'Kode Gaji', 'class' => 'span4 angkahuruf-only', 'maxlength' => 50)); ?>
        <?php //echo $form->checkBoxRow($model,'ispotongan'); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'ispotongan', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="checkbox">
                    <?php echo $form->checkBox($model, 'ispotongan', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label for="KomponengajiM_ispotongan">Potongan</label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'komponengaji_nama', array('placeholder' => 'Nama Gaji', 'class' => 'span4 custom-only', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'komponengaji_singkt', array('placeholder' => 'Singkatan Gaji', 'class' => 'span4 angkahuruf-only', 'maxlength' => 20)); ?>
        <?php // echo $form->dropDownListRow($model, 'kelompokpegawai_id', $model->getDropKelPegAktif(),array('empty' => '-- Pilih --')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'tipekomponengaji', LookupM::getItems('tipekomponengaji'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        <?php //echo $form->checkBoxRow($model,'komponengaji_aktif', array('checked'=>'checked')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'komponengaji_aktif', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="checkbox">
                    <?php echo $form->checkBox($model, 'komponengaji_aktif', array('checked' => 'komponengaji_aktif', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label for="KomponengajiM_komponengaji_aktif">Aktif</label>
                </div>
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

<?php //echo $form->textFieldRow($model,'komponengaji_id',array('class'=>'span5')); 
?>
<?php $this->endWidget(); ?>