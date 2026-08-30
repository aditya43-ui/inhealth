<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', 'Data Presensi ' . $model->pegawai->nama_pegawai . ' berhasil disimpan.');
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kppresensi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#namapegawai',
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_pegawai', array('model' => $modPegawai, 'form' => $form, 'modPresensi' => $model)); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Presensi</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group input_tanggal" id="tgl_hadir">
                <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    // $model->tglpresensi = (!empty($model->tglpresensi) ? date("d/m/Y",strtotime($model->tglpresensi)) : null);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglpresensi',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'showOn' => false,
                            //                                                'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'class' => 'dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                        ),
                    )); ?>
                    <?php echo $form->error($model, 'tglpresensi'); ?>
                </div>
            </div>
            <div class="control-group input_tanggal" id="tgl_nonhadir">
                <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tglpresensi)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tglpresensi_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d F Y', strtotime($model->tglpresensi)) ?> - <?php echo date('d F Y', strtotime($model->tglpresensi_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tglpresensi', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tglpresensi_akhir', array('class' => 'end')) ?>
                    </div>

                </div>
            </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'statuskehadiran_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'statuskehadiran_id', CHtml::listData(StatuskehadiranM::model()->findAll('statuskehadiran_aktif = true order by statuskehadiran_nama asc'), 'statuskehadiran_id', 'statuskehadiran_nama'), array('style' => 'width:100px', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "empty" => '-- Pilih --', 'onchange' => 'cekStatusKehadiran(this);'));
                        ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model, 'keterangan', array('placeholder' => 'Keterangan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <?php echo CHtml::label("Upload File", 'bukti_file', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->fileField($model, 'bukti_file', array('maxlength' => 100, 'hint' => 'Unggah file untuk bukti', 'class' => 'required')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6" id="statusscan_data" style="display: none;">
                <div class="control-group">
                    <?php echo CHtml::label("Status Scan", 'statusscan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'statusscan_id', CHtml::listData(StatusscanM::model()->findAll('statusscan_aktif = true ORDER BY statusscan_nama ASC'), 'statusscan_id', 'statusscan_nama'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:100px', "empty" => '-- Pilih --', 'onchange' => 'cekJam();')); ?>
                    </div>
                </div>
                
                <div class="control-group clspresensi_shift">
                    <?php echo CHtml::label("Shift", 'shift_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'shift_id', array(), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:100px', "empty" => '-- Pilih --', 'onchange' => 'generatePerhitungan();')); ?>
                    </div>
                </div>
                <div class="control-group clspresensi_jamscankeluartomasuk" style="display: none;">
                    <?php echo CHtml::label('Jam Scan Keluar', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('jamscankeluartomasuk','', array('readonly' => true, 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>
                    </div>
                </div>
                 
                <div class="control-group clspresensi_jamkerjamasuk">
                    <?php echo CHtml::activeLabel($model, 'jamkerjamasuk', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'jamkerjamasuk', array('readonly' => true, 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>
                    </div>
                </div>
                <div class="control-group clspresensi_jamscanmasuk">
                    <?php echo $form->labelEx($model, 'jamscanmasuk', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jamscanmasuk',
                            'mode' => 'time',
                            'options' => array(
                                'onSelect' => 'js:function(){generatePerhitungan();}',
                                //                                            'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'placeholder' => '00:00:00', 'class' => 'dtPicker2 timemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:120px;'
                            ),
                        )); ?>
                        <?php echo $form->error($model, 'jamscanmasuk'); ?>
                    </div>
                </div>
                <div class="control-group clspresensi_terlambat">
                    <?php echo CHtml::label('Waktu Keterlambatan', 'terlambat_mnt', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'terlambat_mnt',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'text-align:right;')); ?>
                        <?php echo CHtml::textField('terlambat_jam', 0, array('style'=>'text-align: right', 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly'=>true)); ?>
                        <label> Jam</label>
                    </div>
                    <div class="controls">
                        <?php echo CHtml::textField('terlambat_menit', 0, array('style'=>'text-align: right', 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly'=>true)); ?>
                        <label> Menit</label>
                    </div>
                    <div class="controls">
                        <?php echo CHtml::textField('terlambat_detik', 0, array('style'=>'text-align: right', 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly'=>true)); ?>
                        <label> Detik</label>
                    </div>
                </div>
                
                <div class="control-group clspresensi_jamkerjapulang">
                    <?php echo CHtml::activeLabel($model, 'jamkerjapulang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'jamkerjapulang', array('readonly' => true, 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>
                    </div>
                </div>
                <div class="control-group clspresensi_jamscanpulang">
                    <?php echo $form->labelEx($model, 'jamscanpulang', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jamscanpulang',
                            'mode' => 'time',
                            'options' => array(
                                'onSelect' => 'js:function(){generatePerhitungan();}',
                                //                                            'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'placeholder' => '00:00:00', 'class' => 'dtPicker2 timemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:120px;'
                            ),
                        )); ?>
                        <?php echo $form->error($model, 'jamscanpulang'); ?>
                    </div>
                </div>  
                <div class="control-group clspresensi_pulangawal">
                    <?php echo CHtml::label('Pulang Awal', 'pulangawal_mnt', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'pulangawal_mnt',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'text-align:right;')); ?>
                        <?php echo CHtml::textField('pulangawal_jam', 0, array('style'=>'text-align: right', 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly'=>true)); ?>
                        <label> Jam</label>
                    </div>
                    <div class="controls">
                        <?php echo CHtml::textField('pulangawal_menit', 0, array('style'=>'text-align: right', 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly'=>true)); ?>
                        <label> Menit</label>
                    </div>
                    <div class="controls">
                        <?php echo CHtml::textField('pulangawal_detik', 0, array('style'=>'text-align: right', 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly'=>true)); ?>
                        <label> Detik</label>
                    </div>
                </div>  
            </div>
        </div>
        
    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disableSave = false;
    $disableSave = (!empty($_GET['presensi_id'])) ? true : (($sukses > 0) ? true : false);
    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'return cekDokter();', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)
    );
    ?>
    <?php if (!isset($_GET['frame'])) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/create'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])) . '";}); return false;'
            )
        );
        //  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    } ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    ?>
    <?php
    $content = $this->renderPartial('tips/transaksi_presensi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<script>
    $(document).ready(function() {
        cekInputHadir();
        <?php if (!empty($_GET['abnormalabsen_id']) && !empty($model->pegawai_id)) { ?>
            getDataPegawai(<?php echo $model->pegawai_id; ?>);
        <?php } ?>
    });

    function cekInputHadir() {
        $(".input_tanggal").hide()
            .find(":input").prop("disabled", true);
        if ($("#KPPresensiT_statuskehadiran_id").val() != "") {
            if ($("#KPPresensiT_statuskehadiran_id").val() == 1) {
                $("#tgl_hadir").show().find(":input").prop("disabled", false);
            } else {
                $("#tgl_nonhadir").show().find(":input").prop("disabled", false);
            }
        }else{
            $("#tgl_hadir").show().find(":input").prop("disabled", false);
        }
    }

    function cekStatusKehadiran(obj) {
        var pegawai_id = $("#pegawai_id").val();
        var tglpresensi = $("#KPPresensiT_tglpresensi").val();
        if (pegawai_id != '') {
            cekInputHadir();
            if ( //$(obj).val() == <?php // echo Params::STATUSKEHADIRAN_ALPHA 
                                    ?> || 
                $(obj).val() == <?php echo Params::STATUSKEHADIRAN_HADIR ?>) {
                $(".control-group").removeClass('error').addClass('notrequired');
                $("label[for=bukti_file]").removeClass('error').addClass('notrequired');
                $("#KPPresensiT_bukti_file").removeClass('error required').addClass('inputnotrequired');
                $("label[for=shift_id]").find($("span[class=required]")).remove();
                $("label[for=shift_id]").append("<span class=required> *</span>");
                $("label[for=shift_id]").addClass("required");
                $("label[for=statusscan_id]").find($("span[class=required]")).remove();
                $("label[for=statusscan_id]").append("<span class=required> *</span>");
                $("label[for=statusscan_id]").addClass("required");
                $("label[for=KPPresensiT_keterangan]").find($("span[class=required]")).remove();
                $(".control-group").removeClass('error').addClass('notrequired');
                $("label[for=KPPresensiT_keterangan]").removeClass('error required').addClass('notrequired');
                $("#KPPresensiT_keterangan").removeClass('error').addClass('inputnotrequired');
                $("label[for=bukti_file]").find($("span[class=required]")).remove();
                $(".control-group").removeClass('error').addClass('notrequired');
                $("label[for=bukti_file]").removeClass('error required').addClass('notrequired');
                $("#KPPresensiT_bukti_file").removeClass('error').addClass('inputnotrequired');
                $("#KPPresensiT_statusscan_id").val("").change();
                $("#statusscan_data").attr("style", 'display:block;');
                <?php if (!empty($_GET['abnormalabsen_id']) && !empty($model->pegawai_id)) { ?>
                    $('#<?php echo CHtml::activeId($model, 'jamscanmasuk'); ?>').val("<?php echo $model->jamscanmasuk; ?>").change();
                    $('#<?php echo CHtml::activeId($model, 'jamscanpulang'); ?>').val("<?php echo $model->jamscanpulang; ?>").change();
                <?php } ?>
            } else {
                $("label[for=KPPresensiT_keterangan]").find($("span[class=required]")).remove();
                $("label[for=KPPresensiT_keterangan]").append("<span class=required> *</span>");
                $("label[for=KPPresensiT_keterangan]").addClass("required");
                $("label[for=shift_id]").find($("span[class=required]")).remove();
                $(".control-group").removeClass('error').addClass('notrequired');
                $("label[for=shift_id]").removeClass('error required').addClass('notrequired');
                $("#KPPresensiT_shift_id").removeClass('error').addClass('inputnotrequired');
                $("label[for=statusscan_id]").find($("span[class=required]")).remove();
                $(".control-group").removeClass('error').addClass('notrequired');
                $("label[for=statusscan_id]").removeClass('error required').addClass('notrequired');
                $("#KPPresensiT_statusscan_id").removeClass('error').addClass('inputnotrequired');
                $("#KPPresensiT_statusscan_id").val("").change();
                $("#statusscan_data").attr("style", 'display:none;');
                if ($(obj).val() != <?php echo Params::STATUSKEHADIRAN_DINAS ?>) {
                    $("label[for=bukti_file]").find($("span[class=required]")).remove();
                    $("label[for=bukti_file]").removeClass('error').addClass('notrequired');
                    $("#KPPresensiT_bukti_file").removeClass('error required').addClass('inputnotrequired');
                } else {
                    $(".control-group").removeClass('error').addClass('notrequired');
                    $("label[for=bukti_file]").removeClass('error').addClass('notrequired');
                    $("#KPPresensiT_bukti_file").removeClass('error required').addClass('inputnotrequired');
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->createUrl('cekDataDinas'); ?>',
                        data: {
                            pegawai_id: pegawai_id,
                            tglpresensi: tglpresensi
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.sukses == 1) {
                                if (data.pesan != '') {
                                    //								myAlert(data.pesan);
                                    myConfirm(data.pesan, "Peringatan", function(r) {
                                        if (r) {
                                            $("#KPPresensiT_statuskehadiran_id").val("4");
                                        } else {
                                            $("#KPPresensiT_statuskehadiran_id").val("");
                                            return false;
                                        }
                                    });
                                    $("label[for=KPPresensiT_keterangan]").find($("span[class=required]")).remove();
                                    $(".control-group").removeClass('error').addClass('notrequired');
                                    $("label[for=KPPresensiT_keterangan]").removeClass('error required').addClass('notrequired');
                                    $("#KPPresensiT_keterangan").removeClass('error').addClass('inputnotrequired');
                                }
                            } else {
                                alert(data.pesan);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            }
        } else {
            myAlert("Data pegawai belum dipilih");
            $(obj).val('');
        }
        $("#KPPresensiT_jamscanmasuk").val("");
        $("#KPPresensiT_jamscanpulang").val("");
        $("#KPPresensiT_jamkerjamasuk").val("");
        $("#KPPresensiT_jamkerjapulang").val("");
        $("#KPPresensiT_terlambat_mnt").val("");
        $("#KPPresensiT_pulang_awal").val("");
    }

    function cekJam() {
        var scan = $("#KPPresensiT_statusscan_id").val();
        var datang = <?php echo Params::STATUSSCAN_DATANG; ?>;
        var masuk = <?php echo Params::STATUSSCAN_MASUK; ?>;
        var pulang = <?php echo Params::STATUSSCAN_PULANG; ?>;
        var keluar = <?php echo Params::STATUSSCAN_KELUAR; ?>;

        if (scan == datang || scan == masuk) { //disabled         

            $("label[for=KPPresensiT_jamscanmasuk]").find($("span[class=required]")).remove();
            $("label[for=KPPresensiT_jamscanmasuk]").addClass("required");
            $("label[for=KPPresensiT_jamscanmasuk]").append("<span class=required> *</span>");
            if(scan == datang){
                $("label[for=shift_id]").find($("span[class=required]")).remove();
                $("label[for=shift_id]").append("<span class=required> *</span>");
                $("label[for=shift_id]").addClass("required");

                $("label[for=KPPresensiT_jamkerjamasuk]").find($("span[class=required]")).remove();
                $("label[for=KPPresensiT_jamkerjamasuk]").append("<span class=required> *</span>");
                $("label[for=KPPresensiT_jamkerjamasuk]").addClass("required");


                $('.clspresensi_shift').show();
                $('.clspresensi_jamkerjamasuk').show();
                $('.clspresensi_jamscanmasuk').show();
                $('.clspresensi_terlambat').show();
                $('.clspresensi_jamscankeluartomasuk').hide();
            }else{
                $("label[for=KPPresensiT_jamkerjamasuk]").find($("span[class=required]")).remove();
                $("label[for=KPPresensiT_jamkerjamasuk]").removeClass('error required').addClass('notrequired');

                $("label[for=shift_id]").find($("span[class=required]")).remove();
                $("label[for=shift_id]").removeClass('error required').addClass('notrequired');
                $("#KPPresensiT_shift_id").removeClass('error').addClass('inputnotrequired');

                loadJamScanPresensi();
                $('.clspresensi_jamscankeluartomasuk').show();


                $('.clspresensi_jamscanmasuk').show();
                $('.clspresensi_shift').hide();
                $('.clspresensi_jamkerjamasuk').hide();
                $('.clspresensi_terlambat').hide();
            }
            $('.clspresensi_jamkerjapulang').hide();
            $('.clspresensi_pulangawal').hide();
            $('.clspresensi_jamscanpulang').hide();
            
            
            $("label[for=KPPresensiT_jamscanpulang]").find($("span[class=required]")).remove();
            $("label[for=KPPresensiT_jamscanpulang]").removeClass('error required').addClass('notrequired');
            $("#KPPresensiT_jamscanpulang").val('');
            $(".control-group").removeClass('error').addClass('notrequired');
            $("label[for=jamscanpulang]").removeClass('error required').addClass('notrequired');
            $("#KPPresensiT_jamscanpulang").removeClass('error').addClass('inputnotrequired');

            
        } else if (scan == keluar || scan == pulang) {
            $("label[for=KPPresensiT_jamscanpulang]").find($("span[class=required]")).remove();
            $("label[for=KPPresensiT_jamscanpulang]").addClass("required");

            if(scan == pulang){
                $("label[for=KPPresensiT_jamscanpulang]").html("Jam Scan Pulang <span class=required> *</span>");

                $("label[for=shift_id]").find($("span[class=required]")).remove();
                $("label[for=shift_id]").append("<span class=required> *</span>");
                $("label[for=shift_id]").addClass("required");
                
                $('.clspresensi_shift').show();
                $('.clspresensi_jamkerjapulang').show();
                $('.clspresensi_pulangawal').show();
                $('.clspresensi_jamscanpulang').show();
            }else{
                $("label[for=KPPresensiT_jamscanpulang]").html("Jam Scan Keluar <span class=required> *</span>");
                $("label[for=shift_id]").find($("span[class=required]")).remove();
                $("label[for=shift_id]").removeClass('error required').addClass('notrequired');
                $("#KPPresensiT_shift_id").removeClass('error').addClass('inputnotrequired');
                    
                // loadJamScanPresensi();
                // $('.clspresensi_jamscanmasuk').show();

                $('.clspresensi_shift').hide();
                $('.clspresensi_jamkerjapulang').hide();
                $('.clspresensi_pulangawal').hide();
                $('.clspresensi_jamscanpulang').show();
            }
           
            $('.clspresensi_jamkerjamasuk').hide();
            $('.clspresensi_terlambat').hide();
            $('.clspresensi_jamscanmasuk').hide();
            $('.clspresensi_jamscankeluartomasuk').hide();
            
            $("label[for=KPPresensiT_jamscanmasuk]").find($("span[class=required]")).remove();
            $("label[for=KPPresensiT_jamscanmasuk]").removeClass('error required').addClass('notrequired');
            $("#KPPresensiT_jamscanmasuk").val('');
            $(".control-group").removeClass('error').addClass('notrequired');
            $("label[for=KPPresensiT_jamscanmasuk]").removeClass('error required').addClass('notrequired');
            $("#KPPresensiT_jamscanmasuk").removeClass('error').addClass('inputnotrequired');
            
            
        } else {
            $("label[for=KPPresensiT_jamscanmasuk]").find($("span[class=required]")).remove();
            $("label[for=KPPresensiT_jamscanmasuk]").removeClass('error required').addClass('notrequired');
            $("label[for=KPPresensiT_jamscanpulang]").find($("span[class=required]")).remove();
            $("label[for=KPPresensiT_jamscanpulang]").removeClass('error required').addClass('notrequired');
            $(".control-group").removeClass('error').addClass('notrequired');
            $("label[for=KPPresensiT_jamscanmasuk]").removeClass('error required').addClass('notrequired');
            $("#KPPresensiT_jamscanmasuk").removeClass('error').addClass('inputnotrequired');
            $(".control-group").removeClass('error').addClass('notrequired');
            $("label[for=KPPresensiT_jamscanpulang]").removeClass('error required').addClass('notrequired');
            $("#KPPresensiT_jamscanpulang").removeClass('error').addClass('inputnotrequired');

            $('.clspresensi_shift').hide();
            $('.clspresensi_jamkerjapulang').hide();
            $('.clspresensi_pulangawal').hide();
            $('.clspresensi_jamscanpulang').hide();
            $('.clspresensi_jamscanmasuk').hide();
            $('.clspresensi_jamkerjamasuk').hide();
            $('.clspresensi_terlambat').hide();
            $('.clspresensi_jamscankeluartomasuk').hide();
        }
        cekStatusScan($("#KPPresensiT_statusscan_id"));
    }

    function konfirmasi() {
        location.reload();
    }
    /**
     * untuk print penjualan dokter
     */
    function print(caraPrint) {
        var presensi_id = '<?php echo isset($model->presensi_id) ? $model->presensi_id : null ?>';
        window.open('<?php echo $this->createUrl('printPresensi'); ?>&presensi_id=' + presensi_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function cekStatusScan(obj) {
        if ($(obj).val() != '') {
            generatePerhitungan();
        }
    }

    function loadJamScanPresensi(){
        var pegawai_id = $("#pegawai_id").val();
        var tglpresensi = $("#KPPresensiT_tglpresensi").val();
        var statuskehadiran = $("#<?php echo CHtml::activeId($model, 'statuskehadiran_id') ?>").val();

        if(pegawai_id != '' && tglpresensi != '' && statuskehadiran != '' && statuskehadiran == <?php echo Params::STATUSKEHADIRAN_HADIR ?>){
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('loadJamScanPresensi'); ?>',
                data: {
                    pegawai_id: pegawai_id,
                    tglpresensi: tglpresensi
                },
                dataType: "json",
                success: function(data) {
                    $("#jamscankeluartomasuk").val(data.jamscan);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function generatePerhitungan() {
        var shift = $("#<?php echo CHtml::activeId($model, 'shift_id') ?>").val();
        var jammasuk = $("#<?php echo CHtml::activeId($model, 'jamscanmasuk') ?>").val();
        var jampulang = $("#<?php echo CHtml::activeId($model, 'jamscanpulang') ?>").val();
        var statusscan_id = $("#<?php echo CHtml::activeId($model, 'statusscan_id') ?>").val();

        var cekstatus = false;

        if(statusscan_id == <?php echo Params::STATUSSCAN_DATANG ?> || statusscan_id == <?php echo Params::STATUSSCAN_PULANG ?>){
            if(shift == ''){
                cekstatus = true;
            }
        }else if(statusscan_id == <?php echo Params::STATUSSCAN_MASUK ?> || statusscan_id == <?php echo Params::STATUSSCAN_KELUAR ?>){
            cekstatus = true;
        }
        
        if(cekstatus == true){
            return false;
        }

        if (statusscan_id != '') {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('generateHitungPresensi'); ?>',
                data: {
                    shift: shift,
                    jammasuk: jammasuk,
                    jampulang: jampulang
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        if (statusscan_id == <?php echo Params::STATUSSCAN_MASUK ?> || statusscan_id == <?php echo Params::STATUSSCAN_DATANG ?>) {
                            $("#<?php echo CHtml::activeId($model, 'jamkerjamasuk') ?>").val(data.jamkerjamasuk);
                            if (jammasuk != '') {
                                $("#<?php echo CHtml::activeId($model, 'terlambat_mnt') ?>").val(data.terlambat);
                                $("#terlambat_jam").val(data.selisi_jam);
                                $("#terlambat_menit").val(data.selisi_menit);
                                $("#terlambat_detik").val(data.selisi_detik);
                            } else {
                                $("#<?php echo CHtml::activeId($model, 'terlambat_mnt') ?>").val('');
                                $("#terlambat_jam").val('');
                                $("#terlambat_menit").val('');
                                $("#terlambat_detik").val('');
                            }
                            $("#<?php echo CHtml::activeId($model, 'pulangawal_mnt') ?>").val('');
                            $("#<?php echo CHtml::activeId($model, 'jamkerjapulang') ?>").val('');
                        } else if (statusscan_id == <?php echo Params::STATUSSCAN_KELUAR ?> || statusscan_id == <?php echo Params::STATUSSCAN_PULANG ?>) {
                            $("#<?php echo CHtml::activeId($model, 'jamkerjamasuk') ?>").val('');
                            $("#<?php echo CHtml::activeId($model, 'terlambat_mnt') ?>").val('');
                            if (jampulang != '') {
                                $("#<?php echo CHtml::activeId($model, 'pulangawal_mnt') ?>").val(data.pulangawal);
                                $("#pulangawal_jam").val(data.selisi_jamPlg);
                                $("#pulangawal_menit").val(data.selisi_menitPlg);
                                $("#pulangawal_detik").val(data.selisi_detikPlg);
                            } else {
                                $("#<?php echo CHtml::activeId($model, 'pulangawal_mnt') ?>").val('');
                                $("#pulangawal_jam").val('');
                                $("#pulangawal_menit").val('');
                                $("#pulangawal_detik").val('');
                            }
                            $("#<?php echo CHtml::activeId($model, 'jamkerjapulang') ?>").val(data.jamkerjapulang);
                        }
                    } else {
                        alert(data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Status scan belum dipilih");
            $("#<?php echo CHtml::activeId($model, 'shift_id') ?>").val('');
            $("#<?php echo CHtml::activeId($model, 'jamscanmasuk') ?>").val('');
            $("#<?php echo CHtml::activeId($model, 'jamscanpulang') ?>").val('');
            $("#<?php echo CHtml::activeId($model, 'jamkerjamasuk') ?>").val('');
            $("#<?php echo CHtml::activeId($model, 'jamkerjapulang') ?>").val('');
            $("#<?php echo CHtml::activeId($model, 'terlambat_mnt') ?>").val('');
            $("#<?php echo CHtml::activeId($model, 'pulangawal_mnt') ?>").val('');
            $("#terlambat_jam").val('');
            $("#terlambat_menit").val('');
            $("#terlambat_detik").val('');
            $("#pulangawal_jam").val('');
            $("#pulangawal_menit").val('');
            $("#pulangawal_detik").val('');
        }
    }
</script>