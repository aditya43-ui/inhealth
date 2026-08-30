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
        
        $("#iframeRencanaKontrol").attr("src","");
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

    var var_pendaftaran_id = null;
    var var_no_sep = null;

    /**
     * set form info pasien
     * @returns {undefined}
     */
    function setInfoPasien(pendaftaran_id, no_sep) {
        $("#form-infopasien").addClass("animation-loading");
        $("#form-isi").addClass("animation-loading");
        var instalasi_id = $("#instalasi_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('index',['jenis'=>'setpasien']); ?>',
            data: {
                instalasi_id: instalasi_id,
                pendaftaran_id: pendaftaran_id,
                no_pendaftaran: null,
                no_rekam_medik: null,
                pasienadmisi_id: null
            },
            dataType: "json",
            success: function(data) {
                setInfoPasienReset();
                $("#cari_pendaftaran_id").val(data.pendaftaran_id);
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#pasienadmisi_id").val(data.pasienadmisi_id);
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

                $("#form-infopasien").removeClass("animation-loading");              
                $("#nama_pasien").focus();

                
                $("#nomorkartu").val(no_sep);
                //$("#nomorsep").val(no_sep);
                //cariDataSep();
                

                                    
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
    
    
    /**
     * fungsi pencarian peserta BPJS berdasarkan Nomor Kartu
     */
    function cariDataSep(nomorsep, objJS) {
        var nama_diagnosa = $(objJS).parents('tr').find('.diagnosa').text();
        // var nomorsep = $('#nomorsep').val();
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
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
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
                    $("#diagnosaLengkap").val(nama_diagnosa);
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

    function cekInput() {
        if ($("#cari_pendaftaran_id").val() == "") {
            myAlert("Pasien harus dipilih");
            return false;
        }
        if ($("#no_sep").val() == "") {
            myAlert("Data SEP harus dicari");
            return false;
        }
        return true;
    }
</script>