<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppkecamatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#propinsi',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Provinsi', 'propinsi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'), array(
                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
                    )
                ));
                ?>
                <?php echo $form->error($model, 'propinsi_id'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($model, 'kabupaten_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'changeKabupaten();'));
                ?>
                <?php echo $form->error($model, 'kabupaten_id'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($model, 'kecamatan_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kecamatan_nama', array('placeholder' => 'Kecamatan', 'onkeyup' => "namaLain(this)", 'class' => 'span3 form-control', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kecamatan_nama'))); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($model, 'kecamatan_namalainnya', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kecamatan_namalainnya', array('placeholder' => 'Nama Lain', 'onkeyup' => "namaLain(this)", 'class' => 'span3 form-control', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kecamatan_nama'))); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'latitude', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'latitude', array('readonly' => false, 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => $model->getAttributeLabel('latitude'))); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'longitude', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'longitude', array('readonly' => false, 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => $model->getAttributeLabel('longitude'))); ?>
                <?php
                $this->widget('ext.LocationPicker2.CoordinatePicker', array(
                    'model' => $model,
                    'latitudeAttribute' => 'latitude',
                    'longitudeAttribute' => 'longitude',
                    //optional settings
                    'editZoom' => 12,
                    'pickZoom' => 7,
                    'defaultLatitude' => $model->latitude,
                    'defaultLongitude' => $model->longitude,
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo CHtml::htmlButton('<i class="entypo-plus-circled"></i> Tambah', array('class' => 'btn btn-primary', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);', 'id' => 'row1-plus')); ?>
            </div>
        </div>
    </div>
</div>

<?php
echo CHtml::hiddenField('Nomor', 0, array('id' => 'nomor'));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Kecamatan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th style="text-align:center;">Kecamatan <span class="required">*</span></th>
                    <th style="text-align:center;">Nama Lain</th>
                    <th style="text-align:center;">Latitude</th>
                    <th style="text-align:center;">Longitude</th>
                </tr>
            </thead>
            <tbody id="tbl-kecamatan">

            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/kecamatanM/admin'), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kecamatan', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('/pendaftaranPenjadwalan/KecamatanM/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
    ?>
    <?php
    $content = $this->renderPartial('rawatDarurat.views.tips.tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>