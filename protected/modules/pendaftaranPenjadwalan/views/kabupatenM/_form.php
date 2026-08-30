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
        <?php echo $form->dropDownListRow($model, 'propinsi_id', CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'), array('class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'onChange' => 'changePropinsi();')); ?>
        <div class="control-group">
            <?php echo $form->label($model, 'kabupaten_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kabupaten_nama', array('placeholder' => 'Nama Kota / Kabupaten', 'class' => 'span3 form-control hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kabupaten_nama'))); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($model, 'kabupaten_namalainnya', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kabupaten_namalainnya', array('placeholder' => 'Nama Lain Kota/Kabupaten', 'class' => 'span3 form-control hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kabupaten_namalainnya'))); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'latitude', array('readonly' => false, 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => $model->getAttributeLabel('latitude'))); ?>
        <?php echo $form->textFieldRow($model, 'longitude', array('readonly' => false, 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => $model->getAttributeLabel('longitude'))); ?>

        <!--Extension location-picker latitude & longitude-->
        <?php /* echo CHtml::htmlButton('<i class="entypo-map"></i>',
      array(
      'class'=>'btn btn-primary btn-location',
      'rel'=>'tooltip',
      'id'=>'yw1',
      'onclick' =>'changeSize()',
      'title'=>'Klik untuk mencari Longitude & Latitude',)); */
        ?>
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
            <i class="entypo-credit-card"></i> Tabel <b>Kabupaten</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tbl-kabupaten" class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Nama Kota/Kabupaten</th>
                    <th>Nama Lain Kota/Kabupaten</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
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
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/kabupatenM/admin'), array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('/pendaftaranPenjadwalan/KabupatenM/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
    ?>
    <?php
    $content = $this->renderPartial('rawatDarurat.views.tips.tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>

</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>