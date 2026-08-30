<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>


<script type="text/javascript">
    var is_signa_select = false;

    const cek_signa = (obj) => {
        var signa = $(obj).val();
        var id = $(obj).parents().parents().parents().attr("id");

        if (signa.length >= 30) {
            $('#' + id).find("#alert-signa").attr('style', 'display: block');
            $(obj).parents(".control-group").addClass('error');
            return false;
        } else {
            $('#' + id).find("#alert-signa").attr('style', 'display: none');
            $(obj).parents(".control-group").removeClass('error');
        }

        return true;
    }

    function sortTable() {
        var rows = $('#table-obatalkespasien tbody  tr').get();
        rows.sort(function(a, b) {

            var A = parseInt($(a).children('td').eq(1).html());
            var B = parseInt($(b).children('td').eq(1).html());

            if (A < B) {
                return -1;
            }

            if (A > B) {
                return 1;
            }

            return 0;

        });
        $.each(rows, function(index, row) {
            $('#table-obatalkespasien').children('tbody').append(row);
        });
    }

    function warningObat(obj) {
        var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
        var pendaftaran_id = '<?php echo $_GET["pendaftaran_id"]; ?>';
        var tglreseptur = $('#<?php echo CHtml::activeId($modReseptur, "tglreseptur") ?>').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cekObat'); ?>',
            data: {
                obatalkes_id: obatalkes_id,
                pendaftaran_id: pendaftaran_id,
                tglreseptur: tglreseptur,
            },
            dataType: "json",
            success: function(data) {
                if (data.warning !== 'aman') {
                    window.parent.myAlert(data.warning);
                }
                tambahObatNonRacik(obj);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }


    function form_tambah_signa() {
        myPrompt("Tambah Signa Baru", "", "", function(r) {
            var v = r;

            if (v.trim() == "") return false;

            myConfirm("Anda yakin untuk menambah signa '" + r + "'?", "Peringatan", function(yes) {
                if (yes) {
                    $.post('<?php echo $this->createUrl('/actionAjax/tambahSigna'); ?>', {
                        signa: v.trim()
                    }, function(data) {
                        window.parent.myAlert(data.msg);
                    }, 'json');
                }
            });
        });
    }

    //  RSWB-1488 - cek nilai max plafon
    var set_nilai_tanggungan = (is_paket, id) => {
        var pendaftaran_id = '<?= $_GET['pendaftaran_id'] ?>';

        $('#table-obatalkespasien > tbody').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('LoadDataTarif'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                id: id,
                is_paket: is_paket,
            }, //
            dataType: "json",
            success: function(data1) {
                if (data1.sukses === 0) {
                    myAlert(data1.pesan);
                    nilai_tanggungan = 0;
                } else {
                    nilai_tanggungan = 1;
                }

                $('#table-obatalkespasien > tbody').removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }


    function tambahDetailObat(obj) {
        var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        var ruangan_id = $('#<?php echo CHtml::activeId($modReseptur, "ruangan_id") ?>').val();
        var penjamin_id = $('#<?php echo CHtml::activeId($modReseptur, "penjamin_id") ?>').val();
        var isRacikan = 0;
        var paketobat_id = $('#paketobat_id').val();

        if (rke == undefined) {
            rke = 1;
        } else {
            rke++;
        }

        // if ('<?php echo Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ ?>') {
        //     set_nilai_tanggungan(1, paketobat_id);
        // }

        if (paketobat_id != '') {
            load_data_tarif(paketobat_id, 1);
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setDetailPaketObat'); ?>',
                data: {
                    paketobat_id: paketobat_id,
                    ruangan_id: ruangan_id,
                    isRacikan: isRacikan,
                    penjamin_id: penjamin_id,
                    rke: rke,
                },
                dataType: "json",
                success: function(data) {
                    if (data.pesan !== "") {
                        window.parent.myAlert(data.pesan);
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Params::MODUL_ID_GUDANGFARMASI; ?>,
                            judulnotifikasi: 'Stok Obat Alkes Habis',
                            isinotifikasi: obatalkes_kode + ' ' + namaObatNonRacik + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'
                        }; // 16
                        insert_notifikasi(params);
                        return false;
                    }
                    var tambahkandetail = true;

                    var therapiobatyangsama = $("#table-obatalkespasien input[name$='[therapiobat_id]'][value='" + therapiobat_id + "']");
                    if (therapiobatyangsama.val()) { //jika ada therapi obat sudah ada
                        window.parent.myAlert('Obat ini memiliki kelas therapi yang sama dengan pilihan obat sebelumnya');
                    }
                    var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
                    if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
                        myConfirm("Apakah anda akan input ulang obat ini?", "Perhatian!",
                            function(r) {
                                if (r) {
                                    $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function() {
                                        rke = $(this).parents("tr").find(".rke").val();
                                        $(this).parents('tr').remove();
                                    });

                                    if (tambahkandetail) {
                                        $('#table-obatalkespasien > tbody').append(data.form);

                                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                                            "symbol": "",
                                            "defaultZero": true,
                                            "allowZero": true,
                                            "decimal": ",",
                                            "thousands": "",
                                            "precision": 0
                                        });
                                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                                            "symbol": "",
                                            "defaultZero": true,
                                            "allowZero": true,
                                            "decimal": ",",
                                            "thousands": ".",
                                            "precision": 2
                                        });
                                        addDataKeGridObat(obj, 'nonracik', rke);
                                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                                        hitungTotal();
                                        // hitungtotalHargaReseptur();
                                    }

                                    $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                                    $('#namaObatNonRacik').val('');
                                    $('#nama_paket').val('');
                                    $('#paketobat_id').val('');
                                    $('#qtyNonRacik').val('');
                                    // formatNumberSemua()
                                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                                    sortTable();
                                } else {
                                    tambahkandetail = false;
                                }
                            });
                    } else {
                        if (tambahkandetail) {
                            $('#table-obatalkespasien > tbody').append(data.form);
                            $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                                "symbol": "",
                                "defaultZero": true,
                                "allowZero": true,
                                "decimal": ",",
                                "thousands": "",
                                "precision": 0
                            });
                            $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                                "symbol": "",
                                "defaultZero": true,
                                "allowZero": true,
                                "decimal": ",",
                                "thousands": ".",
                                "precision": 2
                            });
                            addDataKeGridObat(obj, 'nonracik', rke);
                            renameInputRowObatAlkes($("#table-obatalkespasien"));
                            hitungTotal();
                            // hitungtotalHargaReseptur();
                        }
                        $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                        $('#namaObatNonRacik').val('');
                        $('#nama_paket').val('');
                        $('#paketobat_id').val('');
                        $('#qtyNonRacik').val('');
                        // formatNumberSemua();
                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            window.parent.myAlert("Silakan pilih obat / alkes terlebih dahulu!");
        }
        $("#namaObatNonRacik").focus();
    }

    function tambahObatNonRacik(obj) {
        var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val()?$(obj).parents('#form-nonracikan').find('#obatalkes_id').val() :7862 ;
        console.log("obatalkes_id", obatalkes_id);
        var obatalkes_kode = $('#obatalkes_kode').val();
        var jumlah = $(obj).parents('#form-nonracikan').find('#qtyNonRacik').val();
        var formulaobatkronis_id = $(obj).parents('#form-nonracikan').find('#formulaobatkronis_id').val();
        var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        var namaObatNonRacik = $('#namaObatNonRacik').val();
        var ruangan_id = $('#<?php echo CHtml::activeId($modReseptur, "ruangan_id") ?>').val();
        var penjamin_id = $('#<?php echo CHtml::activeId($modReseptur, "penjamin_id") ?>').val();
        var isRacikan = 0;
        var therapiobat_id = $(obj).parents('.row-fluid').find('#therapiobat_id2').val();
        var rke_edit = $(obj).parents('#form-nonracikan').find('#rke').val();
        var is_obatkronis = $(obj).parents('#form-nonracikan').find('#is_obatkronis').val();
        var formulaobatkronis_id = $(obj).parents('#form-nonracikan').find('#formulaobatkronis_id').val();
        var obatlain = $(".namaobatlain").val();
        const dosis = $(obj).parents('#form-nonracikan').find(".dosis").val();
        const etiketwaktu = $(obj).parents('#form-nonracikan').find(".etiketwaktu").val();
        const frekuensi = $(obj).parents('#form-nonracikan').find(".frekuensi").val();
        const keterangan = $(obj).parents('#form-nonracikan').find(".keterangan").val();
        const satuankekuatan = $(obj).parents('#form-nonracikan').find("#satuan_permintaandosis").val();
        console.log(satuankekuatan);

        if (is_obatkronis == undefined) {
            is_obatkronis = '';
        }

        if (formulaobatkronis_id == undefined) {
            formulaobatkronis_id = '';
        }
        if (rke == undefined) {
            rke = 1;
        } else {
            rke++;
        }
        // console.log("Reseptur R", rke);

        if (jumlah <= 0) {
            window.parent.myAlert("Jumlah obat harus ada.");
            return false;
        }


        if ('<?php echo Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ ?>') {
            set_nilai_tanggungan(0, obatalkes_id);
        }

        if (obatalkes_id != '') {
            load_data_tarif(obatalkes_id, 0);
            console.log("obatlain",obatlain);
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
                data: {
                    obatalkes_id: obatalkes_id,
                    jumlah: jumlah,
                    ruangan_id: ruangan_id,
                    isRacikan: isRacikan,
                    therapiobat_id: therapiobat_id,
                    penjamin_id: penjamin_id,
                    is_obatkronis: is_obatkronis,
                    formulaobatkronis_id: formulaobatkronis_id,
                    dosis: dosis,
                    etiketwaktu: etiketwaktu,
                    keterangan: keterangan,
                    obatlain
                }, //
                dataType: "json",
                success: function(data) {
                    if (data.pesan !== "") {
                        window.parent.myAlert(data.pesan);
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Params::MODUL_ID_GUDANGFARMASI; ?>,
                            judulnotifikasi: 'Stok Obat Alkes Habis',
                            isinotifikasi: obatalkes_kode + ' ' + namaObatNonRacik + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'
                        }; // 16
                        insert_notifikasi(params);
                        return false;
                    }
                    var tambahkandetail = true;

                    // var therapiobatyangsama = $("#table-obatalkespasien input[name$='[therapiobat_id]'][value='" + therapiobat_id + "']");
                    // if (therapiobatyangsama.val()) { //jika ada therapi obat sudah ada
                    //     window.parent.myAlert('Obat ini memiliki kelas therapi yang sama dengan pilihan obat sebelumnya');
                    // }

                        if (tambahkandetail) {
                            $('#table-obatalkespasien > tbody').append(data.form);
                            $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                                "symbol": "",
                                "defaultZero": true,
                                "allowZero": true,
                                "decimal": ",",
                                "thousands": "",
                                "precision": 0
                            });
                            $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                                "symbol": "",
                                "defaultZero": true,
                                "allowZero": true,
                                "decimal": ",",
                                "thousands": ".",
                                "precision": 2
                            });
                            addDataKeGridObat(obj, 'nonracik', rke);
                            renameInputRowObatAlkes($("#table-obatalkespasien"));
                            hitungTotal();
                            // hitungtotalHargaReseptur();
                        }
                        $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                        $('#namaObatNonRacik').val('');
                        $('#formulaobatkronis_id').val("");
                        $('#qtyNonRacik').val('');
                        $("#dosisnon, #etiketwaktunon").val("-");
                        $("#keterangannon, #signa").val("");
                        $(obj).parents('#form-nonracikan').find('#is_obatkronis').attr('checked',false);
                    changeKronisObat($('#form-nonracikan').find('#is_obatkronis'));
                   
                        // $("#obatlain").val(""),
                        // formatNumberSemua();
                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            window.parent.myAlert("Silahkan pilih obat / alkes terlebih dahulu!");
        }
        $("#namaObatNonRacik").focus();
    }

    function tambahObatRacik(obj) {
        var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();
        var obatalkes_kode = $('#obatalkes_kode').val();
        var jumlah = $(obj).parents('#form-racikan').find('#qtyRacik').val();
        var permintaan = $(obj).parents('#form-racikan').find('#permintaan').val();
        var ruangan_id = $('#<?php echo CHtml::activeId($modReseptur, "ruangan_id") ?>').val();
        var rke = $(obj).parents('#form-racikan').find('#racikanKe').val();
        var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        var penjamin_id = $('#<?php echo CHtml::activeId($modReseptur, "penjamin_id") ?>').val();
        var is_obatkronis = $(obj).parents('#form-racikan').find('#is_obatkronis').val();
        var formulaobatkronis_id = $(obj).parents('#form-racikan').find('#formulaobatkronis_id').val();  
        var namaObatRacik = $('#namaObatRacik').val();
        var satuansediaan = $('#form-racikan').find('#satuansediaan_text').val();
        var jmlKemasanObat = $('#form-racikan').find('#jmlKemasanObat').val();
        var obatlain = $('#form-racikan').find('.namaobatlain').val();
        console.log(is_obatkronis,formulaobatkronis_id,obatlain);

        const dosis = $(obj).parents('#form-racikan').find(".dosis").val();
        const etiketwaktu = $(obj).parents('#form-racikan').find(".etiketwaktu").val();
        const frekuensi = $(obj).parents('#form-racikan').find(".frekuensi").val();
        const keterangan = $(obj).parents('#form-racikan').find(".keterangan").val();

        var indexrke = 0;
        var jmlrke = 0;
        var marginrke = 0;
        var statusmargin = 0;
        var isRacikan = 1;


        //    if ($("#jmlKemasanObat").val() == "") {
        //        myAlert("Jumlah kemasan untuk Racikan harus diisi");
        //        return false;
        //    }

        var kemasan = parseFloat(unformatNumber($("#jmlKemasanObat").val()));
        var permintaan = $("#permintaan").val();
        var kekuatan = parseFloat(unformatNumber($("#kekuatanObat").val()));


        if (jumlah <= 0) {
            myAlert("Jumlah obat harus ada.");
            return false;
        }

        if(permintaan <= 0 || permintaan == ""){
            myAlert("Permintaan dosis tidak boleh kosong");
            return false;
        }
        if (obatalkes_id != '') {

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
                data: {
                    obatalkes_id: obatalkes_id,
                    jumlah: jumlah,
                    ruangan_id: ruangan_id,
                    isRacikan: isRacikan,
                    penjamin_id: penjamin_id,
                    satuansediaan: satuansediaan,
                    jmlkemasan: jmlKemasanObat,
                    dosis: dosis,
                    is_obatkronis:is_obatkronis,
                    formulaobatkronis_id: formulaobatkronis_id,
                    etiketwaktu: etiketwaktu,
                    frekuensi: frekuensi,
                    keterangan: keterangan,
                    permintaan: permintaan,
                    obatlain
                }, //
                dataType: "json",
                success: function(data) {
                    if (data.pesan !== "") {
                        myAlert(data.pesan);
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Params::MODUL_ID_GUDANGFARMASI; ?>,
                            judulnotifikasi: 'Stok Obat Alkes Habis',
                            isinotifikasi: obatalkes_kode + ' ' + namaObatRacik + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'
                        }; // 16
                        insert_notifikasi(params);
                        return false;
                    }
                    var tambahkandetail = true;
                    // var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
                    // if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
                    //     myConfirm("Apakah anda akan input ulang obat ini?", "Perhatian!",
                    //         function(r) {
                    //             if (r) {
                    //                 $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function() {
                    //                     $(this).parents('tr').detach();
                    //                 });
                    //                 if (tambahkandetail) {
                    //                     if (indexrke == 0) {
                    //                         $('#table-obatalkespasien > tbody').append(data.form);
                    //                     } else {
                    //                         $('#table-obatalkespasien > tbody > tr:nth-child(' + (indexrke + marginrke) + ')').after(data.form);
                    //                         $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").parents('tr').find("#isi-r").hide();
                    //                         $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").parents('tr').find("input[name$='[total_embalase]']").val('');
                    //                     }
                    //                     $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                    //                         "symbol": "",
                    //                         "defaultZero": true,
                    //                         "allowZero": true,
                    //                         "decimal": ".",
                    //                         "thousands": ",",
                    //                         "precision": 0
                    //                     });
                    //                     $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                    //                         "symbol": "",
                    //                         "defaultZero": true,
                    //                         "allowZero": true,
                    //                         "decimal": ",",
                    //                         "thousands": ".",
                    //                         "precision": 2
                    //                     });
                    //                     addDataKeGridObat(obj, 'racik', rke);
                    //                     renameInputRowObatAlkes($("#table-obatalkespasien"));
                    //                     hitungTotal();
                    //                 }
                    //                 $(obj).parents('#form-racikan').find('#obatalkes_id').val('');
                    //                 $('#namaObatRacik').val('');
                    //             } else {
                    //                 tambahkandetail = false;
                    //             }
                    //         });
                    // } else {
                        $('#table-obatalkespasien > tbody > tr').each(function() {
                            if ($(this).find('input[name*="[rke]"]').val() == rke) {
                                if (marginrke == 0) {
                                    if (statusmargin == 0) {
                                        marginrke = jmlrke;
                                        statusmargin = 1;
                                    }
                                };
                                indexrke++;
                            }
                            jmlrke++;
                        });

                        if (tambahkandetail) {
                            if (indexrke == 0) {
                                $('#table-obatalkespasien > tbody').append(data.form);
                            } else {
                                $('#table-obatalkespasien > tbody > tr:nth-child(' + (indexrke + marginrke) + ')').after(data.form);
                                $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").parents('tr').find("#isi-r").hide();
                                $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").parents('tr').find("input[name$='[total_embalase]']").val('');
                            }
                            $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                                "symbol": "",
                                "defaultZero": true,
                                "allowZero": true,
                                "decimal": ".",
                                "thousands": ",",
                                "precision": 0
                            });
                            $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                                "symbol": "",
                                "defaultZero": true,
                                "allowZero": true,
                                "decimal": ",",
                                "thousands": ".",
                                "precision": 2
                            });
                            addDataKeGridObat(obj, 'racik', rke);
                            renameInputRowObatAlkes($("#table-obatalkespasien"));
                            hitungTotal();
                        }
                    // }

                    $(obj).parents('#form-racikan').find('#obatalkes_id').val('');
                    $('#namaObatRacik').val('');
                    $('#qtyNonRacik').val('');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Silakan pilih obat / alkes terlebih dahulu!");
        }
        $("#namaObatRacik").focus();
        setTombolRacikanBaru();
    }

    function addDataKeGridObat(obj, tipe, rke) {
        if (tipe == 'racik') {
            var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();
            var signa = $(obj).parents('#form-racikan').find('#signaracikan').val();
            var iterRacik = $('#iter').val();
            var kemasan = $(obj).parents('#form-racikan').find('#jmlKemasanObat').val();
            var kekuatan = $(obj).parents('#form-racikan').find('#kekuatanObat').val();
            var satuan_kekuatan = $(obj).parents('#form-racikan').find('#satuan_kekuatan_racikan').val();
            var pembilang = $(obj).parents('#form-racikan').find('#pembilang').val();
            var penyebut = $(obj).parents('#form-racikan').find('#penyebut').val();
            var formulaobatkronis_id = $(obj).parents('#form-racikan').find('#formulaobatkronis_id').val();
            var val_dosis = $(obj).parents('#form-racikan').find(".dosis").val();
            var val_etiketwaktu = $(obj).parents('#form-racikan').find(".etiketwaktu").val();
            var val_frekuensi = $(obj).parents('#form-racikan').find(".input_signa").val();
            var satuan_permintaandosis = $(obj).parents('#form-racikan').find('#satuan_permintaandosis').val();
            var permintaan = $(obj).parents('#form-racikan').find('#permintaan').val();
            var permintaan2 = $(obj).parents('#form-racikan').find('#permintaanresep').val();
            
            console.log(obj);
            console.log("permintaan"+permintaan);
            console.log(satuan_permintaandosis);
            var etiket = setEtiket($(obj).parents('#form-racikan').find('#etiketracikan1').val(), $(obj).parents('#form-racikan').find('#etiketracikan2').val(), $(obj).parents('#form-racikan').find('#etiketracikan3').val(), $(obj).parents('#form-racikan').find('#etiketracikan4').val());
            const table = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][frekuensi]"]');
            //var etiket = $(obj).parents('#form-racikan').find('#etiketracikan').val();
            //var etiket = setEtiket($(obj).parents('#form-racikan').find('#etiketracikan1').val(), $(obj).parents('#form-racikan').find('#etiketracikan2').val(), $(obj).parents('#form-racikan').find('#etiketracikan3').val(), $(obj).parents('#form-racikan').find('#etiketracikan4').val());
            var etiket = setEtiket(val_frekuensi, val_dosis, val_etiketwaktu, "");
            var satuansediaan = $(obj).parents('#form-racikan').find('#satuansediaan').val();
            // var satuansediaan = $(obj).parents('#form-racikan').find('#satuansediaan_text').val();
            var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][signa_reseptur]"]');
            input_signa.val(signa);

            const frekuensi = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][frekuensi]"]');
            frekuensi.val(signa);

            var input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaan_reseptur]"]');


            var satuansediaan = $(obj).parents('#form-racikan').find('#satuansediaan').val();
            var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][signa_reseptur]"]');
            input_signa.val(signa);
            var input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaan_reseptur]"]');

            input_permintaan.val(permintaan);
            var input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][jmlkemasan_reseptur]"]');
            input_kemasan.val(kemasan);
            var input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][kekuatan_reseptur]"]');
            input_kekuatan.val(kekuatan);
            var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][iter]"]');
            input_iter.val(iterRacik);
            var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][etiket]"]');
            input_etiket.val(etiket);
            var input_satuansediaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][satuansediaan]"]');
            input_satuansediaan.val(satuansediaan);
            var input_satuankekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][satuan]"]');
            input_satuankekuatan.val(satuan_kekuatan);
            var span_satuankekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('.satuankekuatan');
            span_satuankekuatan.text(satuan_kekuatan);
            var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][rke]"]');
            input_rke.val(rke);
            var input_pembilang = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaandosis_pembilang]"]');
            input_pembilang.val(pembilang);
            var input_penyebut = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaandosis_penyebut]"]');
            input_penyebut.val(penyebut);
            // var span_satuankekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('.satuankekuatan');
            // span_satuankekuatan.text(satuan_permintaandosis);
            var input_satuankekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][satuankekuatan]"]');
            input_satuankekuatan.val(satuan_permintaandosis);
            var span_satuankekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('.satuankekuatan');
            span_satuankekuatan.text(satuan_permintaandosis);
            var span_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('.resep_ke');
            span_rke.text(rke);

            var input_formulaobatkronis = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][formulaobatkronis_id]"]');
            input_formulaobatkronis.val(formulaobatkronis_id);

            var input_is_obatkronis = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][is_obatkronis]"]');
            input_is_obatkronis.val(is_obatkronis);
             //  $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][is_obatkronis]"]').val();
            
            if (penyebut !== '' && pembilang !== '') {
                var pecahan = pembilang + ' / '+penyebut;
                $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaan_temp]"]').val(pecahan);
                $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][is_permitaandosispecahan]"]').val(1);
            } else {
                if (permintaan !== "") {
                    $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaan_temp]"]').val(permintaan);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][is_permitaandosispecahan]"]').val(1);
                } else {
                    $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaan_temp]"]').val('0');
                }
            }

            // replaceRacikan(rke, etiket, signa, satuansediaan);
            var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][rke]"]');
            input_rke.val(rke);
        } else {
            var formulaobatkronis_id = $(obj).parents('#form-nonracikan').find('#formulaobatkronis_id').val();
            var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
            var signa = $(obj).parents('#form-nonracikan').find('#signa').val();
            var iterNonRacik = $('#iter').val();
            var val_dosis = $(obj).parents('#form-nonracikan').find(".dosis").val();
            var val_etiketwaktu = $(obj).parents('#form-nonracikan').find(".etiketwaktu").val();
            var val_frekuensi = $(obj).parents('#form-nonracikan').find(".input_signa").val();
            var etiket = setEtiket(val_frekuensi, val_dosis, val_etiketwaktu, "");
            var obatlain = $(obj).parents("#form-nonracikan").find('#obatlain').val();

            var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][signa_reseptur]"]');
            input_signa.val(signa);

            const frekuensi = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][frekuensi]"]');
            frekuensi.val(signa);

            var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][iter]"]');
            input_iter.val(iterNonRacik);
            var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][etiket]"]');
            input_etiket.val(etiket);

            var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][rke]"]');
            
            console.log(input_rke);
            input_rke.val(rke);
            var input_formulaobatkronis = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][formulaobatkronis_id]"]');
            input_formulaobatkronis.val(formulaobatkronis_id);
            $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaan_temp]"]').val('0,0');

            var span_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('.resep_ke');
            span_rke.text(rke);
        }
        <?php //if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RJ) { 
        ?>
        //window.parent.$("#is_reseptur").val('ada');
        <?php //} 
        ?>
        //enabledField();
    }

    function setEtiket(etiket_1, etiket_2, etiket_3, etiket_4) {
        var etiket_final = "";
        var count = 0;

        if (etiket_1 == " " || etiket_1 == "") {} else {
            count++;
            etiket_final += etiket_1;
        }
        if (etiket_2 == " " || etiket_2 == "") {} else {
            if (count == 1)
                etiket_final += " - ";
            count++;
            etiket_final += etiket_2;
        }
        if (etiket_3 == " " || etiket_3 == "") {} else {
            if (count == 2 || count == 1)
                etiket_final += " - ";
            count++;
            etiket_final += etiket_3;
        }
        if (etiket_4 == " " || etiket_4 == "") {} else {
            if (count == 3 || count == 2 || count == 1)
                etiket_final += " - ";
            count++;
            etiket_final += etiket_4;
        }

        return etiket_final;
    }


    function tambahObatReseptur(obatalkes_id, rke, rkelast, jumlah, signa, permintaan, kemasan, kekuatan, etiket) {
        var indexrke = 0;
        var jmlrke = 0;
        var marginrke = 0;
        var statusmargin = 0;

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {
                obatalkes_id: obatalkes_id,
                jumlah: jumlah
            }, //
            dataType: "json",
            success: function(data) {
                if (data.pesan !== "") {
                    window.parent.myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
                if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
                    myConfirm("Apakah anda akan input ulang obat ini?", "Perhatian!",
                        function(r) {
                            if (r) {
                                $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function() {
                                    $(this).parents('tr').detach();
                                });
                            } else {
                                tambahkandetail = false;
                            }
                        });
                }
                $('#table-obatalkespasien > tbody > tr').each(function() {
                    if ($(this).find('input[name*="[rke]"]').val() == rke) {
                        if (marginrke == 0) {
                            if (statusmargin == 0) {
                                marginrke = jmlrke;
                                statusmargin = 1;
                            }
                        };
                        indexrke++;
                    }
                    jmlrke++;
                });

                if (tambahkandetail) {
                    if (indexrke == 0) {
                        $('#table-obatalkespasien > tbody').append(data.form);
                    } else {
                        $('#table-obatalkespasien > tbody > tr:nth-child(' + (indexrke + marginrke) + ')').after(data.form);
                        $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").parents('tr').find("#isi-r").hide();
                    }
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": ".",
                        "precision": 0
                    });
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": ".",
                        "precision": 2
                    });
                    addDataKeGridObatReseptur(obatalkes_id, signa, permintaan, kemasan, kekuatan, etiket, rke);
                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    hitungTotal();
                    // hitungtotalHargaReseptur();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function addDataKeGridObatReseptur(obatalkes_id, signa, permintaan, kemasan, kekuatan, etiket, rke) {
        input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
        input_permintaan.val(permintaan);
        input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
        input_kemasan.val(kemasan);
        input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
        input_kekuatan.val(kekuatan);
        input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
    }

    /**
     * rename input grid
     */
    function renameInputRowObatAlkes(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
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
     * refresh dialog kunjungan
     * @returns {undefined}
     */
    function refreshDialogInfoPasien() {
        var instalasi_id = $("#instalasi_id").val();
        var instalasi_nama = $("#instalasi_id option:selected").text();
        $.fn.yiiGridView.update('datakunjungan-grid', {
            data: {
                "FAPasienM[idInstalasi]": instalasi_id,
                // "FAPasienM[instalasi_nama]":instalasi_nama,
            }
        });
    }

    /**
     * menghapus detail obat alkes pasien berdasarkan obatalkes_id
     * @param {type} caraPrint
     * @returns {undefined} */
    function batalObatAlkesPasienDetail(obj) {
        myConfirm("Apakah anda akan membatalkan penjualan obat alkes ini?", "Perhatian!",
            function(r) {
                    $(obj).parents("tr").remove();
                    hitungTotal();
                    // hitungtotalHargaReseptur();
                
            });
    }

    // function editObatAlkesPasienDetail(obj) {
    //     unformatNumberSemua();

    //     var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
    //     var formulaobatkronis_id = $(obj).parents('tr').find('input[name$="[formulaobatkronis_id]"]').val();
    //     var racikan_id = $(obj).parents('tr').find('input[name$="[racikan_id]"]').val();
    //     var permintaan_reseptur = $(obj).parents('tr').find('input[name$="[permintaan_reseptur]"]').val();
    //     var kekuatan_reseptur = $(obj).parents('tr').find('input[name$="[kekuatan_reseptur]"]').val();
    //     var satuankekuatan = $(obj).parents('tr').find('input[name$="[satuankekuatan]"]').val();
    //     var qty_reseptur = $(obj).parents('tr').find('input[name$="[qty_reseptur]"]').val();
    //     var signa_reseptur = $(obj).parents('tr').find('input[name$="[signa_reseptur]"]').val();
    //     var jmlkemasan_reseptur = $(obj).parents('tr').find('input[name$="[jmlkemasan_reseptur]"]').val();
    //     var satuansediaan = $(obj).parents('tr').find('input[name$="[satuansediaan]"]').val();
    //     var etiket = $(obj).parents('tr').find('input[name$="[etiket]"]').val();
    //     var rke = $(obj).parents('tr').find('input[name$="[rke]"]').val();
    //     var kodeObat = $(obj).parents('tr').find('span[name$="[obatalkes_kode]"]').html();
    //     var namaObat = $(obj).parents('tr').find('.obatalkes_nama').html();
    //     var obat = kodeObat + ' - ' + namaObat;
    //     var pembilang = $(obj).parents('tr').find('input[name$="[permintaandosis_pembilang]"]').val();
    //     var peyebut = $(obj).parents('tr').find('input[name$="[permintaandosis_penyebut]"]').val();


    //     formjenisresep(racikan_id);
    //     setTimeout(function() {
    //         explodeEtiket(etiket, racikan_id)
    //         if (racikan_id == <?= Params::RACIKAN_ID_RACIKAN ?>) {
    //             setEditRacikan(rke, signa_reseptur, jmlkemasan_reseptur, permintaan_reseptur, satuankekuatan, kekuatan_reseptur, obatalkes_id, obat, pembilang, peyebut);
    //             $('#jenisresep').val(1);
    //         } else {
    //             setEditNonRacikan(signa_reseptur, qty_reseptur, obatalkes_id, obat, formulaobatkronis_id, rke);
    //             $('#jenisresep').val(0);
    //         }
    //     }, 800);

    // }

    // function explodeEtiket(etiket, racikan_id) {
    //     var Etiket = etiket.split(" - ");

    //     if (racikan_id == 1) {
    //         $('#etiketracikan1').val(Etiket[0]);
    //         $('#etiketracikan2').val(Etiket[1]);
    //         $('#etiketracikan3').val(Etiket[2]);
    //         $('#etiketracikan4').val(Etiket[3]);
    //     } else {
    //         $('#etiketnonracikan1').val(Etiket[0]);
    //         $('#etiketnonracikan2').val(Etiket[1]);
    //         $('#etiketnonracikan3').val(Etiket[2]);
    //         $('#etiketnonracikan4').val(Etiket[3]);
    //     }
    // }

    // function setEditRacikan(rke, signa_reseptur, jmlkemasan_reseptur, permintaan_reseptur, satuankekuatan, kekuatan_reseptur, obatalkes_id, obat, pembilang, penyebut) {
    //     $("#form-racikan .add-on").hide();
    //     $("#form-racikan .icon-remove").hide();

    //     $("#form-racikan").find("#tombolracikanbaru").attr('disabled', true);
    //     $("#form-racikan").find("#racikanKe").attr('disabled', true);
    //     $("#form-racikan").find("#signaracikan").attr('readonly', false);
    //     $("#form-racikan").find("#satuansediaan").attr('disabled', false);
    //     $("#form-racikan").find("#namaObatRacik").attr('readonly', true);
    //     $("#form-racikan").find("#jmlKemasanObat").attr('readonly', true);
    //     $("#form-racikan").find('#racikanKe').val(rke);
    //     $("#form-racikan").find('#signaracikan').val(signa_reseptur);
    //     $("#form-racikan").find('#jmlKemasanObat').val(jmlkemasan_reseptur);
    //     $("#form-racikan").find("#permintaan").val(permintaan_reseptur);
    //     $("#form-racikan").find("#satuan_kekuatan_racikan").val(satuankekuatan);
    //     $("#form-racikan").find("#kekuatanObat").val(kekuatan_reseptur);
    //     $("#form-racikan").find('#obatalkes_id').val(obatalkes_id);
    //     $("#form-racikan").find("#namaObatRacik").val(obat);
    //     $("#form-racikan").find("#pembilang").val(pembilang);
    //     $("#form-racikan").find("#penyebut").val(penyebut);
    //     formatNumberSemua();
    //     hitungJumlahObat();
    // }

    // function setEditNonRacikan(signa_reseptur, qty_reseptur, obatalkes_id, obat, formulaobatkronis_id, rke) {
    //     $("#form-nonracikan .add-on").hide();
    //     $("#form-nonracikan .icon-remove").hide();
    //     $("#form-nonracikan").find("#namaObatNonRacik").attr('readonly', true);
    //     $("#form-nonracikan").find('#obatalkes_id').val(obatalkes_id);
    //     $("#form-nonracikan").find("#namaObatNonRacik").val(obat);
    //     $("#form-nonracikan").find("#qtyNonRacik").val(qty_reseptur);
    //     $("#form-nonracikan").find("#signa").val(signa_reseptur);
    //     $("#form-nonracikan").find("#formulaobatkronis_id").val(formulaobatkronis_id);
    //     $("#form-nonracikan").find("#rke").val(rke);
    //     if (formulaobatkronis_id != '') {
    //         $("#form-nonracikan").find("#is_obatkronis").val(1);
    //         $("#form-nonracikan").find("#is_obatkronis").prop("checked", false);
    //     }
    //     formatNumberSemua();
    // }

    // function enabledField() {
    //     $("#form-racikan").find("#tombolracikanbaru").attr('disabled', false);
    //     $("#form-racikan").find("#jmlKemasanObat").attr('readonly', false);
    //     $("#form-racikan").find("#namaObatRacik").attr('readonly', false);
    //     $("#form-racikan .add-on").show();
    //     $("#form-racikan .icon-remove").show();

    //     $("#form-nonracikan").find("#rke").val('');
    //     $("#form-nonracikan").find("#namaObatNonRacik").attr('readonly', false);
    //     $("#form-nonracikan .add-on").show();
    //     $("#form-nonracikan .icon-remove").show();
    // }

    // function replaceRacikan(rke, etiket, signa, satuansediaan) {
    //     $('#table-obatalkespasien').find("tbody > tr").each(function() {
    //         var rke_field = $(this).find('input[name*="[rke]"]').val();

    //         if (rke == rke_field) {
    //             $(this).find('input[name*="[signa_reseptur]"]').val(signa);
    //             $(this).find('input[name*="[etiket]"]').val(etiket);
    //             $(this).find('input[name*="[satuansediaan]"]').val(satuansediaan);
    //         }
    //     });
    // }

    //TIDAK DIGUNAKAN ?
    function hitungSubTotal(obj) {
        unformatNumberSemua();
        harga = parseInt($(obj).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
        qty = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
        diskon = parseInt($(obj).parents('tr').find('input[name$="[discount]"]').val());

        totaliurbiaya = ((harga * qty) - ((harga * qty) * (diskon / 100)));
        iurbiaya = $(obj).parents('tr').find('input[name$="[iurbiaya]"]');

        subtotal = $(obj).parents('tr').find('input[name$="[hargajual_oa]"]');
        totalsubtotal = ((harga * qty) - ((harga * qty) * (diskon / 100)));
        if (totaliurbiaya <= 0) {
            totaliurbiaya = 0;
        }

        if (totalsubtotal <= 0) {
            totalsubtotal = 0;
        }

        subtotal.val(totalsubtotal);
        iurbiaya.val(totaliurbiaya);

        hitungTotal();
        formatNumberSemua();
    }

    function hitungTotal() {
        unformatNumberSemua();
        obj_totalharganetto = $('#<?php echo CHtml::activeId($modReseptur, "totharganetto") ?>');
        obj_totalhargajual = $('#<?php echo CHtml::activeId($modReseptur, "totalhargajual") ?>');
        var jasapelayanan_farmasi = parseFloat($('input[name*="[jasapelayanan_farmasi]"]').val());
        if (isNaN(jasapelayanan_farmasi)) {
            jasapelayanan_farmasi = 0;
        }
        totalharganetto = 0;
        totalhargajual = 0;
        $('#table-obatalkespasien > tbody > tr').each(function() {
            var ppnpersen = parseFloat($(this).find('input[name*="[persenppnjual]"]').val());
            var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_reseptur]"]').val());
            var qty = parseFloat(unformatNumber($(this).find('input[name*="[qty_reseptur]"]').val()));
            var biayaadmin = parseFloat($(this).find('input[name*="[biayaadministrasi]"]').val());
            var persdiskon = parseFloat($(this).find('input[name*="[persdiskon]"]').val());
            var total_embalase = parseFloat($(this).find('input[name*="[total_embalase]"]').val());

            if (isNaN(total_embalase)) {
                total_embalase = 0;
            }

            if (isNaN(persdiskon)) {
                persdiskon = 0;
            }

            if (Math.ceil(persdiskon) > 100) {
                window.parent.myAlert('Diskon (%) Lebih dari 100%');
                persdiskon = 0;
                $(this).find('input[name*="[persdiskon]"]').val(0);
            }

            var jmlqty = (hargasatuan * qty);
            if (jmlqty > 0) {
                jmlqty = parseFloat(jmlqty.toFixed(2));
            }

            var totalbiayaadmin = (biayaadmin * qty);
            if (totalbiayaadmin > 0) {
                totalbiayaadmin = parseFloat(totalbiayaadmin.toFixed(2));
            }

            var jmldiskon = (((jmlqty + totalbiayaadmin) * persdiskon) / 100);
            if (jmldiskon > 0) {
                jmldiskon = parseFloat(jmldiskon.toFixed(2));
            }

            var subSementara = jmlqty + total_embalase + totalbiayaadmin - jmldiskon;

            var jmlppn = ((subSementara * ppnpersen) / 100);
            if (jmlppn > 0) {
                jmlppn = parseFloat(jmlppn.toFixed(2));
            }

            var subtotal = subSementara + jmlppn;
            $(this).find('input[name*="[jumlahppn]"]').val(jmlppn);
            $(this).find('input[name*="[hargajual_reseptur]"]').val(subtotal);
            $(this).find('input[name*="[totalbiayaadministrasi]"]').val(totalbiayaadmin);
            $(this).find('input[name*="[jumlahdiskon]"]').val(jmldiskon);

            totalharganetto += parseFloat($(this).find('input[name*="[harganetto_oa]"]').val() * $(this).find('input[name*="[qty_oa]"]').val());
            totalhargajual = totalhargajual + jasapelayanan_farmasi + subtotal;
            // totalhargajual += subtotal;
        });

        obj_totalharganetto.val(totalharganetto);
        obj_totalhargajual.val(totalhargajual);
        $('#totalHargaReseptur').val(totalhargajual);

        formatNumberSemua();
        
        setChangedForm();
    }

    function hitungPersenDiskon() {
        unformatNumberSemua();

        $('#table-obatalkespasien > tbody > tr').each(function() {
            var totalbiayaadmin = parseFloat($(this).find('input[name*="[totalbiayaadministrasi]"]').val());
            var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_reseptur]"]').val());
            var qty = parseFloat($(this).find('input[name*="[qty_reseptur]"]').val());
            var jmldiscount = parseFloat($(this).find('input[name*="[jumlahdiskon]"]').val());

            var jmlqty = (hargasatuan * qty);
            if (jmlqty > 0) {
                jmlqty = parseFloat(jmlqty.toFixed(2));
            }

            var diskoPersen = ((jmldiscount / (jmlqty + totalbiayaadmin)) * 100);
            if (diskoPersen > 0) {
                diskoPersen = parseFloat(diskoPersen.toFixed(2));
            }

            if (Math.ceil(diskoPersen) > 100) {
                window.parent.myAlert('Diskon (%) Lebih dari 100%');
                diskoPersen = 0;
            }

            $(this).find('input[name*="[persdiskon]"]').val(diskoPersen);
        });
        formatNumberSemua();
        hitungTotal();
    }

    /**
     * class integer2 di unformat
     * @returns {undefined}
     */
    // function unformatNumberSemua(){
    //     $(".integer2").each(function(){
    //         $(this).val(parseFloat(unformatNumber($(this).val())));
    //     });
    //     $(".float2").each(function() {
    //         $(this).val(parseFloat(unformatNumber($(this).val())));
    //     });
    // }
    /**
     * class integer2 di format kembali
     * @returns {undefined}
     */
    // function formatNumberSemua(){
    //     $(".integer2").each(function(){
    //         $(this).val(formatNumber($(this).val()));
    //     });
    //
    //     $(".float2").each(function() {
    //         $(this).val(formatFloat(parseFloat($(this).val())));
    //     });
    // }

    /**
     * untuk print penjualan dokter
     */
    function print(caraPrint, idReseptur) {
        var pendaftaran_id = '<?php echo isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id=' + pendaftaran_id + '&idReseptur=' + idReseptur + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printPenjualan(caraPrint, idPenjualan) {
        var pendaftaran_id = '<?php echo isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
        window.open('<?php echo $this->createUrl('printPenjualan'); ?>&id=' + pendaftaran_id + '&idPenjualan=' + idPenjualan + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    /**
     * set form obat dari reseptur detail
     * @returns {undefined}
     */
    function setFormObatReseptur() {
        $('#tabel-detailreseptur tbody').find('tr').each(function() {
            var obatalkes_id = $(this).find('input[name*="[obatalkes_id]"]').val();
            var signa = $(this).find('input[name*="[signa_reseptur]"]').val();
            var permintaan = $(this).find('input[name*="[permintaan_reseptur]"]').val();
            var kemasan = $(this).find('input[name*="[jmlkemasan_reseptur]"]').val();
            var kekuatan = $(this).find('input[name*="[kekuatan_reseptur]"]').val();
            var jumlah = $(this).find('input[name*="[qty_reseptur]"]').val();
            var rke = $(this).find('input[name*="[rke]"]').val();
            var etiket = $(this).find('input[name*="[etiket]"]').val();
            var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
            tambahObatReseptur(obatalkes_id, rke, rkelast, jumlah, signa, permintaan, kemasan, kekuatan, etiket);
        });
    }

    function cekObat() {
        if (requiredCheck($("form"))) {
            var jumlah_obat = $('#table-obatalkespasien tbody tr').length;
            console.log
            if (jumlah_obat <= 0) {
                window.parent.myAlert('Isikan obat alkes terlebih dahulu.');
                return false;
            } else {
                $(".qty, .integer2, .float2, .integer-decimal").each(function() {
                    $(this).val(unformatNumber($(this).val()));
                });
                $('#rjreseptur-t-form').submit();
                $("#btn_submit").attr("disabled", true);
            }

            $(".animation-loading").removeClass("animation-loading");
            $("form").find('.float, .qty').each(function() {
                $(this).val(formatFloat(parseFloat($(this).val())));
            });
            $("form").find('.integer2').each(function() {
                $(this).val(formatInteger(parseFloat($(this).val())));
            });
            $("form").find('.integer-decimal').each(function() {
                $(this).val(formatThousandDecimal(parseFloat($(this).val())));
            });
        }
        return false;

    }
    /**
     * ubah takaran resep
     * @returns {undefined}
     */
    function ubahTakaranResep(obj) {
        var takaran = $(obj).val();
        var takarantext = $(obj).find("[value='" + takaran + "']").text();
        myConfirm('Proses perhitungan takaran resep hanya bisa dilakukan satu kali. Apakah anda ingin mengubah takaran semua obat menjadi ' + takarantext + ' dari resep?', 'Perhatian!', function(r) {
            if (r) {
                proporsiTakaranResep(takaran);
                $(obj).attr('readonly', true);
                $(obj).click(function() {
                    $('#<?php echo CHtml::activeId($modReseptur, "totalhargajual") ?>').focus();
                });
            } else {
                $(obj).val(1);
            }
        });
    }

    /**
     * menghitung proporsi semua obat berdasarkan takaran
     * @returns {undefined}
     */
    function proporsiTakaranResep(takaran) {
        $('#table-obatalkespasien > tbody').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetProporsiTakaranResep'); ?>',
            data: {
                takaran: takaran,
                data: $("input[name*='FAObatalkesPasienT']").serialize()
            }, //
            dataType: "json",
            success: function(data) {
                $('#table-obatalkespasien > tbody tr').detach();
                $('#table-obatalkespasien > tbody').append(data.form);
                renameInputRowObatAlkes($("#table-obatalkespasien"));
                hitungTotal();
                $('#table-obatalkespasien > tbody').removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setOaByRuangTujuan(obj) {
        var ruangan = $(obj).find("option:selected").text();

        $("#form-nonracikan").addClass("animation-loading");
        $("#form-racikan").addClass("animation-loading");
        clearInputan();

        $(".rid").html(ruangan);

        $('#ruanganapotek_id').val(obj.value);
        setTimeout(function() {
            $("#form-nonracikan").removeClass("animation-loading");
            $("#form-racikan").removeClass("animation-loading");
        }, 500);
    }

    function clearInputan() {
        $('#obatalkes_id').val('');
        $('#obatalkes_kode').val('');
        $('#ruanganapotek_id').val('');
        $('#namaObatNonRacik').val('');
        $('#therapiobat_id2').val('');
    }

    function terapiobat_reset() {
        $("#form-nonracikan").addClass("animation-loading");
        var ruangantujuan_id = $('#ruanganapotek_id').val();
        $('#therapiobat_id').val('');
        $('#therapiobat_nama').val('');
        $('#RJObatAlkesM_therapiobat_id').val('');
        clearInputan();
        $('#ruanganapotek_id').val($('#<?php echo CHtml::activeId($modReseptur, "ruangan_id") ?>').val());
        setTimeout(function() {
            $("#form-nonracikan").removeClass("animation-loading");
        }, 500);
    }

    $('#tombolDialogOa').click(function() {
        var therapiobat_id = $('#therapiobat_id').val();
        var ruangantujuan_id = $('#ruanganapotek_id').val();
        $.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
            data: {
                "RJObatAlkesM[ruangan_id]": ruangantujuan_id,
                "RJObatAlkesM[therapiobat_id]": therapiobat_id,
            }
        });
    });
    
    $('#tombolDialogOaRacikan').click(function() {
        $("#permintaan").val('');
        $('.namaobatlain').val("");
        var ruangantujuan_id = $('#ruanganapotek_id').val();
        $.fn.yiiGridView.update('obatAlkesDialogRacikan-m-grid', {
            data: {
                "RJObatAlkesM[ruangan_id]": ruangantujuan_id,
            }
        });
    });


    function setEditRacikan(rke, signa_reseptur, jmlkemasan_reseptur, permintaan_reseptur, satuankekuatan, kekuatan_reseptur, obatalkes_id, obat, pembilang, penyebut, namaRacikan){
        $("#form-racikan .add-on").hide();
        $("#form-racikan .icon-remove").hide();

        $("#form-racikan").find("#tombolracikanbaru").attr('disabled', true);
        $("#form-racikan").find("#racikanKe").attr('disabled', true);
        $("#form-racikan").find("#signaracikan").attr('readonly', false);
        $("#form-racikan").find("#satuansediaan").attr('disabled', false);
        $("#form-racikan").find("#namaObatRacik").attr('readonly', true);
        $("#form-racikan").find("#jmlKemasanObat").attr('readonly', true);
        $("#form-racikan").find('#racikanKe').val(rke);
        $("#form-racikan").find('#signaracikan').val(signa_reseptur);
        $("#form-racikan").find('#jmlKemasanObat').val(jmlkemasan_reseptur);
        $("#form-racikan").find("#permintaan").val(permintaan_reseptur);
        $("#form-racikan").find("#satuan_kekuatan_racikan").val(satuankekuatan);
        $("#form-racikan").find("#kekuatanObat").val(kekuatan_reseptur);
        $("#form-racikan").find('#obatalkes_id').val(obatalkes_id);
        $("#form-racikan").find("#namaObatRacik").val(obat);
        $("#form-racikan").find("#pembilang").val(pembilang);
        $("#form-racikan").find("#penyebut").val(penyebut);
        $("#form-nonracikan").find("#formulaobatkronis_id").val(formulaobatkronis_id);
        $("#form-racikan").find("#nama_obat_racikan").val(namaRacikan);
        if(formulaobatkronis_id != ''){
            $("#form-nonracikan").find("#is_obatkronis").val(1);
            $("#form-nonracikan").find("#is_obatkronis").prop("checked", false);
        }
        formatNumberSemua();
        hitungJumlahObat();
    }

    function setEditNonRacikan(signa_reseptur, qty_reseptur, obatalkes_id, obat, formulaobatkronis_id, rke){
        $("#form-nonracikan .add-on").hide();
        $("#form-nonracikan .icon-remove").hide();
        $("#form-nonracikan").find("#namaObatNonRacik").attr('readonly', true);
        $("#form-nonracikan").find('#obatalkes_id').val(obatalkes_id);
        $("#form-nonracikan").find("#namaObatNonRacik").val(obat);
        $("#form-nonracikan").find("#qtyNonRacik").val(qty_reseptur);
        $("#form-nonracikan").find("#signa").val(signa_reseptur);
        $("#form-nonracikan").find("#formulaobatkronis_id").val(formulaobatkronis_id);
        $("#form-nonracikan").find("#rke").val(rke);
        if(formulaobatkronis_id != ''){
            $("#form-nonracikan").find("#is_obatkronis").val(1);
            $("#form-nonracikan").find("#is_obatkronis").prop("checked", false);
        }
        formatNumberSemua();
    }

    // function untuk men set dialog oa agar berelasi dengan therapiobatmap_m
    function setOAJoinTerapi() {
        var therapiobat_id = $('#therapiobat_id').val();
        var ruangantujuan_id = $('#ruanganapotek_id').val();
        $("#namaObatNonRacik").addClass("animation-loading-1");
        $.fn.yiiGridView.update('rjobat-alkes-m-nonracik-grid', {
            data: {
                "RJObatAlkesM[ruangan_id]": ruangantujuan_id,
                "RJObatAlkesM[therapiobat_id]": therapiobat_id,
            }
        });
        setTimeout(function() {
            $("#namaObatNonRacik").removeClass("animation-loading-1");
        }, 500);
    }

    function setThreapiobat_id(obatalkes_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setTherapiobatid'); ?>',
            data: {
                obatalkes_id: obatalkes_id
            }, //
            dataType: "json",
            success: function(data) {
                if(obatalkes_id == 7862){
                    $('.namaobatlain').removeClass('hidden');
                }else{
                    $('#obatlain').val('');
                    $('.namaobatlain').addClass('hidden');
                }
                renameInputRowObatAlkes($("#table-obatalkespasien"));
                if (data) {
                    $("#therapiobat_id2").val(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setObat(obatalkes_id){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setTherapiobatid'); ?>',
            data: {
                obatalkes_id: obatalkes_id
            }, //
            dataType: "json",
            success: function(data) {
                if(obatalkes_id == 7862){
                    $('.namaobatlain').removeClass('hidden');
                }else{
                    $('.namaobatlain').addClass('hidden');
                    $('.namaobatlain').val("");
                }
                renameInputRowObatAlkes($("#table-obatalkespasien"));
                if (data) {
                    $("#therapiobat_id2").val(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hitungtotalHargaReseptur() {
        unformatNumberSemua();
        $("#totalHargaReseptur").addClass("animation-loading-1");
        var total = 0;
        $("#table-obatalkespasien > tbody > tr").each(function() {
            total = +parseInt($(this).find('input[name$="[hargajual_reseptur]"]').val());
        });
        setTimeout(function() {
            $('#totalHargaReseptur').val(total);
            $("#totalHargaReseptur").removeClass("animation-loading-1");
            formatNumberSemua();
        }, 300);

    }

    function formjenisresep(jenisresep) {
        $("#formjenisresep").addClass("animation-loading");
        setTimeout(function() {
            if (jenisresep == 1) {
                $("#form-nonracikan, #judul_non_racikan").hide();
                $("#form-racikan, #judul_racikan").show();
            } else {
                $("#form-nonracikan, #judul_non_racikan").show();
                $("#form-racikan, #judul_racikan").hide();
            }
            $("#formjenisresep").removeClass("animation-loading");
        }, 500);
    }

    // function hitungJumlahObat() {
    //     // unformatNumberSemua();
    //     $("#qtyRacik").addClass("animation-loading-1");
    //     var jmlkemasanobat = $('#jmlKemasanObat').val();
    //     var permintaan = parseFloat(unformatNumber($('#permintaan').val()));
    //     var kekuatanobat = parseFloat(unformatNumber($('#kekuatanObat').val()));

    //     setTimeout(function() {
    //         if ((jmlkemasanobat != '') && (permintaan != '') && (kekuatanobat != '')) {
    //             var jmlobat = permintaan * jmlkemasanobat / kekuatanobat;
    //             // $("#tomboltambahracikan").attr("disabled", false);
    //         } else {
    //             var jmlobat = 0;
    //             // $("#tomboltambahracikan").attr("disabled", true);
    //         }

    //         $("#qtyRacik").val(formatFloat(jmlobat));
    //         $("#qtyRacik").removeClass("animation-loading-1");
    //     }, 500);

    // }

    const load_data_tarif = (id, is_paket) => {
        var pendaftaran_id = <?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : '' ?>;

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('LoadDataTarif'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                id: id,
                is_paket: is_paket,
            }, //
            dataType: "json",
            success: function(data1) {
                if (data1.sukses === 0) {
                    myAlert(data1.pesan);
                }

                $('#table-obatalkespasien > tbody').removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }


    function hitungJumlahObatQty() {
        // unformatNumberSemua();
        $("#permintaan").addClass("animation-loading-1");
        var jmlkemasanobat = $('#jmlKemasanObat').val();
        // var permintaan = parseFloat(unformatNumber($('#permintaan').val()));
        var kekuatanobat = $('#kekuatanObat').val();
        var qtyRacik = parseFloat(unformatNumber($("#qtyRacik").val()));

        setTimeout(function() {
            if ((qtyRacik != '') && (jmlkemasanobat != '') && (kekuatanobat != '')) {
                var permintaan = qtyRacik * kekuatanobat / jmlkemasanobat;
                // $("#tomboltambahracikan").attr("disabled", false);
            } else {
                var permintaan = 0;
                // $("#tomboltambahracikan").attr("disabled", true);
            }

            $("#permintaan").val(formatFloat(permintaan));
            $("#permintaan").removeClass("animation-loading-1");
        }, 500);

    }

    function setTombolRacikanBaru() {
        $("#formanak").addClass("animation-loading-1");
        setTimeout(function() {
            $("#tombolracikanbaru").attr('disabled', false);
            $("#racikanKe").attr('disabled', true);
            $("#signaracikan").attr('disabled', true);
            $("#etiketracikan").attr('disabled', true);
            $("#jmlKemasanObat").attr('disabled', true);
            $("#satuansediaan").attr('disabled', true);
            // $("#permintaan").val('');
            $("#kekuatanObat").val('');
            // $("#penyebut").val('');
            // $("#pembilang").val('');
            $("#namaObatRacik").val('');
            // $("#obatalkes_id").val('');
            $("#formulaobatkronis_id").val('');
            $("#is_obatkronis").prop('checked', false);
            // hitungJumlahObat();
            $("#formanak").removeClass("animation-loading-1");
        }, 1000);
    }

    function racikanBaru() {
        $("#formanak").addClass("animation-loading-1");
        setTimeout(function() {
            $("#tombolracikanbaru").attr('disabled', true);
            $("#racikanKe").attr('disabled', false);
            $("#signaracikan").attr('disabled', false);
            $("#etiketracikan").attr('disabled', false);
            $("#jmlKemasanObat").attr('disabled', false);
            $("#satuansediaan").attr('disabled', false);
            $("#jmlKemasanObat").val('');
            $("#signaracikan").val("");
            $("#dosisracik").val("");
            $("#etiketwakturacik").val("");
            $("#keteranganracik").val("");
            $("#permintaan").val('');
            $("#kekuatanObat").val('');
            $("#namaObatRacik").val('');
            // $("#obatlain").val('');
            // $("#penyebut").val('');
            // $("#pembilang").val('');
            // $("#namaObatRacik").val('');
            // $("#obatalkes_id").val('');
            // $("#signaracikan").val('');
            // hitungJumlahObat();
            setDropDownRke();
            $("#formanak").removeClass("animation-loading-1");
        }, 500);
    }

    function setDropDownRke() {
        var rmax = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        if (isNaN(rmax)) {
            rmax = 0;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownRke'); ?>',
            data: {
                rmax: rmax++
            }, //
            dataType: "json",
            success: function(data) {
                $('#racikanKe').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function changeKronisObat(obj) {
        if ($(obj).prop('checked') == true) {
            $('#form-nonracikan').find('#formulaobatkronis_id').attr('disabled', false);
            $('#form-racikan').find('#formulaobatkronis_id').attr('disabled', false);
            
        } else {
            $('#form-nonracikan').find('#formulaobatkronis_id').val('');
            $('#form-nonracikan').find('#formulaobatkronis_id').attr('disabled', true);

            $('#form-racikan').find('#formulaobatkronis_id').val('');
            $('#form-racikan').find('#formulaobatkronis_id').attr('disabled', true);
        }
    }

    function setFormulaobat() {
        var value = $('#form-nonracikan').find('#qtyNonRacik').val();
        
        $("#qty").val(value);

        if ($('#form-nonracikan').find('#formulaobatkronis_id').prop('disabled') == false) {
            var nilai = '';
            $('#form-nonracikan').find('#formulaobatkronis_id').find('option').each(function() {
                var dataoption = $(this).data('jumlahobat');

                if (dataoption != undefined) {
                    if (dataoption == value) {
                        nilai = $(this).val();
                    }
                }

            });
            $('#form-nonracikan').find('#formulaobatkronis_id').val(nilai);
        } else {
            $('#form-nonracikan').find('#formulaobatkronis_id').val('');
        }
    }


    function setFormulaobat2() {
        var value = $('#form-racikan').find('#qtyRacik').val();
        
        $("#qty").val(value);

        if ($('#form-racikan').find('#formulaobatkronis_id').prop('disabled') == false) {
            var nilai = '';
            $('#form-racikan').find('#formulaobatkronis_id').find('option').each(function() {
                var dataoption = $(this).data('jumlahobat');

                if (dataoption != undefined) {
                    if (dataoption == value) {
                        nilai = $(this).val();
                    }
                }

            });
            $('#form-racikan').find('#formulaobatkronis_id').val(nilai);
        } else {
            $('#form-racikan').find('#formulaobatkronis_id').val('');
        }
    }


    function setSediaanRacikan() {
        var nominal = $('#form-racikan').find('#satuansediaan').val();
        var text = $('#form-racikan').find('#satuansediaan :selected').text();
        var jmlkemasan = $('#form-racikan').find('#jmlKemasanObat').val();

        if (nominal != '') {
            $('#form-racikan').find('#satuansediaan_text').val(text);
            $('#form-racikan').find('#tarifembalase').val(formatThousandDecimal(nominal * jmlkemasan));
        }
    }

    function tambahDetailObat(obj) {
        var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        var ruangan_id = $('#<?php echo CHtml::activeId($modReseptur, "ruangan_id") ?>').val();
        var penjamin_id = $('#<?php echo CHtml::activeId($modReseptur, "penjamin_id") ?>').val();
        var isRacikan = 0;
        var paketobat_id = $('#paketobat_id').val();

        if (rke == undefined) {
            rke = 1;
        } else {
            rke++;
        }

        if ('<?php echo Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ ?>') {
            set_nilai_tanggungan(1, paketobat_id);
        }

        if (paketobat_id != '') {
            load_data_tarif(paketobat_id, 1);
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setDetailPaketObat'); ?>',
                data: {
                    paketobat_id: paketobat_id,
                    ruangan_id: ruangan_id,
                    isRacikan: isRacikan,
                    rke: rke,
                },
                dataType: "json",
                success: function(data) {
                    if (data.pesan !== "") {
                        window.parent.myAlert(data.pesan);
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Params::MODUL_ID_GUDANGFARMASI; ?>,
                            judulnotifikasi: 'Stok Obat Alkes Habis',
                            isinotifikasi: obatalkes_kode + ' ' + namaObatNonRacik + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'
                        }; // 16
                        insert_notifikasi(params);
                        return false;
                    }
                    var tambahkandetail = true;

                    var therapiobatyangsama = $("#table-obatalkespasien input[name$='[therapiobat_id]'][value='" + therapiobat_id + "']");
                    if (therapiobatyangsama.val()) { //jika ada therapi obat sudah ada
                        window.parent.myAlert('Obat ini memiliki kelas therapi yang sama dengan pilihan obat sebelumnya');
                    }
                    var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
                    if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
                        myConfirm("Apakah anda akan input ulang obat ini?", "Perhatian!",
                            function(r) {
                                if (r) {
                                    $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function() {
                                        rke = $(this).parents("tr").find(".rke").val();
                                        $(this).parents('tr').remove();
                                    });

                                    if (tambahkandetail) {
                                        $('#table-obatalkespasien > tbody').append(data.form);

                                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                                            "symbol": "",
                                            "defaultZero": true,
                                            "allowZero": true,
                                            "decimal": ",",
                                            "thousands": "",
                                            "precision": 0
                                        });
                                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                                            "symbol": "",
                                            "defaultZero": true,
                                            "allowZero": true,
                                            "decimal": ",",
                                            "thousands": ".",
                                            "precision": 2
                                        });
                                        addDataKeGridObat(obj, 'nonracik', rke);
                                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                                        hitungTotal();
                                        // hitungtotalHargaReseptur();
                                    }

                                    $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                                    
                                    $('#namaObatNonRacik').val('');
                                    $('#nama_paket').val('');
                                    $('#paketobat_id').val('');
                                    $('#qtyNonRacik').val('');
                                    // formatNumberSemua();
                                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                                    sortTable();
                                } else {
                                    tambahkandetail = false;
                                }
                            });
                    } else {
                        if (tambahkandetail) {
                            $('#table-obatalkespasien > tbody').append(data.form);
                            $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                                "symbol": "",
                                "defaultZero": true,
                                "allowZero": true,
                                "decimal": ",",
                                "thousands": "",
                                "precision": 0
                            });
                            $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                                "symbol": "",
                                "defaultZero": true,
                                "allowZero": true,
                                "decimal": ",",
                                "thousands": ".",
                                "precision": 2
                            });
                            addDataKeGridObat(obj, 'nonracik', rke);
                            renameInputRowObatAlkes($("#table-obatalkespasien"));
                            hitungTotal();
                            // hitungtotalHargaReseptur();
                        }
                        $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                        $('#namaObatNonRacik').val('');
                        $('#nama_paket').val('');
                        $('#paketobat_id').val('');
                        $('#qtyNonRacik').val('');
                        // formatNumberSemua();
                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            window.parent.myAlert("Silakan pilih obat / alkes terlebih dahulu!");
        }
        $("#namaObatNonRacik").focus();
    }

    function ceklist(obj) {
        var parent = $(obj).parents().parents().parents().attr('id');
        if (parent != 'form-nonracikan') {
            var parent = $(obj).parents().parents().parents().parents().attr('id');
        }
        var objk = $(obj).parents('#' + parent);
        var qty = objk.find('.qty').val();

        if (objk.find('#is_obatkronis').is(':checked')) {
            objk.find('#formulaobatkronis_id').attr('readonly', false);
            objk.find('#formulaobatkronis_id').attr('disabled', false);
            $.post('<?php echo $this->createUrl('GetJumlahObat') ?>', {
                qty: qty,
            }, function(data) {
                if (data.formulaobatkronis_id != "") {
                    objk.find('#formulaobatkronis_id').val(data.formulaobatkronis_id);

                    objk.find("#alert-kronis").attr('style', 'display: none');
                    objk.find("#formulaobatkronis_id").parents(".control-group").removeClass('error');
                } else {
                    objk.find("#alert-kronis").attr('style', 'display: block');
                    objk.find("#formulaobatkronis_id").parents(".control-group").addClass('error');
                    return false;
                }
            }, 'json');
        } else {
            objk.find('#formulaobatkronis_id').attr('readonly', true);
            objk.find('#formulaobatkronis_id').attr('disabled', true);
            objk.find('#formulaobatkronis_id').val('');

            objk.find("#alert-kronis").attr('style', 'display: none');
            objk.find("#formulaobatkronis_id").parents(".control-group").removeClass('error');
        }
    }

    function dropDownKronis(obj) {
        var formulaobatkronis_id = $(obj).val();
        var parent = $(obj).parents().parents().parents().attr('id');
        if (parent != 'form-nonracikan') {
            var parent = $(obj).parents().parents().parents().parents().attr('id');
        }
        var objk = $(obj).parents('#' + parent);

        if (objk.find('#is_obatkronis').is(':checked')) {
            $.post('<?php echo $this->createUrl('GetKronisObat') ?>', {
                formulaobatkronis_id: formulaobatkronis_id,
            }, function(data) {
                if (data.formulaobatkronis_id != "") {
                    objk.find('.qty').val(data.jumlahobat);
                }
            }, 'json');
        } else {
            objk.find('.qty').val(0);
        }

    }

    //  RSWB-1488 - cek nilai max plafon
    var set_nilai_tanggungan = (is_paket, id) => {
        var pendaftaran_id = '<?= $_GET['pendaftaran_id'] ?>';

        $('#table-obatalkespasien > tbody').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('LoadDataTarif'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                id: id,
                is_paket: is_paket,
            }, //
            dataType: "json",
            success: function(data1) {
                if (data1.sukses === 0) {
                    // window.parent.window.parent.myAlert(data1.pesan);
                    nilai_tanggungan = 0;
                } else {
                    nilai_tanggungan = 1;
                }

                $('#table-obatalkespasien > tbody').removeClass("animation-loading");
                sortTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

    function hitungPecahanDosisRacikan() {
        $('#dialogPecahanDosis').addClass("animation-loading");
        setTimeout(function() {
            var pembilang = $("#dosis_pembliang").val();
            var penyebut = $("#dosis_penyebut").val();
            var kekuatan = $("#kekuatanObat").val();
            $('#penyebut').val(penyebut);
            $('#pembilang').val(pembilang);
            var hasil = 0;

            if (penyebut == 0) {
                window.parent.myAlert("Penyebut tidak boleh 0.");
                return false;
            }

            if (kekuatan.trim() == "") {
                window.parent.myAlert("Kekuatan obat belum ada.");
                return false;
            }
            hasil = (parseFloat(pembilang) / parseFloat(penyebut)) * parseFloat(kekuatan);

            $("#permintaan").val(formatFloat(hasil));
            $('#dialogPecahanDosis').removeClass("animation-loading");
            $("#dialogPecahanDosis").dialog("close");
            $("#dosis_pembliang").val("");
            $("#dosis_penyebut").val("");
            // hitungJumlahObat();
        }, 1000);
    }

    const set_rke = (r) => {
        $("#table-obatalkespasien > tbody > tr").each(function() {
            var rke = parseInt($(this).find('input[name*="[rke]"]').val());
            if (rke > parseInt(r)) {
                r_now = rke - 1;
                $(this).find('input[name*="[rke]"]').val(r_now);
                $(this).find('.resep_ke').html(r_now);
            }
        });
    }

    /**
     * function ini harus tetap berada di bawah
     */
    $(document).ready(function() {
        var ruanganapotek_id = $('#<?php echo CHtml::activeId($modReseptur, "ruangan_id") ?>').val();
        // var paketobat_id = jQuery('#<?php //echo CHtml::activeId($modReseptur, 'paketobat_id') 
                                        ?>');	
        changeKronisObat($('#form-nonracikan').find('#is_obatkronis'));

        $("#ruanganapotek_id").val(ruanganapotek_id);
        renameInputRowObatAlkes($("#table-obatalkespasien"));
        hitungTotal();
        var seconds = 0;
        setInterval(function() {
            seconds++;
            if (seconds >= 999999) {
                seconds = 0;
            }
            $('#<?php echo CHtml::activeId($modReseptur, "lamapelayanan") ?>').val(seconds);
        }, 1000);

        <?php if (isset($_GET['reseptur_id'])) { ?>
            var reseptur_id = <?php echo isset($_GET['reseptur_id']) ? $_GET['reseptur_id'] : '' ?>;
            var pendaftaran_id = <?php echo isset($modReseptur->pendaftaran_id) ? $modReseptur->pendaftaran_id : '' ?>;

            if (reseptur_id != '') {
                if (pendaftaran_id != '') {
                    //            setInfoPasien(pendaftaran_id,'','','');
                    setFormObatReseptur();
                }
            }
        <?php } ?>
        <?php if (isset($_GET['pendaftaran_id'])) { ?>
            var pendaftaran_id = <?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : '' ?>;
            var instalasi_id = <?php echo isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : 'null' ?>;
            $('#instalasi_id').val(instalasi_id);
            if (pendaftaran_id != '') {
                //            setInfoPasien(pendaftaran_id,'','','');
            }
        <?php } ?>

        <?php if (isset($_GET['penjualanresep_id']) && isset($_GET['sukses'])) { ?>
            var penjualanresep_id = <?php echo isset($_GET['penjualanresep_id']) ? $_GET['penjualanresep_id'] : '' ?>;
            $("#table-obatalkespasien :input").removeAttr("readonly", true);
            $("#table-obatalkespasien .add-on").remove();
            $("#table-obatalkespasien .icon-remove").remove();

            $("#penjualanresep-form :input").attr("readonly", true);
            $("#penjualanresep-form .dtPicker3").attr("readonly", true);
            $("#penjualanresep-form .add-on").remove();
            $("#penjualanresep-form .btn-mini").remove();

            $("input, select, textarea").attr("disabled", true);
        <?php } ?>

        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modReseptur->pasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16
                insert_notifikasi(params);
        <?php
            }
        }
        ?>
        formjenisresep(0); // load awal form non racikan yang dimunculkan

        // jQuery(paketobat_id).multiselect({
        // 	includeSelectAllOption: true,
        // 	buttonClass: "form-control",
        // 	maxHeight: 300,
        // 	buttonWidth: '182px',
        // 	enableCaseInsensitiveFiltering: true
        // }).hide();

    });
    
    const setChangedForm = () => {
        <?php if (!isset($_GET['sukses'])){ ?>            
        
            const adaObat = $("#table-obatalkespasien > tbody > tr").length;
            if (adaObat > 0){
                $("#rjreseptur-t-form").attr('changed', true);
            }else{
                $("#rjreseptur-t-form").attr('changed', false);
            }
        <?php } ?>
    }

    // function cekInput(){
    //     var kosong = 0;
    //     if($('#pendaftaran_id').val()==''){
    //         window.parent.myAlert('Input data pasien terlebih dahulu');
    //         kosong++;
    //     }
    //     if($('#<?php // echo CHtml::activeId($modReseptur,"pegawai_id");
                    ?>').val()==''){
    //         window.parent.myAlert('Input data dokter reseptur terlebih dahulu');
    //         kosong++;
    //     }
    //     if(kosong>0){
    //         return false;
    //     }else{
    //         return true;
    //     }
    // }

    
</script>