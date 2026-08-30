<style>
    .form_utama {
        text-align: center;
    }

    .form_utama .form_main {
        display: inline-block;
        align-items: center;
    }
</style>
<br>
<div class="form_panel form_utama">
    <div class="form_main">
        <div style="text-align: center;">
            <?php
            echo CHtml::textField('input_no_kartu', null, array('class' => 'input_no_kartu span12', 'placeholder' => 'No. Rekam Medis / No. Rujukan BPJS / No. Kartu BPJS / No. KTP / No. Telepon', 'onkeyup' => "namaLain(this);", 'style' => 'border: 3px solid black; height: 50px !important; border-radius:20px; font-size: 17px !important; background-color: #fff0f0; text-align: center;'));
            ?>
        </div>
        <div id="pesan">
        </div>
        <br>
        <div style="color: black;">
            <p>
                Masukkan SALAH SATU data yang anda miliki : No. Rekam Medis, No. Rujukan BPJS, No. Kartu BPJS, No. KTP, No. Telepon
                <hr>
                <i>Enter ONE of the data you have : Medical Record Number, BPJS Reference Number, BPJS Card Number, KTP Number, Mobile Number</i>
            </p>
        </div>
        <br>
        <br>
        <div>
            <table width="100%">
                <tr>
                    <td width="50%" style="text-align: left;">
                        <?php
                        echo CHtml::htmlButton("<i class=\"entypo-home\"></i> HOME", array(
                            "onclick" => "kembali();",
                            'style' => 'height: 50px; width: 130px; border-radius: 50px; text-align: center; color: white; background-color: #00008B;'
                        ));
                        ?>
                    </td>
                    <td width="50%" style="text-align: right;">
                        <?php
                        echo CHtml::htmlButton("<i class=\"icon-search icon-white\"></i> Cari", array(
                            "onclick" => "setPemeriksaanPertama(1);",
                            'style' => 'height: 50px; width: 130px; border-radius: 50px; text-align: center; color: white; background-color: #006400;'
                        ));
                        ?>

                    </td>
                </tr>
            </table>
        </div>
        <div class="control-group" hidden>
            <?php echo CHtml::label("Klinik Tujuan", "", array("class" => "control-label")); ?>
            <div class="controls">
                <?php
                $ruangan = RuanganM::model()->findAllByAttributes(array(
                    //'instalasi_id'=>Params::INSTALASI_ID_RJ,
                    'ruangan_aktif' => true,
                ), array(
                    'order' => 'ruangan_nama'
                ));

                $listRuangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
                $optionRuangan = array();

                foreach ($ruangan as $item) {
                    $optionRuangan[$item->ruangan_id] = array(
                        'data-kode' => $item->kode_bpjs,
                    );
                }

                echo CHtml::dropDownList('input_klinik_tujuan', null, $listRuangan, array(
                    'empty' => '-- Pilih --', 'options' => $optionRuangan,
                )); ?>
            </div>
        </div>
        <div class="form-action">
            <?php /* echo CHtml::htmlButton("Tujuan Kontrol", array(
                "onclick"=>"setPemeriksaanPertama(2);",
                "class"=>"btn btn-success",
            )); */ ?>
        </div>
    </div>
</div>

