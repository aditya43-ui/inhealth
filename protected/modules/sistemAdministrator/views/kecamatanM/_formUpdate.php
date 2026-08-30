<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakecamatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#propinsi',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Provinsi', 'propinsi', array('class' => "control-label")) ?>
            <div class="controls">
                <?php
                echo CHtml::dropDownList('propinsi', $model->getPropinsiItemsKab($model->kabupaten_id), CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => '', 'attr' => 'propinsi')),
                        'update' => '#SAKecamatanM_kabupaten_id',
                    )
                ));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'kabupaten_id', CHtml::listData($model->KabupatenItems, 'kabupaten_id', 'kabupaten_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>

        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'longitude', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'longitude', array('placeholder' => 'Longitude', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php
                echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
                    'class' => 'btn btn-primary',
                    'rel' => "tooltip",
                    'id' => 'yw1',
                    'title' => "Klik untuk mencari Longitude & Latitude",
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'latitude', array('placeholder' => 'Latitude', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kecamatan_nama', array('placeholder' => 'Nama Kecamatan', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php echo $form->textFieldRow($model, 'kecamatan_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 50, 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'kecamatan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kecamatan_aktif'); ?> <label for="SAKecamatanM_kecamatan_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kecamatanM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kecamatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('KecamatanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('../tips/tipsadd1', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<!--Extension location-picker latitude & longitude-->
<?php
$this->widget('ext.LocationPicker2.CoordinatePicker', array(
    'model' => $model,
    'latitudeAttribute' => 'latitude',
    'longitudeAttribute' => 'longitude',
    //optional settings
    'editZoom' => 12,
    'pickZoom' => 7,
    'defaultLatitude' => $latitude,
    'defaultLongitude' => $longitude,
));
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAKecamatanM_kecamatan_namalainnya').value = nama.value.toUpperCase();
    }
</script>