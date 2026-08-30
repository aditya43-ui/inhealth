<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienpulang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return cekValidasi()'),
    'focus' => '#',
)); 

$modSep = SepT::model()->findByPk($modPendaftaran->sep_id);
if (empty($modSep)) {
    $modSep = new SepT;
}

?>
<?php echo $form->errorSummary(array($modelPulang, $modRujukanKeluar)); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>

    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tindak Lanjut</div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <div class="col-sm-6">
            <?php //echo $form->textFieldRow($modelPulang,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <div class="control-group">
                <?php //echo $form->labelEx($modelPulang,'tglpasienpulang', array('class'=>'control-label')) 
                ?>
                <?php echo CHtml::label('Tgl. Pasien Keluar', 'tglpasienpulang', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modelPulang,
                        'attribute' => 'tglpasienpulang',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5', 'style' => 'width:150px;'),
                    )); ?>
                    <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?>
                </div>
            </div>

            <?php echo $form->hiddenfield($modelPulang, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            <?php echo $form->hiddenfield($modelPulang, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modelPulang, 'carakeluar_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modelPulang,
                        'carakeluar_id',
                        CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'),
                        array(
                            'class' => 'span3 carakeluar_id', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekCaraKeluar(this);',
                            //'ajax'=>array('type'=>'POST',
                            //			'url'=>$this->createUrl('SetDropDownKondisiKeluar',array('encode'=>false,'model_nama'=>get_class($modelPulang))),
                            //			'update'=>"#".CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                            //),
                        )
                    ); ?>
                    <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Kondisi Pulang <span class="required">*</span>"', 'kondisikeluar_id', array('class' => 'control-label')) ?>
                <?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label')) 
                ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modelPulang,
                        'kondisikeluar_id',
                        CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'),
                        array('class' => 'span3 kondisikeluar_id', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'cekKondisiKeluar(this);')
                    ); ?>
                    <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                </div>
            </div>
            <?php //echo $form->textFieldRow($modelPulang,'ruanganakhir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo $form->textFieldRow($modelPulang, 'penerimapasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

            <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) { ?>
                <?php echo $form->textFieldRow($modMasukKamar, 'tglmasukkamar', array('readonly' => true)) ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modMasukKamar, 'lamadirawat_kamar', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modMasukKamar, 'lamadirawat_kamar', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                        <?php echo $form->hiddenField($modelPulang, 'lamarawat', array('class' => 'span1', 'value' => $modMasukKamar->lamadirawat_kamar, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                    </div>
                </div>
            <?php } else { ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modelPulang, 'lamarawat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPulang, 'lamarawat', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Jam
                    </div>
                </div>
                <?php echo $form->error($modelPulang, 'lamarawat'); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                    </div>
                </div>

            <?php } ?>
            <div class="input_kabur" style="display: none";>
                <?php
                if (Yii::app()->user->getState('isbridging') == true && $modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                    echo $form->textFieldRow($modSep, 'kll_nolaporan_polisi', array(
                        'class'=>'span3'
                    ));
                }
                ?>
            </div>
            <?php //echo $form->textFieldRow($modelPulang,'satuanlamarawat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
            ?>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success" id="panel_dpjp" hidden>
                <div class="panel-heading">
                    <div class="panel-title">
                        Dokter Penerima dan DPJP
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $this->renderPartial('_dpjp', array('form' => $form, 'modelPulang' => $modelPulang), true); ?>
                </div>
            </div>

            <div class="panel panel-success box-meninggal" hidden>
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress' => "return $(this).focusNextInputField(event)", "readonly" => true)) ?>
                        Pasien Meninggal
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPulang, 'tgl_meninggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modelPulang,
                                'attribute' => 'tgl_meninggal',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5 tgl_meninggal', 'readonly' => true, 'disabled' => true),
                            )); ?>

                        </div>
                    </div>
                    <?php
                    if (Yii::app()->user->getState('isbridging') == true && $modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                        echo $form->textFieldRow($modSep, 'nosurat_ketmeninggal', array(
                            'class'=>'span3'
                        ));
                    }
                    ?>
                </div>
            </div>

            <div class="panel panel-success boxkirimdokumen" hidden>
                <div class="panel-heading">
                    <div class="panel-title">
                        Form Kirim Dokumen Rekam Medik
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $this->renderPartial('_formStatusDokPP', array('form' => $form, 'modUbahStatus' => $modUbahStatus), true); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->renderPartial('_formRujukanKeluar', array('form' => $form, 'modelPulang' => $modelPulang, 'modRujukanKeluar' => $modRujukanKeluar)); ?>


<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $modelPulang->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
</div>

