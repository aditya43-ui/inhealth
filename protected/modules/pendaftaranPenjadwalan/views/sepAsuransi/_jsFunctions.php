<script type="text/javascript">
    /**
     * fungsi BPJS
     */
    function setRadioButton(obj, value) {
        for (var i = 0; i < $(obj).length; i++) {
            if ($(obj).eq(i).val() == value) {
                $(obj).eq(i).attr('checked', true);
            } else {
                $(obj).eq(i).attr('checked', false);
            }
        }
    }

    function getAsuransiNoKartu(isi) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        }

        var tglsep = $('#<?php echo CHtml::activeId($model, 'tglsep') ?>').val();

        var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi + '&tgl=' + tglsep,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.metaData.code != '200') {
                    if (typeof obj.metaData !== 'undefined') {
                        if (obj.metaData.message != 'Rujukan Tidak Ada') {
                            myAlert(obj.metaData.message);
                        }
                    }
                    return false;
                }
                if (obj.response != null) {
                    var rujukan = obj.response.rujukan;
                    var isadarujukan = 0;

                    if (rujukan != null && rujukan != undefined) {
                        var peserta = rujukan.peserta;
                        isadarujukan = 1;
                    } else {
                        var peserta = obj.response.peserta;
                    }


                    if (obj.response.asalFaskes != '' && obj.response.asalFaskes != undefined) {
                        setRadioButton($(".jenisfaskes_bpjs"), obj.response.asalFaskes);
                    }

                    if (peserta.statusPeserta.keterangan == 'AKTIF') {



                        var provRujukan = (rujukan != null) ? rujukan.provPerujuk : null;

                        if (provRujukan != null) {
                            getRujukanDari(provRujukan.kode, provRujukan.nama);
                        }

                        var prolanis = peserta.informasi.prolanisPRB;
                        var dinsos = peserta.informasi.noSKTM;

                        if (prolanis == null) {
                            prolanis = "-";
                        }

                        if (dinsos == null) {
                            dinsos = "-";
                        }

                        $("#bpjs_prolanis").val(prolanis);
                        $("#bpjs_dinsos").val(dinsos);

                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                        $("#<?php echo CHtml::activeId($model, 'nopeserta') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($model, 'nokartuasuransi') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nopeserta') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val(peserta.nama);

                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'tglcetakkartuasuransi') ?>").val(peserta.tglCetakKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'hakkelas_kode') ?>").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'kelastanggungan_id') ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
                        $("#<?php echo CHtml::activeId($model, 'kelastanggungan') ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
                        $("#<?php echo CHtml::activeId($model, 'kelastanggunganasuransi_nama') ?>").val(peserta.hakKelas.keterangan);
                        if (provRujukan != null) {
                            $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").val(rujukan.provPerujuk.kode);
                            $("#<?php echo CHtml::activeId($model, 'ppkrujukan_nama') ?>").val(rujukan.provPerujuk.nama);
                        }

                        // $("#<?php //echo CHtml::activeId($model, 'no_telpon_peserta') 
                                ?>").val(peserta.mr.noTelepon);


                        if (peserta.cob.nmAsuransi == null && peserta.cob.noAsuransi == null) {
                            $("#<?php echo CHtml::activeId($model, 'is_cob') ?>").val(0);
                            $("#<?php echo CHtml::activeId($model, 'status_nosep') ?>").val("TIDAK");
                        } else {
                            $("#<?php echo CHtml::activeId($model, 'is_cob') ?>").val(1);
                            $("#<?php echo CHtml::activeId($model, 'no_asuransi_cob') ?>").val(peserta.cob.noAsuransi);
                            $("#<?php echo CHtml::activeId($model, 'namaasuransi_cob') ?>").val(peserta.cob.nmAsuransi);
                            $("#<?php echo CHtml::activeId($model, 'status_nosep') ?>").val("YA");
                        }

                        if (rujukan != null && rujukan != undefined) {
                            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val(rujukan.noKunjungan);
                            if ($("#instalasi_id").val() == <?php echo Params::INSTALASI_ID_RI; ?>) {
                                $("#<?php echo CHtml::activeId($model, 'jnspelayanan') ?>").val(1);
                                $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val(rujukan.poliRujukan.kode);
                            } else if ($("#instalasi_id").val() == <?php echo Params::INSTALASI_ID_RD; ?>) {
                                $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val("IGD");
                                $("#<?php echo CHtml::activeId($model, 'jnspelayanan') ?>").val(rujukan.pelayanan.kode);
                            } else {
                                $("#<?php echo CHtml::activeId($model, 'jnspelayanan') ?>").val(rujukan.pelayanan.kode);
                                $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val(rujukan.poliRujukan.kode);
                            }

                            // $("#<?php //echo CHtml::activeId($model, 'politujuan') 
                                    ?>").val(rujukan.poliRujukan.kode);
                            $("#<?php echo CHtml::activeId($model, 'diagnosaawal') ?>").val(rujukan.diagnosa.kode);
                            $("#<?php echo CHtml::activeId($model, 'nama_diagnosaawal') ?>").val(rujukan.diagnosa.nama);
                            setDiagnosaBpjs(rujukan.diagnosa.kode, rujukan.diagnosa.nama);
                        }





                        setTimeout(function() {
                            if (isadarujukan == 1) {
                                getRujukanNoRujukan(rujukan.noKunjungan);
                            }
                            getPPKPelayanan();
                            // cekPerbedaanKelas();

                        }, 1000);



                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function(a, i, m) {
                            return jQuery(a).text().toUpperCase()
                                .indexOf(m[3].toUpperCase()) >= 0;
                        };
                        //					$("#<?php // echo CHtml::activeId($model, 'kelastanggungan_id') 
                                                    ?>").find("option:contains('" + peserta.kelasTanggungan.nmKelas + "')").attr("selected", true);
                        $("#<?php echo CHtml::activeId($model, 'klsrawat') ?>").val(peserta.hakKelas.kode);
                    } else {
                        myAlert('Peserta Tidak Aktif');
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

    function getAsuransiNoKartuPeserta(isi) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        };
        var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.metaData.code != '200') {
                    myAlert(obj.metaData.message);
                    return false;
                }
                if (obj.response != null) {
                    var peserta = obj.response.peserta;

                    if (peserta.statusPeserta.keterangan == 'AKTIF') {
                        if ($("#instalasi_id").val() != '<?php echo Params::INSTALASI_ID_RD ?>') {
                            setTimeout(function() {
                                getAsuransiNoKartu(peserta.noKartu);
                            }, 1000);
                        }

                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                        $("#<?php echo CHtml::activeId($model, 'nopeserta') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($model, 'nokartuasuransi') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nopeserta') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val(peserta.nama);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'tglcetakkartuasuransi') ?>").val(peserta.tglCetakKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'hakkelas_kode') ?>").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'kelastanggungan_id') ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
                        $("#<?php echo CHtml::activeId($model, 'kelastanggungan') ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
                        $("#<?php echo CHtml::activeId($model, 'kelastanggunganasuransi_nama') ?>").val(peserta.hakKelas.keterangan);
                        $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);
                        $("#<?php echo CHtml::activeId($model, 'ppkrujukan_nama') ?>").val(peserta.provUmum.nmProvider);
                        // $("#<?php //echo CHtml::activeId($model, 'no_telpon_peserta') 
                                ?>").val(peserta.mr.noTelepon);
                        if (peserta.cob.nmAsuransi == null && peserta.cob.noAsuransi == null) {
                            $("#<?php echo CHtml::activeId($model, 'is_cob') ?>").val(0);
                            $("#<?php echo CHtml::activeId($model, 'status_nosep') ?>").val("TIDAK");
                        } else {
                            $("#<?php echo CHtml::activeId($model, 'is_cob') ?>").val(1);
                            $("#<?php echo CHtml::activeId($model, 'no_asuransi_cob') ?>").val(peserta.cob.noAsuransi);
                            $("#<?php echo CHtml::activeId($model, 'namaasuransi_cob') ?>").val(peserta.cob.nmAsuransi);
                            $("#<?php echo CHtml::activeId($model, 'status_nosep') ?>").val("YA");
                        }
                        setTimeout(function() {
                            getPPKPelayanan();
                        }, 1000);


                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function(a, i, m) {
                            return jQuery(a).text().toUpperCase()
                                .indexOf(m[3].toUpperCase()) >= 0;
                        };
                        //					$("#<?php // echo CHtml::activeId($model, 'kelastanggungan_id') 
                                                    ?>").find("option:contains('" + peserta.kelasTanggungan.nmKelas + "')").attr("selected", true);
                        $("#<?php echo CHtml::activeId($model, 'klsrawat') ?>").val(peserta.hakKelas.kode);
                    } else {
                        myAlert('Peserta Tidak Aktif');
                    }
                    cekDisabled('form');
                } else {
                    myAlert(obj.metaData.message);
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

    function getRujukanNoRujukan(isi) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        }

        var jenis_rujukan = $('.jenispeserta_id:checked').val();
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
                        var noKunjungan = rujukan.noKunjungan;
                        var tglKunjungan = rujukan.tglKunjungan;
                        var peserta = rujukan.peserta; //array
                        var provKunjungan = rujukan.provKunjungan; //array
                        var keluhan = rujukan.keluhan;
                        var diagnosa = rujukan.diagnosa; //array
                        var catatan = rujukan.catatan;
                        var pemFisikLain = rujukan.pemFisikLain;
                        var provRujukan = rujukan.provPerujuk; //array
                        var poliRujukan = rujukan.poliRujukan; //array

                        getRujukanDari(peserta.provUmum.kdProvider);

                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispersertakode_bpjs') ?>").val(rujukan.peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispeserta_bpjs') ?>").val(rujukan.peserta.jenisPeserta.keterangan);
                        $("#<?php echo CHtml::activeId($model, 'nopeserta') ?>").val(rujukan.peserta.noKartu);
                        $("#<?php echo CHtml::activeId($model, 'nokartuasuransi') ?>").val(rujukan.peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nopeserta') ?>").val(rujukan.peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') ?>").val(rujukan.peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val(rujukan.peserta.nama);

                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val(rujukan.peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_nama') ?>").val(rujukan.peserta.hakKelas.keterangan);
                        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val(rujukan.noKunjungan);
                        $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").val(rujukan.peserta.provUmum.kdProvider);
                        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(rujukan.peserta.provUmum.nmProvider);
                        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val(rujukan.tglKunjungan);
                        $("#<?php echo CHtml::activeId($model, 'hakkelas_kode') ?>").val(rujukan.peserta.hakKelas.kode);

                        $("#<?php echo CHtml::activeId($model, 'diagnosaawal') ?>").val(rujukan.diagnosa.kode);
                        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val(rujukan.noKunjungan);
                        $("#<?php echo CHtml::activeId($model, 'jnspelayanan') ?>").val(rujukan.pelayanan.kode);
                        $("#<?php echo CHtml::activeId($model, 'kelastanggungan') ?>").val(rujukan.peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").val(rujukan.provPerujuk.kode);
                        $("#<?php echo CHtml::activeId($model, 'ppkrujukan_nama') ?>").val(rujukan.provPerujuk.nama);
                        $("#<?php echo CHtml::activeId($model, 'tanggal_rujukan') ?>").val(rujukan.tglKunjungan);
                        $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val(rujukan.poliRujukan.kode);
                        // $("#<?php //echo CHtml::activeId($model, 'no_telpon_peserta') 
                                ?>").val(rujukan.peserta.mr.noTelepon);
                        $("#<?php echo CHtml::activeId($model, 'klsrawat') ?>").val(rujukan.peserta.hakKelas.kode);
                        if (rujukan.peserta.cob.nmAsuransi == null && rujukan.peserta.cob.noAsuransi == null) {
                            $("#<?php echo CHtml::activeId($model, 'is_cob') ?>").val(0);
                            $("#<?php echo CHtml::activeId($model, 'status_nosep') ?>").val("TIDAK");
                        } else {
                            $("#<?php echo CHtml::activeId($model, 'is_cob') ?>").val(1);
                            $("#<?php echo CHtml::activeId($model, 'no_asuransi_cob') ?>").val(rujukan.peserta.cob.noAsuransi);
                            $("#<?php echo CHtml::activeId($model, 'namaasuransi_cob') ?>").val(rujukan.peserta.cob.nmAsuransi);
                            $("#<?php echo CHtml::activeId($model, 'status_nosep') ?>").val("YA");
                        }
                        setDiagnosaBpjs(diagnosa.kode, diagnosa.nama);

                        setTimeout(function() {
                            getPPKPelayanan();
                        }, 1000);
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

    function getPPKPelayanan() {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        //	if (isi == "") {
        //		myAlert('Isi data terlebih dahulu!');
        //		return false;
        //	}

        var jenis_rujukan = 2;

        $('.jenisfaskes_bpjs').each(function() {
            if ($(this).prop('checked') == true) {
                jenis_rujukan = $(this).val();
            }
        });
        var kodeppkpelayanan = $('#<?php echo CHtml::activeId($model, 'ppkpelayanan'); ?>').val();

        var aksi = 16;
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&kodeppkpelayanan=' + kodeppkpelayanan + '&jenis_rujukan=' + jenis_rujukan,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.metaData.code == '201') {
                    //				myAlert(obj.metaData.message);
                } else {
                    if (obj.response != null) {
                        var faskes = obj.response.faskes;
                        $('#<?php echo CHtml::activeId($model, 'ppkpelayanan_nama'); ?>').val(faskes[0].nama);

                        if ($("#instalasi_id").val() == '<?php echo Params::INSTALASI_ID_RD ?>' || $("#instalasiasal_id").val() == '<?php echo Params::INSTALASI_ID_RD ?>') {
                            $('#<?php echo CHtml::activeId($model, 'ppkrujukan'); ?>').val(faskes[0].kode);
                            $('#<?php echo CHtml::activeId($model, 'ppkrujukan_nama'); ?>').val(faskes[0].nama);
                        }
                    }
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

    function cekAsuransiBpjs() {
        var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
        var pasien_id = $("#<?php echo CHtml::activeId($model, 'pasien_id') ?>").val();

        if (pasien_id == "") {
            myAlert('Masukan terlebih dahulu data pasien!');
        } else if (penjamin_id == "") {
            myAlert('Masukan terlebih dahulu penjamin!');
        } else {
            $.fn.yiiGridView.update('asuransibpjs-m-grid', {
                data: {
                    "<?php echo get_class($modAsuransiPasienBpjs); ?>[pasien_id]": pasien_id,
                    "<?php echo get_class($modAsuransiPasienBpjs); ?>[penjamin_id]": penjamin_id,
                }
            });
            $("#dialogAsuransiBpjs").dialog('open');
        }
        return false;
    }

    function clearRujukanBpjs() {
        $('#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>').val('');
    }

    /**
     * set otomatis nama_perujuk dari dropdown rujukandari_id Untuk BPJS
     * @returns {Boolean}
     */
    function setNamaPerujukBpjs() {
        var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").val();
        var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").find('option[value="' + rujukandari_id + '"]').text();
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(nama_perujuk);
    }

    function setDiagnosa(kode_diagnosa, nama_diagnosa) {
        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var randomId = '';
        for (var i = 0; i < 32; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomId += chars.substring(rnum, rnum + 1);
        }

        var op = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + nama_diagnosa + '">' + nama_diagnosa + '</option>';
        var list = '<li id="pt_' + randomId + '" class="bit-box" rel="' + nama_diagnosa + '">' + nama_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
        var opKode = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + kode_diagnosa + '">' + kode_diagnosa + '</option>';
        var listKode = '<li id="pt_' + randomId + '" class="bit-box" rel="' + kode_diagnosa + '">' + kode_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
        var objSelect = $('select#diagnosaRujukan').parent().find('select');
        var objList = $('select#diagnosaRujukan').parent().find('ul li.bit-input');
        var objSelectKode = $('select#diagnosaRujukanKode').parent().find('select');
        var objListKode = $('select#diagnosaRujukanKode').parent().find('ul li.bit-input');

        objSelect.append(op);
        objList.before(list);
        objSelectKode.append(opKode);
        objListKode.before(listKode);

    }

    function setDiagnosaBpjs(kode_diagnosa, nama_diagnosa) {

        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var randomId = '';
        for (var i = 0; i < 32; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomId += chars.substring(rnum, rnum + 1);
        }

        var op = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + nama_diagnosa + '">' + nama_diagnosa + '</option>';
        var list = '<li id="pt_' + randomId + '" class="bit-box" rel="' + nama_diagnosa + '">' + nama_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
        var opKode = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + kode_diagnosa + '">' + kode_diagnosa + '</option>';
        var listKode = '<li id="pt_' + randomId + '" class="bit-box" rel="' + kode_diagnosa + '">' + kode_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
        var objSelect = $('select#diagnosaRujukanBpjs').parent().find('select');
        var objList = $('select#diagnosaRujukanBpjs').parent().find('ul li.bit-input');
        var objSelectKode = $('select#diagnosaRujukanKodeBpjs').parent().find('select');
        var objListKode = $('select#diagnosaRujukanKodeBpjs').parent().find('ul li.bit-input');

        objSelect.append(op);
        objList.before(list);
        objSelectKode.append(opKode);
        objListKode.before(listKode);

    }

    function removeItemDiagnosa(id) {
        $('li#' + id).remove();
        var id_opt = id.replace('pt_', 'opt_');
        $('option#' + id_opt).remove();
    }

    function setSEP(obj) {
        if ($(obj).is(':checked')) {
            $('#assep-t-form').find(".nosep").removeAttr("disabled");
        } else {
            $('#assep-t-form').find(".nosep").attr("disabled", true);
        }
    }

    function printSEP() {
        window.open('<?php echo $this->createUrl('printSep', array('sep_id' => $model->sep_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
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

        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val(null);
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'ppkrujukan_nama') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'catatansep') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'diagnosaawal') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val();
        $('input:radio[name="ARSepT[is_polieksekutif]"]:checked').val(0);
        $('input:radio[name="ARSepT[is_lakalantas]"]:checked').val(0);
        $("#<?php echo CHtml::activeId($model, 'penjamin_lakalantas') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'lokasi_lakalantas') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'no_telpon_peserta') ?>").val('');
    }

    function refreshDialogInfoPasien() {
        var instalasi_id = $("#instalasi_id").val();
        var instalasi_nama = $("#instalasi_id option:selected").text();
        $.fn.yiiGridView.update('datakunjungan-grid', {
            data: {
                "ARPasienM[instalasi_id]": instalasi_id,
                "ARPasienM[tgl_pendaftaran]": '<?php echo date('m/d/Y') . ' - ' . date('m/d/Y'); ?>',
                // "FAPasienM[instalasi_nama]":instalasi_nama,
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
                // console.log("data : ", data)
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

                $("#<?php echo CHtml::activeId($model, 'catatansep') ?>").val("-");

                $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val(data.penjamin_id);

                $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val(data.ruangan_kode_bpjs);
                if (data.photopasien === null || data.photopasien === "") { //set photo
                    $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                } else {
                    $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                }

                $("#form-infopasien > legend > .judul").html('Data Pasien ' + data.no_pendaftaran);
                $("#form-infopasien > legend > .tombol").attr('style', 'display:true;');
                $("#form-infopasien > .box").addClass("well").removeClass("box");

                $("#form-infopasien > div").removeClass("animation-loading");
                $("#nama_pasien").focus();

                var Instalasi_RJ = <?php echo CJSON::encode($model->InstalasiPelayananRJ()); ?>;

                if (searchArray(data.instalasi_id, Instalasi_RJ)) {
                    $('#rujukanTombol').show();
                    $('#skdp').show();
                    $('.rujukanBpjs').show();
                    $('.hideDpjpDialog').show();

                    // $("#<?php //echo CHtml::activeId($model, 'jnspelayanan_kode') 
                            ?>").val(2);
                    $("#<?php echo CHtml::activeId($model, 'no_rujukan') ?>").addClass("required").removeClass("not-required");
                } else {
                    $('#skdp').hide();
                    $('.rujukanTombol').show();
                    $('.hideDpjpDialog').show();
                    if (data.instalasi_id == '<?php echo Params::INSTALASI_ID_RD; ?>') {
                        // $("#<?php //echo CHtml::activeId($model, 'jnspelayanan_kode') 
                                ?>").val(2);
                        $('#rujukanBpjs').hide();
                        $('.rujukanTombol').hide();
                        $('.hideDpjpDialog').hide();
                        cariDataDokter();
                        $("#<?php echo CHtml::activeId($model, 'no_rujukan') ?>").removeClass("required").addClass("not-required");
                    } else {
                        // $("#<?php //echo CHtml::activeId($model, 'jnspelayanan_kode') 
                                ?>").val(1);
                        $('#rujukanBpjs').show();
                        $('#skdp').show();
                        $("#<?php echo CHtml::activeId($model, 'no_rujukan') ?>").addClass("required").removeClass("not-required");
                    }
                }

                if (data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?>) {
                    <?php if (isset($_GET['pengajuanapprovalsep_id']) && !empty($_GET['pengajuanapprovalsep_id'])) { ?>
                        $("#<?php echo CHtml::activeId($model, 'nopeserta') ?>").val('<?php echo $modPengajuanApproval->no_kartu_bpjs; ?>');
                        if ('<?php echo $modPengajuanApproval->no_kartu_bpjs; ?>' != '') {
                            setTimeout(function() {
                                getAsuransiNoKartu('<?php echo $modPengajuanApproval->no_kartu_bpjs; ?>');
                            }, 1000);
                        }
                    <?php } else { ?>
                        $("#<?php echo CHtml::activeId($model, 'nopeserta') ?>").val(data.no_asuransi);
                    <?php } ?>

                }
                setKelasRawatDrop();
                getInstalasiSep();

                setTimeout(function() {
                    if (data.instalasi_id == '<?php echo Params::INSTALASI_ID_RI; ?>') {
                        getAsuransiNoKartu(data.no_peserta);
                    }
                }, 1000);
                $("#<?php echo CHtml::activeId($model, 'jnspelayanan') ?>").val(data.jnspelayanan);

                if (data.isNaikKelas == 1) {
                    $("#<?php echo CHtml::activeId($model, 'klsRawatNaik') ?>").val(data.kelaspelayanan_id);
                    $("#<?php echo CHtml::activeId($model, 'isNaikKelas') ?>").prop('checked', true);
                    
                    $("#<?php echo CHtml::activeId($model, 'penanggungjwb_naikkls_id') ?>").prop("disabled", false).parents(".control-group").show();
                    $('.is-naikkelas').show()
                    $('.is-naikkelas').find(".not-required").addClass("required").removeClass("not-required");

                }

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

    /* Pencarian array */
    function searchArray(nameKey, myArray) {
        var ada = false;
        for (var i = 0; i < myArray.length; i++) {
            if (myArray[i] === nameKey) {
                ada = true;
            }
        }

        return ada;
    }

    function cekInput(obj, param) {
        var status = 1;
        var noTlp = $("#<?php echo CHtml::activeId($model, 'no_telpon_peserta') ?>").val();
        if (!requiredCheck("#assep-t-form")) {
            status = 0;
            // requiredCheck("#assep-t-form");
        } else {
            status = 1;
        }
        if (status == 1 && noTlp.length < 8) {
            myAlert("No Telepon Minimal 8 Digit");
        } else if (noTlp.length < 8) {
            status = 0;
        } else if (status == 1 && noTlp.length >= 8) {
            status = 1;
        }

        var noMR = $('#no_rekam_medik').val();
        var noKartu = $("#<?php echo CHtml::activeId($model, 'nopeserta') ?>").val();
        var noSep = $("#<?php echo CHtml::activeId($model, 'nosep') ?>").val();
        var tglSep = $("#<?php echo CHtml::activeId($model, 'tglsep') ?>").val();
        var ppkPelayanan = $("#<?php echo CHtml::activeId($model, 'ppkpelayanan') ?>").val();
        var jnsPelayanan = $("#<?php echo CHtml::activeId($model, 'jnspelayanan') ?>").val();
        var hakkelas = parseInt($("#<?php echo CHtml::activeId($model, 'hakkelas_kode') ?>").val());
        var klsRawat = parseInt($("#<?php echo CHtml::activeId($model, 'klsrawat') ?>").val());
        if (klsRawat >= hakkelas) {
            var klsRawat = klsRawat;
        } else {
            var klsRawat = hakkelas;
        }
        if (jnsPelayanan == 2) {
            klsRawat = 3; //default kelas 3 RJ
        }
        //    var klsRawat = $("#<?php // echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') 
                                    ?>").val();
        var asalRujukan = $('input:radio[name=ARSepT\\[jenispeserta_id\\]]:checked').val();
        var tglRujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val();
        var noRujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val();
        var ppkRujukan = $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").val();
        var catatan = $("#<?php echo CHtml::activeId($model, 'catatansep') ?>").val();
        var diagAwal = $("#<?php echo CHtml::activeId($model, 'diagnosaawal') ?>").val();
        var tujuan = $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val();
        var eksekutif = $('input:radio[name="ARSepT[is_polieksekutif]"]:checked').val();
        var cob = $("#<?php echo CHtml::activeId($model, 'is_cob') ?>").val();
        //    var lakaLantas = $('input:radio[name="ARSepT[is_lakalantas]"]:checked').val();
        var lakaLantas = $("#<?php echo CHtml::activeId($model, 'is_lakalantas') ?>").val();
        var penjamin = $("#<?php echo CHtml::activeId($model, 'penjamin_lakalantas') ?>").val();

        var tglKejadian = $("#<?php echo CHtml::activeId($model, 'tanggal_kejadian') ?>").val();
        var keterangan = $("#<?php echo CHtml::activeId($model, 'keterangan_kejadian') ?>").val();
        var suplesi = $('input:radio[name="ARSepT[suplesi_jasaraharja]"]:checked').val();
        var katarak = $('input:radio[name="ARSepT[katarak]"]:checked').val();
        var noSepSuplesi = $("#<?php echo CHtml::activeId($model, 'no_suplesi') ?>").val();
        var kdPropinsi = $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?>").val();
        var kdKabupaten = $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?>").val();
        var kdKecamatan = $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?>").val();
        var noSurat = $("#<?php echo CHtml::activeId($model, 'no_surat') ?>").val();
        var kodeDPJP = $("#<?php echo CHtml::activeId($model, 'kode_dpjp') ?>").val();

        var lokasiLaka = $("#<?php echo CHtml::activeId($model, 'lokasi_lakalantas') ?>").val();
        var noTelp = $("#<?php echo CHtml::activeId($model, 'no_telpon_peserta') ?>").val();
        var user = $("#<?php echo CHtml::activeId($model, 'pembuat_sep') ?>").val();
        var tglPulang = $("#<?php echo CHtml::activeId($model, 'tglpulang') ?>").val();

        var status_pulang = $("#<?php echo CHtml::activeId($model, 'statuspulang_kode') ?>").val();
        var tglMeninggal = $("#<?php echo CHtml::activeId($model, 'tgl_meninggal') ?>").val();
        var nosurat_ketmeninggal = $("#<?php echo CHtml::activeId($model, 'nosurat_ketmeninggal') ?>").val();

        var kll_nolaporan_polisi = $("#<?php echo CHtml::activeId($model, 'kll_nolaporan_polisi') ?>").val();


        if (status == 1) {
            if (param == 14) {
                $("#assep-t-form").submit();
            }
            $("#content-bpjs").addClass("animation-loading");
            var setting = {
                url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
                type: 'GET',
                dataType: 'html',
                data: 'param=' + param + '&noMR=' + noMR + '&noKartu=' + noKartu + '&tglSep=' + tglSep + '&ppkPelayanan=' + ppkPelayanan + '&jnsPelayanan=' + jnsPelayanan + '&klsRawat=' + klsRawat + '&asalRujukan=' + asalRujukan + '&tglRujukan=' + tglRujukan + '&noRujukan=' + noRujukan + '&ppkRujukan=' + ppkRujukan + '&catatan=' + catatan + '&diagAwal=' + diagAwal + '&tujuan=' + tujuan + '&eksekutif=' + eksekutif + '&cob=' + cob + '&lakaLantas=' + lakaLantas + '&penjamin=' + penjamin + '&lokasiLaka=' + lokasiLaka + '&noTelp=' + noTelp + '&user=' + user + '&penjamin=' + penjamin + '&noSep=' + noSep + '&tglPulang=' + tglPulang +
                    '&tglKejadian=' + tglKejadian + '&keterangan=' + keterangan + '&suplesi=' + suplesi + '&noSepSuplesi=' + noSepSuplesi + '&kdPropinsi=' + kdPropinsi + '&kdKabupaten=' + kdKabupaten + '&kdKecamatan=' + kdKecamatan + '&noSurat=' + noSurat + '&kodeDPJP=' + kodeDPJP + '&katarak=' + katarak + '&status_pulang=' + status_pulang + '&tglMeninggal=' + tglMeninggal + '&nosurat_ketmeninggal=' + nosurat_ketmeninggal + '&kll_nolaporan_polisi=' + kll_nolaporan_polisi,
                beforeSend: function() {
                    $("#content-bpjs").addClass("animation-loading");
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.metaData.code != '200') {
                        myAlert(obj.metaData.message);
                    } else {
                        if (obj.response != null) {
                            if (param == 13) { //insert
                                var sep = obj.response.sep;
                                $("#<?php echo CHtml::activeId($model, 'nosep') ?>").val(sep.noSep);
                            } else { //update

                            }
                            $("#assep-t-form").submit();
                        }
                        if (param == 15) { //update tanggal pulang
                            myAlert('Update Tanggal Pulang Berhasil');
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
            window.parent.myAlert("Silahkan isi yang bertanda bintang <span class='required'>*</span> !"); //("+kosong+" input)
            return false;
        } else {
            return true;
        }
    }

    function cekSuplesi(obj) {
        if ($(obj).val() == 1) {
            $("#ARSepT_no_suplesi").addClass("required");
            $("#ARSepT_no_suplesi").attr('disabled', false);
            $('.cari_suplesi').show();
        } else {
            $("#ARSepT_no_suplesi").attr('disabled', 'disabled');
            $("#ARSepT_no_suplesi").removeClass("required");
            $("#ARSepT_no_suplesi").removeClass("error");
            $("#ARSepT_no_suplesi").parents(".control-group").removeClass("error");
            $('.cari_suplesi').hide();
        }
    }

    $(document).ready(function() {
        $("#form-suplesi .accordion-heading a").click(function() {
            $("#<?php echo CHtml::activeId($model, 'is_lakalantas') ?>").val(0);
            if ($('#content-suplesi').hasClass('accordion-body  in collapse')) {
                cekSuplesi($('input:radio[name="ARSepT[suplesi_jasaraharja]"]:checked'));
            } else {
                var suplesi_jasaraharja = $('input:radio[name="ARSepT[suplesi_jasaraharja]"]:checked').val();
                if (suplesi_jasaraharja == 1) {
                    $("#<?php echo CHtml::activeId($model, 'is_lakalantas') ?>").val(0);
                } else {
                    $("#<?php echo CHtml::activeId($model, 'is_lakalantas') ?>").val(1);
                }

                setPropinsi();
                $('.frminput_suplesi').show();
                $('.frminput_lppolisi').hide();
            }
        });
        // cekPerbedaanKelas();

        <?php if (isset($_GET['pengajuanapprovalsep_id']) && !empty($_GET['pengajuanapprovalsep_id'])) { ?>
            setInfoPasien('<?php echo $modPendaftaran->pendaftaran_id; ?>', '<?php echo $modPendaftaran->no_pendaftaran; ?>', '<?php echo $modPasien->no_rekam_medik; ?>', '<?php echo (!empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : ""); ?>')
        <?php } ?>
        setChangeStatusKecelakaan();
    });

    function setPropinsi() {
        var setting = {
            url: "<?php echo $this->createUrl('propinsi/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=1',
            beforeSend: function() {},
            success: function(data) {
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                }
                var list = obj.response.list;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('SetDropdownPropinsi'); ?>',
                    data: {
                        propinsiList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?>").empty();
                        $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?>").append(data.form);
                        var propinsi = $(".propinsi").val();
                        console.log('propinsi', propinsi);
                        $("#ARSepT_propinsi_lakalantas_id").val(propinsi);
                        setKabupaten(propinsi);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {}
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function setKabupaten(obj) {
        var katakunci = $(obj).val();
        console.log('katakunci', katakunci, obj);

        var propinsi = $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?> option:selected").text();
        $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_nama') ?>").val(propinsi);

        isi = "";
        if (katakunci != '') {
            var isi = katakunci;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan

        }
        if (katakunci == undefined) {
            var isi = obj;

        }
        $(".propinsi").val(isi)

        if (isi == "") {
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('kabupaten/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {},
            success: function(data) {
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                }
                var list = obj.response.list;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('SetDropdownKabupaten'); ?>',
                    data: {
                        propinsiList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?>").empty();
                        $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?>").append(data.form);
                        var kabupaten = $(".kabupaten").val();
                        console.log('kabupaten', kabupaten);
                        $("#ARSepT_kabupaten_lakalantas_id").val(kabupaten);
                        setKecamatan(kabupaten);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {
                myAlert('Terjadi kesalahan saat briging');
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function setKecamatan(obj) {
        var katakunci = $(obj).val();

        var kabupaten = $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?> option:selected").text();
        $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_nama') ?>").val(kabupaten);

        isi = "";
        if (katakunci != '') {
            var isi = katakunci;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
        }
        if (katakunci == undefined) {
            var isi = obj;
        }

        if (isi == "") {
            return false;
        };
        $(".kabupaten").val(isi)
        var setting = {
            url: "<?php echo $this->createUrl('kecamatan/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {},
            success: function(data) {
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                }
                var list = obj.response.list;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('SetDropdownKecamatan'); ?>',
                    data: {
                        kabupatenList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?>").empty();
                        $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?>").append(data.form);
                        var kecamatan = $(".kecamatan").val();
                        console.log('kecamatan', kecamatan);
                        $("#ARSepT_kecamatan_lakalantas_id").val(kecamatan);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {
                myAlert('Terjadi kesalahan saat briging');
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function setKecamatanValue(obj) {
        var kecamatan = $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?> option:selected").text();
        var id = $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?> option:selected").val();
        $(".kecamatan").val(id)
        $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_nama') ?>").val(kecamatan);
    }


    $('.no_pendaftaran').find(".add-on").click(function() {
        refreshDialogInfoPasien();
    });

    <?php

    $kelas_data  = KelaspelayananM::model()->findAllByAttributes(array(
        'kelaspelayanan_aktif' => true,
    ), array(
        'order' => 'kelaspelayanan_nama',
    ));
    $kelas = CHtml::listData($kelas_data, 'kelaspelayanan_id', 'kelasbpjs_id');

    $kelas_urut = CHtml::listData($kelas_data, 'kelaspelayanan_id', 'kelasnaikbpjs_id');


    ?>

    var data_kelas = <?php echo CJSON::encode($kelas); ?>;
    var data_kelas_naik_bpjs = <?php echo CJSON::encode($kelas_urut); ?>;

    /**
     * - digunakan untuk menginformasikan ada perbedaan kelas tanggunagn dan kelas pelayanan
     * @returns {give warning} */
    function cekPerbedaanKelas() {
        var kelaspelayanan = $("#kelaspelayanan_id");
        var kelastanggungan = $("#ARSepT_klsrawat");

        // alert(kelaspelayanan.val()+'-'+kelastanggungan.val());

        $("#ARSepT_penanggungjwb_naikkls_id").prop("disabled", true).val("").parents(".control-group").hide();
        $("#ARSepT_klsRawatNaik").val("");

        if (typeof kelastanggungan.val() === 'undefined') {

        } else {

            if (kelaspelayanan.val() != '' && (kelastanggungan.val() != '')) {
                cekBedaKelasBPJS(kelaspelayanan.val(), kelaspelayanan.val());
            }
        }
    }


    function cekBedaKelasBPJS(kelaspelayanan_id, kelastanggungan_id) {
        console.log("Kelas BPJS", data_kelas[kelaspelayanan_id], kelastanggungan_id);

        if (data_kelas[kelaspelayanan_id] != null && data_kelas[kelaspelayanan_id] < kelastanggungan_id) {
            $("#ARSepT_penanggungjwb_naikkls_id").prop("disabled", false).val("").parents(".control-group").show();
            $("#ARSepT_klsRawatNaik").val(data_kelas_naik_bpjs[kelaspelayanan_id]);
        } else {
            $("#ARSepT_penanggungjwb_naikkls_id").prop("disabled", true).val("").parents(".control-group").hide();
            $("#ARSepT_klsRawatNaik").val("");
        }
    }

    function getRujukanDari(kodeppk) {
        var asarujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetRujukanDariBpjs'); ?>',
            data: {
                kodeppk: kodeppk,
                asarujukan: asarujukan
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val(data.asalrujukan);
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").html(data.datarujukandari);
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").val(data.rujukandari);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    var data_kontrol = null;

    function cariSuratKontrol() {
        var isi = $("#<?php echo CHtml::activeId($model, 'no_surat') ?>").val();
        var no_kartu = $('#ARSepT_nopeserta').val();
        var aksi = 19;


        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi + '&nokartu=' + no_kartu,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                // console.log(data);
                $("#content-bpjs").removeClass("animation-loading");
                var res = JSON.parse(data);
                console.log(res);
                if (res.response != null) {
                    data_kontrol = res.response;
                    showDialogSuratKontrol();
                } else {
                    myAlert(res.metaData.message);
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


    function showDialogSuratKontrol() {
        $("#tab_sc #sc_nama_pasien").html(data_kontrol.sep.peserta.nama);
        $("#tab_sc #sc_jeniskelamin").html(data_kontrol.sep.peserta.kelamin == "L" ? "LAKI-LAKI" : "PEREMPUAN");
        $("#tab_sc #sc_tanggal_lahir").html(data_kontrol.sep.peserta.tglLahir);
        $("#tab_sc #sc_nosurat").html(data_kontrol.noSuratKontrol);
        $("#tab_sc #sc_tanggal_entri").html(data_kontrol.tglTerbit);
        $("#tab_sc #sc_tanggal_rencana").html(data_kontrol.tglRencanaKontrol);
        $("#tab_sc #sc_poli_tujuan").html(data_kontrol.namaPoliTujuan);
        $("#tab_sc #sc_dokter_kontrol").html(data_kontrol.namaDokter);
        $("#tab_sc #sc_no_sep").html(data_kontrol.sep.noSep);
        $("#tab_sc #sc_tgl_sep").html(data_kontrol.sep.tglSep);

        if (data_kontrol.status_kontrol == 1) {
            $("#tab_sc #sc_status").html("Sudah melewati jadwal kontrol yang Direncanakan!");
        } else if (data_kontrol.status_kontrol == -1) {
            $("#tab_sc #sc_status").html("Belum Masuk jadwal kontrol yang Direncanakan!");
        }

        $("#dialogSuratKontrol").dialog("open");
    }

    function cariSpri() {
        var isi = $("#ARSepT_no_surat").val();
        var no_kartu = $('#ARSepT_nopeserta').val();
        var aksi = 19;

        console.log('data kartu', isi, no_kartu, aksi)

        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi + '&nokartu=' + no_kartu,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                // console.log(data);
                $("#content-bpjs").removeClass("animation-loading");
                var res = JSON.parse(data);
                console.log(res);
                if (res.response != null) {
                    data_kontrol = res.response;
                    showDialogSpri();
                } else {
                    myAlert(res.metaData.message);
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

    function showDialogSpri() {
        $("#tab_sc #sc_nama_pasien").html(data_kontrol.sep.peserta.nama);
        $("#tab_sc #sc_jeniskelamin").html((data_kontrol.sep.peserta.kelamin == null || data_kontrol.sep.peserta.kelamin == "") ? "-" : (data_kontrol.sep.peserta.kelamin == "L" ? "LAKI-LAKI" : "PEREMPUAN"));
        $("#tab_sc #sc_tanggal_lahir").html(data_kontrol.sep.peserta.tglLahir);
        $("#tab_sc #sc_nosurat").html(data_kontrol.noSuratKontrol);
        $("#tab_sc #sc_tanggal_entri").html(data_kontrol.tglTerbit);
        $("#tab_sc #sc_tanggal_rencana").html(data_kontrol.tglRencanaKontrol);
        $("#tab_sc #sc_poli_tujuan").html(data_kontrol.namaPoliTujuan); // mengambil data nama politujuan dari response bpjs
        $("#tab_sc #sc_dokter_kontrol").html(data_kontrol.namaDokter);
        $("#tab_sc #sc_no_sep").html(data_kontrol.sep.noSep);
        $("#tab_sc #sc_tgl_sep").html("");

        if (data_kontrol.status_kontrol == 1) {
            $("#tab_sc #sc_status").html("Sudah melewati jadwal inap yang Direncanakan!");
        } else if (data_kontrol.status_kontrol == -1) {
            $("#tab_sc #sc_status").html("Belum Masuk jadwal kontrol yang Direncanakan!");
        }

        $("#dialogSpri").dialog("open");
    }

    function setSuratKontrol() {
        $("#dialogSuratKontrol").dialog("close");
        $("#dialogSpri").dialog("close");
        if (data_kontrol.status_kontrol != 0) {
            $("#<?php echo CHtml::activeId($model, 'no_surat') ?>").val("");
        } else {
            $("#<?php echo CHtml::activeId($model, 'nama_dpjp') ?>").val(data_kontrol.namaDokter);
            $("#<?php echo CHtml::activeId($model, 'kode_dpjp') ?>").val(data_kontrol.kodeDokter);
            $("#<?php echo CHtml::activeId($model, 'no_surat') ?>").val(data_kontrol.noSuratKontrol);
            if (data_kontrol.sep.noSep) {
                $("#isSepManual").prop("checked", true).change();
                $("#<?php echo CHtml::activeId($model, 'nosep') ?>").val(data_kontrol.sep.noSep);
            }
            $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").val(data_kontrol.poliTujuan);
        }
    }

    function getInstalasiSep() {
        $('#lablenosuratkontrol').html('Nomor Surat Kontrol');
        $('#lablendpjpsuratkontrol').html('DPJP Pemberi Surat Kontrol');

        $('#<?php echo CHtml::activeId($model, 'no_surat') ?>').attr('placeholder', 'Nomor Surat Kontrol');
        $('#<?php echo CHtml::activeId($model, 'nama_dpjp') ?>').attr('placeholder', 'DPJP Pemberi Surat Kontrol');

        $('.dpjp-melayani').show();
        $('.dpjp-melayani').find(".not-required").addClass("required").removeClass("not-required");
        $('.politujuan_n').find(".not-required").addClass("required").removeClass("not-required");

        $(".isRawatInap").addClass("hidden");

        $("#<?php echo CHtml::activeId($model, 'jnspelayanan') ?>").val(2);
        if ($('#instalasi_id').val() == '<?php echo Params::INSTALASI_ID_RD ?>') {
            $('.clsrujukan').hide();
            $('#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>').val('IGD');
            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").removeClass("required");
            $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").removeClass("required");
            $("#<?php echo CHtml::activeId($model, 'ppkrujukan_nama') ?>").removeClass("required");
        } else {
            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").addClass("required");
            $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").addClass("required");
            $("#<?php echo CHtml::activeId($model, 'ppkrujukan_nama') ?>").addClass("required");
            $('.clsrujukan').show();
            var instalasi_id_ri = ['<?php echo Params::INSTALASI_ID_RI ?>', '79', '38', '14', '100', '20', '85'];
            var instalasi_id = $('#instalasi_id').val();
            if ($.inArray(instalasi_id, instalasi_id_ri) !== -1) {
                $(".isRawatInap").removeClass("hidden");
                $('#lablenosuratkontrol').html('No. SPRI');
                $('#lablendpjpsuratkontrol').html('DPJP Pemberi SPRI');

                $('#<?php echo CHtml::activeId($model, 'no_surat') ?>').attr('placeholder', 'No. SPRI');
                $('#<?php echo CHtml::activeId($model, 'nama_dpjp') ?>').attr('placeholder', 'DPJP Pemberi SPRI');
                $('#tombolcari').attr('onclick', "$('#dialogSpri').dialog('open');return true;");
                $('#tombolcarispri').attr('onclick', "cariSpri()");
                $("#<?php echo CHtml::activeId($model, 'jnspelayanan') ?>").val(1);

                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").removeClass("required");
                $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").removeClass("required");
                $("#<?php echo CHtml::activeId($model, 'ppkrujukan_nama') ?>").removeClass("required");
                $("#<?php echo CHtml::activeId($model, 'politujuan') ?>").removeClass("required");
                $("#<?php echo CHtml::activeId($model, 'dpjpygmelayani_nama') ?>").removeClass("required");
                $("#<?php echo CHtml::activeId($model, 'dpjpygmelayani_kode') ?>").removeClass("required");
                $('.clsrujukan').hide();
                $('.dpjp-melayani').hide();
                $('.dpjp-melayani').find(".required").addClass("not-required").removeClass("required");
                $('.politujuan_n').find(".required").addClass("not-required").removeClass("required");
            }
            // if ($('#instalasi_id').val() == '<?php //echo Params::INSTALASI_ID_RI 
                                                ?>') {
            //     $('#lablenosuratkontrol').html('No. SPRI');
            //     $('#lablendpjpsuratkontrol').html('DPJP Pemberi SPRI');

            //     $('#<?php //echo CHtml::activeId($model, 'no_surat') 
                        ?>').attr('placeholder', 'No. SPRI');
            //     $('#<?php //echo CHtml::activeId($model, 'nama_dpjp') 
                        ?>').attr('placeholder', 'DPJP Pemberi SPRI');
            //     $('#tombolcari').attr('onclick', "$('#dialogSpri').dialog('open');return true;");
            //     $('#tombolcarispri').attr('onclick', "cariSpri()");
            //     $("#<?php //echo CHtml::activeId($model, 'jnspelayanan') 
                        ?>").val(1);

            //     $("#<?php //echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') 
                        ?>").removeClass("required");
            //     $("#<?php //echo CHtml::activeId($model, 'ppkrujukan') 
                        ?>").removeClass("required");
            //     $("#<?php //echo CHtml::activeId($model, 'ppkrujukan_nama') 
                        ?>").removeClass("required");
            //     $('.clsrujukan').hide();
            // }


        }
    }

    function setKelasRawatDrop() {
        var setting = {
            url: "<?php echo $this->createUrl('SetKelasRawatBpjs'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'instalasi_id=' + $('#instalasi_id').val() + '&pasienadmisi_id=' + $('#pasienadmisi_id').val(),
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, 'klsrawat') ?>").html(data.html);
            },
            error: function(data) {

            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function setChangeStatusKecelakaan() {
        if ($('#<?php echo CHtml::activeId($model, 'statuskecelakaan_kode') ?>').val() != '' && ($('#<?php echo CHtml::activeId($model, 'statuskecelakaan_kode') ?>').val() == 1 || $('#<?php echo CHtml::activeId($model, 'statuskecelakaan_kode') ?>').val() == 2 || $('#<?php echo CHtml::activeId($model, 'statuskecelakaan_kode') ?>').val() == 3)) {
            tampilKecelakaan();
            cekSuplesi($('input:radio[name="ARSepT[suplesi_jasaraharja]"]:checked'));
            setPropinsi();
            $("#<?php echo CHtml::activeId($model, 'is_lakalantas') ?>").val(1);

            $('.frminput_suplesi').show();
            $('.frminput_lppolisi').show();

            // if($('#<?php //echo CHtml::activeId($model,'statuskecelakaan_kode') 
                        ?>').val() == 3){
            //     $('#<?php //echo CHtml::activeId($model,'no_suplesi') 
                        ?>').val('');
            //     setRadioButton($(".suplesi_jasaraharja"), 0);
            //     $('.frminput_suplesi').hide();
            //     $('.frminput_lppolisi').show();
            // }else{
            //     $('.frminput_suplesi').show();
            //     $('.frminput_lppolisi').hide();
            // }
        } else {
            sembunyiKecelakaan();
            $("#<?php echo CHtml::activeId($model, 'is_lakalantas') ?>").val(0);
        }
    }

    function tampilKecelakaan() {
        $('#form-suplesi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-suplesi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-suplesi').removeClass().addClass("accordion-body in collapse");
        $('#content-suplesi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-suplesi').removeAttr("style").attr("style", "height:auto");
        $('#content-suplesi').find("input,select,textarea").removeAttr("disabled");
        $('#content-suplesi').find(".nosep").attr("readonly", true);
    }

    function sembunyiKecelakaan() {
        $('#content-suplesi').find(".required").addClass("not-required").removeClass("required");
        $('#form-suplesi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-suplesi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-suplesi').removeClass().addClass("accordion-body collapse");
        $('#content-suplesi').removeAttr("style").attr("style", "height:0px");
        $('#content-suplesi').find("input,select,textarea").attr("disabled", true);
    }

    function srkCariRiwayatSEPRI() {
        $("#dialogRSKRiwayatSEPRI").dialog("open");

        var no_kartu = $("#PPAsuransipasienbpjsM_nopeserta").val(); //$(".no_kartu_srk").val();

        if (no_kartu == "") {
            myAlert("Isi Nomor Kartu terlebih dahulu");
            $("#PPAsuransipasienbpjsM_nopeserta").focus()
            return false;
        }

        $(".tab_srk_riwayat_sep_ri").empty();
        $(".srk_tab_riwayat_base_ri").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/srkGetLoadRiwayatSEPRI'); ?>', {
            nokartu: no_kartu
        }, function(data) {
            console.log(data, 'data');
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_srk_riwayat_sep_ri").html(data.html);
            }
            $(".srk_tab_riwayat_base_ri").removeClass('animation-loading');
        }, 'json');
    }

    function srkCariRiwayatSEPRI_1() {
        $("#dialogRSKRiwayatSEPRI").dialog("open");

        var no_kartu = $("#<?php echo CHtml::activeId($model, 'nopeserta') ?>").val(); //$(".no_kartu_srk").val();

        console.log(no_kartu, 'nokartu bree')

        $(".tab_srk_riwayat_sep_ri").empty();
        $(".srk_tab_riwayat_base_ri").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/srkGetLoadRiwayatSEPRI'); ?>', {
            nokartu: no_kartu
        }, function(data) {
            console.log(data, 'data');
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_srk_riwayat_sep_ri").html(data.html);
            }
            $(".srk_tab_riwayat_base_ri").removeClass('animation-loading');
        }, 'json');
    }

    function getBpjsPPKRujukan(ppk) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (ppk == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        }
        if (ppk.trim().length != 8) {
            myAlert('PPK Rujukan harus 8 Digit');
            return false;
        }
        var aksi = 12; // 12 cari ppk rujukan
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&ppkrujukan=' + ppk + '&start=0&limit=1',
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                console.log(obj, 'obje');
                var asalrujukan_id = $('#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id'); ?>');
                var asalrujukan2 = $('#<?php echo CHtml::activeId($modRujukanBpjs->asalrujukan, 'asalrujukan_nama'); ?>');
                if (obj.response != null) {
                    myAlert("PKK : " + obj.response.faskes[0].kode + "\n" +
                        "Nama : " + obj.response.faskes[0].nama + "\n");
                    $('#<?php echo CHtml::activeId($model, 'ppkrujukan_nama'); ?>').val(obj.response.faskes[0].nama);
                    $('#<?php echo CHtml::activeId($model, 'ppkrujukan'); ?>').val(obj.response.faskes[0].kode);
                    asalrujukan_id.val(obj.response.faskes[0].asalrujukan_id);
                    // asalrujukan2.val(asalrujukan[obj.response.faskes[0].asalrujukan_id]);

                } else {
                    myAlert(obj.metadata.message);
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

    function setDiagnosaBpjs(kode_diagnosa, nama_diagnosa) {

        $('#<?php echo CHtml::activeId($model, 'diagnosaawal'); ?>').val(kode_diagnosa);
        $("#<?php echo CHtml::activeId($model, 'nama_diagnosaawal') ?>").val(kode_diagnosa + " - " + nama_diagnosa);

    }

    function resetDiagnosaBpjs() {

        $('#<?php echo CHtml::activeId($model, 'diagnosaawal'); ?>').val("");
        $("#<?php echo CHtml::activeId($model, 'nama_diagnosaawal') ?>").val("");

    }

    function isNaikKelas(obj) {
        $("#<?php echo CHtml::activeId($model, 'penanggungjwb_naikkls_id') ?>").prop('checked', true);
        var kelaspelayanan_id = $("#kelaspelayanan_id").val();
        if ($(obj).is(':checked')) {
            $('.is-naikkelas').show()
            $('.is-naikkelas').find(".not-required").addClass("required").removeClass("not-required");
            $("#<?php echo CHtml::activeId($model, 'klsRawatNaik') ?>").val(kelaspelayanan_id);

        } else {
            $('.is-naikkelas').hide()
            $('.is-naikkelas').find(".required").addClass("not-required").removeClass("required");
            $("#<?php echo CHtml::activeId($model, 'klsRawatNaik') ?>").val("");
        }
    }
</script>