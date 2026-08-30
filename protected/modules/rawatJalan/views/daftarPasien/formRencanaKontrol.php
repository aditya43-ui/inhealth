<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienpulang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert'); ?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary(array($model)); ?>
<div class="dataSRK">
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($modPasien, 'no_rekam_medik', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textField($modPasien, 'no_rekam_medik', array('class' => 'span3', 'readonly' => true));
                    echo $form->hiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'span3', 'readonly' => true));
                    ?>
                    <?php echo $form->error($modPasien, 'no_rekam_medik'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textField($modPendaftaran, 'no_pendaftaran', array('class' => 'span3', 'readonly' => true));
                    ?>
                    <?php echo $form->error($modPendaftaran, 'no_pendaftaran'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textField($modPasien, 'nama_pasien', array('class' => 'span3', 'readonly' => true));
                    ?>
                    <?php echo $form->error($modPasien, 'nama_pasien'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPendaftaran, 'carabayar_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textField($modPendaftaran->carabayar, 'carabayar_nama', array('class' => 'span3', 'readonly' => true));
                    ?>
                    <?php // echo $form->error($modPasien, 'nama_pasien'); 
                    ?>
                </div>
            </div>
            <?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) : ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPendaftaran, 'sep_id', array('class' => 'control-label', 'label' => 'No. SEP')) ?>
                    <div class="controls">
                        <?php
                        $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
                        //$sep = SepT::model()->find();
                        if (!empty($sep)) {
                            $modPendaftaran->sep_id = $sep->sep_id;
                        } else {
                            $modPendaftaran->sepTs = new SepT;
                        }
                        if (!empty($noSEP)) {
                            $modPendaftaran->sepTs->nosep = $noSEP;
                        }
                        echo $form->hiddenField($modPendaftaran, 'sep_id');
                        echo $form->textField($modPendaftaran->sepTs, 'nosep', array('class' => 'span3', 'readonly' => true));
                        ?>
                        <?php // echo $form->error($modPasien, 'nama_pasien'); 
                        ?>
                    </div>
                    <div class="controls">

                    </div>
                </div>
            <?php endif; ?>
            <div class="control-group ">
                <?php echo CHtml::label('Diagnosa', 'diagnosa_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($modSurat, 'diagnosa_kontrol', array('class' => 'span3', 'readonly' => true));
                    ?>
                    <?php echo $form->error($modSurat, 'diagnosa_kontrol'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Alasan Kontrol', 'kontrol_alasan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($modSurat, 'kontrol_alasan', array('class' => 'span3'));
                    ?>
                    <?php echo $form->error($modSurat, 'kontrol_alasan'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Rencana tidak lanjut saat Kontrol', 'konrol_rencanatindaklanjut', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($modSurat, 'konrol_rencanatindaklanjut', array('class' => 'span3', 'readonly' => false));
                    ?>
                    <?php echo $form->error($modSurat, 'konrol_rencanatindaklanjut'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No. Handphone Pasien <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'form-control span3 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
                    <?php echo CHtml::checkBox('is_whatsapp', true, array('rel' => 'tooltip', 'title' => 'Klik untuk mengirim pesan Whatsapp')); ?>
                    <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
                </div>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textField($modPasien, 'jeniskelamin', array('class' => 'span3', 'readonly' => true));
                    ?>
                    <?php echo $form->error($modPasien, 'jeniskelamin'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Surat', 'tglsurat', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modSurat,
                        'attribute' => 'tglsurat',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class' => 'dtPicker3 span3'),
                    )); ?>
                    <?php echo $form->error($modSurat, 'tglsurat'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglrenkontrol', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglrenkontrol',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class' => 'dtPicker3 span3', 'onchange' => 'setLoadRencanaKontrol();'),
                    )); ?>
                    <?php echo $form->error($model, 'tglrenkontrol'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Dokter Tujuan Kontrol', 'doktertujuankontrol_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    if ($modPendaftaran->carabayar_id != Params::CARABAYAR_ID_BPJS || Yii::app()->user->getState('isbridging') == false) {

                        echo $form->dropDownList($model, 'doktertujuankontrol_id', CHtml::listData(DokterV::model()->findAllByAttributes(array(
                            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                            'ruangan_id' => Yii::app()->user->getState("ruangan_id"),//$modPendaftaran->ruangan_id,
                        )), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'class' => 'doktertujuankontrol_id'));
                    } else {
                        echo $form->dropDownList($model, 'doktertujuankontrol_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true and kodedokter_bpjs is not null order by nama_pegawai'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'class' => 'doktertujuankontrol_id'));
                    }


                    ?>
                    <?php echo $form->error($model, 'doktertujuankontrol_id'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('No. Surat', 'nomorsurat', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textField($modSurat, 'nomorsurat', array('class' => 'span3'));
                    ?>
                    <?php echo $form->error($modSurat, 'nomorsurat'); ?>
                </div>
            </div>
            <?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) : ?>
                <div class="control-group ">
                    <?php echo CHtml::label('No. Surat Kontrol', 'nomorsurat_bpjs', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modSurat, 'nomorsurat_bpjs', array('class' => 'span3', 'readonly' => true));
                        ?>
                        <?php echo $form->error($modSurat, 'nomorsurat_bpjs'); ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="control-group ">
                <?php echo CHtml::label('Terapi', 'kontrolri_terapipulang', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($modSurat, 'kontrolri_terapipulang', array('class' => 'span3'));
                    ?>
                    <?php echo $form->error($modSurat, 'kontrolri_terapipulang'); ?>
                </div>
            </div>

        </div>
    </div>

    <?= $this->renderPartial($this->path_view . 'form/_formDataSep', [], true)  ?>





    <div class="form-actions tombolSRK" <?= isset($_GET['lihat']) ? 'hidden' : '' ?>>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')),
            array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'verifikasiSubmit(); return false;')
        ); ?>

        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
            array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()')
        ) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp;&nbsp;";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print SRK BPJS', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'printBpjs(\'PRINT\')', 'disabled' => empty($modSurat->nomorsurat_bpjs)));

        $urlPrint = $this->createUrl('PrintRencanaKontrol&pendaftaran_id=' . $modPendaftaran->pendaftaran_id);
        $urlPrintBpjs = $this->createUrl('PrintRencanaKontrolBpjs&pendaftaran_id=' . $modPendaftaran->pendaftaran_id);
        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#sanapza-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printBpjs(caraPrint)
{
    window.open("${urlPrintBpjs}"+$('#sanapza-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php

//========= Dialog buat cari data riwayat SEP =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatSep',
    'options' => array(
        'title' => 'Pencarian Riwayat SEP Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));

$this->renderPartial($this->pathView . 'grid/_formRiwayatSep', []);

$this->endWidget();
?>
<script type="text/javascript">
    $(document).ready(function() {
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
<?php
if ($tersimpan == 'Ya') {
?>
    <script>
        //parent.location.reload();
    </script>
<?php
}
?>
<script>
    function konfirmasi() {
        //        if(confirm('<?php echo Yii::t('mds', 'Do You want to cancel?') ?>'))
        //        {
        //            $('#iframeRencanaKontrol').attr('src',$(this).attr("href"));window.parent.$('#dialogRencanaKontrol').dialog('close');
        //            return false;
        //        }
        //        else
        //        {   
        //            $('#PasienM_no_rekam_medik').focus();
        //            return false;
        //        }
        myConfirm(' <?php echo Yii::t('mds', 'Do You want to cancel?') ?> ', 'Perhatian!', function(r) {
            if (r) {
                $('#iframeRencanaKontrol').attr('src', $(this).attr("href"));
                window.parent.$('#dialogRencanaKontrol').dialog('close');
                return false;
            } else {
                $('#PasienM_no_rekam_medik').focus();
                return false;
            }
        });
    }

    function polimulti() {
        var dokter = jQuery('.doktertujuankontrol_id');

        jQuery(dokter).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    }

    $(document).ready(function() {
        polimulti();
        <?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) :
            if (Yii::app()->user->getState('isbridging') == false) : ?>
                myAlert("Bridging BPJS Tidak Aktif! Rencana Kontrol tidak akan terbridging dengan BPJS");
            <?php else :


            ?>
                <?php if ($tersimpan != 'Ya') { ?>
                    setLoadRencanaKontrol();
                <?php } ?>
                // setLoadDokterKontrol();

            <?php endif; ?>
        <?php endif; ?>
    });

    function setLoadRencanaKontrol() {

        <?php if ($modPendaftaran->carabayar_id != Params::CARABAYAR_ID_BPJS || Yii::app()->user->getState('isbridging') == false) : ?>
            return false;
        <?php endif; ?>


        var ruangan_id = <?php echo $modPendaftaran->ruangan_id; ?>;
        var pegawai_id = <?php echo $modPendaftaran->pegawai_id; ?>;
        var tgl = $("#PendaftaranT_tglrenkontrol").val();
        var sep_id = $("#PendaftaranT_sep_id").val();
        var nosep = $("#SepT_nosep").val();
        $(".doktertujuankontrol_id").html("");
        var dokter = jQuery('.doktertujuankontrol_id');

        $("#PendaftaranT_doktertujuankontrol_id").addClass('animation-loading');
        $.post('<?php echo $this->createUrl('vclaimCekRuangan'); ?>', {
            // sep_id: sep_id, 
            nosep: nosep,
            ruangan_id: ruangan_id,
            pegawai_id: pegawai_id,
            tgl: tgl
        }, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg, "VClaim - " + data.judul);
            }
            if ($(".doktertujuankontrol_id").html() != data.html) {
                $(".doktertujuankontrol_id").html(data.html);
                dokter.multiselect('rebuild');

            }
            $("#PendaftaranT_doktertujuankontrol_id").removeClass('animation-loading');
        }, 'json');
    }

    function verifikasiSubmit() {
        $(".dataSRK").addClass("animation-loading");

        <?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS && Yii::app()->user->getState('isbridging') == false) : ?>
            myAlert("Bridging BPJS Tidak Aktif ! Rencana Kontrol tidak akan terbridging dengan BPJS", "Peringatan", function() {
                $("#pasienpulang-t-form").submit();
            });
        <?php else : ?>
            $("#pasienpulang-t-form").submit();
        <?php endif; ?>
    }

    function setNoKartu() {
        $.post('<?php echo $this->createUrl('getNoKartu'); ?>', {
            nokartu: no_kartu
        }, function(data) {
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_riwayat_sep").html(data.html);
            }
            $(".tab_riwayat_base").removeClass('animation-loading');
        }, 'json');
    }

    function setNomorDanCariRiwayatSEP() {
        var pendaftaran_id = $("#<?php echo CHtml::activeId($model, 'pendaftaran_id') ?>").val();

        $("#dialogRiwayatSep").dialog("open");


        $(".tab_riwayat_sep").empty();
        $(".tab_riwayat_base").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('getLoadRiwayatSEP'); ?>', {
            pendaftaran_id: pendaftaran_id
        }, function(data) {
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_riwayat_sep").html(data.html);
            }
            $(".tab_riwayat_base").removeClass('animation-loading');
        }, 'json');
    }

    function cariDataSep(nomorsep) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var isi = "";
        if (nomorsep != '') {
            isi = nomorsep;
            var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu Peserta
        }
        if (isi == "") {
            myAlert('Isi data Nomor SEP terlebih dahulu!');
            return false;
        };

        var diagnosa = $('#SuratketeranganR_diagnosa_kontrol').val();
        var setting = {
            url: "<?php echo $this->createUrl('/pendaftaranPenjadwalan/sinkronisasiSEP/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#data-sep").addClass("animation-loading");
            },
            success: function(data) {
                $("#data-sep").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var peserta = obj.response.peserta;

                    var propinsi = "";
                    var kabupaten = "";
                    var kecamatan = "";

                    if (obj.response.lokasiKejadian.lokasi != null) {
                        var arr_lokasi = obj.response.lokasiKejadian.lokasi.split("|");
                        if (arr_lokasi[0] != null) {
                            propinsi = arr_lokasi[0];
                        }
                        if (arr_lokasi[1] != null) {
                            kabupaten = arr_lokasi[1];
                        }
                        if (arr_lokasi[2] != null) {
                            kecamatan = arr_lokasi[2];
                        }
                    }

                    $("#SepT_nosep").val(obj.response.noSep);
                    $("#no_sep").val(obj.response.noSep);
                    $("#tgl_sep").val(obj.response.tglSep);
                    $("#jns_pelayanan").val(obj.response.jnsPelayanan);
                    $("#poli_pelayanan").val(obj.response.poli);
                    $("#poli_eksekutif").val(obj.response.poliEksekutif);
                    $("#kls_rawat").val(obj.response.klsRawat.klsRawatHak);
                    $("#kls_rawat_naik").val(obj.response.klsRawat.klsRawatNaik);
                    $("#kls_rawat_pj").val(obj.response.klsRawat.penanggungJawab);
                    $("#status_kecelakaan").val(obj.response.nmstatusKecelakaan);
                    $("#tgl_kejadian").val(obj.response.lokasiKejadian.tglKejadian);
                    $("#keterangan_kecelakaan").val(obj.response.lokasiKejadian.ketKejadian);
                    $("#propinsi").val(propinsi);
                    $("#kabupaten").val(kabupaten);
                    $("#kecamatan").val(kecamatan);
                    $("#diagnosa").val(obj.response.diagnosa);

                    if (diagnosa == '') {
                        $('#SuratketeranganR_diagnosa_kontrol').val(obj.response.diagnosa);
                    }

                    $("#penjamin").val(obj.response.penjamin);
                    $("#asuransi").val(peserta.asuransi);

                    if (obj.response.jnsPelayanan == "Rawat Inap") {
                        $("#kelompok_kontrol").html("SPRI");
                    } else {
                        $("#kelompok_kontrol").html("Surat Kontrol");
                    }

                    $("#dpjp_pelayanan").val(obj.response.dpjp.nmDPJP);
                    $("#dokter_kontrol").val(obj.response.kontrol.nmDokter);
                    $("#surat_kontrol").val(obj.response.kontrol.noSurat);

                    $("#no_kartu").val(peserta.noKartu);
                    $("#no_rm").val(peserta.noMr);
                    $("#nama").val(peserta.nama);
                    $("#tgl_lahir").val(peserta.tglLahir);
                    $("#jns_kelamin").val(peserta.kelamin);
                    $("#hak_akses").val(peserta.hakKelas);
                    $("#jns_peserta").val(peserta.jnsPeserta);

                    $("#cob").val(obj.response.cob == 0 ? "Tidak" : "Ya");
                    $("#katarak").val(obj.response.katarak == 0 ? "Tidak" : "Ya");
                    $("#keterangan_sep").val(obj.response.catatan);

                    jQuery.expr[':'].contains = function(a, i, m) {
                        return jQuery(a).text().toUpperCase()
                            .indexOf(m[3].toUpperCase()) >= 0;
                    };

                    setLoadRencanaKontrol();
                } else {
                    if (obj.metaData.message == "OK") {
                        myAlert(obj.metaData.code);
                    } else {
                        myAlert(obj.metaData.message);
                    }
                }
            },
            error: function(data) {
                $("#data-sep").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }
</script>