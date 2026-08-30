<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    input.invalid {
        /*            background-color: #ffdddd;*/
        border: 1px solid #ffdddd;

    }

    select.invalid {
        border: 1px solid #ffdddd;

    }

    textarea.invalid {
        border: 1px solid #ffdddd;

    }

    .radio.invalid {
        border: 1px solid #ffdddd;

    }

    .wizard {
        margin: 20px auto;
        background: #fff;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 40px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard>div.wizard-inner {
        position: relative;
    }

    .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 80%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 50%;
        z-index: 1;
    }

    .wizard .nav-tabs>li.active>a,
    .wizard .nav-tabs>li.active>a:hover,
    .wizard .nav-tabs>li.active>a:focus {
        color: #555555;
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }

    span.round-tab {
        width: 70px;
        height: 70px;
        line-height: 70px;
        display: inline-block;
        border-radius: 100px;
        background: #fff;
        border: 2px solid #e0e0e0;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 25px;
    }

    span.round-tab i {
        color: #555555;
    }

    .wizard li.active span.round-tab {
        background: #fff;
        border: 2px solid #57a595;

    }

    .wizard li.active span.round-tab i {
        color: #57a595;
    }

    span.round-tab:hover {
        color: #333;
        border: 2px solid #333;
    }

    .wizard .nav-tabs>li {
        width: 25%;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #57a595;
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #57a595;
    }

    .wizard .nav-tabs>li a {
        width: 70px;
        height: 70px;
        margin: 20px auto;
        border-radius: 100%;
        padding: 0;
    }

    .wizard .nav-tabs>li a:hover {
        background: transparent;
    }

    .wizard .tab-pane {
        position: relative;
        padding-top: 50px;
    }

    .wizard h3 {
        margin-top: 0;
    }

    #setpad {
        margin: 15px;
    }

    .form-horizontal .controls {
        margin-left: 0 !important;
    }

    .form-horizontal .control-label {
        text-align: left !important;
    }

    .panel-success>.panel-heading {
        color: white;
        background-color: #c42196;
        border-color: #768086;
    }

    .panel-success {
        border-color: #768086;
    }

    .btn-primary {
        background-color: #57a595;
    }

    ul {
        margin: 0;
    }

    .container,
    .tab-pane {
        padding-top: 0px !important;
    }

    .tile-purple {
        background-color: white !important;
        border: 2px solid #57a595;
        margin-bottom: 15px;
    }

    .tile-stats.tile-purple .num {
        color: #57a595;
    }
</style>

