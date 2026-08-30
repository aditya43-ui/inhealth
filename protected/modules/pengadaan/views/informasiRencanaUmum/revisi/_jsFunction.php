<?php
$i = 0;
$rencana_id = $_GET['id'];
?>
<script>
    var set_ceklist_barang = {};

    function cekListBarang() {
        $("#barangjasa-m-grid > table > tbody > tr").find('.pilih').each(function () {
            if (typeof $("#tabelRAB").find('.dokumenpelaksanaananggarandet_id[value="' + $(this).attr('id-data') + '"]').val() !== 'undefined') {
                $(this).prop("checked", true);
                $(this).prop("disabled", true);
            }
        });
    }

    function setSemuaBarang(obj) {
        if ($(obj).prop("checked") == true) {
            $(obj).parents("#barangjasa-m-grid").find('table > tbody > tr').find('.pilih').each(function () {
                if (typeof $(this).attr("disabled") === 'undefined') {
                    $(this).prop("checked", true);
                    setBarangCek($(this));
                }
            });
        } else {
            $(obj).parents("#barangjasa-m-grid").find('table > tbody > tr').find('.pilih').each(function () {
                if (typeof $(this).attr("disabled") === 'undefined') {
                    $(this).prop("checked", false);
                }
            });
        }

    }

    function setBarangCek(obj) {
        var det_id = $(obj).attr('id-data');

        if ($(obj).prop("checked") == true) {
            set_ceklist_barang[det_id] = det_id;
        } else {
            delete set_ceklist_barang[det_id];
        }
    }

    function loadBarangJasaByDetId() {
        var row = $('#noRow').val();
        var jenis_trans = $('#jenis_trans').val();
        var rencanaumumpengadaan_id = <?php echo $model->rencanaumumpengadaan_id; ?>;

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setDokumenRevisi'); ?>',
            data: {
                dokumenpelaksanaananggarandet_id: set_ceklist_barang,
                jenis_trans: jenis_trans,
                rencanaumumpengadaan_id: rencanaumumpengadaan_id
            },
            dataType: "json",
            success: function (data) {
                if (data.html != '') {

                    $("#tabelRAB > tbody").find('tr[rowdata="' + row + '"]').detach();
                    $("#tabelRAB > tbody").append(data.html);

                    set_ceklist_barang = {};

                    $("#tabelRAB").find('input[class*="integer-decimal"]').unmaskMoney();
                    $("#tabelRAB").find('input[class*="integer-decimal"]').maskMoney(
                            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );


                    $("#tabelRAB").find('input[class*="float2"]').unmaskMoney();
                    $("#tabelRAB").find('input[class*="float2"]').maskMoney(
                            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": "", "precision": 2}
                    );

                    renameInputRow($("#tabelRAB"));

                    generateExt();

                    hitungTotalSeluruhnya();
                }
                $("#dialogBarangJasa").dialog('close');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

<?php
$rab = new RencanaumumpengadaandetT;
$rab->rencanaumumpengadaandet_pajak = 10;
?>
    function tambahRAB() {
        var row_rab = <?php echo CJSON::encode($this->renderPartial("revisi/_rowRABHPS", array('model' => new RencanaumumpengadaandetT,), true)); ?>;
        $("#tabelRAB > tbody").append(row_rab);
        $("#tabelRAB > tbody > tr:last").find('input[class*="integer-decimal"]').maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
        );
        $("#tabelRAB > tbody > tr:last").find('input[class*="float2"]').maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": "", "precision": 2}
        );
        renameInputRow($("#tabelRAB"));

        generateExt();

        hitungTotalSeluruhnya();
    }

    function setJenisRUP(obj) {
        isi = $(obj).val();
        if (isi == "Penyedia") {
            $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").addClass('required');
            $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").parents(".control-group").find('.control-label').append(" <span class='required'>*</span>");
            $('.swakelola').find("input,select,textarea").attr("disabled", true);
            $('.penyedia').find("input,select,textarea").removeAttr("disabled");
            $('.swakelola').hide();
            $('.penyedia').show();
        } else {
            $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").removeClass('required');
            $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").parents(".control-group").find('.control-label').find("span").remove();
            $('.swakelola').find("input,select,textarea").removeAttr("disabled");
            $('.penyedia').find("input,select,textarea").attr("disabled", true);
            $('.penyedia').hide();
            $('.swakelola').show();
        }
    }
    function hapusRAB(obj) {
        var id = $(obj).parents("tr").find('.rencanaumumpengadaandet_id').val();
        myConfirm("Apakah anda yakin akan menghapus data ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        if (id != '') {
                            $(obj).parents('tr').hide();
                            $(obj).parents("tr").find(".status").val(1);
                        } else {
                            $(obj).parents("tr").remove();
                        }
                        var rowCount = 0;
                        $("#tabelRAB > tbody > tr").each(function () {
                            var status = parseFloat($(this).find('.status').val());
                            rowCount += status;
                        });
                        
                        var rowHapus = $('#tabelRAB').find('tbody tr').length;
                        
                        if (rowCount == rowHapus) {
                            tambahRAB(); 
                        }
                        hitungTotalSeluruhnya();
                        renameInputRow($("#tabelRAB"));
                    }
                });
    }


    function cekDipaDpa(obj) {
        if ($(obj).is(":checked")) {
            $("#ADRencanaumumpengadaanT_nomor_kppuas").removeAttr("disabled");
            $('.kppuas').show();
        } else {
            $("#ADRencanaumumpengadaanT_nomor_kppuas").attr("disabled", true);
            $('.kppuas').hide();
        }
    }

    function renameInputRow(obj_table) {
        var row = 0;
        var count = $(obj_table).find("tbody > tr").length;

        $(obj_table).find("tbody > tr").each(function () {
            $(this).attr('data-row', row);
            $(this).find('.no-urut').html(row + 1);
            $(this).find('span').each(function () { //element <input>
                if (typeof $(this).attr("name") != 'undefined') {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                    }
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

//            if (count == 1) {
//                $(this).find('.btntambah').removeClass('hide');
//                $(this).find('.btnhapus').addClass('hide');
//            } else {
//                if (count == (row + 1)) {
//                    $(this).find('.btntambah').removeClass('hide');
//                    $(this).find('.btnhapus').removeClass('hide');
//                } else {
//                    $(this).find('.btnhapus').removeClass('hide');
//                    $(this).find('.btntambah').addClass('hide');
//                }
//            }

            row++;
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
     function hitungTotalSumberDana(){
        var total = 0;
        unformatNumberSemua();
        $("#tabelSumberDana > tbody > tr").each(function () {
            var pagu = parseFloat($(this).find('.pagu').val());
            console.log('pagu '+pagu);
            total += pagu;
        });
        console.log('total '+total);
        $("#totalDana").val(total.toFixed(2));
        formatNumberSemua();
    }
    
    function cekSimpanRUP() {
        var totalDana = parseFloat(unformatNumber($("#totalDana").val()));
        var totalJenisPengadaan = parseFloat(unformatNumber($("#totalJenisPengadaan").val()));
        var kategori = $("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").val();
        var totalPagu = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model, 'dpa_pagu') ?>").val()));
        var totalRAB = parseFloat(unformatNumber($("#total_hargaseluruhnya").val()));
        var status = $("#<?php echo CHtml::activeId($model, 'statusnya') ?>").val();

        if (requiredCheck($("#rup-t-form"))) {
            var total = 0;
            var ok = 0;
            var total_serapan = 0;
            var ok_serapan = 0;
                $("#tabelRAB > tbody > tr").each(function () {
                var status = parseFloat($(this).find('.status').val());
                if (status === 0) {
                    var jumlah_harga = parseFloat($(this).find('.harga').val());
                    var sisa_pagu = parseFloat($(this).find('.sisapagu_pengadaan').val());
                    var serapan = parseFloat($(this).find('.serapan').val());
                    
                    if (serapan > 0) {
                        if (jumlah_harga < serapan) {
                            $(this).find('td').attr('style', 'background: #ffcece !important');
                            ok_serapan = 1;
                        }
                    }
                    
                    if (jumlah_harga > sisa_pagu) {
                        $(this).find('td').attr('style', 'background: #ffcece !important');
                        ok = 1;
                    } else {
                        $(this).find('td').attr('style', 'background: white !important');
                        ok = 0;
                    }
                }
                total += ok;
                total_serapan += ok_serapan;
            });
            
            if (total > 0) {
                toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");            
            }
            
            if (total_serapan > 0) {
                toastr.error("Jumlah yang dikurangi tidak boleh kurang dari serapan", "Perhatian!");            
            } 
            
            if (total === 0 && total_serapan === 0) {
                $("#rup-t-form").submit();
                disableOnSubmit($(".form-actions"), 'no_unformat');
            }
            
            formatNumberSemua();
        }
        return false;
    }

    /**
     * Show RAB
     * @returns {undefined}
     */
    function showRAB() {
        var x = document.getElementById("RAB");
        var a = document.getElementById("ADRencanaumumpengadaanT_subkegiatanprogram_id");
        if (a.value != null) {
            if (x.style.display === "none") {
                x.style.display = "block";
            }
        }
    }

    /**
     * Generate tabel RAB
     * @returns {undefined}
     */
    function showTabelRAB() {
        var unitkerjanya = $("#unitkerjanya").val();
        var periodeanggaran_id = $("#ADRencanaumumpengadaanT_periodeanggaran_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generateTableRAB'); ?>',
            data: {unitkerjanya: unitkerjanya, periodeanggaran_id: periodeanggaran_id},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#tabelRAB").html(data.html);
                    $("#totalnya").html(data.valtotal);
                    hitungTotalSeluruhnya();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Digunakan sebagai autocomplete data pegawai
     * @param {type} data
     * @returns {undefined}
     */
    function setData(data) {
        $("#rup-t-form #ADRencanaumumpengadaanT_subprogram_id").val(data.subprogramkerja_id);
        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_id").val(data.value);
        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_nama").val(data.label);
        $("#rup-t-form #ADRencanaumumpengadaanT_nama_pekerjaan").val(data.label);
        $("#rup-t-form #program").val(data.programkerja_nama);
        $("#rup-t-form #kegiatan").val(data.subprogramkerja_nama);
    }


    function generateExt() {
        $('.numbers-only').keyup(function () {
            setNumbersOnly(this);
        });

        $("#tabelRAB").find('.rencanaumumpengadaandet_nama').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        $(this).val(ui.item.label);
                        return false;
                    },
                    'select': function (event, ui)
                    {
                        setBarangJasa(ui.item, this);
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('autocomplate/BarangJasa'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    }
                }
        );
    }

    function setRow(obj) {
        var no = $(obj).parents("tr").attr('rowdata');
        $("#noRow").val(no);
    }

    function setBarangJasa(data, obj) {

        var cek = 0;
        $("#tabelRAB > tbody > tr").each(function () {
            if ($(this).find('.dokumenpelaksanaananggarandet_id').val() == data.dokumenpelaksanaananggarandet_id) {
                cek++;
            }
        });

        if (cek > 0) {
            toastr.error("Barang dan Jasa sudah dipilih", "Perhatian!");
            return false;
        }

        if (typeof obj === 'undefined') {
            var row = $('#noRow').val();
        } else {
            var row = $(obj).parents("tr").attr('data-row');
        }

        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.barang_id').val(data.barang_id);
        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.jenis_barang').val(data.jenis_barang);
        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.dokumenpelaksanaananggarandet_id').val(data.dokumenpelaksanaananggarandet_id);
        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.rencanaumumpengadaandet_nama').val(data.uraian);
        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.rencanaumumpengadaandet_satuan').val(data.satuan);
        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.rencanaumumpengadaandet_harga').val(data.harga_satuan);
        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.hargaawal').val(data.harga_satuan);
        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.rencanaumumpengadaandet_volume').val(data.volume);
        $("#tabelRAB > tbody > tr[data-row='" + row + "']").find('.volumeawal').val(data.volume);

        hitungTotalSeluruhnya();

        $("#<?php echo CHtml::activeId($model, 'pegawaipa_nama') ?>").blur();
    }

    function refreshBarangJasa() {
        var instalasi_id = $("#<?php echo CHtml::activeId($model, 'instalasi_id') ?>").val();
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>").val();
        var periodeanggaran_id = $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id') ?>").val();
        //var subkegiatanprogram_id = $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_id') ?>").val();

        var subkegiatanprogram_id = '';

        var i = 0;
        $("#tabel-subkegiatan-list > tbody > tr").find('.subkegiatanprogram_id').each(function (index) {
            subkegiatanprogram_id += $(this).val() + ',';
            i++;
        })

        var jenis_trans = $("#jenis_trans").val();
        var paket_id = '';
        var mappingrekeninganggaran_id = '';

        if (jenis_trans == 'paket') {
            var i = 0;
            $("#tabel-paket-rup > tbody > tr").find('.paketpekerjaan_id').each(function (index) {
                paket_id += $(this).val() + ',';
                i++;
            });
            //mappingrekeninganggaran_id = $("#mappingrekeninganggaran_id").val();
            //$(".paketpekerjaan_id").val(paket_id);
            //$(".barang_mappingrekeninganggaran_id").val(mappingrekeninganggaran_id);
        } else {
            paket_id = '';
            // $(".paketpekerjaan_id").val('');
            // $(".barang_mappingrekeninganggaran_id").val('');
        }

        $(".barang_instalasi_id").val(instalasi_id);
        $(".barang_periodeanggaran_id").val(periodeanggaran_id);
        $(".barang_unitkerja_id").val(unitkerja_id);
        $(".barang_subkegiatanprogram_id").val(subkegiatanprogram_id);
        $(".barang_paketpekerjaan_id").val(paket_id);

        $.fn.yiiGridView.update('barangjasa-m-grid', {
            data: {
                "DokumenpelaksanaananggarandetT[instalasi_id]": instalasi_id,
                "DokumenpelaksanaananggarandetT[periodeanggaran_id]": periodeanggaran_id,
                "DokumenpelaksanaananggarandetT[subkegiatanprogram_id]": subkegiatanprogram_id,
                "DokumenpelaksanaananggarandetT[unitkerja_id]": unitkerja_id,
                "DokumenpelaksanaananggarandetT[paketpekerjaan_id]": paket_id,
            }
        });
    }

    function setPaguDPA() {

        var id = new Array();

        var i = 0;
        var a = 0;
        var load = 'dpadet';
        $("#tabelRAB > tbody > tr").each(function () {
            if ($(this).find('.dokumenpelaksanaananggarandet_id').val() != '') {
                id[i] = $(this).find('.dokumenpelaksanaananggarandet_id').val();
                i++;
            }
            if ($(this).find('.rencanaumumpengadaandet_id').val() != '') {
                a++;
            }
        });

        if ($("#tabelRAB > tbody > tr").length == a) {
            load = 'rup';
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/actionAjax/loadDPAdariPagu'); ?>',
            data: {
                dokumenpelaksanaananggarandet_id: id,
                st: 'ubah',
                load: load,
                rencanaumumpengadaan_id: '<?php echo $model->rencanaumumpengadaan_id; ?>'
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#<?php echo CHtml::activeId($model, 'dpa_pagu') ?>").val(data.total);
                    $("#<?php echo CHtml::activeId($model, 'dpa_pagu_temp') ?>").val(data.total);
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hitungJumlahBaris(obj) {
        var volume = 0;
        var pajak = 0;
        var jumlah = 0;
        var harga_satuan = 0;
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.rencanaumumpengadaandet_volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.rencanaumumpengadaandet_pajak').val());
        jumlah = $(obj).parents("tr").find('.rencanaumumpengadaandet_jumlah').val();
        if (volume !== '' && jumlah !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = 100 / (100 + pajak) * jumlah;
            harga_satuan = hit_persen / volume;
            var jumlah_persen = ((volume * harga_satuan * pajak) / 100);
            $(obj).parents("tr").find('.rencanaumumpengadaandet_harga').val(harga_satuan.toFixed(2));
            $(obj).parents("tr").find('.rencanaumumpengadaandet_jmlpajak').val(jumlah_persen.toFixed(2));
        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }

    function hitungHargaBaris(obj) {
        var volume = 0;
        var pajak = 0;
        var harga_satuan = 0;
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.rencanaumumpengadaandet_volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.rencanaumumpengadaandet_pajak').val());
        harga_satuan = $(obj).parents("tr").find('.rencanaumumpengadaandet_harga').val();
        if (volume !== '' && harga_satuan !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = ((volume * harga_satuan * pajak) / 100);
            var sebelum_pajak = (volume * harga_satuan);
            var total = (hit_persen) + (sebelum_pajak);
            $(obj).parents("tr").find('.rencanaumumpengadaandet_jumlah').val(total.toFixed(2));
            $(obj).parents("tr").find('.rencanaumumpengadaandet_jmlpajak').val(hit_persen.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }

    function hitungTotalSeluruhnya() {
        var total_harga = 0;
        var total_pagu = 0;
        var total_pajak = 0;
        var total_serapan = 0;
        var sebelum_pajak = 0;
        var total_ok = 0;
        var total_ok_serapan = 0;
        unformatNumberSemua();
        $("#tabelRAB > tbody > tr").each(function () {
            var status = parseFloat($(this).find('.status').val());
            if (status === 0) {
                var ok = 0;
                var ok_serapan = 0;
                var jumlah_harga = parseFloat($(this).find('.harga').val());
                var rencanaumumpengadaandet_harga = parseFloat($(this).find('.rencanaumumpengadaandet_harga').val());
                var sisa_pagu = parseFloat($(this).find('.sisapagu_pengadaan').val());
                var volume = parseFloat($(this).find(".volume").val());
                var pajak = parseFloat($(this).find(".persenpajak").val());
                var serapan = parseFloat($(this).find(".serapan").val());
                var hit_pajak = ((volume * rencanaumumpengadaandet_harga * pajak) / 100);
                var harga_vol = (volume * rencanaumumpengadaandet_harga);
                var total = (harga_vol) + (hit_pajak);
                if (serapan > 0) {
                    if (jumlah_harga < serapan) {
                        ok_serapan = 1;
                        $(this).find('td').attr('style', 'background: #ffcece !important');
                    } 
                }
                
                if (jumlah_harga > sisa_pagu) {
                    ok = 1;
                    $(this).find('td').attr('style', 'background: #ffcece !important');
                } else {
                    ok = 0;
                    $(this).find('td').attr('style', 'background: white !important');
                }

                total_harga += jumlah_harga;
                total_pagu += sisa_pagu;
                sebelum_pajak += harga_vol;
                total_pajak += hit_pajak;
                total_serapan += serapan;
                total_ok += ok;
                total_ok_serapan += ok_serapan;
            }
        });
        
        if (total_ok > 0) {
            toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");
        }
        
        if (total_ok_serapan > 0) {
            toastr.error("Jumlah yang dikurangi tidak boleh kurang dari serapan", "Perhatian!");
        }

        $('#total_hargaseluruhnya').val(total_harga.toFixed(2));
        $('#total_sisapagu').val(total_pagu.toFixed(2));
        $('#total_serapan').val(total_serapan.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'dpa_pagu') ?>").val(total_pagu.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_harga') ?>").val(sebelum_pajak.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_pajak') ?>").val(total_pajak.toFixed(2));
        formatNumberSemua();
    }

    function cekPaket() {
        var adapaket = $("#adapaket").prop("checked");
        var nonpaket = $("#nonpaket").prop("checked");

        if (adapaket == true) {
            $("#form-pilih-paket").show();

            $('#RAB').attr('style', 'display:none');
            $("#jenis_trans").val('paket');
        } else {
            $("#form-pilih-paket").hide();
            $("#adapaket").attr('checked', false);
            $("#nonpaket").attr('checked', true);

            $("#jenis_trans").val('nonpaket');
            var i = 1;
            $("#tabel-paket-rup > tbody > tr").each(function () {
                if (i == 1) {
                    $(this).find('input,select,textarea').val('');
                } else {
                    $(this).detach();
                }
                i++;
            });

            $('#RAB').attr('style', 'display:none');

        }
    }
    $(document).ready(function () {
        setJenisRUP($("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori"));
        var ispradpa = $("#ADRencanaumumpengadaanT_ispradpa").val();
        if (ispradpa == 1) {
            $("#ADRencanaumumpengadaanT_ispradpa").attr('checked', true);
            cekDipaDpa($("#ADRencanaumumpengadaanT_ispradpa"));
            $("#ytADRencanaumumpengadaanT_ispradpa").val(1);
        } else {
            $("#ADRencanaumumpengadaanT_ispradpa").attr('checked', false);
            cekDipaDpa($("#ADRencanaumumpengadaanT_ispradpa"));
            $("#ytADRencanaumumpengadaanT_ispradpa").val(0);
        }
        cekPaket();
        hitungTotalSeluruhnya();
        renameInputRow($("#tabelRAB"));
<?php if (isset($_GET['sukses'])) { ?>
            $("input,select,textarea").attr("disabled", true);
            $('.add-on').hide();
<?php } ?>
    });

</script>