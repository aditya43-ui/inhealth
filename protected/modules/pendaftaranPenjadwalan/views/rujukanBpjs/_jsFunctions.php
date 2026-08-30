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
    /**
     * fungsi pencarian Rujukan BPJS FKTP
     */
    function cariDataRujukanBpjsFktp() {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var norujukan = $('#nomorrujukan_fktp').val();
        var nokartu = $('#nomorkartupeserta_fktp').val();
        var tglrujukan = $('#tglrujukan_fktp').val();


        if (norujukan != '') {
            var isi = norujukan;
            var aksi = 1; // 1 untuk mencari data rujukan berdasarkan Nomor Rujukan
            var alert = 'Isi data Nomor Rujukan terlebih dahulu!';
        } else if (nokartu != '') {
            var isi = nokartu;
            var aksi = 2; // 2 untuk mencari data rujukan berdasarkan Nomor Kartu Peserta
            var alert = 'Isi data Nomor Kartu Peserta terlebih dahulu!';
        } else {
            var isi = tglrujukan;
            var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Tanggal Rujukan
            var alert = 'Isi data Tanggal Rujukan terlebih dahulu!';
        }

        if (isi == "") {
            myAlert(alert);
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
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
                    var peserta = obj.response.peserta;
                    if (obj.metadata.code == '201') {
                        myAlert(obj.metadata.message);
                    } else {
                        //Data Rujukan
                        $("#tglKunjungan").text(peserta.tglKunjungan);
                        $("#noKunjungan").text(peserta.noKunjungan);
                        $("#kdPoli").text(peserta.poliRujukan.kdPoli);
                        $("#nmPoli").text(peserta.poliRujukan.nmPoli);
                        $("#keluhan").text(peserta.keluhan);
                        $("#nmDiag").text(peserta.diagnosa.kdDiag + '-' + peserta.diagnosa.nmDiag);
                        $("#pemFisikLain").text(peserta.pemFisikLain);
                        $("#catatan").text(peserta.catatan);
                        //End Data Rujukan
                        //Data Peserta
                        $("#noKartu").text(peserta.noKartu);
                        $("#nama").text(peserta.nama);
                        $("#tglLahir").text(peserta.tglLahir);
                        $("#nik").text(peserta.nik);
                        $("#sex").text(peserta.sex);
                        $("#kdProvider").text(peserta.provUmum.kdProvider);
                        $("#nmProvider").text(peserta.provUmum.nmProvider);
                        $("#kdCabang").text(peserta.provUmum.kdCabang);
                        $("#nmCabang").text(peserta.provUmum.nmCabang);
                        $("#kdKelas").text(peserta.kelasTanggungan.kdKelas);
                        $("#nmKelas").text(peserta.kelasTanggungan.nmKelas);
                        $("#kdJenisPeserta").text(peserta.jenisPeserta.kdJenisPeserta);
                        $("#nmJenisPeserta").text(peserta.jenisPeserta.nmJenisPeserta);
                        //RND-9239 $("#keterangan").text(peserta.statusPeserta.keterangan);
                        $("#tglCetakKartu").text(peserta.tglCetakKartu);
                        $("#tglTAT").text(peserta.tglTAT);
                        $("#tglTMT").text(peserta.tglTMT);
                        $("#noMr").text(peserta.noMr);
                        //RND-9239 $("#umurSekarang").text(peserta.umur.umurSekarang);
                        //RND-9239 $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
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
    /**
     * fungsi pencarian Rujukan RS BPJS FKTL
     */
    function cariDataRujukanBpjsFktl() {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var norujukan = $('#nomorrujukan_fktl').val();
        var nokartu = $('#nomorkartupeserta_fktl').val();
        var tglrujukan = $('#tglrujukan_fktl').val();


        if (norujukan != '') {
            var isi = norujukan;
            var aksi = 4; // 1 untuk mencari data rujukan rs berdasarkan Nomor Rujukan
            var alert = 'Isi data Nomor Rujukan terlebih dahulu!';
        } else if (nokartu != '') {
            var isi = nokartu;
            var aksi = 5; // 2 untuk mencari data rujukan rs berdasarkan Nomor Kartu Peserta
            var alert = 'Isi data Nomor Kartu Peserta terlebih dahulu!';
        } else {
            var isi = tglrujukan;
            var aksi = 6; // 3 untuk mencari data rujukan rs berdasarkan Tanggal Rujukan
            var alert = 'Isi data Tanggal Rujukan terlebih dahulu!';
        }

        if (isi == "") {
            myAlert(alert);
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
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
                if (obj.metadata.code == '201') {
                    myAlert(obj.metadata.message);
                } else {
                    if (obj.response != null) {
                        var peserta = obj.response.peserta;
                        //Data Rujukan
                        $("#tglKunjungan").text(peserta.tglKunjungan);
                        $("#noKunjungan").text(peserta.noKunjungan);
                        $("#kdPoli").text(peserta.poliRUjukan.kdPoli);
                        $("#nmPoli").text(peserta.poliRUjukan.nmPoli);
                        $("#keluhan").text(peserta.keluhan);
                        $("#nmDiag").text(peserta.diagnosa.kdDiag + '-' + peserta.diagnosa.nmDiag);
                        $("#pemFisikLain").text(peserta.pemFisikLain);
                        $("#catatan").text(peserta.catatan);
                        //End Data Rujukan
                        //Data Peserta
                        $("#noKartu").text(peserta.noKartu);
                        $("#nama").text(peserta.nama);
                        $("#tglLahir").text(peserta.tglLahir);
                        $("#nik").text(peserta.nik);
                        $("#sex").text(peserta.sex);
                        $("#kdProvider").text(peserta.provUmum.kdProvider);
                        $("#nmProvider").text(peserta.provUmum.nmProvider);
                        $("#kdCabang").text(peserta.provUmum.kdCabang);
                        $("#nmCabang").text(peserta.provUmum.nmCabang);
                        $("#kdKelas").text(peserta.kelasTanggungan.kdKelas);
                        $("#nmKelas").text(peserta.kelasTanggungan.nmKelas);
                        $("#kdJenisPeserta").text(peserta.jenisPeserta.kdJenisPeserta);
                        $("#nmJenisPeserta").text(peserta.jenisPeserta.nmJenisPeserta);
                        //RND-9239 $("#keterangan").text(peserta.statusPeserta.keterangan);
                        $("#tglCetakKartu").text(peserta.tglCetakKartu);
                        $("#tglTAT").text(peserta.tglTAT);
                        $("#tglTMT").text(peserta.tglTMT);
                        $("#noMr").text(peserta.noMr);
                        //RND-9239 $("#umurSekarang").text(peserta.umur.umurSekarang);
                        //RND-9239 $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
                        //End Data Peserta
                        $("#pencarian-rujukan-bpjs-form .btn-primary-blue").removeAttr('disabled', true);
                        $("#pencarian-rujukan-bpjs-form .btn-riwayat").removeAttr('disabled', true);
                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function(a, i, m) {
                            return jQuery(a).text().toUpperCase()
                                .indexOf(m[3].toUpperCase()) >= 0;
                        };
                    } else {
                        if (obj.metaData.message == null) {
                            myAlert('Data Not Found');
                        } else {
                            myAlert(obj.metaData.message);
                        }
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

        window.open('<?php echo $this->createUrl('PrintRujukanBpjs'); ?>&norujukan=' + norujukan + '&nokartu=' + nokartu + 'tglrujukan=' + tglrujukan + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printRujukanFktl(caraPrint) {
        var norujukan = $('#nomorrujukan_fktp').val();
        var nokartu = $('#nomorkartupeserta_fktp').val();
        var tglrujukan = $('#tglrujukan_fktp').val();

        window.open('<?php echo $this->createUrl('PrintRujukanBpjsFktl'); ?>&norujukan=' + norujukan + '&nokartu=' + nokartu + 'tglrujukan=' + tglrujukan + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printRujukanFktp(caraPrint) {
        var norujukan = $('#nomorrujukan_fktp').val();
        var nokartu = $('#nomorkartupeserta_fktp').val();
        var tglrujukan = $('#tglrujukan_fktp').val();

        window.open('<?php echo $this->createUrl('PrintRujukanBpjsFktp'); ?>&norujukan=' + norujukan + '&nokartu=' + nokartu + 'tglrujukan=' + tglrujukan + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    $(document).each(function() {

    });
</script>