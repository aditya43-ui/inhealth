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
    function cariDataSep(nomorsep) {
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

                $(row_sep).find(".list_no_sep")
                    .val("")
                    .addClass("animation-loading");

                $(row_sep).find(".list_data_sep")
                    .val("");
            },
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var peserta = obj.response.peserta;

                    $(row_sep).find(".list_no_sep").val(obj.response.noSep);
                    $(row_sep).find(".list_data_sep").val(data);
                } else {
                    if (obj.metaData.message == "OK") {
                        myAlert(obj.metaData.code);
                    } else {
                        myAlert(obj.metaData.message);
                    }
                }
                $(row_sep).find(".list_no_sep").removeClass("animation-loading");
            },
            error: function(data) {
                $(row_sep).find(".list_no_sep").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    var row_sep = null;

    function cariNomorSep(obj) {
        var row = $(obj).parents('tr');
        var no_kartu = $(row).find(".list_no_kartu").val();
        
        if (no_kartu.trim() == "") {
            myAlert("Nomor Kartu Asuransi harus diisi");
            return false;
        }

        row_sep = row;

        $("#dialogRiwayatSep").dialog("open");


        $(".tab_riwayat_sep").empty();
        $(".tab_riwayat_base").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('getLoadRiwayatSEP'); ?>', {
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


</script>