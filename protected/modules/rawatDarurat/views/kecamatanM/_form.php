<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakecamatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#propinsi',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Provinsi', 'propinsi', array('class' => "control-label")) ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('propinsi', 'propinsi_id', CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'), array(
                    'empty' => '-- Pilih --',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => '', 'attr' => 'propinsi')),
                        'update' => '#RDKecamatanM_kabupaten_id',
                    )
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kabupaten_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Kecamatan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table style="width:100%;" class="table table-bordered table-striped datatable">
            <tr>
                <th style="text-align:center;">Kecamatan</th>
                <th style="text-align:center;">Nama Lain</th>
                <th style="text-align:center;">Latitude</th>
                <th style="text-align:center;">Longitude</th>
            </tr>
            <tr>
                <td>
                    <?php echo $form->textField($model, 'kecamatan_nama', array('onkeyup' => "namaLain(this)", 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kecamatan_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model, 'kecamatan_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kecamatan_namalainnya'))); ?>
                </td>
                <td>
                    <?php echo $form->textField($model, 'latitude', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => $model->getAttributeLabel('latitude'))); ?>
                    <?php echo CHtml::htmlButton(
                        '<i class="entypo-map"></i>',
                        array(
                            'class' => 'btn btn-primary btn-location',
                            'rel' => 'tooltip',
                            'id' => 'yw1',
                            'onclick' => 'changeSize()',
                            'title' => 'Klik untuk mencari Longitude & Latitude',
                        )
                    );
                    ?>
                </td>
                <td>
                    <?php echo $form->textField($model, 'longitude', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => $model->getAttributeLabel('longitude'))); ?>

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
                </td>
                <td>
                    <?php echo CHtml::htmlButton('<i class="entypo-plus-circled"></i>', array('class' => 'btn btn-danger', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);', 'id' => 'row1-plus')); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<table id="tbl-kecamatan" class="table table-striped table-bordered table-condensed">
    <?php
    echo CHtml::hiddenField('Nomor', 0, array('id' => 'nomor'));
    ?>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kecamatanM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kecamatan', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$buttonMinus = CHtml::link('<i class="entypo-minus-circled"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kecamatan tr').length;
    var i = 1;
    $('#tbl-kecamatan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('RDKecamatanM_kecamatan_namalainnya').value = nama.value.toUpperCase();
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

    function addRow(obj) //input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']
    {
        var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;')) ?>';
        var no = eval($('#nomor').val()) + 1;
        var kabupaten = $('#RDKecamatanM_kecamatan_nama').val();
        var namalain = $('#RDKecamatanM_kecamatan_namalainnya').val();

        if ((kabupaten != '') || (namalain != '')) {
            var td = '   <td><input name = "RDKecamatanM[' + no + '][kecamatan_nama]"  type = "text" id = "RDKecamatanM_' + no + '_kecamatan_nama" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "' + $('#RDKecamatanM_kecamatan_nama').val() + '"> <span class="required">*<span></td>\n\
                            <td><input name = "RDKecamatanM[' + no + '][kecamatan_namalainnya]" type = "text" id = "RDKecamatanM_' + no + '_kecamatan_namalainnya" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "' + $('#RDKecamatanM_kecamatan_namalainnya').val() + '"> <span class="required">*<span></td>\n\
                            <td><input name = "RDKecamatanM[' + no + '][latitude]" type = "text" id = "RDKecamatanM_' + no + '_latitude" class="span3 " onkeypress = "return $(this).focusNextInputField(event);",  readonly = TRUE value = "' + $('#RDKecamatanM_latitude').val() + '"> </td>\n\
                            <td><input name = "RDKecamatanM[' + no + '][longitude]" type = "text" id = "RDKecamatanM_' + no + '_longitude" class="span3 " onkeypress = "return $(this).focusNextInputField(event);", readonly = TRUE value = "' + $('#RDKecamatanM_longitude').val() + '"> </td>\n\
                            <td>' + buttonMinus + '</td>';
            $('#tbl-kecamatan').append('<tr>' + td + '</tr>');
        } else {
            myAlert('Maaf Kecamatan dan Nama  Lain Tidak Boleh Kosong');
        }

        $('#nomor').val(no);
        clearRow();
    }

    function delRow(obj) {
        var no = $('#nomor').val();
        myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
            if (r) {
                $(obj).parent().parent().remove();
                //renameInput('RDKabupatenM','kabupaten_nama');
                //renameInput('RDKabupatenM','kabupaten_namalainnya');
                $('#nomor').val(eval(no) - 1);
            }
        });
    }



    function clearRow() {
        $('#RDKecamatanM_kecamatan_nama').val('');
        $('#RDKecamatanM_kecamatan_namalainnya').val('');
        $('#RDKecamatanM_latitude').val('');
        $('#RDKecamatanM_longitude').val('');
    }
</script>