<body>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'ppbuat-janji-poli-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'id' => 'regForm', 'onKeyPress' => 'return disableKeyPress(event)',
            'onsubmit' => 'return requiredCheck(this);'
        ),
        //'focus'=>'#',
    ));
    ?>
    <?php
    ?>
    <div class="container">
        <div class="row">
            <section>
                <div class="wizard">
                    <div class="wizard-inner">
                        <!--                <div class="connecting-line"></div>-->
                        <ul class="nav nav-tabs" role="tablist" hidden="true">

                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-folder-open"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Step 4">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Step 5">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step6" data-toggle="tab" aria-controls="step6" role="tab" title="Step 6">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step7" data-toggle="tab" aria-controls="step7" role="tab" title="Step 7">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>


                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <div class="row" id="menudokumen">
                                <div class="col-xs-6 ">
                                    <a href="#" onclick="setPasien('pasienlama')">
                                        <div class="tile-stats tile-purple" style="background-color:#57a595;height:100px;">
                                            <div class="icon"><i class="entypo-doc-text"></i></div>
                                            <div class="num" style="color:#57a595; font-size:14pt"><b>Pasien Lama</b></div>

                                        </div>
                                    </a>

                                </div>
                                <div class="col-xs-6">
                                    <a href="#" onclick="setPasien('pasienbaru')">
                                        <div class="tile-stats tile-purple" style="background-color:#57a595;height:100px;">
                                            <div class="icon"><i class="entypo-doc-text"></i></div>
                                            <div class="num" style="color:#57a595;font-size:14pt"><b>Pasien Baru</b></div>

                                        </div>
                                    </a>

                                </div>
                            </div>
                            <!--                                <ul class="list-inline pull-right">
                                                                    <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                                                </ul>-->
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step2">
                            <input type="hidden" id="statuspasien" />
                            <div id="">
                                <div style="text-align:center">
                                    <h1>GO SHOW</h1>
                                </div>
                                <div class="row" id="setpad">
                                    <div class="col-xs-12" id="setpad" align="center">
                                        <?php echo $form->textField($modPasien, 'no_rekam_medik', array('placeholder' => 'Nomer Rekam Medik', 'onChange' => "return cek_data()", 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span12',)); ?>
                                    </div>
                                    <div class="col-xs-12" id="setpad">
                                        <div style="position:relative;height:50px">
                                            <div style="position:absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                                <?php
                                                $this->widget('MyDateTimePicker', array(
                                                    'model' => $modPasien,
                                                    'attribute' => 'tanggal_lahir',
                                                    'mode' => 'date',
                                                    'options' => array(
                                                        'dateFormat' => Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                        //
                                                        'onkeypress' => "js:function(){}",
                                                        'onSelect' => 'js:function(){}',
                                                    ),
                                                    'htmlOptions' => array(
                                                        'placeholder' => 'tanggal lahir', 'readonly' => true, 'id' => 'picker', 'style' => '', 'class' => 'dtPicker3 span12', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                                    ),
                                                ));
                                                echo "<div style='color:red'>Jika anda lupa No Rekam Medis silakan hub petugas</div>";
                                                ?>
                                                <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                            </ul>
                            <ul class="list-inline pull-right">

                                <li><button type="button" class="btn btn-primary " onclick="nextTabLog()"><i class="glyphicon glyphicon-search"></i> Cari</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step3">

                            <?php echo $this->renderPartial('formbuatjanji/formpasien', array('form' => $form, 'modPPBuatJanjiPoli' => $modPPBuatJanjiPoli, 'modPasien' => $modPasien)); ?>

                        </div>
                        <div class="tab-pane" role="tabpanel" id="step4">
                            <?php echo $this->renderPartial('formbuatjanji/formanamnesa', array('form' => $form, 'modPPBuatJanjiPoli' => $modPPBuatJanjiPoli)); ?>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step5">
                            <?php echo $this->renderPartial('formbuatjanji/jadwaldokter', array('form' => $form, 'modPPBuatJanjiPoli' => $modPPBuatJanjiPoli)); ?>


                        </div>

                        <div class="tab-pane" role="tabpanel" id="step6">
                            <div style="padding-bottom: 20px;">
                                <ul class="list-inline pull-left">
                                    <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                                </ul>

                                <ul class="list-inline pull-right">

                                    <li><button type="button" class="btn btn-primary" onclick="checkTindakan(this)">Lanjut</button></li>
                                </ul>
                            </div>
                            <br>
                            <div id="tampil-tindakan"></div>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step7">

                            <?php echo $this->renderPartial('tipebayarbuatjanji/formtipebayar', array('form' => $form, 'modPPBuatJanjiPoli' => $modPPBuatJanjiPoli, 'modpendaftaran' => $modpendaftaran, 'modPasien' => $modPasien)); ?>

                        </div>
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>Complete</h3>
                            <p>You have successfully completed all steps.</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </section>
        </div>
    </div>

    <?php if (!empty($_GET['buatjanjipoli_id'])) { ?>
        <?php
        // Dialog untuk ubah status periksa =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogQRcode',
            'options' => array(
                'title' => 'Qrcode Buat Janji',
                'autoOpen' => false,
                'modal' => true,
                'zIndex' => 1002,
                'minWidth' => 600,
                'minHeight' => 500,
                'resizable' => false,
            ),
        ));
        if (!empty($_GET['buatjanjipoli_id'])) {
            $modBuatJanjiPoli = BuatjanjipoliT::model()->findByPk($_GET['buatjanjipoli_id']);

            $dataKunjungan = InfokunjunganrjV::model()->findByAttributes([
                'pasien_id' => $modBuatJanjiPoli->pasien_id
            ], array('order' => 'create_time DESC'));
            $this->render('_frameQrBuatjanji', array(
                'format' => $format,
                'dataKunjungan' => $dataKunjungan,
                'modBuatJanjiPoli' => $modBuatJanjiPoli,
            ));
        }

        $this->endWidget();
        //========= end ubah status periksa dialog =============================
        ?>

    <?php } ?>
    <script>
        $(document).ready(function() {
            $("#picker_date").hide();
            <?php if (!empty($_GET['buatjanjipoli_id'])) { ?>

                window.open('<?php echo $this->createUrl('PrintBuatJanji', array('buatjanjipoli_id' => $_GET['buatjanjipoli_id'])); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
                $('#dialogQRcode').dialog('open');
            <?php } ?>

        });

        var currentTab = 0;

        /** bersihkan dropdown kecamatan */
        function setClearDropdownKecamatan() {
            $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "rv_kecamatan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        }
        /** bersihkan dropdown kelurahan */
        function setClearDropdownKelurahan() {
            $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "rv_kelurahan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        }
        $(document).ready(function() {

            $("#BuatjanjipoliT_rv_jeniskelamin_0").attr('checked', 'checked');
            $("#ytBuatjanjipoliT_rv_jeniskelamin").val("LAKI-LAKI");


            $(".next-step").click(function(e) {
                //tab yang aktif menjadi patokan
                var $active = $('.wizard .nav-tabs li.active');
                var idsetep = $active.find('a[aria-controls]').attr('aria-controls');
                if (requiredCheck($("#" + idsetep))) {
                    nextTab($active);
                }

            });
            $(".prev-step").click(function(e) {
                //tab yang aktif menjadi patokan
                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);

            });
        });

        function setPasien(status) {
            $('#statuspasien').val();
            $('#statuspasien').val(status);
            var $active = $('.wizard .nav-tabs li.active');

            if ($('#statuspasien').val() == "pasienlama") {
                $active.next().removeClass('disabled');
                nextTab($active);
            } else {

                nextTabPasienNew($active);
            }

        }

        function nextTabPasienNew(elem) {
            $(elem).next().next().find('a[data-toggle="tab"]').click();
        }

        function nextTab(elem) {

            $(elem).next().find('a[data-toggle="tab"]').click();
        }

        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

        function setDropdownJeniskasuspenyakit(ruangan_id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
                data: {
                    ruangan_id: ruangan_id
                }, //
                dataType: "json",
                success: function(data) {
                    $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "jeniskasuspenyakit_id"); ?>").html(data.listKasuspenyakit);
                    // $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "jeniskasuspenyakit_id"); ?>").val(kk_id);
                    cekPilihSatu($("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "jeniskasuspenyakit_id"); ?>"));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

        function cekPilihSatu(obj) {
            // console.log($(obj).find('option').length);
            if ($(obj).find('option').length == 2) {
                $(obj).val($(obj).find('option').eq(1).val());
                $(obj).change();
            }
            if ($(obj).find('option').length == 1) {
                $(obj).change();
            }
        }

        function setJamBooking(jambooking, tglbooking, ruangan_id) {
            // alert('escobar')
            console.log(jambooking)
            // console.log($('#ppbuat-janji-poli-t-form').serialize())
            $("#BuatjanjipoliT_jambooking").val(jambooking);
            $("#BuatjanjipoliT_tgljadwal").val(tglbooking);
            $("#BuatjanjipoliT_ruangan_id").val(ruangan_id);
            var x = '';
            $('#ppbuat-janji-poli-t-form').submit(function() {
                // var x = $(this).serialize();
                return false;

            });
            console.log($('#BuatjanjipoliT').serialize());
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GetTindakanDokter'); ?>',
                data: {
                    tglbooking: tglbooking,
                    jambooking: jambooking
                },
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    $("#tampil-tindakan").html(data.form);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    console.error(textStatus, errorThrown.toString())
                }
            });


            // alert(a)
            // $("#BuatjanjipoliT_jambooking").val(a);

        }

        function loadJadwalPerhari(e) {
            console.log($(e).val())
            var is_kontrol = $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "is_kontrol"); ?>").val();


            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GetJadwalPerhari'); ?>',
                data: {
                    tanggaljadwal: $(e).val(),
                    is_kontrol: is_kontrol,
                    pasien_id: $("#BuatjanjipoliT_pasien_id").val()
                },
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    $("#janjipoli-klinik").html(data.tr);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }

        function nextTabLog(elem) {
            var inisial = $('#inisial').val();
            var norekam = $('#PPPasienM_no_rekam_medik').val();
            var tgllahir = $('#picker').val();
            console.log(inisial);
            var statusaksi = false;


            if (norekam != "") {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('/ekios/Default/ValidasiUtama') ?>',
                    data: {
                        norekam: norekam,
                        tgllahir: tgllahir
                    },
                    dataType: "json",
                    success: function(data) {
                        // alert(data);
                        if (data.status != false) {
                            console.log("berhasil");
                            console.log(data.tempatbekerja_nama);
                            $("#no_rekam_medik").val(data.no_rekam_medik);
                            $("#BuatjanjipoliT_pasien_id").val(data.pasien_id);
                            $("#BuatjanjipoliT_rv_nama_pasien").val(data.nama_pasien);
                            $("#BuatjanjipoliT_pasien_id").val(data.pasien_id);
                            $("#BuatjanjipoliT_rv_tgl_lahir").val(data.tanggal_lahir);
                            $("#BuatjanjipoliT_tempatbekerja_nama").val(data.tempatbekerja_nama);
                            $("#BuatjanjipoliT_tempatbekerja_id").val(data.tempatbekerja_id);
                            $("#usia").val(data.umur);
                            $("#BuatjanjipoliT_rv_no_telepon").val(data.no_mobile_pasien);
                            $("#BuatjanjipoliT_rv_no_telepon_darurat").val(data.no_telepon_pasien);
                            $("#BuatjanjipoliT_rv_email").val(data.alamatemail);
                            $("#BuatjanjipoliT_rv_propinsi_id").val(data.propinsi_id).change();
                            $("#BuatjanjipoliT_rv_agama").val(data.agama);
                            $("#BuatjanjipoliT_rv_alamat").val(data.alamat_pasien);
                            $("#BuatjanjipoliT_rv_golongandarah").val(data.golongandarah);
                            // $("#BuatjanjipoliT_jambooking").val(jambooking);
                            setTimeout(function() {
                                $("#BuatjanjipoliT_rv_kabupaten_id").val(data.kabupaten_id).change();
                            }, 1000);
                            setTimeout(function() {
                                $("#BuatjanjipoliT_rv_kecamatan_id").val(data.kecamatan_id).change();
                            }, 2000);
                            setTimeout(function() {
                                $("#BuatjanjipoliT_rv_kelurahan_id").val(data.kelurahan_id).change();
                            }, 3000);

                            if (data.jeniskelamin == "LAKI-LAKI") {
                                $('#PPPasienM_jeniskelamin_0').attr("checked", 'checked');
                            } else if (data.jeniskelamin == "PEREMPUAN") {
                                $('#PPPasienM_jeniskelamin_1').attr("checked", 'checked');
                            }
                            $("textarea#PPPasienM_alamat_pasien").val(data.alamat_pasien);

                            if (data.jeniskelamin == "LAKI-LAKI") {
                                $('#BuatjanjipoliT_rv_jeniskelamin_0').attr("checked", 'checked');
                            } else if (data.jeniskelamin == "PEREMPUAN") {
                                $('#BuatjanjipoliT_rv_jeniskelamin_1').attr("checked", 'checked');
                            }
                            //  $("#BuatjanjipoliT_rv_propinsi_id option[value='"+data.propinsi_id+"']").prop('selected', true);
                            var $active = $('.wizard .nav-tabs li.active');
                            $active.next().removeClass('disabled');
                            nextTab($active);

                        } else {
                            alert("Data Yang Anda Cari Belum Terdaftar ");
                            return false;
                        }
                    }
                });
            } else {
                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);
            }

            console.log(statusaksi);

        }

        function inputkontrol(obj) {
            // console.log(obj)
            if ($(obj).is(':checked')) {
                //    var box =  $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "is_kontrol"); ?>").val();
                console.log(obj.value)
                //     $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, 'is_kontrol') ?>").val(obj.value);
                $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "is_kontrol"); ?>").val(1);
                $("#tampil").addClass("animation-loading");
                $('#tampil').html("");

                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('SetTindakanOrtho'); ?>',
                    // data: {st: st, id: $(obj).val(), pasien_id: $("#BuatjanjipoliT_pasien_id").val()},
                    dataType: "json",
                    success: function(data) {
                        $('#tampil').append(data.form);
                        $('#tampil').removeClass("animation-loading");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "is_kontrol"); ?>").val(0)
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('SetTindakan'); ?>',
                    data: {
                        tgl: $('#BuatjanjipoliT_tgljadwal').val(),
                        jam: $('#BuatjanjipoliT_jambooking').val()
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $('#tampil').append(data.form);
                        $('#tampil').removeClass("animation-loading");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        }

        function inputperiksa(obj) {
            console.log(obj)
            console.log($(obj))

            if ($(obj).is(':checked')) {
                var daftartindakan_id = obj.value;

                jQuery.ajax({
                    'url': '<?php echo $this->createUrl(Yii::app()->controller->id . '/LoadFormTindakan') ?>',
                    'data': {
                        daftartindakan_id: daftartindakan_id
                    },
                    'type': 'post',
                    'dataType': 'json',
                    'success': function(data) {
                        if ($.trim(data.form) == '') {
                            console.log($(obj))
                            $(obj).removeAttr('checked');
                            // myAlert('Pemeriksaan belum memilik tarif silakan hubungi SIMRS untuk memeriksa tarif pemeriksaan tersebut');
                            // checkIni(obj);
                        }
                        $('#tblFormPemeriksaanLab #trPeriksaLabKosong').detach();
                        $('#tblFormPemeriksaanLab > tbody').append(data.form);
                        $("#tblFormPemeriksaanLab > tbody > tr:last .integer").maskMoney({
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ".",
                            "thousands": ",",
                            "precision": 0,
                            "symbol": null
                        });
                        $('.integer').each(function() {
                            this.value = formatNumber(this.value)
                        });
                        hitungTotal();

                        if (obj.value == '352') {
                            batalPeriksa('563');
                            $('#formPeriksaLab').find('input[value="563"]').attr('checked', 'checked');
                            $('#formPeriksaLab').find('input[value="563"]').attr('disabled', 'true');

                            batalPeriksa('564');
                            $('#formPeriksaLab').find('input[value="564"]').attr('checked', 'checked');
                            $('#formPeriksaLab').find('input[value="564"]').attr('disabled', 'true');

                            //  hitungTotal();

                        }
                    },
                    'cache': false
                });
            } else {

                // batalPeriksa(obj.value);
                //hitungTotal();

                myConfirm("Apakah anda akan membatalkan Tindakan ini?", "Perhatian!", function(r) {
                    if (r) {
                        batalPeriksa(obj.value);
                        hitungTotal();

                        if (obj.value == '352') {
                            $('#formPeriksaLab').find('input[value="563"]').removeAttr('checked');
                            $('#formPeriksaLab').find('input[value="563"]').removeAttr('disabled');

                            $('#formPeriksaLab').find('input[value="564"]').removeAttr('checked');
                            $('#formPeriksaLab').find('input[value="564"]').removeAttr('disabled');
                        }
                    } else {
                        $(obj).attr('checked', 'checked');
                    }
                });
            }
        }

        function hapus(pemeriksaanlab_id) {
            console.log($('input[id="pemeriksaanLab"][value="' + pemeriksaanlab_id + '"]'))
            // if($('#pemeriksaanLab').find('input[value="'+pemeriksaanlab_id+'"]').is(':checked')){
            //     alert('sa');
            // }else{
            //     alert('1')
            //     $('#formPeriksaLab').find('input[value="'+pemeriksaanlab_id+'"]').removeAttr('checked');
            // }

            myConfirm("Apakah anda akan membatalkan Tindakan ini?", "Perhatian!", function(r) {
                if (r) {
                    $('input[id="pemeriksaanLab"][value="' + pemeriksaanlab_id + '"]').attr('checked', false);

                    batalPeriksa(pemeriksaanlab_id);
                    hitungTotal();
                    // console.log(pemeriksaanlab_id)
                    // $('#formPeriksaLab').find('input[value="pemeriksaanlab_id"]').removeAttr('checked');
                    // if (obj.value == '352')
                    // {
                    //     $('#formPeriksaLab').find('input[value="563"]').removeAttr('checked');
                    //     $('#formPeriksaLab').find('input[value="563"]').removeAttr('disabled');

                    //     $('#formPeriksaLab').find('input[value="564"]').removeAttr('checked');
                    //     $('#formPeriksaLab').find('input[value="564"]').removeAttr('disabled');
                    // }
                } else {
                    // $(obj).attr('checked', 'checked');
                }
            });
            return false
        }

        function batalPeriksa(pemeriksaanlab_id) {
            $('#tblFormPemeriksaanLab #daftartindakan_' + pemeriksaanlab_id).detach();
            //if($('#tblFormPemeriksaanLab tr').length == 1)
            //$('#tblFormPemeriksaanLab').append('<tr id="trPeriksaLabKosong"><td colspan="4"></td></tr>'
        }

        function hitungTotal() {
            var total = 0;
            $('.tarif_satuan').each(
                function() {

                    total_harga = unformatNumber(this.value);
                    total += total_harga;
                }
            );

            $('#periksaTotal').val(formatNumber(total));
        }

        /**
         * 
         * @param {type} obj
         * @param {type} st
         * @returns {undefined}
         */
        function listDataPasienJanjiPoli(obj, st) {
            $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, 'harijadwal') ?>").val('');
            // $('')
            console.log($("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "is_kontrol"); ?>").val())
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GetJadwalJanjiPolik'); ?>',
                // $("#BuatjanjipoliT_pasien_id").val(data.pasien_id);
                data: {
                    st: st,
                    id: $(obj).val(),
                    pasien_id: $("#BuatjanjipoliT_pasien_id").val(),
                    is_kontrol: $("#<?php echo CHtml::activeId($modPPBuatJanjiPoli, "is_kontrol"); ?>").val()
                },
                dataType: "json",
                success: function(data) {
                    if (st == 'ruangan') {
                        $("#janjipoli-klinik").html(data.tr);
                        //$)('#klinikNama')
                    } else {
                        $("#janjipoli-dokter").html(data.tr);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }

        function checkTindakan(obj) {
            console.log($('#tblFormPemeriksaanLab > tbody tr').length);

            if ($('#tblFormPemeriksaanLab > tbody tr').length == 0) {
                $(obj).removeClass('next-step')
                myAlert('Harus memilih tindakan untuk melanjutkan tahap selanjutnya !');
                return false;
            } else {
                $(obj).addClass('next-step')

                var $active = $('.wizard .nav-tabs li.active');
                var idsetep = $active.find('a[aria-controls]').attr('aria-controls');
                nextTab($active);


            }
        }

        function listDokterRuangan(idRuangan) {
            $.post("<?php echo $this->createUrl('listDokterRuangan'); ?>", {
                    idRuangan: idRuangan
                },
                function(data) {
                    console.log(data.listDokter);
                    $('.datalistdokter').html(data.listDokter);
                }, "json");
        }

        function listKuota() {
            var pegawai_id = $("#BuatJanjiPoliT_pegawai_id").val();
            var tgl = $("#BuatJanjiPoliT_tgljadwal").val();
            var ruangan_id = $("#BuatJanjiPoliT_ruangan_id").val();

            $("#BuatjanjipoliT_pasien_id").val(data.pasien_id);
            console.log(pegawai_id, ruangan_id, tgl);


            if (pegawai_id == "" || ruangan_id == "" || tgl == "") {
                return false;
            }

            $.post("<?php echo $this->createUrl("getKuotaJanjiPoli") ?>", {
                pegawai_id: pegawai_id,
                ruangan_id: ruangan_id,
                tgl: tgl
            }, function(data) {

                if (data.is_penuh == 1) {
                    myAlert(data.msg);
                    $("#kuota_janji").val("");
                    $("#sisa_kuota").val("");
                    $("#BuatJanjiPoliT_pegawai_id").val(null);
                    return false;
                }

                $("#kuota_janji").val(data.kuota);
                $("#sisa_kuota").val(data.sisa);
            }, 'json');
        }

        function pilihdokter(jadwaldokter_id) {
            //                alert(jadwaldokter_id);
            // console.log(time)
            $("#BuatjanjipoliT_jadwalpegawai_id").val(jadwaldokter_id);



            // var $active = $('.wizard .nav-tabs li.active');
            // $active.next().removeClass('disabled');

            // nextTab($active);

        }


        function setButton(id) {
            // var 
            $('.btnall').css("background-color", "#c12b90");
            $('#btn-' + id).css("background-color", "gray");

        }

        function validateForm(elem) {
            console.log(elem);

            //                 This function deals with validation of the form fields
            var x, a, y, z, i, valid = true;

            x = document.getElementById(elem);
            y = x.getElementsByTagName("input");
            z = x.getElementsByTagName("select");

            // A loop that checks every input field in the current tab:


            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {

                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            for (i = 0; i < z.length; i++) {
                // If a field is empty...
                if (z[i].value == "") {
                    // add an "invalid" class to the field:
                    z[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }



            // If the valid status is true, mark the step as finished and valid:
            //                if (valid) {
            //                  document.getElementsByClassName("step")[currentTab].className += " finish";
            //                }
            return valid; // return the valid status
        }

        function setHamil(obj) {
            var status = $(obj).val();
            if (status == 0) {
                $('.statushamil').attr('readonly', true);
            } else {
                $('.statushamil').removeAttr('readonly', true);
            }
        }
    </script>

</body>

</html>