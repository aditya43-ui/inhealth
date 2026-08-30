<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'verifikasipermintaandarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">No Permintaan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('no_permintaan', $model->no_permintaandarah, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tgl. Permintaan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('tglpermintaan', MyFormatter::formatDateTimeForUser($model->tglpermintaan), array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Pendaftaran</label>
                    <div class="controls">
                        <?php echo CHtml::textField('no_pendaftaran', $modPendaftaran->no_pendaftaran, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Ruangan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('ruangan', $ruangan, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Penjamin</label>
                    <div class="controls">
                        <?php echo CHtml::textField('penjamin', $penjamin, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Diagnosis</label>
                    <div class="controls">
                        <?php echo CHtml::textField('diagnosis', $diagnosis, array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">No Rekam Medis</label>
                    <div class="controls">
                        <?php echo CHtml::textField('no_rekam_medik', $modPasien->no_rekam_medik, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nama Pasien</label>
                    <div class="controls">
                        <?php echo CHtml::textField('nama_pasien', $modPasien->nama_pasien, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Umur</label>
                    <div class="controls">
                        <?php echo CHtml::textField('umur', $modPendaftaran->umur, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Kelamin</label>
                    <div class="controls">
                        <?php echo CHtml::textField('jenis_kelamin', $modPasien->jeniskelamin, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Alamat</label>
                    <div class="controls">
                        <?php echo CHtml::textArea('alamat', $modPasien->alamat_pasien, array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-check"></i> Verifikasi Permintaan Darah
        </div>
    </div>
    <div class='panel-body'>
        <div class='control-group'>
            <?php echo CHtml::label('Petugas Penerima <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo CHtml::activeHiddenField($model, 'permintaandarah_id', array('onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                <?php echo CHtml::activeHiddenField($model, 'pegawai_penerima_id', array('onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawai_penerima_nama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePetugas') . '",
                                           dataType: "json",
                                           data: {
                                               term: request.term,
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val("");
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    $("#' . CHtml::activeId($model, 'pegawai_penerima_id') . '").val(ui.item.pegawai_id);
                                    $("#' . CHtml::activeId($model, 'pegawai_penerima_nama') . '").val(ui.item.nama_pegawai);
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#PermintaandarahT_pegawai_penerima_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPetugas', 'jsFunction' => "setDialog(this);"),
                ));
                ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Waktu Penerimaan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'waktu_terima',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::activeCheckBox($model, 'is_pasiensama', array('uncheckValue' => 0), array('class' => 'required')); ?> <label>Cek jika data pasien sama <span class="required">*</span></label>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'simpanVerifikasi();')); ?>
</div>
<?php $this->endWidget(); ?>
<script>
    function setDialog(obj) {
        var dialog = "#dialogPetugas";
        window.parent.$(dialog).dialog("open");
    }

    function simpanVerifikasi() {
        var permintaandarah_id = $('#PermintaandarahT_permintaandarah_id').val();
        var pegawai_penerima_id = $('#PermintaandarahT_pegawai_penerima_id').val();
        var waktu_terima = $('#PermintaandarahT_waktu_terima').val();
        var cek = $('#PermintaandarahT_is_pasiensama').prop('checked');
        if (requiredCheck($("form"))) {
            if (cek == true) {
                var is_pasiensama = 1;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('ajaxSimpanVerifikasi'); ?>',
                    data: {
                        permintaandarah_id: permintaandarah_id,
                        pegawai_penerima_id: pegawai_penerima_id,
                        waktu_terima: waktu_terima,
                        is_pasiensama: is_pasiensama
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 'berhasil_form') {
                            window.parent.$('#dialogVerifikasi').dialog('close');
                            window.parent.reloadTabelVerifikasi();
                        } else {
                            myAlert('Verifikasi Gagal');
                            return false;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                myAlert('Centang dahulu checkbox cek');
                return false;
            }
        }
    }
</script>