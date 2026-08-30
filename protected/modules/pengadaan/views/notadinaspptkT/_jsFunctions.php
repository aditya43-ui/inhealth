<script>

    /**
     * Set show hide form pph22 dan tanpa pph22
     * @returns {undefined}
     */
    function setPph22() {
        var ada = $('#NotadinaspptkT_ispph22');
        var panelkuitansi = document.getElementById("panelkuitansi");
        var unitkerja = document.getElementById("unitkerja");
        var jabatan = document.getElementById("jabatan");
        if (ada.is(" :checked")) {
            if (panelkuitansi.style.display === "none") {
                panelkuitansi.style.display = "block";
            } else {
                panelkuitansi.style.display = "none";
            }
            if (unitkerja.style.display === "none") {
                unitkerja.style.display = "block";
            } else {
                unitkerja.style.display = "none";
            }
            if (jabatan.style.display === "none") {
                jabatan.style.display = "block";
            } else {
                jabatan.style.display = "none";
            }
            showTabelRincian();
            $(".denganpph22").addClass("required");
        } else {
            if (panelkuitansi.style.display === "none") {
                panelkuitansi.style.display = "block";
            } else {
                panelkuitansi.style.display = "none";
            }
            if (unitkerja.style.display === "none") {
                unitkerja.style.display = "block";
            } else {
                unitkerja.style.display = "none";
            }
            if (jabatan.style.display === "none") {
                jabatan.style.display = "block";
            } else {
                jabatan.style.display = "none";
            }
            showTabelRinciantanpapph22();
            $(".denganpph22").removeClass("required");
        }
    }

    /**
     * Generate tabel Rincian
     * @returns {undefined}
     */
    function showTabelRincian(jenis) {
        var rencanaumumpengadaan_id = $("#NotadinaspptkT_rencanaumumpengadaan_id").val();
        var suratperjanjiankerja_id = $("#NotadinaspptkT_suratperjanjiankerja_id").val();
        var perintahpengiriman_id = $("#NotadinaspptkT_perintahpengiriman_id").val();
        var notadinaspptk_id = <?php echo!empty($_GET['notadinaspptk_id']) ? $_GET['notadinaspptk_id'] : 0 ?>;
        $("#tabelRincian").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generateTableRincian'); ?>',
            data: {rencanaumumpengadaan_id: rencanaumumpengadaan_id, 
                   suratperjanjiankerja_id: suratperjanjiankerja_id, 
                   jenis: jenis, 
                   notadinaspptk_id: notadinaspptk_id,
                   perintahpengiriman_id: perintahpengiriman_id},
            dataType: "json",
            success: function (data) {
                $("#tabelRincian").removeClass("animation-loading");
                if (data.sukses == 1) {
                    $("#tabelRincian tbody").html(data.html);
                    renameInputRow($("#tabelRincian"));
                    $("#<?php echo CHtml::activeId($model, 'jumlah_harga') ?>").val(data.total_sebelumpajak);
                    $("#<?php echo CHtml::activeId($model, 'jumlah_pajak') ?>").val(data.total_pajak);
                    $("#<?php echo CHtml::activeId($model, 'jumlah_diterima') ?>").val(data.total_diterima);
                    setPaguDPA();
                    $("#tabelRincian").find('input[class*="integer-decimal"]').unmaskMoney();
                    $("#tabelRincian").find('input[class*="integer-decimal"]').maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );
                    hitungTotalSeluruhnya();
                } else {
                    toastr.error(data.pesan, 'Perhatian!');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function tambahBaris(obj) {
        var row = <?php echo CJSON::encode($this->renderPartial('_rowRincian', array('modDetail' => $modDetails), true)); ?>;
        $(obj).parents('tbody').append(row);
        renameInputRow($("#tabelRincian"));
    }

    function hapusBaris(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus data ini?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents("tr").detach();
                renameInputRow($("#tabelRincian"));
                setPaguDPA();
                hitungTotalSeluruhnya();
            }
        });
    }

    function renameInputRow(obj_table) {
        var row = 0;
        var count = $(obj_table).find('tbody > tr').length;
        $(obj_table).find('tbody > tr').each(function () {
            $(this).attr('no-row', row + 1);
            $(this).find('.no-urut').html(row + 1);
            $(this).find('#nomor').val(row + 1);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });

            if (count == 1) {
                $(this).find('.btntambah').removeClass('hide');
                $(this).find('.btnhapus').addClass('hide');
            } else {
                if (count == (row + 1)) {
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').removeClass('hide');
                } else {
                    $(this).find('.btnhapus').removeClass('hide');
                    $(this).find('.btntambah').addClass('hide');
                }
            }

            row++;
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }

    var is_checked = {};
    
    function cekListSpk(){
        $("#dialogrincianspk-m-grid > table > tbody > tr").find('.pilih').each(function(){                        
            if (typeof $("#tabelRincian").find('.dokumenpelaksanaananggarandet_id[value="'+$(this).attr('dokumenpelaksanaananggarandet_id')+'"]').val() !== 'undefined'){
                $(this).prop("checked", true);
                $(this).prop("disabled", true);
            }
        });
    }
    
    function cekListRup(){
        $("#dialogrincianrup-m-grid > table > tbody > tr").find('.pilih').each(function(){                        
            if (typeof $("#tabelRincian").find('.dokumenpelaksanaananggarandet_id[value="'+$(this).attr('dokumenpelaksanaananggarandet_id')+'"]').val() !== 'undefined'){
                $(this).prop("checked", true);
                $(this).prop("disabled", true);
            }
        });
    }
    
    

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    function setSemuaRincian(obj) {
        if ($(obj).prop("checked") == true) {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", true).change();
            });
        } else {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", false).change();
            });
        }
    }

    function setPilihan(obj) {
        var nomor = $(obj).attr('dokumenpelaksanaananggarandet_id');

        if ($(obj).prop("checked") == true) {
            is_checked[nomor] = nomor;
        } else {
            is_checked[nomor] = 0;
        }
    }

    function inputRincian() {
        var dokumen_id = is_checked;

        if (isEmpty(dokumen_id)) {
            toastr.error('Rincian belum dipilih', "Perhatian");
            return false;
        } else {
            $('#tabelRincian').addClass("animation-loading");
            cekList(dokumen_id);

        }
    }

    function cekList(id) {
        x = true;
        if (x == true) {
            tambahRincianDokumen(is_checked);
            $("#dialogRUP").dialog("close");
            $("#dialogSPK").dialog("close");
            return x;
        }
        return false;
    }

    /**
     * Set ceklis
     * Tidak ada validasi hanya bisa memilih 1 rincian
     * Setiap rincian bisa dipilih > 1 kali 
     * @returns {undefined}
     */
    function setCeklisSpesimen() {
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $("#tabelRincian > tbody > tr").find(".dokumenpelaksanaananggarandet_id").each(function () {
                if (nomor.attr('dokumenpelaksanaananggarandet_id') == $(this).val()) {
                    nomor.prop("checked", true);
                    nomor.attr("disabled", true);
                }
            });
        });
    }

    function tambahRincianDokumen(nomor) {
        var row = $("#norow").val();
        var jenis = $('#kategori_pengadaan').val();
        var rup_id = $("#NotadinaspptkT_rencanaumumpengadaan_id").val();
        var spk_id = $("#NotadinaspptkT_suratperjanjiankerja_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getRincianDokumen'); ?>',
            data: {dokumendet_id: nomor, jenis: jenis, rup_id: rup_id, spk_id: spk_id},
            dataType: "json",
            success: function (data) {
                $("#tabelRincian > tbody").find('tr[no-row="' + row + '"]').detach();
                $('#tabelRincian > tbody').append(data);
                $('#tabelRincian').removeClass("animation-loading");
                renameInputRow($("#tabelRincian"));
                setPaguDPA();
                is_checked = {};
                hitungTotalSeluruhnya();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * JIika jenis verifikasi ada SPK-nya 
     * @param {type} jenis
     * @param {type} dlg
     * @param {type} obj
     * @returns {undefined}
     */
    function setDialogRincian(jenis, dlg, obj) {
        var kategoripengadaan = $("#kategori_pengadaan").val();

        $('#norow').val($(obj).parents("tr").attr('no-row'));
        var no = $('#norow').val();
        var nomor = $(obj).parents("tr").attr('no-row');

        if (kategoripengadaan == 'Penyedia') {
            dlg = 'dialogSPK';
        } else if (kategoripengadaan == 'Swakelola') {
            dlg = 'dialogRUP';
        }

        $("#" + dlg).dialog('open');
    }

    /**
     * Set Tanggal Persiapan Pengadaan
     * @param {type} tgl
     * @returns {undefined}     
     */
    function setTgl(tgl) {
        var tgl = tgl;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggal'); ?>',
            data: {tgl: tgl},
            dataType: "json",
            success: function (data) {
                $("#NotadinaspptkT_persiapanpengadaan_tanggal").val(data.persiapanpengadaan_tanggal);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
   
    function hitungHargaBaris(obj){
        var volume = 0;
        var pagu = 0;
        var pajak = 0;
        var jumlah = 0;
        var harga_satuan = 0; 
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.barang_volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.pajak_persen').val());
        jumlah = $(obj).parents("tr").find('.jumlah_diterima').val();
        if (volume !== '' && jumlah !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = 100 / (100 + pajak) * jumlah;
            harga_satuan = hit_persen / volume; 
            $(obj).parents("tr").find('.jumlah_harga').val(hit_persen.toFixed(2));
            $(obj).parents("tr").find('.harga_satuan').val(harga_satuan.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }
    
    function hitungJumlahBaris(obj){
        var volume = 0;
        var pagu = 0;
        var pajak = 0;
        var jumlah = 0;
        var harga_satuan = 0; 
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.barang_volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.pajak_persen').val());
        jumlah = $(obj).parents("tr").find('.jumlah_diterima').val();
        harga_satuan = $(obj).parents("tr").find('.harga_satuan').val();
        if (volume !== '' && jumlah !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = ((volume * harga_satuan * pajak) / 100);
            var sebelum_pajak  = (volume * harga_satuan);
            var total = (hit_persen) + (sebelum_pajak);
            $(obj).parents("tr").find('.jumlah_harga').val(sebelum_pajak.toFixed(2));
            $(obj).parents("tr").find('.jumlah_diterima').val(total.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }
    
    function hitungTotalSeluruhnya(){
        var jumlah_tagihan = 0;
        var total_pagu = 0;
        var total_sebelum_pajak = 0;
        var total_pajak = 0;
        unformatNumberSemua();
        var lump_sum = $("#NotadinaspptkT_islumsum");
        var total = 0;
        $("#tabelRincian > tbody > tr").each(function () {
            var jumlah_harga = parseFloat($(this).find('.jumlah_diterima').val());
            var sisa = parseFloat($(this).find('.sisa').val());
            var pajak = parseFloat($(this).find('.pajak_persen').val());
            var volume = parseFloat($(this).find('.barang_volume').val());
            var harga_satuan = parseFloat($(this).find('.harga_satuan').val());
            var jumlah_pajak = ((volume * harga_satuan * pajak) / 100);
            var sebelum_pajak = parseFloat($(this).find('.jumlah_harga').val());
            total_pagu += sisa; 
            jumlah_tagihan += jumlah_harga;
            total_sebelum_pajak += sebelum_pajak;
            total_pajak += jumlah_pajak;
            var ok = 0;
            if (lump_sum.is(" :checked")) {
                if (jumlah_tagihan > total_pagu) {
                    $('#NotadinaspptkT_jumlah_diterima').css('border-color', '#b94a48');
                    $('#NotadinaspptkT_sisa_pagu').css('border-color', '#b94a48');
                    ok = 1;
                } else {
                    $(this).find('td').attr('style', 'background: white !important');
                    $('#NotadinaspptkT_jumlah_diterima').css('border-color', '');
                    $('#NotadinaspptkT_sisa_pagu').css('border-color', '');
                }
            } else {
                if (jumlah_harga > sisa) {
                    $(this).find('td').attr('style', 'background: #ffcece !important');
                    ok = 1;
                } else {
                    $(this).find('td').attr('style', 'background: white !important');
                    $('#NotadinaspptkT_jumlah_diterima').css('border-color', '');
                    $('#NotadinaspptkT_sisa_pagu').css('border-color', '');
                } 
            }
            total += ok;
        });
        
        
        if (total > 0) {
            toastr.error("Jumlah Tagihan tidak boleh lebih dari Sisa Pagu", "Perhatian!");
        }
        
        $('#NotadinaspptkT_jumlah_harga').val(total_sebelum_pajak);
        $("#NotadinaspptkT_jumlah_pajak").val(total_pajak);
        $("#NotadinaspptkT_jumlah_diterima").val(jumlah_tagihan);
        formatNumberSemua();
    }

    function setPaguDPA() {
        var id = new Array();

        $("#tabelRincian > tbody > tr").each(function (index) {
            if ($(this).find('.dokumenpelaksanaananggarandet_id').val() != '') {
                id[index] = $(this).find('.dokumenpelaksanaananggarandet_id').val();
            }
        });

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('PagudariDPA'); ?>',
            data: {
                dokumenpelaksanaananggarandet_id: id

            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#<?php echo CHtml::activeId($model, 'sisa_pagu') ?>").val(data.total);
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function cekForm() {
        var lump_sum = $("#NotadinaspptkT_islumsum");
        var total_tagihan = parseFloat(unformatNumber($("#NotadinaspptkT_jumlah_diterima").val()));
        var total_pagu = parseFloat(unformatNumber($("#NotadinaspptkT_sisa_pagu").val()));
        if (requiredCheck($("#notadinaspptk-t-form"))) {
            var ok = 0;
            var total = 0;
            $("#tabelRincian > tbody > tr").each(function () {
                var jumlah = parseFloat($(this).find('.jumlah_diterima').val());
                var sisa = parseFloat($(this).find('.sisa').val());
                var selisih = parseFloat($(this).find('.selisih').val());
                var sisapagu_pengadaan_awal = parseFloat($(this).find('.sisapagu_pengadaan').val());
                var sisapagu_pengadaan_baru = parseFloat($(this).find('.sisapagu_pengadaan_baru').val());
                if (lump_sum.is(" :checked")) {
                    if (total_tagihan > total_pagu) {
                        ok = 1;
                    } else {
                        $(this).find('td').attr('style', 'background: white!important');
                        ok = 0;
                    }
                } else {
                    if (jumlah > sisa) {
                        $(this).find('td').attr('style', 'background: #ffcece !important');
                        ok = 1;
                    } else {
                        $(this).find('td').attr('style', 'background: white!important');
                        ok = 0;
                    }
                }
                total += ok;
            });
            
            if (total > 0) {
                toastr.error("Jumlah Tagihan tidak boleh lebih dari Sisa Pagu", "Perhatian!");
            }
            
            if (total === 0) {
                $('#notadinaspptk-t-form').submit();
                disableOnSubmit($("#btn_submit"), 'no_unformat');
            }
            formatNumberSemua();
        }
        return false;
    }

    $(document).ready(function () {
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
<?php if (!empty($_GET['sukses'])) { ?>
            $("#notadinaspptk-t-form").find('input,select,textarea').each(function () {
                $(this).attr('disabled', true);
            });
<?php } ?>
//        setPph22();
<?php if (!empty($model->notadinaspptk_id)) { ?>
            renameInputRow($("#tabelRincian"));
            $("#kategori_pengadaan").val('<?php echo$model->kategori_pengadaan ?>');
            $('.spk_id').val('<?php echo $model->suratperjanjiankerja_id ?>');
            setTimeout(function () {
                $.fn.yiiGridView.update('dialogrincianspk-m-grid', {
                    data: {
                        "SuratperjanjiankerjarincianT[suratperjanjiankerja_id]": '<?php echo $model->suratperjanjiankerja_id ?>',
                        "SuratperjanjiankerjarincianT[default]": 'ada'
                    }
                });
            }, 500);

            $('.rencanaumumpengadaan_id').val('<?php echo $model->kategori_pengadaan ?>');
            setTimeout(function () {
                $.fn.yiiGridView.update('dialogrincianrup-m-grid', {
                    data: {
                        "ADRencanaumumpengadaandetT[rencanaumumpengadaan_id]": '<?php echo $model->rencanaumumpengadaan_id ?>',
                        "ADRencanaumumpengadaandetT[default]": 'ada'
                    }
                });
            }, 500);

            if ('<?php echo $model->kategori_pengadaan ?>' == 'Penyedia') {
                $('#field-termin').attr('hidden', true);
                $('#formKontrak').show();
                refreshDialog('Penyedia');
            } else {
                $('#formKontrak').hide();
                refreshDialog('Swakelola');
            }
<?php } else { ?>
            $('#NotadinaspptkT_kategoripengadaan_0').attr('checked', true);
            refreshDialog('Penyedia');
<?php } ?>
    });

    function hitungSelisih() {
        var harga = 0;
        var selisih = 0;
        var sisa = 0;
        var row = '';
        var dok_id = '';
        var harga_2 = '';
        var total_2 = '';
        var sisa_2 = '';
        unformatNumberSemua();
        $("#tabelRincian > tbody > tr").each(function () {
            row = $(this).attr('no-row');
            dok_id = $(this).find('.dokumenpelaksanaananggarandet_id').val();
            sisa = $(this).find('.sisa').val();
            harga = $(this).find('.jumlah_diterima').val();

            $("#tabelRincian > tbody > tr").each(function () {
                var dok_id2 = $(this).find('.dokumenpelaksanaananggarandet_id').val();
                var row_2 = $(this).attr('no-row');
                var harga_2 = $(this).find('.jumlah_diterima').val();
                if (dok_id2 === dok_id && row_2 < row) {
                    total_2 += harga_2;
                    sisa_2 = sisa - total_2;
                    $("#tabelRincian > tbody > tr[no-row='" + row + "'] ").find('.sisa').val(sisa_2);
                }
//                $(this).find('.sisa').val(sisa);
            });

            selisih = sisa - total_2;

        });
        formatNumberSemua();
    }
</script>