<script>
    function cekCaraKeluar(obj) {

        $.post('<?php echo $this->createUrl('SetDropDownKondisiKeluar'); ?>&model_nama=RDPasienPulangT', $("#pasienpulang-t-form").serialize(), function(data) {
            // if (data.sudah_bayar == 1) {
            //     $(obj).val("");
            //     myAlert("Pasien sudah melakukan pelunasan tagihan. Harap daftarkan ulang ke Rawat Inap jika Ingin ditindak lanjut.");
            // } else {
                $(".kondisikeluar_id").html(data.options);

                if (obj.value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>") {
                    $('#pakeRujukan').attr('checked', true);
                    $('#divRujukan input').removeAttr('disabled');
                    $('#divRujukan select').removeAttr('disabled');
                    $('#divRujukan textarea').removeAttr('disabled');
                    $('#divRujukan').show(500);
                } else {
                    $('#pakeRujukan').removeAttr('checked');
                    $('#divRujukan input').attr('disabled', 'true');
                    $('#divRujukan select').attr('disabled', 'true');
                    $('#divRujukan textarea').attr('disabled', 'true');
                    $('#divRujukan').hide(500);
                }

                if (obj.value == "<?php echo Params::CARAKELUAR_ID_RAWATINAP ?>") {
                    $('#panel_dpjp .main_form input').removeAttr('disabled');
                    $('#panel_dpjp .main_form select').removeAttr('disabled');
                    $('#panel_dpjp .main_form textarea').removeAttr('disabled');
                    $('#panel_dpjp').show(500);
                } else {
                    $('#panel_dpjp').removeAttr('checked');
                    $('#panel_dpjp .main_form input').attr('disabled', 'true');
                    $('#panel_dpjp .main_form select').attr('disabled', 'true');
                    $('#panel_dpjp .main_form textarea').attr('disabled', 'true');
                    $('#panel_dpjp').hide(500);
                }



                if (obj.value == "<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>") {
                    $("#isDead").prop("checked", true);
                    $(".box-meninggal").show();
                    $(".tgl_meninggal").prop("disabled", false).val("");
                } else {
                    $("#isDead").prop("checked", false);
                    $(".box-meninggal").hide();
                    $(".tgl_meninggal").prop("disabled", true).val("");
                }

                if(obj.value == "<?php echo Params::CARAKELUAR_ID_MELARIKANDIRI ?>"){
                    $(".input_kabur").show();
                } else {
                    $(".input_kabur").hide();
                }

                if (data.statusdokrm == 'belum-dikembalikan') {
                    $("#formKirimDok").val('ada');
                    $(".boxkirimdokumen").show();
                    $(".boxkirimdokumen").find("input, textarea, select").each(function() {
                        $(this).attr("disabled", false);
                    });
                } else {
                    $("#formKirimDok").val('');
                    $(".boxkirimdokumen").hide();
                    $(".boxkirimdokumen").find("input, textarea, select").each(function() {
                        $(this).attr("disabled", true);
                    });
                }

            // }
        }, 'json');


    }

    function cekKondisiKeluar(obj) {
        if (obj.value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_1 ?>" || obj.value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_2 ?>") {
            $('#isDead').attr('checked', true);
            $('#RDPasienPulangT_tgl_meninggal').removeAttr('disabled');
        } else {
            $('#isDead').removeAttr('checked');
            $('#RDPasienPulangT_tgl_meninggal').attr('disabled', true);
        }
    }

    function konfirmasi() {
        myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?') ?>", "Perhatian!", function(r) {
            if (r) {
                window.location.href = window.location;
            } else {
                $('#RDPasienPulangT_carakeluar_id').focus();
                return false;
            }
        });
    }
    /*
    function cekValidasiRujukRawatInap(obj) {
        
        
        
    }
    */

    function cekValidasi() {
        var keluar = $("#RDPasienPulangT_carakeluar_id").val();
        var kondisi = $("#RDPasienPulangT_kondisikeluar_id").val();
        var isd = $("#isDead").is(":checked");
        var tgld = $(".tgl_meninggal").val();
        var adadok = $("#formKirimDok").val();
        var insdok = $("#PengirimanrmT_instalasi_id").val();
        var rudok = $("#PengirimanrmT_ruangan_id").val();


        if (keluar.trim() === "") {
            myAlert("Cara Keluar harus diisi.");
            return false;
        }
        if (kondisi.trim() === "") {
            myAlert("Kondisi Pulang harus diisi.");
            return false;
        }
        if (isd && tgld.trim() === "") {
            myAlert("Tanggal Meninggal harus diisi.");
            return false;
        }
        if ($(".carakeluar_id").val() == "<?php echo Params::CARAKELUAR_ID_RAWATINAP ?>") {
            if ($("#dokterpenerima_id").val().trim() == "") {
                myAlert("Dokter Penerima harus diisi.");
                return false;
            }
            if ($("#dpjp1_id").val().trim() == "") {
                myAlert("Dokter DPJP1 harus diisi.");
                return false;

            }
        }

        if (adadok == 'ada') {
            if (insdok === "") {
                myAlert("Instalasi Tujuan Dokumen Rekam Medis harus diisi ");
                return false;
            }

            if (rudok === "") {
                myAlert("Ruangan Tujuan Dokumen Rekam Medis harus diisi ");
                return false;
            }
        }

        // myAlert("Kick"); return false;

        return true;
    }

    $(document).ready(function() {
        cekCaraKeluar(".carakeluar_id");
        // Notifikasi Pasien
        <?php
        if (isset($smspasien)) {
            if ($smspasien == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>
    });
</script>
<?php if ($tersimpan == true) { ?>
    <script>
        parent.location.reload();
    </script>
<?php } ?>

<?php if ($gagalSimpanAlert == true) { ?>
    <script>
        myAlert("Tagihan pasien belum diselesaikan di Kasir");
    </script>
<?php } ?>

<?php $this->endWidget(); ?>