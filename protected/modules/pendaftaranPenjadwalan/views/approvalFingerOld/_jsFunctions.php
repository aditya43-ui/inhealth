<script type="text/javascript">
    /**
     * fungsi BPJS
     */

    function printSEP() {
        window.open('<?php echo $this->createUrl('printSep', array('sep_id' => null)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

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
        $("#form-infopasien > legend > .judul").html('Data Pasien');
        $("#form-infopasien > legend > .tombol").attr('style', 'display:none;');
        $("#form-infopasien > .well").addClass("box").removeClass("well");
    }

    function refreshDialogInfoPasien() {
        var instalasi_id = $("#instalasi_id").val();
        var instalasi_nama = $("#instalasi_id option:selected").text();
        $.fn.yiiGridView.update('datakunjungan-grid', {
            data: {
                "ARPasienM[instalasi_id]": instalasi_id,
            }
        });
    }

    /**
     * set form info pasien
     * @returns {undefined}
     */
    function setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id) {
        $("#form-infopasien > div").addClass("animation-loading");
        var instalasi_id = $("#instalasi_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
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
                if (data.photopasien === null || data.photopasien === "") { //set photo
                    $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                } else {
                    $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                }

                $("#form-infopasien > legend > .judul").html('Data Pasien ' + data.no_pendaftaran);
                $("#form-infopasien > legend > .tombol").attr('style', 'display:true;');
                $("#form-infopasien > .box").addClass("well").removeClass("box");

                $("#ARPengajuanapprovalsepT_no_kartu_bpjs").val(data.no_kartu);

                $("#form-infopasien > div").removeClass("animation-loading");
                $("#nama_pasien").focus();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data kunjungan tidak ditemukan !");
                console.log(errorThrown);
                setInfoPasienReset();
                $("#form-infopasien > div").removeClass("animation-loading");
                $("#instalasi_id").focus();
            }
        });
    }

    function setLakaLantas(ojb) {
        if ($(ojb).val() == 1) {
            $("#ARPengajuanapprovalsepT_penjamin").addClass("required");
            $("#ARPengajuanapprovalsepT_lokasilakalantas").attr('readonly', false);
            $("#ARPengajuanapprovalsepT_penjamin").attr('disabled', false);
        } else {
            $("#ARPengajuanapprovalsepT_lokasilakalantas").attr('readonly', true);
            $("#ARPengajuanapprovalsepT_penjamin").attr('disabled', 'disabled');
            $("#ARPengajuanapprovalsepT_penjamin").removeClass("required");
            $("#ARPengajuanapprovalsepT_penjamin").removeClass("error");
            $("#ARPengajuanapprovalsepT_penjamin").parents(".control-group").removeClass("error");
            $("#ARPengajuanapprovalsepT_lokasilakalantas").val('');
            $("#ARPengajuanapprovalsepT_penjamin").val(null);
        }
    }



    function requiredCheck(obj) {
        var kosong = 0;
        $(obj).find('input,select,textarea').each(function() {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true) {
                $(this).parents(".control-group").removeClass("error").removeClass("success");
            }
        });
        $(obj).find('input,select,textarea').each(function() {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {
                if (($(this).val() === "")) {
                    if ($(this).is(":hidden")) { //untuk element type:hidden 
                        var radio_checked = false;
                        $(this).parent().find(".radio").each(function() { //mengecek element radio button
                            if ($(this).find("input").is(":checked")) {
                                radio_checked = true;
                            }
                        });
                        if (radio_checked == false) {
                            $(this).parents(".control-group").addClass("error");
                            $(this).addClass("error");
                            kosong++;
                        } else {
                            $(this).parents(".control-group").removeClass("error");
                            $(this).removeClass("error");
                        }
                    } else {
                        $(this).parents(".control-group").addClass("error");
                        $(this).addClass("error");
                        kosong++;
                    }
                } else {
                    $(this).parents(".control-group").removeClass("error");
                    $(this).removeClass("error");
                }
            }
        });
        if (kosong > 0) {
            window.parent.myAlert("Silahkan isi yang bertanda bintang !"); //("+kosong+" input)
            return false;
        } else {
            return true;
        }
    }

    function getAsuransiNoKartu(isi) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        /*
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        };*/
        var tanggal = $("#ApprovalfingerbpjsT_tgl_sep").val();
        var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu

        if (tanggal == null || tanggal == "") {
            myAlert("Tanggal dan Nomor Kartu harus diisi");
            return false;
        }

        if (isi == null || isi == "") {
            return false;
        }

        $("#ApprovalfingerbpjsT_noka_bpjs").addClass("animation-loading");

        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi + '&query2=' + tanggal,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
                $("#ApprovalfingerbpjsT_namapeserta_bpjs").val("");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);

                if (obj.metaData.code != 200) {
                    myAlert(obj.metaData.message);
                } else if (obj.response != null) {
                    var peserta = obj.response.peserta;
                    if (peserta.statusPeserta.keterangan == 'AKTIF') {

                        $("#<?php echo CHtml::activeId($model, 'no_kartu_bpjs') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($model, 'namapeserta_bpjs') ?>").val(peserta.nama);
                        $("#<?php echo CHtml::activeId($model, 'kelas_tanggungan') ?>").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'hakkelas_kode') ?>").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'notelpon_peserta') ?>").val(peserta.mr.noTelepon);
                        $("#<?php echo CHtml::activeId($model, 'kode_ppk_rujukan') ?>").val(peserta.provUmum.kdProvider);
                        $("#<?php echo CHtml::activeId($model, 'nama_ppk_rujukan') ?>").val(peserta.provUmum.nmProvider);
                        $("#<?php echo CHtml::activeId($model, 'jenispeserta_bpjs_kode') ?>").val(peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($model, 'jenispeserta_bpjs_nama') ?>").val(peserta.jenisPeserta.keterangan);
                        $("#<?php echo CHtml::activeId($model, 'no_asuransi_cob') ?>").val(peserta.cob.noAsuransi);
                        $("#<?php echo CHtml::activeId($model, 'nama_asuransi_cob') ?>").val(peserta.cob.nmAsuransi);
                        

                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function(a, i, m) {
                            return jQuery(a).text().toUpperCase()
                                .indexOf(m[3].toUpperCase()) >= 0;
                        };
                    } else {
                        myAlert(peserta.statusPeserta.keterangan);
                    }
                    cekDisabled('form');
                } else {
                    myAlert(obj.metadata.message);
                }

                $("#ApprovalfingerbpjsT_noka_bpjs").removeClass("animation-loading");
            },
            error: function(data) {
                $("#ApprovalfingerbpjsT_noka_bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function getRujukanNoRujukan(isi) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        };
        var jenis_rujukan = $('.input_jenisrujukan:checked').val();
        var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Nomor rujukan
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi + '&jenis_rujukan=' + jenis_rujukan,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.metaData.code == '201') {
                    myAlert(obj.metaData.message);
                } else {
                    if (obj.response != null) {
                        var rujukan = obj.response.rujukan;
                        $("#<?php echo CHtml::activeId($model, 'no_kartu_bpjs') ?>").val(rujukan.peserta.noKartu);
                        $("#<?php echo CHtml::activeId($model, 'namapeserta_bpjs') ?>").val(rujukan.peserta.nama);

                        $("#<?php echo CHtml::activeId($model, 'diagnosa_awal') ?>").val(rujukan.diagnosa.kode);
                        $("#<?php echo CHtml::activeId($model, 'diagnosa_awal_nama') ?>").val(rujukan.diagnosa.kode);
                        $("#<?php echo CHtml::activeId($model, 'no_rujukan') ?>").val(rujukan.noKunjungan);
                        $("#<?php echo CHtml::activeId($model, 'jenis_pelayanan') ?>").val(rujukan.pelayanan.kode);
                        $("#<?php echo CHtml::activeId($model, 'kelas_tanggungan') ?>").val(rujukan.peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'hakkelas_kode') ?>").val(rujukan.peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'kode_ppk_rujukan') ?>").val(rujukan.provPerujuk.kode);
                        $("#<?php echo CHtml::activeId($model, 'nama_ppk_rujukan') ?>").val(rujukan.provPerujuk.nama);
                        $("#<?php echo CHtml::activeId($model, 'tgl_rujukan') ?>").val(rujukan.tglKunjungan);
                        $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val(rujukan.poliRujukan.kode);
                        $("#<?php echo CHtml::activeId($model, 'politujuan_nama') ?>").val(rujukan.poliRujukan.nama);
                        $("#<?php echo CHtml::activeId($model, 'no_telepon_pasien') ?>").val(rujukan.peserta.mr.noTelepon);
                        $("#<?php echo CHtml::activeId($model, 'jenispeserta_bpjs_kode') ?>").val(rujukan.peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($model, 'jenispeserta_bpjs_nama') ?>").val(rujukan.peserta.jenisPeserta.keterangan);
                        $("#<?php echo CHtml::activeId($model, 'no_asuransi_cob') ?>").val(rujukan.peserta.cob.noAsuransi);
                        $("#<?php echo CHtml::activeId($model, 'nama_asuransi_cob') ?>").val(rujukan.peserta.cob.nmAsuransi);
                        if (rujukan.peserta.cob.nmAsuransi == null && rujukan.peserta.cob.noAsuransi == null) {
                            $("#<?php echo CHtml::activeId($model, 'cob') ?>").val(0);
                            $("#<?php echo CHtml::activeId($model, 'cob_status') ?>").val("TIDAK");
                        } else {
                            $("#<?php echo CHtml::activeId($model, 'cob') ?>").val(1);
                            $("#<?php echo CHtml::activeId($model, 'cob_status') ?>").val("YA");
                        }
                    } else {
                        myAlert(obj.metaData.message);
                    }
                    cekDisabled('form');
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function cekInput(obj, param) {
        var status = 0;
        var noTlp = $("#<?php echo CHtml::activeId($model, 'no_telepon_pasien') ?>").val();
        if (!requiredCheck("#assep-t-form")) {
            //        requiredCheck("#assep-t-form");
            return false;
        } else {
            status = 1;
        }

        if ($("#ApprovalfingerbpjsT_keterangan").val().length < 5) {
            myAlert("Keterangan yang diinput minimal 5 karakter.");
            return false;
        }
        
        $("#assep-t-form").submit();
    }

    function cekInputSep(obj, param) {
        var status = 0;
        var noTlp = $("#<?php echo CHtml::activeId($model, 'no_telepon_pasien') ?>").val();
        if (!requiredCheck("#assep-t-form")) {
            //        requiredCheck("#assep-t-form");
        } else {
            status = 1;
        }
        if (status == 1 && noTlp.length < 6) {
            myAlert("No Telepon Minimal 8 Digit");
        } else if (noTlp.length < 6) {
            status = 0;
        } else if (status == 1 && noTlp.length >= 6) {
            status = 1;
        }

        var noMR = $('#no_rekam_medik').val();
        var noKartu = $("#<?php echo CHtml::activeId($model, 'no_kartu_bpjs') ?>").val();
        var noSep = $("#<?php echo CHtml::activeId($model, 'no_sep') ?>").val();
        var tglSep = $("#<?php echo CHtml::activeId($model, 'tgl_sep') ?>").val();
        var ppkPelayanan = $("#<?php echo CHtml::activeId($model, 'kode_ppk_pelayanan') ?>").val();
        var jnsPelayanan = $("#<?php echo CHtml::activeId($model, 'jenis_pelayanan') ?>").val();
        var hakkelas = parseInt($("#<?php echo CHtml::activeId($model, 'hakkelas_kode') ?>").val());
        var klsRawat = parseInt($("#<?php echo CHtml::activeId($model, 'kelas_tanggungan') ?>").val());
        if (klsRawat >= hakkelas) {
            var klsRawat = klsRawat;
        } else {
            var klsRawat = hakkelas;
        }
        //    var klsRawat = $("#<?php // echo CHtml::activeId($model, 'kelas_tanggungan') 
                                    ?>").val();
        var asalRujukan = $('input:radio[name="ARPengajuanapprovalsepT[jenisrujukan]"]:checked').val();
        var tglRujukan = $("#<?php echo CHtml::activeId($model, 'tgl_rujukan') ?>").val();
        var noRujukan = $("#<?php echo CHtml::activeId($model, 'no_rujukan') ?>").val();
        var ppkRujukan = $("#<?php echo CHtml::activeId($model, 'kode_ppk_rujukan') ?>").val();
        var catatan = $("#<?php echo CHtml::activeId($model, 'catatan') ?>").val();
        var diagAwal = $("#<?php echo CHtml::activeId($model, 'diagnosa_awal') ?>").val();
        var tujuan = $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val();
        var eksekutif = $('input:radio[name="ARPengajuanapprovalsepT[poli_eksekutif]"]:checked').val();
        var cob = $("#<?php echo CHtml::activeId($model, 'cob') ?>").val();
        var lakaLantas = $('input:radio[name="ARPengajuanapprovalsepT[lakalantas]"]:checked').val();
        var penjamin = $("#<?php echo CHtml::activeId($model, 'penjamin') ?>").val();
        var lokasiLaka = $("#<?php echo CHtml::activeId($model, 'lokasilakalantas') ?>").val();
        var noTelp = $("#<?php echo CHtml::activeId($model, 'no_telepon_pasien') ?>").val();
        var user = $("#<?php echo CHtml::activeId($model, 'userpembuat_bpjs') ?>").val();
        var tglPulang = $("#<?php echo CHtml::activeId($model, 'tanggalpulang_sep') ?>").val();

        if (status == 1) {
            var setting = {
                url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
                type: 'GET',
                dataType: 'html',
                data: 'param=' + param + '&noMR=' + noMR + '&noKartu=' + noKartu + '&tglSep=' + tglSep + '&ppkPelayanan=' + ppkPelayanan + '&jnsPelayanan=' + jnsPelayanan + '&klsRawat=' + klsRawat + '&asalRujukan=' + asalRujukan + '&tglRujukan=' + tglRujukan + '&noRujukan=' + noRujukan + '&ppkRujukan=' + ppkRujukan + '&catatan=' + catatan + '&diagAwal=' + diagAwal + '&tujuan=' + tujuan + '&eksekutif=' + eksekutif + '&cob=' + cob + '&lakaLantas=' + lakaLantas + '&penjamin=' + penjamin + '&lokasiLaka=' + lokasiLaka + '&noTelp=' + noTelp + '&user=' + user + '&penjamin=' + penjamin + '&noSep=' + noSep + '&tglPulang=' + tglPulang,
                beforeSend: function() {
                    $("#content-bpjs").addClass("animation-loading");
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.metaData.code != '200') {
                        myAlert(obj.metaData.code + ' - ' + obj.metaData.message);
                    } else {
                        if (obj.response != null) {
                            var sep = obj.response.sep;
                            $("#<?php echo CHtml::activeId($model, 'no_sep') ?>").val(sep.noSep);
                            $("#assep-t-form").submit();
                        }
                    }
                    $("#content-bpjs").removeClass("animation-loading");
                },
                error: function(data) {
                    $("#content-bpjs").removeClass("animation-loading");
                }
            }
            if (typeof ajax_request !== 'undefined')
                ajax_request.abort();
            ajax_request = $.ajax(setting);
        }
    }

    function approve(obj, param) {

        var noKartu = $("#<?php echo CHtml::activeId($model, 'no_kartu_bpjs') ?>").val();
        var tglSep = $("#<?php echo CHtml::activeId($model, 'tgl_sep') ?>").val();
        var jnsPelayanan = $("#<?php echo CHtml::activeId($model, 'jenis_pelayanan') ?>").val();
        var catatan = $("#<?php echo CHtml::activeId($model, 'catatan') ?>").val();
        var user = $("#<?php echo CHtml::activeId($model, 'user_approval_bpjs') ?>").val();

        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + param + '&noKartu=' + noKartu + '&tglSep=' + tglSep + '&jnsPelayanan=' + jnsPelayanan + '&catatan=' + catatan + '&user=' + user,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.metaData.code != '200') {
                    myAlert(obj.metaData.message);
                } else {
                    if (obj.response != null) {
                        $("#approve-t-form").submit();
                    }
                }
                $("#content-bpjs").removeClass("animation-loading");
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }
        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    $(document).ready(function() {
        setLakaLantas($('input:radio[name="ARSepT[is_lakalantas]"]:checked'));
    });
</script>