<script>
    function kembali() {
        window.location.replace("<?php echo $this->createUrl('/ekios/Default/Index'); ?>");
    }

    function namaLain(nama) {
        $('#input_no_kartu').val(nama.value.toUpperCase());
    }

    // function setPemeriksaanPertama(tipe) {

    //     var nomor = $("#input_no_kartu").val();
    //     $("#input_no_kartu").addClass("animation-loading");
    //     $(".form_utama").addClass("animation-loading");

    //     $.post('<?php echo $this->createUrl('GetPasienDariNomorPesertaNIK'); ?>', {
    //         nomor: nomor
    //     }, function(data) {

    //         $("#input_no_kartu").removeClass("animation-loading");
    //         $(".form_utama").removeClass("animation-loading");

    //         if (data.ok == 0) {
    //             myAlert(data.msg);
    //         } else {

    //             $("#PPPasienM_no_rekam_medik").val(data.pasien.no_rekam_medik);
    //             $("#PPPasienM_nama_pasien").val(data.pasien.nama_pasien);
    //             $("#PPPasienM_tanggal_lahir").val(data.pasien.tanggal_lahir);
    //             $("#PPSepT_nokartuasuransi").val(data.asuransi.nokartuasuransi);
    //             $("#PPSepT_pasien_id").val(data.pasien.pasien_id);
    //             $("#PPPasienM_no_identitas_pasien").val(data.pasien.no_identitas_pasien);

    //             if (data.pendaftaran != null) {
    //                 $("#PPPendaftaranT_tgl_pendaftaran").val(data.pendaftaran.tgl_pendaftaran);
    //                 $("#PPPendaftaranT_ruangan_id").val(data.pendaftaran.ruangan);
    //                 $("#PPPendaftaranT_pegawai_id").val(data.pendaftaran.dokter);
    //                 $("#PPPendaftaranT_no_urutantri").val(data.pendaftaran.no_urutantri);
    //                 $("#PPPendaftaranT_kode_ruangan_bpjs").val(data.pendaftaran.kode_ruangan_bpjs);
    //             }

    //             if (data.janjipoli != null) {
    //                 $("#input_klinik_tujuan").val(data.janjipoli.ruangan_id);
    //                 $("#PPPendaftaranT_no_buatjanji").val(data.janjipoli.no_buatjanji);
    //                 $("#PPPendaftaranT_buatjanjipoli_id").val(data.janjipoli.buatjanjipoli_id);
    //             } else {
    //                 $("#input_klinik_tujuan").val(data.pendaftaran.ruangan_id);
    //             }

    //             $("#PPAsuransipasienbpjsM_jenispeserta_bpjs").val(data.bpjs.peserta.jenisPeserta.keterangan);

    //             if (data.is_janjipoli == 1) {
    //                 if (data.is_janjipolinormal == 0) {
    //                     $("#PPSepT_jenis_kunjungan").val("0");
    //                     $("#PPSepT_flag_procedure").val("");
    //                     $("#PPSepT_kode_penunjang").val("");
    //                     $("#PPSepT_asesmen_pelayanan").val("");
    //                     $(".panel_kontrol").hide();

    //                     if (data.is_jkn == 1) {
    //                         $("#PPSepT_asesmen_pelayanan").val("");
    //                         $("#nosep_sebelumnya").val("")
    //                             .parents(".control-group").hide();
    //                     }

    //                 }
    //                 if (data.is_janjipolinormal == 1) {
    //                     $("#PPSepT_jenis_kunjungan").val("2");
    //                     $("#PPSepT_flag_procedure").val("");
    //                     $("#PPSepT_kode_penunjang").val("");
    //                     $("#PPSepT_asesmen_pelayanan").val("5");
    //                     $(".panel_kontrol").show();
    //                     $("#nosep_sebelumnya").val(data.is_janjipoliref.noSep);
    //                 }
    //                 if (data.is_janjipolinormal == 2) {
    //                     $("#PPSepT_jenis_kunjungan").val("0");
    //                     $("#PPSepT_flag_procedure").val("");
    //                     $("#PPSepT_kode_penunjang").val("");
    //                     $("#PPSepT_asesmen_pelayanan").val("2");
    //                     $(".panel_kontrol").show();
    //                     $("#nosep_sebelumnya").val(data.is_janjipoliref.noSep);
    //                 }

    //                 $("#dialogNoRujukan #norujukan").val(data.asuransi.nokartuasuransi);




    //                 if (data.janjipoli != null && data.janjipoli.nomorreferensijkn != null) {
    //                     $("#PPRujukanbpjsT_no_rujukan").val(data.janjipoli.nomorreferensijkn);
    //                     getRujukanNoRujukan(data.janjipoli.nomorreferensijkn);
    //                 }

    //                 if (data.is_janjipolikontrol != null) {
    //                     $("#PPSepT_no_surat").val(data.is_janjipolikontrol.noSuratKontrol);
    //                     $("#PPSepT_kode_dpjp").val(data.is_janjipolikontrol.kodeDokter);
    //                     $("#PPSepT_nama_dpjp").val(data.is_janjipolikontrol.namaDokter);
    //                     $("#PPSepT_dpjpygmelayani_kode").val(data.is_janjipolikontrol.kodeDokter);
    //                     $("#PPSepT_dpjpygmelayani_nama").val(data.is_janjipolikontrol.namaDokter);
    //                 }

    //                 if (data.janjipoli.kode_dokter != null) {
    //                     $("#PPSepT_dpjpygmelayani_kode").val(data.janjipoli.kode_dokter);
    //                     $("#PPSepT_dpjpygmelayani_nama").val(data.janjipoli.nama_pegawai);
    //                 }

    //             } else {
    //                 if (tipe == 1) {
    //                     $("#PPSepT_jenis_kunjungan").val("0");
    //                     $("#PPSepT_flag_procedure").val("");
    //                     $("#PPSepT_kode_penunjang").val("");
    //                     $("#PPSepT_asesmen_pelayanan").val("");
    //                     $(".panel_kontrol").hide();
    //                 }
    //                 if (tipe == 2) {
    //                     $("#PPSepT_jenis_kunjungan").val("2");
    //                     $("#PPSepT_flag_procedure").val("");
    //                     $("#PPSepT_kode_penunjang").val("");
    //                     $("#PPSepT_asesmen_pelayanan").val("5");
    //                     $(".panel_kontrol").show();
    //                 }

    //                 $("#dialogNoRujukan").dialog("open");
    //                 $("#dialogNoRujukan #norujukan").val(data.bpjs.peserta.noKartu);

    //                 // cariDataNoRujukan();
    //             }

    //             if (
    //                 data.pasien.no_mobile_pasien == null ||
    //                 data.pasien.no_mobile_pasien.trim() == "" ||
    //                 data.pasien.no_mobile_pasien.trim() == "-"
    //             ) {
    //                 $("#PPSepT_no_telpon_peserta").val("0000000000000");
    //             } else {
    //                 $("#PPSepT_no_telpon_peserta").val(data.pasien.no_mobile_pasien);
    //             }

    //             $("#data_pasien").val(JSON.stringify(data));

    //             $(".form_utama").hide();
    //             $(".form_bpjs").show();
    //             $(".form_bpjs_sep").hide();

    //         }

    //         console.log(data);
    //     }, 'json');

    // }

    function setPemeriksaanPertama(tipe) {

        var nomor = $("#input_no_kartu").val();
        $("#input_no_kartu").addClass("animation-loading");
        $(".form_utama").addClass("animation-loading");


        // return false;

        $.post('<?php echo $this->createUrl('GetPasienDariNomorPesertaNIK'); ?>', {
            nomor: nomor
        }, function(data) {

            $("#input_no_kartu").removeClass("animation-loading");
            $(".form_utama").removeClass("animation-loading");
            console.log(data);
            if (data.ok == 0) {
                myAlert(data.msg);
            } else if (data.isRm == 1 && data.isBpjs == 0) {
                $('#dialog_updatenobpjs').dialog("open");
                $("#nomor_rm").val(data.nomor);
            }

            if (data.ok == 1) {

                $("#PPPasienM_no_rekam_medik").val(data.pasien.no_rekam_medik);
                $("#PPPasienM_nama_pasien").val(data.pasien.nama_pasien);
                $("#PPPasienM_tanggal_lahir").val(data.pasien.tanggal_lahir);
                $("#PPSepT_nokartuasuransi").val(data.no_kartu_bpjs);
                $("#PPSepT_pasien_id").val(data.pasien.pasien_id);
                $("#PPPasienM_no_identitas_pasien").val(data.pasien.no_identitas_pasien);
                $("#PPBuatjanjipoli_buatjanjipoli_id").val(data.janjipoli.buatjanjipoli_id);
                if (data.pendaftaran != null) {
                    $("#PPPendaftaranT_tgl_pendaftaran").val(data.pendaftaran.tgl_pendaftaran);
                    $("#PPPendaftaranT_ruangan_id").val(data.pendaftaran.ruangan);
                    $("#PPPendaftaranT_pegawai_id").val(data.pendaftaran.dokter);
                    $("#PPPendaftaranT_no_urutantri").val(data.pendaftaran.no_urutantri);
                    $("#PPPendaftaranT_kode_ruangan_bpjs").val(data.pendaftaran.kode_ruangan_bpjs);
                }

                if (data.janjipoli != null) {
                    $("#input_klinik_tujuan").val(data.janjipoli.ruangan_id);
                    $("#PPPendaftaranT_buatjanjipoli_id").val(data.janjipoli.buatjanjipoli_id);
                } else {
                    $("#input_klinik_tujuan").val(data.pendaftaran.ruangan_id);
                }

                $("#PPAsuransipasienbpjsM_jenispeserta_bpjs").val(data.bpjs);

                if (data.is_janjipoli == 1) {

                    if (data.is_janjipolinormal == 0) {
                        $("#PPSepT_jenis_kunjungan").val("0");
                        $("#PPSepT_flag_procedure").val("");
                        $("#PPSepT_kode_penunjang").val("");
                        $("#PPSepT_asesmen_pelayanan").val("");
                        $(".panel_kontrol").hide();

                        if (data.is_jkn == 1) {
                            $("#PPSepT_asesmen_pelayanan").val("");
                            $("#nosep_sebelumnya").val("")
                                .parents(".control-group").hide();
                        }

                    }
                    if (data.is_janjipolinormal == 3) {
                        $("#PPSepT_jenis_kunjungan").val("2");
                        $("#PPSepT_flag_procedure").val("");
                        $("#PPSepT_kode_penunjang").val("");
                        $("#PPSepT_asesmen_pelayanan").val("5");
                        $(".panel_kontrol").show();
                        $("#nosep_sebelumnya").val(data.is_janjipoliref.noSep);
                        $("#PPSepT_skenario").val(data.is_janjipolinormal);
                    }
                    if (data.is_janjipolinormal == 4) {
                        $("#PPSepT_jenis_kunjungan").val("0");
                        $("#PPSepT_flag_procedure").val("");
                        $("#PPSepT_kode_penunjang").val("");
                        $("#PPSepT_asesmen_pelayanan").val("1");
                        $(".panel_kontrol").show();
                        $("#nosep_sebelumnya").val(data.is_janjipoliref.noSep);
                        $("#PPSepT_skenario").val(data.is_janjipolinormal);
                    }

                    if (data.is_janjipolinormal == 8) {
                        $("#PPSepT_jenis_kunjungan").val("0");
                        $("#PPSepT_flag_procedure").val("");
                        $("#PPSepT_kode_penunjang").val("");
                        $("#PPSepT_asesmen_pelayanan").val("1");
                        $(".panel_kontrol").show();
                        $("#nosep_sebelumnya").val(data.is_janjipoliref.noSep);
                        $("#PPSepT_skenario").val(data.is_janjipolinormal);
                    }

                    // if (data.is_janjipolinormal == 3) {
                    //     $("#PPSepT_jenis_kunjungan").val("2");
                    //     $("#PPSepT_flag_procedure").val("");
                    //     $("#PPSepT_kode_penunjang").val("");
                    //     $("#PPSepT_asesmen_pelayanan").val("1");
                    //     $(".panel_kontrol").show();
                    //     $("#nosep_sebelumnya").val(data.is_janjipoliref.noSep);
                    // }

                    $("#dialogNoRujukan #norujukan").val(data.no_kartu_bpjs);




                    if (data.janjipoli != null && data.janjipoli.nomorreferensijkn != null) {
                        $("#PPRujukanbpjsT_no_rujukan").val(data.janjipoli.nomorreferensijkn);
                        getRujukanNoRujukan(data.janjipoli.nomorreferensijkn);
                    }

                    if (data.is_janjipolikontrol != null) {
                        $("#PPSepT_no_surat").val(data.is_janjipolikontrol.noSuratKontrol);
                        $("#PPSepT_kode_dpjp").val(data.is_janjipolikontrol.kodeDokter);
                        $("#PPSepT_nama_dpjp").val(data.is_janjipolikontrol.namaDokter);
                        $("#PPSepT_dpjpygmelayani_kode").val(data.is_janjipolikontrol.kodeDokter);
                        $("#PPSepT_dpjpygmelayani_nama").val(data.is_janjipolikontrol.namaDokter);
                    }

                    if (data.janjipoli.kode_dokter != null) {
                        $("#PPSepT_dpjpygmelayani_kode").val(data.janjipoli.kode_dokter);
                        $("#PPSepT_dpjpygmelayani_nama").val(data.janjipoli.nama_pegawai);
                    }

                } else {
                    if (tipe == 1) {
                        $("#PPSepT_jenis_kunjungan").val("0");
                        $("#PPSepT_flag_procedure").val("");
                        $("#PPSepT_kode_penunjang").val("");
                        $("#PPSepT_asesmen_pelayanan").val("");
                        $(".panel_kontrol").hide();
                    }
                    if (tipe == 2) {
                        $("#PPSepT_jenis_kunjungan").val("2");
                        $("#PPSepT_flag_procedure").val("");
                        $("#PPSepT_kode_penunjang").val("");
                        $("#PPSepT_asesmen_pelayanan").val("5");
                        $(".panel_kontrol").show();
                    }

                    $("#dialogNoRujukan").dialog("open");
                    $("#dialogNoRujukan #norujukan").val(data.bpjs.peserta.noKartu);

                    // cariDataNoRujukan();
                }

                if (
                    data.pasien.no_mobile_pasien == null ||
                    data.pasien.no_mobile_pasien.trim() == "" ||
                    data.pasien.no_mobile_pasien.trim() == "-"
                ) {
                    $("#PPSepT_no_telpon_peserta").val("0000000000000");
                } else {
                    $("#PPSepT_no_telpon_peserta").val(data.pasien.no_mobile_pasien);
                }

                $("#data_pasien").val(JSON.stringify(data));

                $(".form_utama").show();
                $(".form_bpjs").hide();

                console.log(data);
                tandaTangan();
                // $("#daftar-mandiri-form").submit();
            }

            // alert("Anda berhasil Checkin ")

            // autoPrint();


        }, 'json');

    }

    function ketikNomor(e) {

        if (e.keyCode == 13) {
            e.preventDefault();
            setPemeriksaanPertama(1);
        }
        console.log(e.keyCode);

    }

    $(document).ready(function() {
        $("#input_no_kartu").on('keydown', ketikNomor);
        $("#pesan")
    });
</script>