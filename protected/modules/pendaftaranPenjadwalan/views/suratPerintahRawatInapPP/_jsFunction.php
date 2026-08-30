<script>
    /**
     * reset form info pasien
     * @returns {undefined}
     */
    function setInfoPasienReset() {
        $("#cari_pendaftaran_id").val("");
        $("#pendaftaran_id").val("");
        $("#pasien_id").val("");
        $("#pasienadmisi_id").val("");
        $("#jeniskasuspenyakit_id").val("");
        $("#carabayar_id").val("");
        $("#penjamin_id").val("");
        $("#penanggungjawab_id").val("");
        $("#kelaspelayanan_id").val("");
        $("#ruangan_id").val("");
        $("#no_pendaftaran").val("");
        $("#tgl_pendaftaran").val("");
        $("#ruangan_nama").val("");
        $("#jeniskasuspenyakit_nama").val("");
        $("#carabayar_nama").val("");
        $("#penjamin_nama").val("");
        $("#no_rekam_medik").val("");
        $("#namadepan").val("");
        $("#nama_pasien").val("");
        $("#nama_bin").val("");
        $("#tanggal_lahir").val("");
        $("#umur").val("");
        $("#jeniskelamin").val("");
        $("#nama_pj").val("");
        $("#pengantar").val("");
        $("#kelaspelayanan_nama").val("");
        $("#alamat_pasien").val("");
        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');

        $("#form-surat").addClass('hide');
    }

    function refreshDialogInfoPasien() {
        var instalasi_id = $("#instalasi_id").val();
        var instalasi_nama = $("#instalasi_id option:selected").text();

        $.fn.yiiGridView.update('datakunjungan-grid', {
            data: {
                "InfokunjunganrdV[instalasi_id]": instalasi_id,
                "InfokunjunganrdV[tgl_pencarian]": $("#InfokunjunganrdV_tgl_pencarian").val(),
            }
        });
    }

    /**
     * set form info pasien
     * @returns {undefined}
     */
    function setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id) {
        $("#form-infopasien").addClass("animation-loading");
        $("#form-isi").addClass("animation-loading");
        var instalasi_id = $("#instalasi_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('index', ['jenis' => 'setpasien']); ?>',
            data: {
                instalasi_id: instalasi_id,
                pendaftaran_id: pendaftaran_id,
                no_pendaftaran: no_pendaftaran,
                no_rekam_medik: no_rekam_medik,
                pasienadmisi_id: pasienadmisi_id
            },
            dataType: "json",
            success: function(data) {
                setInfoPasienReset();
                $("#cari_pendaftaran_id").val(data.pendaftaran_id);
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#pasienadmisi_id").val(data.pasienadmisi_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#instalasi_id").val(data.instalasi_id);
                $("#instalasi_nama").val(data.instalasi_nama);
                $("#ruangan_id").val(data.ruangan_id);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
                $("#ruangan_nama").val(data.ruangan_nama);
                $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
                $("#carabayar_nama").val(data.carabayar_nama);
                $("#penjamin_nama").val(data.penjamin_nama);
                $("#no_rekam_medik").val(data.no_rekam_medik);
                $("#namadepan").val(data.namadepan);
                $("#nama_pasien").val(data.nama_pasien);
                $("#nama_bin").val(data.nama_bin);
                $("#tanggal_lahir").val(data.tanggal_lahir);
                $("#umur").val(data.umur);
                $("#jeniskelamin").val(data.jeniskelamin);
                $("#nama_pj").val(data.nama_pj);
                $("#pengantar").val(data.pengantar);
                $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
                $("#alamat_pasien").val(data.alamat_pasien);
                $("#instalasiasal_id").val(data.instalasiasal_id);
                $("#<?php echo CHtml::activeId($model, 'no_telpon_peserta') ?>").val(data.no_mobile_pasien);
                $("#<?php echo CHtml::activeId($model, 'no_surat') ?>").val(data.nomorspri_bpjs);



                $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val(data.penjamin_id);

                $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val(data.ruangan_kode_bpjs);
                if (data.photopasien === null || data.photopasien === "") { //set photo
                    $('#photo-preview').attr('src',
                        '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                } else {
                    $('#photo-preview').attr('src',
                        '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                }
                $("#form-isi-surat").html(data.isisurat.html);
                $("#form-isi").removeClass("animation-loading");
                $("#form-infopasien").removeClass("animation-loading");
                $("#nama_pasien").focus();

                $("#form-surat").removeClass('hide');

                setTimeout(function() {
                    cekSpesialisVClaim();
                    let date_input = $(".tgl_suratperintahranap");
                    $(date_input).datetimepicker(jQuery.extend({
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'], {
                            'dateFormat': 'dd M yy',
                            'maxDate': 'd',
                            'timeText': 'Waktu',
                            'hourText': 'Jam',
                            'minuteText': 'Menit',
                            'secondText': 'Detik',
                            'showSecond': true,
                            'timeOnlyTitle': 'Pilih   Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold'
                        }));
                    $(date_input).parents(".input-append").find(".add-on").on('click', function() {
                        $(date_input).datepicker('show');
                    });


                    date_input = $(".tgl_rencanaranap");
                    $(date_input).datepicker(jQuery.extend({
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'], {
                            'dateFormat': 'dd M yy',
                      //      'maxDate': 'd',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold'
                        }));
                    $(date_input).parents(".input-append").find(".add-on").on('click', function() {
                        $(date_input).datepicker('show');
                    });

                    $('#SuratperintahranapT_therapi_sementara').redactor({
                        "lang": "en",
                        "toolbar": "mini"
                    });
                }, 500);

                jQuery($("#SuratperintahranapT_spesialissubspesialis_id")).multiselect({
                    includeSelectAllOption: false,
                    buttonClass: "form-control",
                    maxHeight: 200,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();

                jQuery($("#SuratperintahranapT_dpjp_id")).multiselect({
                    includeSelectAllOption: false,
                    buttonClass: "form-control",
                    maxHeight: 200,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data kunjungan tidak ditemukan !");
                console.log(errorThrown);
                setInfoPasienReset();
                $("#form-infopasien").removeClass("animation-loading");
                $("#instalasi_id").focus();
            }
        });
    }

    $(document).ready(function() {

    })
</script>