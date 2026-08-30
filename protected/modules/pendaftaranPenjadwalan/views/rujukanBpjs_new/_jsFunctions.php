<script type="text/javascript">
    // FORM PENCARIAN FKTL
    $("#pencarian-rujukan-bpjs-form .btn-nomorrujukan_fktl").attr('disabled', true);
    $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktl").attr('disabled', true);
    $("#pencarian-rujukan-bpjs-form .btn-tglrujukan_fktl").attr('disabled', true);

    function setPencarianFktl(obj) {
        if ($(obj).val() == 'radio_nomorrujukan_fktl') {
            $('#radio_nomorrujukan_fktl').attr('checked', true);
            $('#radio_nomorkartu_fktl').attr('checked', false);
            $('#radio_tglrujukan_fktl').attr('checked', false);

            $('#nomorrujukan_fktl').removeAttr('disabled', true);
            $('#nomorkartupeserta_fktl').attr('disabled', true);
            $('#tglrujukan_fktl').attr('disabled', true);

            $("#pencarian-rujukan-bpjs-form .btn-nomorrujukan_fktl").removeAttr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktl").attr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-tglrujukan_fktl").attr('disabled', true);

            $('#nomorkartupeserta_fktl').val('');
            $('#tglrujukan_fktl').val('');
            clearDataPeserta();
        } else if ($(obj).val() == 'radio_nomorkartu_fktl') {
            $('#radio_nomorrujukan_fktl').attr('checked', false);
            $('#radio_nomorkartu_fktl').attr('checked', true);
            $('#radio_tglrujukan_fktl').attr('checked', false);

            $('#nomorrujukan_fktl').attr('disabled', true);
            $('#nomorkartupeserta_fktl').removeAttr('disabled', true);
            $('#tglrujukan_fktl').attr('disabled', true);

            $("#pencarian-rujukan-bpjs-form .btn-nomorrujukan_fktl").attr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktl").removeAttr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-tglrujukan_fktl").attr('disabled', true);

            $('#nomorrujukan_fktl').val('');
            $('#tglrujukan_fktl').val('');
            clearDataPeserta();
        } else if ($(obj).val() == 'radio_tglrujukan_fktl') {
            $('#radio_nomorrujukan_fktl').attr('checked', false);
            $('#radio_nomorkartu_fktl').attr('checked', false);
            $('#radio_tglrujukan_fktl').attr('checked', true);

            $('#nomorrujukan_fktl').attr('disabled', true);
            $('#nomorkartupeserta_fktl').attr('disabled', true);
            $('#tglrujukan_fktl').removeAttr('disabled', true);

            $("#pencarian-rujukan-bpjs-form .btn-nomorrujukan_fktl").attr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktl").attr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-tglrujukan_fktl").removeAttr('disabled', true);

            $('#nomorrujukan_fktl').val('');
            $('#nomorkartupeserta_fktl').val('');
            clearDataPeserta();
        }
    }

    function setPencarianFktl_1(obj) {
        $('#radio_nomorkartu_fktl_1').attr('checked', true);

        $('#nomorkartupeserta_fktl_1').removeAttr('disabled', true);

        $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktl_1").removeAttr('disabled', true);

        clearDataPeserta();
    }

    // FORM PENCARIAN FKTP
    $("#pencarian-rujukan-bpjs-form .btn-nomorrujukan_fktp").attr('disabled', true);
    $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktp").attr('disabled', true);
    $("#pencarian-rujukan-bpjs-form .btn-tglrujukan_fktp").attr('disabled', true);

    function setPencarianFktp(obj) {
        if ($(obj).val() == 'radio_nomorrujukan_fktp') {
            $('#radio_nomorrujukan_fktp').attr('checked', true);
            $('#radio_nomorkartu_fktp').attr('checked', false);
            $('#radio_tglrujukan_fktp').attr('checked', false);

            $('#nomorrujukan_fktp').removeAttr('disabled', true);
            $('#nomorkartupeserta_fktp').attr('disabled', true);
            $('#tglrujukan_fktp').attr('disabled', true);

            $("#pencarian-rujukan-bpjs-form .btn-nomorrujukan_fktp").removeAttr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktp").attr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-tglrujukan_fktp").attr('disabled', true);

            $('#nomorkartupeserta_fktp').val('');
            $('#tglrujukan_fktp').val('');
            clearDataPeserta();
        } else if ($(obj).val() == 'radio_nomorkartu_fktp') {
            $('#radio_nomorrujukan_fktp').attr('checked', false);
            $('#radio_nomorkartu_fktp').attr('checked', true);
            $('#radio_tglrujukan_fktp').attr('checked', false);

            $('#nomorrujukan_fktp').attr('disabled', true);
            $('#nomorkartupeserta_fktp').removeAttr('disabled', true);
            $('#tglrujukan_fktp').attr('disabled', true);

            $("#pencarian-rujukan-bpjs-form .btn-nomorrujukan_fktp").attr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktp").removeAttr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-tglrujukan_fktp").attr('disabled', true);

            $('#nomorrujukan_fktp').val('');
            $('#tglrujukan_fktp').val('');
            clearDataPeserta();
        } else if ($(obj).val() == 'radio_tglrujukan_fktp') {
            $('#radio_nomorrujukan_fktp').attr('checked', false);
            $('#radio_nomorkartu_fktp').attr('checked', false);
            $('#radio_tglrujukan_fktp').attr('checked', true);

            $('#nomorrujukan_fktp').attr('disabled', true);
            $('#nomorkartupeserta_fktp').attr('disabled', true);
            $('#tglrujukan_fktp').removeAttr('disabled', true);

            $("#pencarian-rujukan-bpjs-form .btn-nomorrujukan_fktp").attr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktp").attr('disabled', true);
            $("#pencarian-rujukan-bpjs-form .btn-tglrujukan_fktp").removeAttr('disabled', true);

            $('#nomorrujukan_fktp').val('');
            $('#nomorkartupeserta_fktp').val('');
            clearDataPeserta();
        }
    }

    function setPencarianFktp_1(obj) {
        $('#radio_nomorkartu_fktp_1').attr('checked', true);
        $('#nomorkartupeserta_fktp_1').removeAttr('disabled', true);

        $("#pencarian-rujukan-bpjs-form .btn-nomorkartu_fktp_1").removeAttr('disabled', true);

        clearDataPeserta();
    }
    /**
     * fungsi pencarian Rujukan BPJS FKTP
     */
    function cariDataRujukanBpjsFktp(jenis) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var norujukan = $('#nomorrujukan_fktp').val();
        var nokartu = $('#nomorkartupeserta_fktp').val();
        var tglrujukan = $('#tglrujukan_fktp').val();

        if (jenis == 1) {
            var isi = norujukan;
            var aksi = 1; // 1 untuk mencari data rujukan berdasarkan Nomor Rujukan
            if (norujukan != '') {
                var alert = '';
            } else {
                var alert = 'Isi data Nomor Rujukan terlebih dahulu!';
            }
        } else if (jenis == 2) {
            var isi = nokartu;
            var aksi = 2; // 2 untuk mencari data rujukan berdasarkan Nomor Kartu Peserta
            if (nokartu != '') {
                var alert = '';
            } else {
                var alert = 'Isi data Nomor Kartu Peserta terlebih dahulu!';
            }
        } else {
            var isi = "";
            var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Tanggal Rujukan
            var alert = 'Isi data Tanggal Rujukan terlebih dahulu!';
        }

        if (isi == "") {
            myAlert(alert);
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('BpjsInterface_new'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#data-peserta").addClass("animation-loading");
                $('#data-fktp').addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktp').removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var rujukan = obj.response.rujukan;
                    if (obj.metaData.code == '201') {
                        myAlert(obj.metaData.message);
                    } else {
                        //Data Rujukan
                        $("#data-fktp #tglKunjungan").text(rujukan.tglKunjungan);
                        $("#data-fktp #noKunjungan").text(rujukan.noKunjungan);
                        $("#data-fktp #kdPoli").text(rujukan.poliRujukan.kode);
                        $("#data-fktp #nmPoli").text(rujukan.poliRujukan.nama);
                        $("#data-fktp #keluhan").text(rujukan.peserta.keluhan);
                        $("#data-fktp #nmDiag").text(rujukan.diagnosa.kode + '-' + rujukan.diagnosa.nama);
                        //					$("#pemFisikLain").text(peserta.pemFisikLain);
                        $("#catatan").text(rujukan.keluhan);
                        //End Data Rujukan
                        //Data Peserta
                        $("#noKartu").text(rujukan.peserta.noKartu);
                        $("#nama").text(rujukan.peserta.nama);
                        $("#tglLahir").text(rujukan.peserta.tglLahir);
                        $("#nik").text(rujukan.peserta.nik);
                        if (rujukan.peserta.sex == "P") {
                            $("#sex").text("Perempuan");
                        } else {
                            $("#sex").text("Laki-laki");
                        }
                        $("#kdProvider").text(rujukan.peserta.provUmum.kdProvider);
                        $("#nmProvider").text(rujukan.peserta.provUmum.nmProvider);
                        $("#kdCabang").text(rujukan.peserta.provUmum.kdProvider);
                        $("#nmCabang").text(rujukan.peserta.provUmum.nmProvider);
                        $("#kdKelas").text(rujukan.peserta.hakKelas.kode);
                        $("#nmKelas").text(rujukan.peserta.hakKelas.keterangan);
                        $("#kdJenisPeserta").text(rujukan.peserta.jenisPeserta.kode);
                        $("#nmJenisPeserta").text(rujukan.peserta.jenisPeserta.keterangan);
                        $("#keterangan").text(rujukan.peserta.statusPeserta.keterangan);
                        $("#tglCetakKartu").text(rujukan.peserta.tglCetakKartu);
                        $("#tglTAT").text(rujukan.peserta.tglTAT);
                        $("#tglTMT").text(rujukan.peserta.tglTMT);
                        $("#noMr").text(rujukan.peserta.noMr);
                        $("#umurSekarang").text(rujukan.peserta.umur.umurSekarang);
                        $("#umurSaatPelayanan").text(rujukan.peserta.umur.umurSaatPelayanan);
                        //End Data Peserta
                        $("#pencarian-rujukan-bpjs-form .btn-primary-blue").removeAttr('disabled', true);
                        $("#pencarian-rujukan-bpjs-form .btn-riwayat").removeAttr('disabled', true);
                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function(a, i, m) {
                            return jQuery(a).text().toUpperCase()
                                .indexOf(m[3].toUpperCase()) >= 0;
                        };
                    }
                } else {
                    if (obj.metaData.message == null) {
                        myAlert('Data Not Found');
                    } else {
                        myAlert(obj.metaData.message);
                    }
                }
            },
            error: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktp').removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function cariDataRujukanBpjsFktp_1(jenis) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var nokartu = $('#nomorkartupeserta_fktp_1').val();

        var isi = nokartu;
        var aksi = 6; // 6 untuk mencari data rujukan berdasarkan Nomor Kartu Peserta
        if (nokartu != '') {
            var alert = '';
        } else {
            var alert = 'Isi data Nomor Kartu Peserta terlebih dahulu!';
        }

        if (isi == "") {
            myAlert(alert);
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('BpjsInterface_new'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#data-peserta").addClass("animation-loading");
                $('#data-fktp').addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktp').removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var rujukan = obj.response.rujukan;
                    if (obj.metaData.code == '201') {
                        myAlert(obj.metaData.message);
                    } else {
                        var list = obj.response.rujukan;
                        $('#data-fktp_1').html('');
                        $('#data-peserta_1').html('');
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('setForm'); ?>',
                            data: {
                                rujukanList: list
                            }, //
                            dataType: "json",
                            success: function(data) {
                                $('#data-fktp_1').append(data.form);
                                $('#data-peserta_1').append(data.pasien);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                } else {
                    if (obj.metaData.message == null) {
                        myAlert('Data Not Found');
                    } else {
                        myAlert(obj.metaData.message);
                    }
                }
            },
            error: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktp').removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    /**
     * fungsi pencarian Rujukan RS BPJS FKTL
     */
    function cariDataRujukanBpjsFktl(jenis) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var norujukan = $('#nomorrujukan_fktl').val();
        var nokartu = $('#nomorkartupeserta_fktl').val();
        var tglrujukan = $('#tglrujukan_fktl').val();

        if (jenis == 1) {
            var isi = norujukan;
            var aksi = 4; // 4 untuk mencari data rujukan berdasarkan Nomor Rujukan
            if (norujukan != '') {
                var alert = '';
            } else {
                var alert = 'Isi data Nomor Rujukan terlebih dahulu!';
            }
        } else if (jenis == 2) {
            var isi = nokartu;
            var aksi = 5; // 5 untuk mencari data rujukan berdasarkan Nomor Kartu Peserta
            if (nokartu != '') {
                var alert = '';
            } else {
                var alert = 'Isi data Nomor Kartu Peserta terlebih dahulu!';
            }
        }

        if (isi == "") {
            myAlert(alert);
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('BpjsInterface_new'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#data-peserta").addClass("animation-loading");
                $('#data-fktl').addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktl').removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var rujukan = obj.response.rujukan;
                    if (obj.metaData.code == '201') {
                        myAlert(obj.metaData.message);
                    } else {
                        console.log("Kicker", rujukan);
                        //Data Rujukan
                        $("#data-fktl #noKunjungan").text(rujukan.tglKunjungan);
                        $("#data-fktl #noKunjungan").text(rujukan.noKunjungan);
                        $("#data-fktl #kdPoli").text(rujukan.poliRujukan.kode);
                        $("#data-fktl #nmPoli").text(rujukan.poliRujukan.nama);
                        $("#data-fktl #keluhan").text(rujukan.peserta.keluhan);
                        $("#data-fktl #nmDiag").text(rujukan.diagnosa.kode + '-' + rujukan.diagnosa.nama);
                        //					$("#pemFisikLain").text(peserta.pemFisikLain);
                        $("#data-fktl #catatan").text(rujukan.keluhan);
                        //End Data Rujukan
                        //Data Peserta
                        $("#noKartu").text(rujukan.peserta.noKartu);
                        $("#nama").text(rujukan.peserta.nama);
                        $("#tglLahir").text(rujukan.peserta.tglLahir);
                        $("#nik").text(rujukan.peserta.nik);
                        if (rujukan.peserta.sex == "P") {
                            $("#sex").text("Perempuan");
                        } else {
                            $("#sex").text("Laki-laki");
                        }
                        $("#kdProvider").text(rujukan.peserta.provUmum.kdProvider);
                        $("#nmProvider").text(rujukan.peserta.provUmum.nmProvider);
                        $("#kdCabang").text(rujukan.peserta.provUmum.kdProvider);
                        $("#nmCabang").text(rujukan.peserta.provUmum.nmProvider);
                        $("#kdKelas").text(rujukan.peserta.hakKelas.kode);
                        $("#nmKelas").text(rujukan.peserta.hakKelas.keterangan);
                        $("#kdJenisPeserta").text(rujukan.peserta.jenisPeserta.kode);
                        $("#nmJenisPeserta").text(rujukan.peserta.jenisPeserta.keterangan);
                        $("#keterangan").text(rujukan.peserta.statusPeserta.keterangan);
                        $("#tglCetakKartu").text(rujukan.peserta.tglCetakKartu);
                        $("#tglTAT").text(rujukan.peserta.tglTAT);
                        $("#tglTMT").text(rujukan.peserta.tglTMT);
                        $("#noMr").text(rujukan.peserta.noMr);
                        $("#umurSekarang").text(rujukan.peserta.umur.umurSekarang);
                        $("#umurSaatPelayanan").text(rujukan.peserta.umur.umurSaatPelayanan);
                        //End Data Peserta
                        $("#pencarian-rujukan-bpjs-form .btn-primary-blue").removeAttr('disabled', true);
                        $("#pencarian-rujukan-bpjs-form .btn-riwayat").removeAttr('disabled', true);
                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function(a, i, m) {
                            return jQuery(a).text().toUpperCase()
                                .indexOf(m[3].toUpperCase()) >= 0;
                        };
                    }
                } else {
                    if (obj.metaData.message == null) {
                        myAlert('Data Not Found');
                    } else {
                        myAlert(obj.metaData.message);
                    }
                }
            },
            error: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktl').removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function cariDataRujukanBpjsFktl_1(jenis) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var nokartu = $('#nomorkartupeserta_fktl_1').val();

        var isi = nokartu;
        var aksi = 7; // 7 untuk mencari data rujukan berdasarkan Nomor Kartu Peserta
        if (nokartu != '') {
            var alert = '';
        } else {
            var alert = 'Isi data Nomor Kartu Peserta terlebih dahulu!';
        }

        if (isi == "") {
            myAlert(alert);
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('BpjsInterface_new'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#data-peserta").addClass("animation-loading");
                $('#data-fktl').addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktl').removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var rujukan = obj.response.rujukan;
                    if (obj.metaData.code == '201') {
                        myAlert(obj.metaData.message);
                    } else {
                        var list = obj.response.rujukan;
                        $('#data-fktl_1').html('');
                        $('#data-peserta_2').html('');
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('setForm'); ?>',
                            data: {
                                rujukanList: list
                            }, //
                            dataType: "json",
                            success: function(data) {
                                $('#data-fktl_1').append(data.form);
                                $('#data-peserta_2').append(data.pasien);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                } else {
                    if (obj.metaData.message == null) {
                        myAlert('Data Not Found');
                    } else {
                        myAlert(obj.metaData.message);
                    }
                }
            },
            error: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktl').removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    /**
     * untuk set ulang form data peserta
     * */
    function clearDataPeserta() {
        //Data Rujukan
        $("#tglKunjungan").text('');
        $("#noKunjungan").text('');
        $("#kdPoli").text('');
        $("#nmPoli").text('');
        $("#keluhan").text('');
        $("#nmDiag").text('');
        $("#pemFisikLain").text('');
        $("#catatan").text('');
        //End Data Rujukan
        //Data Peserta
        $("#noKartu").text('');
        $("#nama").text('');
        $("#tglLahir").text('');
        $("#nik").text('');
        $("#sex").text('');
        $("#kdProvider").text('');
        $("#nmProvider").text('');
        $("#kdCabang").text('');
        $("#nmCabang").text('');
        $("#kdKelas").text('');
        $("#nmKelas").text('');
        $("#kdJenisPeserta").text('');
        $("#nmJenisPeserta").text('');
        $("#keterangan").text('');
        $("#tglCetakKartu").text('');
        $("#tglTAT").text('');
        $("#tglTMT").text('');
        $("#noMr").text('');
        $("#nama_asuransi_cob").text('');
        $("#no_asuransi_cob").text('');
        $("#dinsos").text('');
        $("#nosktm").text('');
        $("#prb").text('');
        //End Data Peserta
        $("#pencarian-rujukan-bpjs-form .btn-primary-blue").attr('disabled', true);
        $("#pencarian-rujukan-bpjs-form .btn-riwayat").attr('disabled', true);
    }

    /**
     * fungsi untuk melihat riwayat Peserta BPJS
     */
    function lihatRiwayat() {
        $('#dialogRiwayatPesertaBpjs').dialog('open');
        $("#data-peserta").removeClass("animation-loading");
    }

    function printRujukanBpjs(caraPrint) {
        var norujukan = $('#nomorrujukan_fktp').val();
        var nokartu = $('#nomorkartupeserta_fktp').val();
        var tglrujukan = $('#tglrujukan_fktp').val();

        window.open('<?php echo $this->createUrl('PrintRujukanBpjs'); ?>&norujukan=' + norujukan + '&nokartu=' + nokartu + '&tglrujukan=' + tglrujukan + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printRujukanFktl(caraPrint) {
        var norujukan = $('#nomorrujukan_fktp').val();
        var nokartu = $('#nomorkartupeserta_fktp').val();
        var tglrujukan = $('#tglrujukan_fktp').val();

        window.open('<?php echo $this->createUrl('PrintRujukanBpjsFktl'); ?>&norujukan=' + norujukan + '&nokartu=' + nokartu + '&tglrujukan=' + tglrujukan + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printRujukanFktp(caraPrint) {
        var norujukan = $('#nomorrujukan_fktp').val();
        var nokartu = $('#nomorkartupeserta_fktp').val();
        var tglrujukan = $('#tglrujukan_fktp').val();

        window.open('<?php echo $this->createUrl('PrintRujukanBpjsFktp'); ?>&norujukan=' + norujukan + '&nokartu=' + nokartu + '&tglrujukan=' + tglrujukan + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    $(document).each(function() {

    });
</script>