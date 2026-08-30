<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<style>
    .checked td {
        background-color: yellow;
    }
</style>

<script type="text/javascript">
    var otoval = 1; // untuk hitung rekam medik
    var isSetLama = false;

    function switchOtomatis(obj) {
        otoval = $(obj).val();
        checkOto();
    }

    function checkOto() {
        console.log("otoval", otoval);
        if (otoval == 1) {
            $(".labelrm").show();
            $(".rm_lama").hide();
            $(".rm_baru").hide();
            $("#lb_rm_lama").removeClass("required").find("span").removeClass("required").hide();
            $("#no_rekam_medik_baru, #ROPasienM_nomorindukpegawai").val("");

            $("#pendaftaranFP").hide();
            $(".rm_nip_baru").show().find(":input").prop("disabled", false);
            $(".normpilihan").removeClass('hide');

            $("#btn_hak_pasien").prop("disabled", false);
        } else {
            $("#pendaftaranFP").show();
            $(".labelrm").hide();
            $(".rm_baru").show();
            $(".rm_lama").hide();
            $("#lb_rm_lama").addClass("required").find("span").addClass("required").show();
            $("#no_rekam_medik_baru, #ROPasienM_nomorindukpegawai").val("");
            $(".rm_nip_baru").hide().find(":input").prop("disabled", true);
            $(".normpilihan").addClass('hide');

            $("#btn_hak_pasien").prop("disabled", true);
        }

    }


    function setPegawai(pegawai_id, nip) {
        $.post('<?php echo $this->createUrl('getDataPegawaiUntukPasienBaru'); ?>', {
            pegawai_id: pegawai_id,
            nip: nip
        }, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
                $("#ROPasienM_nomorindukpegawai").val("").focus();
            } else {
                $("#<?php echo CHtml::activeId($modPasien, "pegawai_id"); ?>").val(data.res.pegawai_id);
                $("#<?php echo CHtml::activeId($modPasien, "jenisidentitas"); ?>").val(data.res.jenisidentitas.trim());
                $("#<?php echo CHtml::activeId($modPasien, "no_identitas_pasien"); ?>").val(data.res.noidentitas);
                $("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val(data.res.nama_pegawai.toUpperCase());
                $("#<?php echo CHtml::activeId($modPasien, "tempat_lahir"); ?>").val(data.res.tempatlahir_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val(data.res.tgl_lahirpegawai);
                $("#<?php echo CHtml::activeId($modPasien, "statusperkawinan"); ?>").val(data.res.statusperkawinan);
                $("#<?php echo CHtml::activeId($modPasien, "golongandarah"); ?>").val(data.res.golongandarah);
                $("#<?php echo CHtml::activeId($modPasien, "rhesus"); ?>").val(data.res.rhesus);
                $("#<?php echo CHtml::activeId($modPasien, "alamat_pasien"); ?>").val(data.res.alamat_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "no_telepon_pasien"); ?>").val(data.res.notelp_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "no_mobile_pasien"); ?>").val(data.res.nomobile_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "suku_id"); ?>").val(data.res.suku_id);
                $("#<?php echo CHtml::activeId($modPasien, "alamatemail"); ?>").val(data.res.alamatemail);
                $("#<?php echo CHtml::activeId($modPasien, "pendidikan_id"); ?>").val(data.res.pendidikan_id);
                $("#<?php echo CHtml::activeId($modPasien, "warga_negara"); ?>").val(data.res.warganegara_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "agama"); ?>").val(data.res.agama);
                setJenisKelaminPasien(data.res.jeniskelamin);
                setRhesusPasien(data.res.rhesus);
                setDaerahPasien(data.res.propinsi_id, data.res.kabupaten_id, data.res.kecamatan_id, data.res.kelurahan_id);
                setUmur(data.res.tgl_lahirpegawai);
                setKarcis();
            }
        }, 'json');
    }

    /**
     * set pasien lama
     * @param {type} pasien_id
     * @returns {undefined}
     */
    function setPasienLama(pasien_id, no_rekam_medik) {
        $("#form-pasien > .panel-body").addClass("animation-loading");
        setPasienBaru();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataPasien'); ?>',
            data: {
                pasien_id: pasien_id,
                no_rekam_medik: no_rekam_medik
            },
            dataType: "json",
            success: function(data) {

                if (data.lebih) {
                    myAlert("No. RM digunakan untuk hitungan otomatis. Pilih antara 000001 - 347499");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#no_rekam_medik_baru").val("");
                    return false;
                }

                <?php // if ($this->id == "pendaftaranRawatInap"): 
                ?>

                if (data.adaInap) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang dirawat inap di " + data.listDaftar.ruangan.ruangan_nama + ".");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
                if (data.tindakLanjut) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                    Hari ini menunggu tindak lanjut ke rawat inap di " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + ".");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
                if (data.adaDaftar) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang di instalasi " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + " dengan status pemeriksan '" +
                        data.listDaftar.statusperiksa + "'.");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }

                if (data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF ?>") {
                    $("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
                    $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                    $("#no_rekam_medik_baru").val(data.no_rekam_medik);
                    $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val(data.pasien_id);
                    $("#<?php echo CHtml::activeId($modPasien, "jenisidentitas"); ?>").val(data.jenisidentitas);
                    $("#<?php echo CHtml::activeId($modPasien, "no_identitas_pasien"); ?>").val(data.no_identitas_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "namadepan"); ?>").val(data.namadepan);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val(data.nama_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_bin"); ?>").val(data.nama_bin);
                    $("#<?php echo CHtml::activeId($modPasien, "tempat_lahir"); ?>").val(data.tempat_lahir);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_ayah"); ?>").val(data.nama_ayah);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_ibu"); ?>").val(data.nama_ibu);
                    $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val(data.tanggal_lahir);
                    $("#<?php echo CHtml::activeId($modPasien, "kelompokumur_id"); ?>").val(data.kelompokumur_id);
                    $("#<?php echo CHtml::activeId($modPasien, "statusperkawinan"); ?>").val(data.statusperkawinan);
                    $("#<?php echo CHtml::activeId($modPasien, "golongandarah"); ?>").val(data.golongandarah);
                    $("#<?php echo CHtml::activeId($modPasien, "rhesus"); ?>").val(data.rhesus);
                    $("#<?php echo CHtml::activeId($modPasien, "alamat_pasien"); ?>").val(data.alamat_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "rt"); ?>").val(data.rt);
                    $("#<?php echo CHtml::activeId($modPasien, "rw"); ?>").val(data.rw);
                    $("#<?php echo CHtml::activeId($modPasien, "no_telepon_pasien"); ?>").val(data.no_telepon_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "no_mobile_pasien"); ?>").val(data.no_mobile_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "suku_id"); ?>").val(data.suku_id);
                    $("#<?php echo CHtml::activeId($modPasien, "alamatemail"); ?>").val(data.alamatemail);
                    $("#<?php echo CHtml::activeId($modPasien, "anakke"); ?>").val(data.anakke);
                    $("#<?php echo CHtml::activeId($modPasien, "jumlah_bersaudara"); ?>").val(data.jumlah_bersaudara);
                    $("#<?php echo CHtml::activeId($modPasien, "pendidikan_id"); ?>").val(data.pendidikan_id);
                    $("#<?php echo CHtml::activeId($modPasien, "pekerjaan_id"); ?>").val(data.pekerjaan_id);
                    $("#<?php echo CHtml::activeId($modPasien, "agama"); ?>").val(data.agama);
                    $("#<?php echo CHtml::activeId($modPasien, "warga_negara"); ?>").val(data.warga_negara);
                    $("#<?php echo CHtml::activeId($modPasien, "is_ambilfoto"); ?>").val(0);

                    $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                    if (data.photopasien != null && data.photopasien != "") { //set photo
                        $("#<?php echo CHtml::activeId($modPasien, "photopasien"); ?>").val(data.photopasien);
                        $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                    }

                    setJenisKelaminPasien(data.jeniskelamin);
                    setRhesusPasien(data.rhesus);
                    setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                    setUmur(data.tanggal_lahir);
                    setKarcis();
                    setRiwayatKunjunganPasien(data.pasien_id);
                    setAsuransiPasienLama(data.pasien_id);

                    if (getDataRiwayatVaksinasi != null) {
                        getDataRiwayatVaksinasi(data.pasien_id);
                    }


                    $("#form-pasien > .panel-heading > .panel-title > .judul").html('Data Pasien Lama ');
                    $("#form-pasien > .panel-heading > .panel-title > .tombol").attr('style', 'display:true;');
                } else {
                    myConfirm("Apakah Anda akan menggunakan No. Rekam Medik Non-Aktif?", "Perhatian!", function(r) {
                        if (r) {
                            $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                            $("#no_rekam_medik_baru").val(data.no_rekam_medik);
                            $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val(data.pasien_id);
                            $("#form-pasien > .panel-heading > .panel-title > .judul").html('Data Pasien No. Rekam Medik Lama ');
                            $("#form-pasien > .panel-heading > .panel-title > .tombol").attr('style', 'display:true;');
                            $("#<?php echo CHtml::activeId($modPasien, 'jenisidentitas'); ?>").focus();
                        }
                    });
                }
                $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").focus(); //<<RND-820 (custom)
                window.scrollBy(0, 380); //<<RND-820 (custom)
                $("#form-pasien > .panel-body").removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data Pasien tidak ditemukan!");
                $("#form-pasien > div").removeClass("animation-loading");
            }
        });

    }
    /**
     * set form pasien ke pasien baru
     * @returns {undefined} */
    function setPasienBaru() {
        $("#<?php echo CHtml::activeId($model, 'umur'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "jenisidentitas"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "no_identitas_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "namadepan"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "nama_bin"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "tempat_lahir"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "nama_ayah"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "nama_ibu"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "kelompokumur_id"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "jeniskelamin"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "statusperkawinan"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "golongandarah"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "rhesus"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "alamat_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "rt"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "rw"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "propinsi_id"); ?>").val(<?php echo $modPasien->propinsi_id; ?>).multiselect('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "kabupaten_id"); ?>").val(<?php echo $modPasien->kabupaten_id; ?>).multiselect('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "kecamatan_id"); ?>").val(<?php echo $modPasien->kecamatan_id; ?>).multiselect('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "kelurahan_id"); ?>").val("").multiselect('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "no_telepon_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "no_mobile_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "suku_id"); ?>").val(<?php echo $modPasien->suku_id; ?>);
        $("#<?php echo CHtml::activeId($modPasien, "alamatemail"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "anakke"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "jumlah_bersaudara"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "pendidikan_id"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "pekerjaan_id"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "agama"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "warga_negara"); ?>").val("<?php echo $modPasien->warga_negara; ?>");

        $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val("");
        $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").val("");
        setAsuransiBadakReset();

        $("#<?php echo CHtml::activeId($modPasien, "photopasien"); ?>").val("");
        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');

        setJenisKelaminPasien("");
        setKarcis();
        setAsuransiBadakReset();

        $("#form-pasien > .panel-heading > .panel-title > .judul").html('Data Pasien Baru ');
        $("#form-pasien > .panel-heading > .panel-title > .tombol").attr('style', 'display:none;');
        //$("#form-pasien > .well").addClass("box").removeClass("well");
        $("#cari_no_rekam_medik").val("");
        $("#cari_nomorindukpegawai").val("");
    }
    /**
     * set input radio button jenis kelamin
     * @param {type} jk
     * @returns {undefined}
     */
    function setJenisKelaminPasien(jk) {
        $('input[name$="[jeniskelamin]"][type="radio"]').each(function() {
            if ($(this).val() == $.trim(jk)) {
                $(this).prop('checked', true);
            }
        });
    }
    /**
     * set input radio button rhesus
     * @param {type} rh
     * @returns {undefined}
     */
    function setRhesusPasien(rh) {
        $('input[name*="[rhesus]"]').each(function() {
            if (this.value == $.trim(rh))
                $(this).attr('checked', true);
        });
    }
    /**
     * set propinsi, kabupaten, kecamatan, dan kelurahan
     * @param {type} propinsi_id
     * @param {type} kabupaten_id
     * @param {type} kecamatan_id
     * @param {type} kalurahan_id
     * @returns {undefined}
     */
    function setDaerahPasien(propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDaerahPasien'); ?>',
            data: {
                propinsi_id: propinsi_id,
                kabupaten_id: kabupaten_id,
                kecamatan_id: kecamatan_id,
                kelurahan_id: kelurahan_id
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPasien, "propinsi_id"); ?>").html(data.listPropinsi).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kabupaten_id"); ?>").html(data.listKabupaten).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kecamatan_id"); ?>").html(data.listKecamatan).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kelurahan_id"); ?>").html(data.listKelurahan).multiselect('rebuild');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nama depan berdasarkan umur, jenis kelamin dan status perkawinan
     * @returns {undefined} */
    function setNamaDepan() {
        var statusperkawinan = $('#ROPasienM_statusperkawinan').val();
        var namadepan = $('#ROPasienM_namadepan');
        var umur = $("#<?php echo CHtml::activeId($model, 'umur'); ?>").val().substr(0, 2);
        umur = parseInt(umur);

        console.log(umur);

        if (umur <= 5) {
            var namadepan = $('#ROPasienM_namadepan').val('By. ');
            if (statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR") {
                $('#ROPasienM_statusperkawinan').val('');
                alert('Maaf status perkawinan belum cukup usia');
            }
        } else if (umur <= 14) { //
            var namadepan = $('#ROPasienM_namadepan').val('An. ');
            if (statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR") {
                $('#ROPasienM_statusperkawinan').val('');
                alert('Maaf status perkawinan belum cukup usia');
            }
        } else {
            ;
            if ($('#ROPasienM_jeniskelamin_0').is(':checked')) {
                if (statusperkawinan !== 'JANDA') {
                    var namadepan = $('#ROPasienM_namadepan').val('Tn. ');
                } else {
                    alert('Pilih status pernikahan yang sesuai!');
                    $('#ROPasienM_statusperkawinan').val('KAWIN');
                    var namadepan = $('#ROPasienM_namadepan').val('Tn. ')
                }

            }

            if ($('#ROPasienM_jeniskelamin_1').is(':checked')) {
                $('#ROPasienM_namadepan').val('Nn. ');
                if (statusperkawinan !== 'DUDA') {
                    var namadepan = $('#ROPasienM_namadepan').val('Nn. ');
                    if (statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI') {
                        var namadepan = $('#ROPasienM_namadepan').val('Ny. ');
                    } else {
                        var namadepan = $('#ROPasienM_namadepan').val('Nn. ');
                    }
                } else {
                    alert('Pilih status pernikahan yang sesuai!');
                    $('#ROPasienM_statusperkawinan').val('KAWIN');
                    var namadepan = $('#ROPasienM_namadepan').val('Ny. ');
                }
            }

            if (statusperkawinan == "DIBAWAH UMUR") {
                alert('Pilih status pernikahan yang sesuai!');
                $('#ROPasienM_statusperkawinan').val('BELUM KAWIN');
            }
        }
    }
    /**
     * set nilai tanggal_lahir dari umur
     * @param {type} obj
     * @returns {undefined} */
    function setTglLahir(obj) {
        var str = obj.value;
        obj.value = str.replace(/_/gi, "0");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggalLahir'); ?>',
            data: {
                umur: obj.value
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val(data.tanggal_lahir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nilai umur dari tanggal_lahir
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmur(tanggal_lahir) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmur'); ?>',
            data: {
                tanggal_lahir: tanggal_lahir
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "umur"); ?>").val(data.umur);
                setNamaDepan();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nilai tanggal_lahir dari umur
     * @param {type} obj
     * @returns {undefined} */
    function setTglLahirPjp(obj) {
        var str = obj.value;
        obj.value = str.replace(/_/gi, "0");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggalLahirPjp'); ?>',
            data: {
                umur_pj: obj.value
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPenanggungJawab, "tgllahir_pj"); ?>").val(data.tgllahir_pj);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nilai umur dari tanggal_lahir
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmurPjp(tgllahir_pj) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmurPjp'); ?>',
            data: {
                tgllahir_pj: tgllahir_pj
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPenanggungJawab, "umur_pj"); ?>").val(data.umur_pj);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /** bersihkan dropdown kecamatan */
    function setClearDropdownKecamatan() {
        $("#<?php echo CHtml::activeId($modPasien, "kecamatan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('').multiselect('rebuild');
    }
    /** bersihkan dropdown kelurahan */
    function setClearDropdownKelurahan() {
        $("#<?php echo CHtml::activeId($modPasien, "kelurahan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('').multiselect('rebuild');
    }
    /**
     * set dropdown dokter ruangan
     * @param {type} ruangan_id
     * @param {type} pegawai_id
     * @returns {undefined}
     */
    function setDropdownDokter(ruangan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDokter'); ?>',
            data: {
                ruangan_id: ruangan_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "pegawai_id"); ?>").html(data.listDokter);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set dropdown jeniskasuspenyakit_id
     * @param {type} ruangan_id
     * @returns {undefined} */
    function setDropdownJeniskasuspenyakit(ruangan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
            data: {
                ruangan_id: ruangan_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "jeniskasuspenyakit_id"); ?>").html(data.listKasuspenyakit);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /** control accordion rujukan */
    $('#form-rujukan > div > .accordion-heading').click(function() {
        //    console.log("Rujukan Di Klik!");
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
        if (is_pasienrujukan.val() > 0) { //hide
            is_pasienrujukan.val(0);
        } else { //show
            is_pasienrujukan.val(1);
        }
    });

    /** control accordion penanggung jawab pasien */
    $('#form-pjpasien > div > .accordion-heading').click(function() {
        var is_adapjpasien = $("#<?php echo CHtml::activeId($model, "is_adapjpasien"); ?>");
        if (is_adapjpasien.val() > 0) { //hide
            is_adapjpasien.val(0);
        } else { //show
            is_adapjpasien.val(1);
        }
    });
    /** control accordion karcis radiologi*/
    $('#form-karcis > div > .accordion-heading').click(function() {
        var is_adakarcis = $("#form-karcis").parent().find('input[name$="[is_adakarcis]"]');
        if (is_adakarcis.val() > 0) { //hide
            is_adakarcis.val(0);
        } else { //show
            is_adakarcis.val(1);
        }
    });

    /**
     * bersihkan form rujukan
     */
    function clearRujukan() {
        $('#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id') ?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    /**
     * set otomatis nama_perujuk dari dropdown rujukandari_id
     * @returns {Boolean}
     */
    function setNamaPerujuk() {
        var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id') ?>").val();
        var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id') ?>").find('option[value="' + rujukandari_id + '"]').text();
        $("#<?php echo CHtml::activeId($modRujukan, 'nama_perujuk') ?>").val(nama_perujuk);
    }
    /**
     * set form asuransi
     * @returns {undefined} */
    function setFormAsuransi(carabayar_id) {
        var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>;
        var carabayar_id_badak = <?php echo Params::CARABAYAR_ID_BADAK; ?>;
        var carabayar_id_departemen = <?php echo Params::CARABAYAR_ID_DEP_BADAK; ?>;
        var carabayar_id_pekerja = <?php echo Params::CARABAYAR_ID_PEKERJA; ?>;
        if (carabayar_id == carabayar_id_umum) {
            sembunyiFormAsuransi();
            sembunyiFormAsuBadak();
            sembunyiFormAsuDepartemen();
            sembunyiFormAsuPekerja();
            $('#form-asuransi').hide();
            $('#form-asubadak').hide();
            $('#form-asudepartemen').hide();
            $('#form-asupekerja').hide();
        } else if (carabayar_id == carabayar_id_badak) {
            sembunyiFormAsuransi();
            tampilFormAsuBadak();
            sembunyiFormAsuDepartemen();
            sembunyiFormAsuPekerja();
            $('#form-asuransi').hide();
            $('#form-asubadak').show();
            $('#form-asudepartemen').hide();
            $('#form-asupekerja').hide();
        } else if (carabayar_id == carabayar_id_departemen) {
            sembunyiFormAsuransi();
            sembunyiFormAsuBadak();
            tampilFormAsuDepartemen();
            sembunyiFormAsuPekerja();
            $('#form-asuransi').hide();
            $('#form-asubadak').hide();
            $('#form-asudepartemen').show();
            $('#form-asupekerja').hide();
        } else if (carabayar_id == carabayar_id_pekerja) {
            sembunyiFormAsuransi();
            sembunyiFormAsuBadak();
            sembunyiFormAsuDepartemen();
            tampilFormAsuPekerja();
            $('#form-asuransi').hide();
            $('#form-asubadak').hide();
            $('#form-asudepartemen').hide();
            $('#form-asupekerja').show();
        } else {
            tampilFormAsuransi();
            sembunyiFormAsuBadak();
            sembunyiFormAsuDepartemen();
            sembunyiFormAsuPekerja();
            $('#form-asuransi').show();
            $('#form-asubadak').hide();
            $('#form-asudepartemen').hide();
            $('#form-asupekerja').hide();
        }
    }

    function sembunyiFormAsuransi() {
        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi').removeAttr("style").attr("style", "height:0px");
        $('#content-asuransi').find("input,select,textarea").attr("disabled", true);

    }

    function tampilFormAsuransi() {
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi').removeAttr("style").attr("style", "height:auto");
        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled");

    }

    function sembunyiFormAsuBadak() {
        $('#content-asubadak').find(".required").addClass("not-required").removeClass("required");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asubadak').removeClass().addClass("accordion-body collapse");
        $('#content-asubadak').removeAttr("style").attr("style", "height:0px");
        $('#content-asubadak').find("input,select,textarea").attr("disabled", true);
    }

    function tampilFormAsuBadak() {
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asubadak').removeClass().addClass("accordion-body in collapse");
        $('#content-asubadak').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asubadak').removeAttr("style").attr("style", "height:auto");
        $('#content-asubadak').find("input,select,textarea").removeAttr("disabled");

    }

    function sembunyiFormAsuDepartemen() {
        $('#content-asudepartemen').find(".required").addClass("not-required").removeClass("required");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asudepartemen').removeClass().addClass("accordion-body collapse");
        $('#content-asudepartemen').removeAttr("style").attr("style", "height:0px");
        $('#content-asudepartemen').find("input,select,textarea").attr("disabled", true);
    }

    function tampilFormAsuDepartemen() {
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asudepartemen').removeClass().addClass("accordion-body in collapse");
        $('#content-asudepartemen').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asudepartemen').removeAttr("style").attr("style", "height:auto");
        $('#content-asudepartemen').find("input,select,textarea").removeAttr("disabled");

    }

    function sembunyiFormAsuPekerja() {
        $('#content-asupekerja').find(".required").addClass("not-required").removeClass("required");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asupekerja').removeClass().addClass("accordion-body collapse");
        $('#content-asupekerja').removeAttr("style").attr("style", "height:0px");
        $('#content-asupekerja').find("input,select,textarea").attr("disabled", true);
    }

    function tampilFormAsuPekerja() {
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asupekerja').removeClass().addClass("accordion-body in collapse");
        $('#content-asupekerja').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asupekerja').removeAttr("style").attr("style", "height:auto");
        $('#content-asupekerja').find("input,select,textarea").removeAttr("disabled");

    }

    /**
     * checking penjamin pegawai badak apakah msh aktif / tidak
     * @returns {undefined}
     * LNG-48
     */
    function cekCaraBayarBadak(carabayar_id) {
        var pegawai_id = $("#<?php echo CHtml::activeId($modPasien, "pegawai_id"); ?>").val();
        if ((carabayar_id == <?= Params::CARABAYAR_ID_BADAK; ?>) || (carabayar_id == <?= Params::CARABAYAR_ID_DEP_BADAK; ?>) || (carabayar_id == <?= Params::CARABAYAR_ID_PEKERJA; ?>)) {
            if (pegawai_id == '') {
                myAlert("Pilih data pegawai penanggung jawab terlebih dahulu!");
                $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val("");
                $("#PPPasienAdmisiT_carabayar_id").val("");
            } else {
                $("#content-asubadak").addClass("animation-loading");
                $("#content-asudepartemen").addClass("animation-loading");
                $("#content-asupekerja").addClass("animation-loading");
                var pasien_id = $("#<?php echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('CekCaraBayarBadak'); ?>',
                    data: {
                        pasien_id: pasien_id,
                        pegawai_id: pegawai_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status === true) {
                            setAsuransiBadak();
                        } else {
                            myAlert(data.pesan);
                            $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val("");
                            $("#ROPendaftaranT_carabayar_id").val("");
                        }
                        $("#content-asubadak").removeClass("animation-loading");
                        $("#content-asudepartemen").removeClass("animation-loading");
                        $("#content-asupekerja").removeClass("animation-loading");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

        }

    }

    /**
     * unset asuransi badak (This Function Dedicate For LNG Projects Only)
     * @returns {undefined}
     * LNG-3
     */
    function setAsuransiBadakReset() {
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'hubkeluarga') ?>").val("");

        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'hubkeluarga') ?>").val("");

        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'hubkeluarga') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'alamat_pegawai') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'notelp_pegawai') ?>").val("");
    }

    /**
     * set asuransi badak (This Function Dedicate For LNG Projects Only)
     * @returns {undefined}
     * LNG-3
     */
    function setAsuransiBadak() {
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>").val();
        var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
        var pegawai_id = $("#<?php echo CHtml::activeId($modPasien, "pegawai_id"); ?>").val();
        $("#form-asubadak").addClass("animation-loading");
        $("#form-asudepartemen").addClass("animation-loading");
        $("#form-asupekerja").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAsuransiBadak'); ?>',
            data: {
                pasien_id: pasien_id,
                penjamin_id: penjamin_id,
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                setAsuransiBadakReset();
                if (data != null) {
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namaperusahaan') ?>").val(data.namaperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'hubkeluarga') ?>").val(data.hubkeluarga);

                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namaperusahaan') ?>").val(data.namaperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);

                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modPegawai, 'alamat_pegawai') ?>").val(data.alamat_pegawai);
                    $("#<?php echo CHtml::activeId($modPegawai, 'notelp_pegawai') ?>").val(data.notelp_pegawai);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
                }

                $("#form-asubadak").removeClass("animation-loading");
                $("#form-asudepartemen").removeClass("animation-loading");
                $("#form-asupekerja").removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * checking validasi penjamin (This Function Dedicate For LNG Projects Only)
     * @returns {undefined}
     * LNG-3
     */
    function cekValiditasPenjamin(penjamin_id) {
        var carabayar_id = $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val();
        var pegawai_id = $("#<?php echo CHtml::activeId($modPasien, "pegawai_id"); ?>").val();
        if (carabayar_id == <?= Params::CARABAYAR_ID_BADAK; ?>) {

            if ((penjamin_id == <?= Params::PENJAMIN_ID_PISA; ?>) || (penjamin_id == <?= Params::PENJAMIN_ID_PROKESPEN; ?>)) {
                var pasien_id = $("#<?php echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
                    data: {
                        type: "badak",
                        pasien_id: pasien_id,
                        penjamin_id: penjamin_id,
                        pegawai_id: pegawai_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if ((data.status == 'Empty') || (data.status == 'Fail')) {
                            myAlert(data.pesan);
                            $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").html(data.html);
                        } else {

                            if (data.penj == <?= Params::PENJAMIN_ID_PISA; ?>) {
                                if (data.status == 'Tidak Tetap') {
                                    myAlert(data.pesan);
                                    $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").html(data.html);
                                }
                            } else {
                                myAlert("Prokespen hanya menjamin Pensiunan dan Istri/Suami Pensiunan");
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
            setDropdownStatushubungankeluarga(penjamin_id);

        } else if (carabayar_id == <?= Params::CARABAYAR_ID_DEP_BADAK; ?>) {

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
                data: {
                    type: "departemen",
                    penjamin_id: penjamin_id
                },
                dataType: "json",
                success: function(data) {
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, "namaperusahaan"); ?>").val(data.data.penjamin_nama);
                    $(".judulasuransi").html("Asuransi " + data.data.penjamin_nama);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }

    }

    /**
     * set dropdown status hubungan keluarga pada form asuransi pt badak
     * @param {type} ruangan_id
     * @returns {undefined} */
    function setDropdownStatushubungankeluarga(penjamin_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setDropdownStatushubungankeluarga'); ?>',
            data: {
                penjamin_id: penjamin_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, "hubkeluarga"); ?>").html(data.statushubungankeluarga);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * menampilkan karcis berdasarkan index form
     */
    function setKarcis() {
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();
        var penjamin_id = $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").val();
        var ruangan_id = $("#form-pemeriksaan").find('input[name$="[ruangan_id]"]').val();
        var kelaspelayanan_id = $("#form-pemeriksaan").find('select[name$="[kelaspelayanan_id]"]').val();

        console.log("penjaminnya punya id " + penjamin_id);
        console.log("penjaminnya kosong? " + (penjamin_id == ""));

        if (ruangan_id !== "" && kelaspelayanan_id !== "" && penjamin_id !== "" && penjamin_id !== null) {
            $("#form-karcis").addClass("animation-loading");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SetKarcis'); ?>',
                data: {
                    kelaspelayanan_id: kelaspelayanan_id,
                    ruangan_id: ruangan_id,
                    penjamin_id: penjamin_id,
                    pasien_id: pasien_id
                }, //
                dataType: "json",
                success: function(data) {
                    $("#form-karcis #content-karcis-html").html(data.listKarcis);
                    $("#form-karcis").removeClass("animation-loading");
                    $("form").find('.integer-decimal').each(function() {
                        $(this).val(formatThousandDecimal($(this).val()));
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            $("#form-karcis").find("#content-karcis-html").html("");
        }

    }

    /**
     * pilih karcis (check - uncheck)
     * harus pilih salah satu
     */
    function pilihKarcis(obj) {
        var is_pilihtindakan = $(obj).parents('tr').find('input[name$="[is_pilihkarcis]"]');
        /*
        $(obj).parents('table').find('tr').each(function(){
            $(this).find('input[name$="[is_pilihkarcis]"]').val(0);
            $(this).removeClass('checked');
        });
        */
        if (is_pilihtindakan.val() > 0) {
            is_pilihtindakan.val(0);
            $(obj).parents('tr').removeClass('checked');
            $(obj).find('i').removeClass('icon-form-check');
            $(obj).find('i').addClass('icon-form-silang');
        } else {
            is_pilihtindakan.val(1);
            $(obj).parents('tr').addClass('checked');
            $(obj).find('i').removeClass('icon-form-silang');
            $(obj).find('i').addClass('icon-form-check');
        }
    }

    /**
     * menampilkan form verifikasi
     * @returns {undefined}
     */
    function setVerifikasi() {

        var total = $("#form-tindakanpemeriksaan table tbody tr").length;

        // if (total == 0) {
        //     myAlert("Silakan pilih pemeriksaan radiologi!");
        //     return false;
        // }

        if (cekValidasiRiwayatVaksinasi != null) {
            if (!cekValidasiRiwayatVaksinasi()) {
                return false;
            }
        }

        if (requiredCheck($(".form_pendaftaran"))) {
            
            $(".form_pendaftaran").find('.integer-decimal, .float, .integer').each(function() {
                $(this).val(unformatNumber($(this).val()));
            });
            $('#dialog-verifikasi').dialog("open");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('verifikasi'); ?>',
                data: $("form").serialize(),
                dataType: "json",
                success: function(data) {
                    $('#dialog-verifikasi > .dialog-content').html(data.content);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            //untuk verifikasi hilangkan srbac loading
            $(".animation-loading").removeClass("animation-loading");
            $(".form_pendaftaran").find('.float').each(function() {
                $(this).val(formatFloat($(this).val()));
            });
            $(".form_pendaftaran").find('.integer').each(function() {
                $(this).val(formatInteger($(this).val()));
            });
            $(".form_pendaftaran").find('.integer-decimal').each(function() {
                $(this).val(formatThousandDecimal($(this).val()));
            });
        }
        return false;
    }

    function setVerifikasi2() {

        var total = $("#form-tindakanpemeriksaan table tbody tr").length;

        // if (total == 0) {
        //     myAlert("Silakan pilih pemeriksaan radiologi!");
        //     return false;
        // }

        if (cekValidasiRiwayatVaksinasi != null) {
            if (!cekValidasiRiwayatVaksinasi()) {
                return false;
            }
        }

        if (requiredCheck($(".form_pendaftaran"))) {
            
            // if ($(".is_adapjpasien").val() != 1){
                // return true;
                // myAlert("Penanggung jawab pasien harus diisi.");
                // return false;
            // }

            $(".form_pendaftaran").find('.integer-decimal, .float, .integer').each(function() {
                $(this).val(unformatNumber($(this).val()));
            });
            $('#dialog-verifikasi').dialog("open");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('verifikasi'); ?>',
                data: $("form").serialize(),
                dataType: "json",
                success: function(data) {
                    $('#dialog-verifikasi > .dialog-content').html(data.content);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            //untuk verifikasi hilangkan srbac loading
            $(".animation-loading").removeClass("animation-loading");
            $(".form_pendaftaran").find('.float').each(function() {
                $(this).val(formatFloat($(this).val()));
            });
            $(".form_pendaftaran").find('.integer').each(function() {
                $(this).val(formatInteger($(this).val()));
            });
            $(".form_pendaftaran").find('.integer-decimal').each(function() {
                $(this).val(formatThousandDecimal($(this).val()));
            });
        }
        return false;
    }

    /**
     * tombol batal pada dialogbox
     * @param {type} dialog_id
     * @returns {undefined}
     */
    function batalDialog(dialog_id) {
        myConfirm("Apakah Anda yakin akan membatalkan ini?", "Perhatian!", function(r) {
            if (r) {
                $('#' + dialog_id).dialog("close");
            }
        });
    }
    /**
     * refresh daftar pasien rj
     * @returns {Boolean} */
    function refreshDaftarPasien() {
        $.fn.yiiGridView.update('pendaftarterakhir-rj-grid', {
            data: $(this).serialize()
        });
        return false;
    }
    /**
     * set tabel riwayat kunjungan pasien
     * @param {type} pasien_id
     * @returns {undefined} */
    function setRiwayatKunjunganPasien(pasien_id) {
        $("#content-riwayatpasien > .accordion-inner").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetRiwayatKunjunganPasien'); ?>',
            data: {
                pasien_id: pasien_id
            },
            dataType: "json",
            success: function(data) {
                $("#content-riwayatpasien > .accordion-inner").html(data.table);
                $("#content-riwayatpasien > .accordion-inner").removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * update (refresh) checklist pemeriksaan lab
     * harus include /js/jquery.tiler.js
     * @param {obj} form_checklist
     */
    function updateChecklistPemeriksaanRad() {

        $('#dialog-pilihpemeriksaan .dialog-content').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetChecklistPemeriksaanRad'); ?>',
            data: {
                data: $("#form-caripemeriksaan :input").serialize()
            },
            dataType: "json",
            success: function(data) {
                $('#dialog-pilihpemeriksaan .dialog-content').html(data.content);
                $('.checkboxlist-tile').tile({
                    widths: [256]
                });
                $('#dialog-pilihpemeriksaan .dialog-content').removeClass("animation-loading");
                // setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"), $('#dialog-pilihpemeriksaan .dialog-content'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Set checklist pemeriksaan lab
     * obj = div yang berisi elemen ruangan_id, kelaspelayanan_id
     */
    function setChecklistPemeriksaanRad(obj) {
        var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
        var ruangan_id = $(obj).find("input[name$='[ruangan_id]']").val();
        var kelaspelayanan_id = $(obj).find("select[name$='[kelaspelayanan_id]']").val();
        if (penjamin_id == "") {
            myAlert("Silakan pilih penjamin!");
        } else if (kelaspelayanan_id == "") {
            myAlert("Silakan pilih kelas pelayanan!");
        } else {
            $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
            $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
            $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
            updateChecklistPemeriksaanRad();
            $('#dialog-rad').dialog('open');

        }
    }
    /**
     * reset pencarian & checklist pemeriksaan lab
     */
    function setChecklistPemeriksaanRadReset() {
        $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function() {
            $(this).val("");
        });
        updateChecklistPemeriksaanRad();
    }
    /**
     * Centang pemeriksaan rad dari checkboxlist
     */
    function pilihPemeriksaanIni(obj) {
        console.log('pilih pemeriksaan');
        var pemeriksaanrad_id = $(obj).parent().find('.pemeriksaanrad_id').val();
        var pemeriksaanrad_nama = $(obj).parent().find('.pemeriksaanrad_nama').val();
        var jenispemeriksaanrad_nama = $(obj).parent().find('.jenispemeriksaanrad_nama').val();
        var daftartindakan_id = $(obj).parent().find('.daftartindakan_id').val();
        var jenistarif_id = $(obj).parent().find('.jenistarif_id').val();
        var harga_tariftindakan = $(obj).parent().find('.harga_tariftindakan').val();
        var rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowTindakanPemeriksaan', array('modTindakan' => $modTindakan), true)); ?>';
        // if ($(obj).is(':checked')) {
            $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanrad_id]"]').val(pemeriksaanrad_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
            $("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanrad_nama]"]').html(pemeriksaanrad_nama);
            $("#form-tindakanpemeriksaan").find('span[name$="[ii][jenispemeriksaanrad_nama]"]').html(jenispemeriksaanrad_nama);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(formatInteger(harga_tariftindakan));
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
        // } else {
        //     var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanrad_id]"][value="' + pemeriksaanrad_id + '"]').parents('tr');
        //     delete_row.detach();
        // }
        var tanggal_tindakan = $('#ROPendaftaranT_tgl_tindakan').val();
        $('.tgl_tindakan').each(function () {

            $(this).val(tanggal_tindakan);

        });
        $('#dialog-rad').dialog('close');
        renameInputRow($("#form-tindakanpemeriksaan"));
    }

    function setElektif(){

        var jml = "0";

        $('.is_elektif_row').each(function () {
            if($(this).prop('checked')) {
                jml = "1";
                console.log('tercek');
            } else {
                console.log('gak tercek');
            }
            console.log($(this).prop('checked'));
        });

        $('#is_elektif_kirim').val(jml);

    }

   
    function deletePemeriksaan(obj){
        myConfirm('Apakah Anda yakin akan membatalkan pemeriksaan tersebut?', 'Perhatian!', function(r) {
            if(r) {
                $(obj).parents('tr').detach();
                updateChecklistPemeriksaanRad();
            } else {
                return false;
            }
        });
    }

                    

    function pilihPemeriksaanIniDialogPaket(id) {

var pasienkirimkeunitlain_id = '<?php //echo $modKunjungan->pasienkirimkeunitlain_id; ?>';

$.post('<?php echo $this->createUrl('tambahTarifTindakanPaket'); ?>', {
    tipepaket_id: id,
    pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
}, function(data) {
    $("#form-tindakanpemeriksaan table > tbody").append(data.rows);
    renameInputRow($("#form-tindakanpemeriksaan"));
}, 'json');

}

    /**
     * Set No Kartu Asuransi Pasien
     */
    function setNoKartuAsuransi() {
        var nopeserta = $("input[name$='[nopeserta]']").val();
        $("input[name$='[nokartuasuransi]']").val(nopeserta);
    }

    function setAsuransiLama() {
        $(".judulasuransi").html("Asuransi Lama");
        $(".refreshasuransi").attr("style", "display:true;");
    }
    /**
     * load otomatis asuransi pasien terakhir
     * @returns {undefined}
     */
    function setAsuransiPasienLama(pasien_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAsuransiPasienLama'); ?>',
            data: {
                pasien_id: pasien_id
            },
            dataType: "json",
            success: function(data) {
                if (data.penjamin_nama != '') {
                    myConfirm("Apakah pasien ini akan menggunakan penjamin " + data.penjamin_nama + "?", "Konfirmasi!", function(r) {
                        if (r) {
                            setFormAsuransi(data.carabayar_id);
                            $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val(data.carabayar_id);
                            $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").html(data.listPenjamin);
                            $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").val(data.penjamin_id);
                            //					belum ada form bpjs
                            //						if(data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?>){
                            //							getAsuransiNoKartu(data.nopeserta);
                            //						}else{
                            if ((data.carabayar_id == <?php echo Params::CARABAYAR_ID_BADAK; ?>) || (data.carabayar_id == <?php echo Params::CARABAYAR_ID_DEP_BADAK; ?>) || (data.carabayar_id == <?php echo Params::CARABAYAR_ID_PEKERJA; ?>)) {
                                setAsuransiBadak(data);
                            } else {
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nopeserta') ?>").val(data.nopeserta);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') ?>").val(data.nokartuasuransi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namaperusahaan') ?>").val(data.namaperusahaan);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'status_konfirmasi') ?>").val(data.status_konfirmasi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'tgl_konfirmasi') ?>").val(data.tgl_konfirmasi);
                            }

                            //						}

                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    <?php
    if (empty($modPasienAdmisi)) {
    ?>

        function cekAsuransi() {
            var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
            var pasien_id = $("#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>").val();

            if (pasien_id == "") {
                myAlert('Masukan terlebih dahulu data pasien!');
            } else if (penjamin_id == "") {
                myAlert('Masukan terlebih dahulu penjamin!');
            } else {
                $.fn.yiiGridView.update('asuransi-m-grid', {
                    data: {
                        "<?php echo get_class($modAsuransiPasien); ?>[pasien_id]": pasien_id,
                        "<?php echo get_class($modAsuransiPasien); ?>[penjamin_id]": penjamin_id,
                    }
                });
                $("#dialogAsuransi").dialog('open');
            }
            return false;
        }
    <?php } ?>

    /**
     * rename input row yang terakhir di tambahkan
     * @param {type} obj_table
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                var new_name = $(this).attr("name").replace("ii", (row));
                $(this).attr("name", new_name);
            });
            $(this).find('span[name$="[pemeriksaanrad_nama]"]').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 2) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[1] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }
    /**
     * set checked pemeriksaan yang sudah ada di daftar
     */
    function setCheckedPemeriksaan(obj_table, obj_dialog) {
        $(obj_table).find('input[name$="[pemeriksaanrad_id]"]').each(function() {
            var pemeriksaanrad_id = $(this).val();
            $(obj_dialog).find('input[name$="[is_pilih]"][value=' + pemeriksaanrad_id + ']').attr('checked', true);
        });

    }

    /**
     * hitung tarif tindakan RND-4169
     */
    function hitungTotal(obj) {
        unformatNumberSemua();
        var qty = $(obj).val();
        var str = $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val();
        var harga = str.replace(/[^\w\s]/gi, '');
        var subTotal = 0;

        subTotal = parseInt(harga * qty);
        if ($.isNumeric(subTotal)) {
            $(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(formatNumber(subTotal));
        }

        formatNumberSemua();
    }

    /**
     * print kartu pasien
     */
    function printKartuPasien(pasien_id) {
        window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien'); ?>&pasien_id=' + pasien_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
    /**
     * print status
     */
    function printStatus(pendaftaran_id) {
        window.open('<?php echo Yii::app()->createUrl('/rawatJalan/tindakan/printTindakan'); ?>&id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=720,height=640');
    }

    /**
     * untuk refresh / reset form pegawai
     * @returns {undefined}
     */
    function setPegawaiReset() {
        $("#<?php echo CHtml::activeId($modPasien, 'pegawai_penanggungjawab_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'nomorindukpegawai') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'nama_pegawai') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'gelardepan') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'gelarbelakang_nama') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'unit_perusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'jabatan_nama') ?>").val("");
    }

    /**
     * untuk print otomatis */
    function autoPrint() {
        window.scrollBy(0, 10000);
        <?php if (Yii::app()->user->getState('printkartulsng') == TRUE) { ?>
            window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien', array('pasien_id' => $model->pasien_id)); ?>', '', 'left=100,top=100,width=480,height=640');
        <?php  } ?>
        <?php if (Yii::app()->user->getState('printkunjunganlsng') == TRUE) { ?>
            window.open('<?php echo Yii::app()->createUrl('/rawatJalan/tindakan/printTindakan', array('id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=720,height=640');
        <?php  } ?>
    }

    /**
     * javascript yang di running setelah halaman ready / load sempurna
     * posisi script ini harus tetap dibawah
     */
    $(document).ready(function() {
        setUmur($("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir'); ?>").val());
        renameInputRow($("#form-tindakanpemeriksaan-0"));
        renameInputRow($("#form-tindakanpemeriksaan-1"));
        setInputWilayah();
        $(".rb_rm").eq(1).click();
        <?php if (!$model->isNewRecord) { ?>
            checkOto();
            autoPrint();
            $("input, select, textarea").attr("disabled", true);
        <?php } else { ?>
            $(".rb_rm").eq(1).click();
        <?php } ?>

        $("#btn_hak_pasien").on('click', setHakPasien);
    });

    function setHakPasien(e) {
        e.preventDefault();
        $("#dialog-hak-pasien").dialog("open");
    }

    function setInputBerdasarkanNoKTP() {
        var jenis = $('#<?php echo CHtml::activeId($modPasien, 'jenisidentitas'); ?>').val();
        var no_ktp = $('#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>').val();


        if (otoval != 1 || jenis != 'KTP') {
            return false;
        }

        //$('#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>').addClass("animation-loading");

        $.post('<?php echo $this->createUrl('inputDariNoKTP'); ?>', {
            no_ktp: no_ktp
        }, function(data) {
            $('#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir'); ?>').val(data.tanggal_lahir_format);
            setJenisKelaminPasien(data.jeniskelamin);
            if (data.propinsi_id != null && data.kabupaten_id != null && data.kecamatan_id != null) {
                setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, null);
            }
            setUmur(data.tanggal_lahir);
            //$('#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>').removeClass("animation-loading");
        }, 'json');

    }


    var input_propinsi = $("<?php echo "#" . CHtml::activeId($modPasien, 'propinsi_id'); ?>");
    var input_kabupaten = $("<?php echo "#" . CHtml::activeId($modPasien, 'kabupaten_id'); ?>");
    var input_kecamatan = $("<?php echo "#" . CHtml::activeId($modPasien, 'kecamatan_id'); ?>");
    var input_kelurahan = $("<?php echo "#" . CHtml::activeId($modPasien, 'kelurahan_id'); ?>");

    function setInputWilayah() {

        jQuery(input_propinsi).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                setClearDropdownKelurahan();
                setClearDropdownKecamatan();
                $.post('<?php echo $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))) ?>', {
                    "ROPasienM": {
                        propinsi_id: $(input_propinsi).val()
                    }
                }, function(data) {
                    $(input_kabupaten).html(data);
                    $(input_kabupaten).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kabupaten).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                setClearDropdownKelurahan();
                $.post('<?php echo $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))) ?>', {
                    "ROPasienM": {
                        kabupaten_id: $(input_kabupaten).val()
                    }
                }, function(data) {
                    $(input_kecamatan).html(data);
                    $(input_kecamatan).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kecamatan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                $.post('<?php echo $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))) ?>', {
                    "ROPasienM": {
                        kecamatan_id: $(input_kecamatan).val()
                    }
                }, function(data) {
                    $(input_kelurahan).html(data);
                    $(input_kelurahan).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kelurahan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();


    }

    function setPenanggungjawabPS() {

        if ($('.pp_sb').is(':checked')) {

            setDataPJP();
        } else {
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'pengantar') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>").prop('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'hubungankeluarga') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val('');

        }
    }

    function setDataPJP() {

        var pasien_id = $('#ROPasienM_pasien_id').val();

        if (pasien_id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GetPJPasien'); ?>',
                data: {
                    pasien_id: pasien_id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'pengantar') ?>").val(data.pengantar);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val(data.nama_pj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>").prop(data.jeniskelamin);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val(data.jenisidentitas);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val(data.no_identitas);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val(data.no_teleponpj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val(data.no_mobilepj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'hubungankeluarga') ?>").val(data.hubungankeluarga);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val(data.tempatlahir_pj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val(data.tgllahir_pj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val(data.alamat_pj);
                        setUmurPjp(data.tgllahir_pj);
                        setJenisKelaminPasien(data.jeniskelamin);
                    } else {
                        myAlert('Pasien balum memiliki penanggungjawab sebelumnya')
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    myAlert('ERORR');
                }
            });
        }

    }

    $('input:radio[name="rb_rm"]').change(
        function() {
            if ($(this).is(':checked') && $(this).val() == '1') {
                $('.pj_sb').hide()
            } else {
                $('.pj_sb').show()
            }
        });

    $(document).ready(function() {
        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
        /**
         * multi select cara bayar dan penjamin
         */

        jQuery(cara).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
                var v = $(element).val();

                var brands = cara_all;
                var selected = [];

                cekCaraBayarBadak(v);
                setFormAsuransi(v);
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjaminan);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = '';


                penj.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
        }).hide();

        jQuery(penj).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {

                var v = $(element).val();

                setKarcis(0);
                setKarcis(1);
                setAsuransiBadak(v);
                cekValiditasPenjamin(v);
            }
        }).hide();


    });

    function printLabel() {
        window.open('<?php echo $this->createUrl('printLabel', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function cekAnakke() {
        var anakke = $('.anakke').val();
        var jumlah_saudara = $('.saudara').val();
        if (jumlah_saudara != '0') {
            if (anakke > jumlah_saudara) {
                myAlert("Jumlah Anak ke, tidak boleh lebih besar dari jumlah bersaudara");
                $('.anakke').focus();
            }
        } 
    }
    function cekAnakke2() {
        var anakke = $('.anakke').val();
        var jumlah_saudara = $('.saudara').val();
        if (jumlah_saudara > 0) {
            if (parseInt(anakke) > parseInt(jumlah_saudara)) {
                myAlert("Jumlah Anak ke, tidak boleh lebih besar dari jumlah bersaudara");
                $('.anakke').focus();
            }
        } 
    }
</script>