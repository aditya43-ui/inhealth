<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapropinsi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SAPropinsiM_propinsi_nama',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'propinsi_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
        <?php echo $form->textFieldRow($model, 'propinsi_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
        <div>
            <?php echo $form->checkBoxRow($model, 'propinsi_aktif', array('onkeypress' => "return nextFocus(this,event,'btn_simpan','SAPropinsiM_propinsi_namalainnya')")); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'longitude', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'longitude', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
                    'class' => 'btn btn-danger',
                    'rel' => 'tootips',
                    'id' => 'yw1',
                    'title' => 'Klik untuk mencari Longitude & Latitude',
                )); ?>
            </div>
            <?php echo $form->textFieldRow($model, 'latitude', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/propinsiM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Provinsi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('PropinsiM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
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
        document.getElementById(nama.id + 'lainnya').value = nama.value.toUpperCase();
    }
</script>