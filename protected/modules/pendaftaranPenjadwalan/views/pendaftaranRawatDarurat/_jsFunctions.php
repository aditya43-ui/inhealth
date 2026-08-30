<script type="text/javascript">
    /** control accordion kecelakaan */
    $('#form-kecelakaan > div > .accordion-heading').click(function() {
        //    console.log("Kecelakaan Di Klik!");
        var is_pasienkecelakaan = $("#<?php echo CHtml::activeId($model, "is_pasienkecelakaan"); ?>");
        if (is_pasienkecelakaan.val() > 0) { //hide
            is_pasienkecelakaan.val(0);
        } else { //show
            is_pasienkecelakaan.val(1);
        }
    });


    function printRM1() {
        window.open('<?php echo $this->createUrl('printRM1', array('id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printStiker() {
        window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/infoKunjunganRJ/printStiker', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }
    
    function cekDokter() {
        var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();

        if (ruangan_id == "") {
            myAlert('Silakan pilih ruangan terlebih dahulu!');
        } else {
            $.fn.yiiGridView.update('dokter-v-grid', {
                data: {
                    "PPDokterV[ruangan_id]": ruangan_id,
                }
            });
            $("#dialogDokter").dialog('open');
        }
        return false;
    }

    function getRuanganPoliklinikPasien() {
        // Hanya digunakan di transaksi Pendaftaran Rawat Jalan
    }

    /**
     * print status rawat darurat dan karcis
     */
    function printStatusRD() {
        window.open('<?php echo $this->createUrl('printStatusRD', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
        <?php if ($model->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) { ?>
            window.open('<?php echo $this->createUrl('printKarcis', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', '', 'left=600,top=100,width=480,height=640');
        <?php } ?>
    }

    function printStatus() {
        window.open('<?php echo $this->createUrl('printStatus', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }
    /**
     * print gelang pasien
     */

    /** control accordion penanggung jawab pasien */
    /*
    $('#form-pjpasien > div > .accordion-heading').click(function() {
        //    console.log("Detail PJ Pasien Di Klik!");
        var is_adapjpasien = $("#<?php echo CHtml::activeId($model, "is_adapjpasien"); ?>");
        console.log(is_adapjpasien.val());
        if (is_adapjpasien.val() != 0) { //hide
            is_adapjpasien.val(0);
        } else { //show
            is_adapjpasien.val(1);
        }
    });
    */
    function printGelangPasien() {
        window.open('<?php echo $this->createUrl('PendaftaranRawatInap/printLabelGelang', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }
    /**
     * print karcis
     */
    function printKarcis() {
        window.open('<?php echo $this->createUrl('printKarcis', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }

    function printLabel() {
        window.open('<?php echo $this->createUrl('pendaftaranRawatJalan/printLabel', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', '_blank', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printLabelRD() {
        window.open('<?php echo $this->createUrl('printLabelRD', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    /**
     * override function yang di pendaftaranRawatJalan
     */
    function autoPrint() {
        // printStatusRD();  
        var carabayar_id = $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val();

        <?php if (Yii::app()->user->getState('isbridging') && isset($modSep->sep_id)) { ?>
            printSEP();
        <?php } ?>

        if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?>) {
            printLabelRD();
            printKarcis();
            printStiker();
        };
        if (carabayar_id == <?php echo Params::SYARAT_CARABAYAR_TUNAI ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_ASURANSI ?>) {
            printLabelRD()
            printKarcis()
            printStiker()
        }
        <?php //if (Yii::app()->user->getState('isbridging') && isset($modSep->sep_id)) { 
        ?>
        //printSEP();
        <?php //} 
        ?>
    }

    /**
     * menampilkan form verifikasi
     * @returns {undefined}
     */
    function setVerifikasi() {

        if (cekValidasiRiwayatVaksinasi != null) {
            if (!cekValidasiRiwayatVaksinasi()) {
                return false;
            }
        }

        var email = $('#<?php echo CHtml::activeId($modPasien, 'alamatemail') ?>').val();

        if (email.length === 0) {
            console.log('email kosong');
        } else {
            if (!isEmail(email)) {
                $('#<?php echo CHtml::activeId($modPasien, 'alamatemail') ?>').focus();
                myAlert("Email yang dimasukan tidak valid.");
                return false;
            };
        }



        if (requiredCheck($(".form_pendaftaran"))) {

            //	LNG-1578 untuk notif pemberitahuan sbelum simpan, jika pasien yang sudah terdaftar.	
            //	NIK : 201410001 
            var pasien_id = $('#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>').val();
            var nama_pasien = $('#<?php echo CHtml::activeId($modPasien, 'nama_pasien') ?>').val();

            //if (!cekNoAsuransiBpjs()) return false;
            if (!cekNoIdentitasPJ()) return false;

            $('#table-pasienterakhir').find("tbody > tr").each(function() {
                row_pasienid = $(this).find(".pasien_id").val();
                if (row_pasienid === pasien_id) {
                    myAlert('Pasien ' + nama_pasien + ' Sudah Terdaftar');
                }
            });
            $('#dialog-verifikasi').dialog("open");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('verifikasi'); ?>',
                data: $("form").serialize(),
                dataType: "json",
                success: function(data) {
                    //$('#dialog-verifikasi > .dialog-content').html(data.content);
                    if (data.ok == 1) {
                        $('#dialog-verifikasi > .dialog-content').html(data.content);
                    } else {
                        $('#dialog-verifikasi > .dialog-content').html('');
                        $('#dialog-verifikasi').dialog("close");
                        alert(data.msg);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            //untuk verifikasi hilangkan srbac loading
            $(".animation-loading").removeClass("animation-loading");
            $("form").find('.float').each(function() {
                $(this).val(formatFloat($(this).val()));
            });
            // $("form").find('.integer').each(function(){
            // 	$(this).val(formatInteger($(this).val()));
            // });
            $("form").find('.integer-decimal').each(function() {
                $(this).val(formatThousandDecimal($(this).val()));
            });

        }
        return false;
    }



    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }


    function cekNoIdentitasPJ() {

        // if ($(".is_adapjpasien").val() != 1){
        //return true;
        // myAlert("Penanggung jawab pasien harus diisi.");
        // return false;
        // }
        // if ($(".is_adapjpasien").val() != 1)
        //     return true;

        var jenis = null;
        var nomor = null;

        jenis = $(".jenisidentitas_pj").val();
        nomor = $(".nik_pj").val().trim();

        console.log("KTP", nomor);

        if (jenis.trim() == "KTP") {

            if (nomor == "") {
                $(".nik_pj").addClass('error');
                $(".nik_pj").parents(".control-group").addClass('error');
                $(".nik_pj")[0].focus();
                myAlert("Nomor KTP Penanggung Jawab Harus Diisi.");
                return false;

            }

            if (nomor.length != 16) {
                $(".nik_pj").addClass('error');
                $(".nik_pj").parents(".control-group").addClass('error');
                $(".nik_pj")[0].focus();
                myAlert("Nomor KTP Penanggung Jawab harus diinput 16 digit.");
                return false;
            }

            if (!cekRendundansiNomor(nomor)) {
                $(".nik_pj").addClass('error');
                $(".nik_pj").parents(".control-group").addClass('error');
                $(".nik_pj")[0].focus();
                myAlert("No KTP Penanggung Jawab yang anda masukan tidak sesuai. 4 digit diawal tidak boleh sama.");
                return false;
            }
        }

        return true;
    }

    function showUmumBpjs(carabayar) {

        if (carabayar == '<?php echo Params::CARABAYAR_ID_MEMBAYAR ?>') {
            $("#isumumbpjs").attr('style', 'display:block;');
        } else {
            $("#isumumbpjs").attr('style', 'display:none;');
        }
    }
    // cek jumlah saudara
    function cekJumlahSaudara(obj) {
        var anakke = $("#<?php echo CHtml::activeId($modPasien, 'anakke') ?>").val();
        var jumlahbersaudara = $("#<?php echo CHtml::activeId($modPasien, 'jumlah_bersaudara') ?>").val();

        if (anakke != '' && jumlahbersaudara != '') {
            if (anakke > jumlahbersaudara) {
                myAlert('Jumlah Anak ke, tidak boleh lebih besar dari jumlah bersaudara');
                // toastr.error("Jumlah Anak ke, tidak boleh lebih besar dari jumlah bersaudara","Perhatian");
                $("#<?php echo CHtml::activeId($modPasien, 'anakke') ?>").val('');
                $("#<?php echo CHtml::activeId($modPasien, 'jumlah_bersaudara') ?>").val('');
                return false;
            }
        }
    }

    function cekSuplesi(obj) {
        console.log('masuk');
        if ($(obj).val() == 1) {
            $("#PPSepT_no_suplesi").addClass("required");
            $("#PPSepT_no_suplesi").attr('disabled', false);
            $('.cari_suplesi').show();
            setPropinsi();
        } else {
            $("#PPSepT_no_suplesi").attr('disabled', 'disabled');
            $("#PPSepT_no_suplesi").removeClass("required");
            $("#PPSepT_no_suplesi").removeClass("error");
            $("#PPSepT_no_suplesi").parents(".control-group").removeClass("error");
            $('.cari_suplesi').hide();
        }
    }

    function setPropinsi() {
        console.log('masuk ke sini yah bre');
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
                        $("#PPSepT_propinsi_lakalantas_id").empty();
                        $("#PPSepT_propinsi_lakalantas_id").append(data.form);
                        var propinsi = $(".propinsi").val();
                        console.log('propinsi', propinsi);
                        $("#PPSepT_propinsi_lakalantas_id").val(propinsi);
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

        var propinsi = $("#<?php echo CHtml::activeId($modSep, 'propinsi_lakalantas_id') ?> option:selected").text();
        $("#<?php echo CHtml::activeId($modSep, 'propinsi_lakalantas_nama') ?>").val(propinsi);

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
                    url: '<?php echo $this->createUrl('SetDropdownKabupatenNew'); ?>',
                    data: {
                        propinsiList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#<?php echo CHtml::activeId($modSep, 'kabupaten_lakalantas_id') ?>").empty();
                        $("#<?php echo CHtml::activeId($modSep, 'kabupaten_lakalantas_id') ?>").append(data.form);
                        var kabupaten = $(".kabupaten").val();
                        console.log('kabupaten', kabupaten);
                        $("#PPSepT_kabupaten_lakalantas_id").val(kabupaten);
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

        var kabupaten = $("#<?php echo CHtml::activeId($modSep, 'kabupaten_lakalantas_id') ?> option:selected").text();
        $("#<?php echo CHtml::activeId($modSep, 'kabupaten_lakalantas_nama') ?>").val(kabupaten);

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
                    url: '<?php echo $this->createUrl('SetDropdownKecamatanNew'); ?>',
                    data: {
                        kabupatenList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#<?php echo CHtml::activeId($modSep, 'kecamatan_lakalantas_id') ?>").empty();
                        $("#<?php echo CHtml::activeId($modSep, 'kecamatan_lakalantas_id') ?>").append(data.form);
                        var kecamatan = $(".kecamatan").val();
                        console.log('kecamatan', kecamatan);
                        $("#PPSepT_kecamatan_lakalantas_id").val(kecamatan);
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
        var kecamatan = $("#<?php echo CHtml::activeId($modSep, 'kecamatan_lakalantas_id') ?> option:selected").text();
        var id = $("#<?php echo CHtml::activeId($modSep, 'kecamatan_lakalantas_id') ?> option:selected").val();
        $(".kecamatan").val(id)
        $("#<?php echo CHtml::activeId($modSep, 'kecamatan_lakalantas_nama') ?>").val(kecamatan);
    }
</script>