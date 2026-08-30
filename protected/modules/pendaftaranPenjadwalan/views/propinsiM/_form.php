<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pppropinsi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'propinsi_nama'),
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'propinsi_nama', array('placeholder' => 'Provinsi', 'class' => 'span3 form-control hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'propinsi_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3 form-control hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <!--Extension location-picker latitude & longitude-->
        <?php
        //  if (isset($model->latitude)){
        // $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getstate('propinsi_id'));
        // $model->latitude = $modPropinsi->latitude;
        // $model->latitude = $modPropinsi->longitude;
        //  }

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
        <?php //echo $form->checkBoxRow($model,'propinsi_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'kodepropinsi_kemenkes', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kodepropinsi_kemenkes', array(), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'latitude', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'latitude', array('placeholder' => 'Latitude', 'readonly' => false, 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'longitude', array('placeholder' => 'Longitude', 'readonly' => false, 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-plus icon-white"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/propinsiM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Provinsi', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/pendaftaranPenjadwalan/PropinsiM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success')
    ); ?>
    <?php
    $content = $this->renderPartial('rawatDarurat.views.tips.tipsaddedit5', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('PPPropinsiM_propinsi_namalainnya').value = nama.value.toUpperCase();
    }

    function registerJSlocation(id, modelName, i) {
        $('#' + id).on('click', function() {
            $('#' + id).coordinate_picker({
                'lat_selector': '#' + modelName + '_' + i + '_latitude',
                'long_selector': '#' + modelName + '_' + i + '_longitude',
                'default_lat': '-7.091932',
                'default_long': '107.672491',
                'edit_zoom': 12,
                'pick_zoom': 7
            })
        });

    }

    function changeSize() {
        window.parent.document.getElementById('frame').style = 'overflow-y:scroll;height:600px;';
    }

    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownPropinsi'); ?>',
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, 'kodepropinsi_kemenkes') ?>").empty();
                $("#<?php echo CHtml::activeId($model, 'kodepropinsi_kemenkes') ?>").html(data.form);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });
</script>