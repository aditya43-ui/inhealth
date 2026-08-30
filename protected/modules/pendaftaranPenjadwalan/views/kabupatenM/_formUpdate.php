<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppkabupaten-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'propinsi_id'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onChange' => 'changePropinsi();')); ?>
        <?php echo $form->textFieldRow($model, 'kabupaten_nama', array('placeholder' => 'Nama Kota / Kabupaten', 'class' => 'span3 form-control hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'kabupaten_namalainnya', array('placeholder' => 'Nama Lain Kota/Kabupaten', 'class' => 'span3 form-control hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'latitude', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'latitude', array('placeholder' => 'Latitude', 'readonly' => false, 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php /* echo CHtml::htmlButton('<i class="entypo-map"></i>',
                  array(
                  'class'=>'btn btn-primary btn-location',
                  'rel'=>'tooltip',
                  'id'=>'yw1',
                  'onclick' =>'changeSize()',
                  'title'=>'Klik untuk mencari Longitude & Latitude',)); */ ?>

            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'longitude', array('placeholder' => 'Longitude', 'readonly' => false, 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

        <!--Extension location-picker latitude & longitude-->
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

        <div class="control-group">
            <?php echo $form->labelEx($model, 'kodekabupaten_kemenkes', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'kodekabupaten_kemenkes_nama'); ?>
                <?php echo $form->dropDownList($model, 'kodekabupaten_kemenkes', array(), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'kabupaten_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kabupaten_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?><label>Aktif</label>
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
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/kabupatenM/admin'), array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('/pendaftaranPenjadwalan/kabupatenM/Admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
    ?>
    <?php
    $content = $this->renderPartial('rawatDarurat.views.tips.tipsaddedit5', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>