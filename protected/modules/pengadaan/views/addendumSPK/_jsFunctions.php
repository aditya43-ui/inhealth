<?php
$modRincian = new SuratperjanjiankerjarincianT();
?>
<script>
    function setPPK(data) {
        $("#<?= CHtml::activeId($model, 'pejabatpembuatkomitmen_id') ?>").val(data.pegawai_id);
        $("#<?= CHtml::activeId($model, 'namapembuatkomitmen') ?>").val(data.nama_pegawai);
        $("#<?= CHtml::activeId($model, 'noindukpegawai') ?>").val(data.nomorindukpegawai);
        $("#<?= CHtml::activeId($model, 'alamat') ?>").val(data.alamat);
        $("#<?= CHtml::activeId($model, 'jabatan') ?>").val(data.jabatan_nama);
    }

    /**
     * Hitung Harga dari Jumlah Harga
     * @param {type} obj
     * @returns {undefined}
     */
    function hitungHargaBaris(obj) {
        var volume = 0;
        var pagu = 0;
        var pajak = 0;
        var jumlah = 0;
        var harga_satuan = 0;
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.persenpajak').val());
        jumlah = $(obj).parents("tr").find('.barang_total').val();
        if (volume !== '' && jumlah !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = 100 / (100 + pajak) * jumlah;
            harga_satuan = hit_persen / volume;
            $(obj).parents("tr").find('.barang_harga').val(harga_satuan.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }

    function hitungJumlahBaris(obj) {
        var volume = 0;
        var pagu = 0;
        var pajak = 0;
        var jumlah = 0;
        var harga_satuan = 0;
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.persenpajak').val());
        harga_satuan = $(obj).parents("tr").find('.barang_harga').val();
        if (volume !== '' && jumlah !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = ((volume * harga_satuan * pajak) / 100);
            var sebelum_pajak = (volume * harga_satuan);
            var total = (hit_persen) + (sebelum_pajak);
            $(obj).parents("tr").find('.barang_total').val(total.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }

    function hitungTotalSeluruhnya() {
        var jumlah_tagihan = 0;
        var total_pagu = 0;
        var total_sebelum_pajak = 0;
        var total_pajak = 0;
        var cara_bayar = $("#SuratperjanjiankerjaT_kontrakcarapembayaran").val();
        unformatNumberSemua();
        $("#tabel-hps > tbody > tr").each(function () {
            var jumlah_harga = parseFloat($(this).find('.barang_total').val());
            var sisa = parseFloat($(this).find('.sisa_pagu').val());
            var pajak = parseFloat($(this).find('.persenpajak').val());
            var volume = parseFloat($(this).find('.volume').val());
            var harga_satuan = parseFloat($(this).find('.barang_harga').val());
            var jumlah_pajak = ((volume * harga_satuan * pajak) / 100);
            var sebelum_pajak = volume * harga_satuan;
            total_pagu += sisa;
            jumlah_tagihan += jumlah_harga;
            total_sebelum_pajak += sebelum_pajak;
            total_pajak += jumlah_pajak;
        });
        if (cara_bayar !== 'Lumsum') {
            $("#tabel-hps > tbody > tr").each(function () {
                var jumlah_harga = parseFloat($(this).find('.barang_total').val());
                var sisa = parseFloat($(this).find('.sisa_pagu').val());
                if (jumlah_harga > sisa) {
                    $(this).find('td').attr('style', 'background: #ffcece !important');
                    toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");
                } else {
                    $(this).find('td').attr('style', 'background: white !important');
                }
            });
        } else {
            if (jumlah_tagihan > total_pagu) {
                toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");
                $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").css('border-color', '#b94a48');
                $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").css('border-color', '#b94a48');
            } else {
                $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").css('border-color', '');
                $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").css('border-color', '');
            }
        }
        $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").val(total_pagu);
        $("#<?php echo CHtml::activeId($model, 'jumlah_harga') ?>").val(total_sebelum_pajak);
        $("#<?php echo CHtml::activeId($model, 'jumlah_pajak') ?>").val(total_pajak);
        $("#<?php echo CHtml::activeId($model, 'nilaikontrak') ?>").val(jumlah_tagihan);
        $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").val(jumlah_tagihan);
        $("#<?php echo CHtml::activeId($model, 'total_pembulatan') ?>").val(jumlah_tagihan);
        formatNumberSemua();
        hitungTerminKonstruksi();
        hitungTerminPerencanaan();
        hitungTerminPeriodikal();
        hitungTerminPengawasan(); 
    }

    function cekForm() {
        if (requiredCheck($("#surat-perjanjian-kerja-form"))) {
            var ok = 0;
            var total = 0;
            var jumlah_tagihan = 0;
            var total_sebelum_pajak = 0;
            var total_pajak = 0;
            var cara_bayar = $("#SuratperjanjiankerjaT_kontrakcarapembayaran").val();
            var total_pagu = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").val()));
            var total_hargaseluruhnya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").val()));
            
            if (cara_bayar !== 'Lumsum') {
                $("#tabel-hps > tbody > tr").each(function () {
                    var jumlah_harga = parseFloat($(this).find('.barang_total').val());
                    var sisa = parseFloat($(this).find('.sisa_pagu').val());
                    if (jumlah_harga > sisa) {
                        ok = 1;
                        $(this).find('td').attr('style', 'background: #ffcece !important');
                        toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");
                    } else {
                        $(this).find('td').attr('style', 'background: white !important');
                    }
                    total += ok;
                });
            } else {
                if (total_hargaseluruhnya > total_pagu) {
                    total = 1;
                    toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");
                    $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").css('border-color', '#b94a48');
                    $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").css('border-color', '#b94a48');
                } else {
                    $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").css('border-color', '');
                    $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").css('border-color', '');
                }
            }
            
            if (total === 0) {
                $('#surat-perjanjian-kerja-form').submit();
                disableOnSubmit($("#btn_submit"), 'no_unformat');
            }
            formatNumberSemua();
        }
        return false;
    }

    function setJenis(obj) {
        var jenis = $('#SuratperjanjiankerjaT_istermin');
        if (jenis.is(" :checked")) {
            $('#jenistermin').show();
            $("#SuratperjanjiankerjaT_jenis_termin").attr('class', 'required');
            showHideTabel();
        } else {
            $('#jenistermin').hide();
            $('#SuratperjanjiankerjaT_jenis_termin').val('');
            showHideTabel();
        }
    }
    function showHideTabel(obj) {
        var jenis_termin = $('#SuratperjanjiankerjaT_jenis_termin').val();
        var rencana = document.getElementById("terminKonsultasiPerencanaan");
        var pengawasan = document.getElementById("terminKonsultasiPengawasan");
        var konstruksi = document.getElementById("terminKonstruksi");
        var periodikal = document.getElementById("terminPeriodikal");


        if (jenis_termin == 'Jasa Konsultansi – Perencanaan') {
            rencana.style.display = "block";
            $('#jumlahbaris').hide();
            tambahBarisPerencanaan();
//            $("#ADSuratperjanjiankerjaterminT_jumlah_termin").val(3);   

            pengawasan.style.display = "none";
            $("#tabel-terminKonsultasiPengawasan > tbody").html('');
            konstruksi.style.display = "none";
            $("#tabel-Konstruksi > tbody").html('');
            periodikal.style.display = "none";
            $("#tabel-Periodikal > tbody").html('');
        } else if (jenis_termin == 'Jasa Konsultansi – Pengawasan') {
            pengawasan.style.display = "block";
            $('#jumlahbaris').hide();
            tambahBarisPengawasan();
//            $("#ADSuratperjanjiankerjaterminT_jumlah_termin").val(2);

            rencana.style.display = "none";
            $("#tabel-terminKonsultasiPerencanaan > tbody").html('');
            konstruksi.style.display = "none";
            $("#tabel-Konstruksi > tbody").html('');
            periodikal.style.display = "none";
            $("#tabel-Periodikal > tbody").html('');
        } else if (jenis_termin == 'Jasa Konstruksi') {
            konstruksi.style.display = "block";
            $('#jumlahbaris').hide();
            tambahBarisKonstruksi();
//            $("#ADSuratperjanjiankerjaterminT_jumlah_termin").val(2);   

            pengawasan.style.display = "none";
            $("#tabel-terminKonsultasiPengawasan > tbody").html('');
            rencana.style.display = "none";
            $("#tabel-terminKonsultasiPerencanaan > tbody").html('');
            periodikal.style.display = "none";
            $("#tabel-Periodikal > tbody").html('');
        } else if (jenis_termin == 'Periodikal') {
//            $("#ADSuratperjanjiankerjaterminT_jumlah_termin").val(1);    
            periodikal.style.display = "block";
            $('#jumlahbaris').show();
            tambahBarisPeriodikal();

            pengawasan.style.display = "none";
            $("#tabel-terminKonsultasiPengawasan > tbody").html('');
            rencana.style.display = "none";
            $("#tabel-terminKonsultasiPerencanaan > tbody").html('');
            konstruksi.style.display = "none";
            $("#tabel-Konstruksi > tbody").html('');
        } else {
            rencana.style.display = "none";
            pengawasan.style.display = "none";
            konstruksi.style.display = "none";
            periodikal.style.display = "none";
            $('#jumlahbaris').hide();

            $("#tabel-terminKonsultasiPengawasan > tbody").html('');
            $("#tabel-terminKonsultasiPerencanaan > tbody").html('');
            $("#tabel-Konstruksi > tbody").html('');
//            $("#ADSuratperjanjiankerjaterminT_jumlah_termin").val(0);
        }

        genExt();
        loadtgl();
    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).attr('data-row', row + 1);
            $(this).find('.no_urut', row + 1);
            $(this).find('.no_urut').html(row + 1);
            $(this).find('span[name*="[ii]"]').each(function () { //element <span>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });
        genExt();
    }

    function tambahBarisBaru() {
        var row = <?php echo CJSON::encode($this->renderPartial('_rowHPSBaru', array('i' => 0, 'model' => $modRincian), true)); ?>;
        $("#tabel-hps > tbody").append(row);
        renameInputRow($("#tabel-hps"));
    }

    function hapusBaris(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus data ini?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents("tr").detach();
                renameInputRow($("#tabel-hps"));
                hitungTotalSeluruhnya();
            }
        });
    }
    
    function hapusData(obj){
        var suratperjanjiankerjarincian_id = $(obj).parents("tr").find('.suratperjanjiankerjarincian_id').val();
        var dokumenpelaksanaananggarandet_id = $(obj).parents("tr").find('.dokumenpelaksanaananggarandet_id').val();
        
        myConfirm("Apakah anda yakin akan menghapus data ini dari database?", "Perhatian!",
            function (r) {
                if (r) {
                    $("#table-hps").addClass("animation-loading");
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->createUrl('Delete'); ?>&suratperjanjiankerjarincian_id=' + suratperjanjiankerjarincian_id +'&dokumenpelaksanaananggarandet_id='+dokumenpelaksanaananggarandet_id,
                        data: {suratperjanjiankerjarincian_id: suratperjanjiankerjarincian_id, dokumenpelaksanaananggarandet_id:dokumenpelaksanaananggarandet_id}, //
                        dataType: "json",
                        success: function (data) {
                            if (data.sukses == 1) {
                                $(obj).parents('tr').detach();
                                renameInputRow($("#tabel-hps"));
                                toastr.success(data.pesan);
                            } else {
                                toastr.error(data.pesan);
                            }
                            $("#table-hps").removeClass("animation-loading");
                            
                            var rowCount = $("#tabel-hps").find('tbody tr').length;
                            if (rowCount == 0) {
                                tambahBarisBaru();
                            }
                            hitungTotalSeluruhnya(); 
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");
                        }
                    });
                }
            });
    }    
    
    function setNamaSPK(data) {
        var row = $('#noRow').val();
        $('#tabel-hps > tbody > tr[data-row="'+row+'"]').find('.barang_id').val(data.barang_id);
        $('#tabel-hps > tbody > tr[data-row="'+row+'"]').find('.barang_nama').val(data.barang_nama);
        $("#dialogObat").dialog('close');
    }
    
    function genExt() {
        $(".integer2").unmaskMoney('destroy');

        $(".integer2").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": "", "thousands": ".", "precision": 0}
        );
    }

    /**
     * Generate picker
     * @returns {undefined}
     */
    function loadtgl() {
<?php
$cekPerjanjiankerja = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
if (!empty($cekPerjanjiankerja)) {
    $cekTermin1 = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $cekPerjanjiankerja->suratperjanjiankerja_id, 'urutan' => 1));
    $cekTermin2 = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $cekPerjanjiankerja->suratperjanjiankerja_id, 'urutan' => 2));
    $cekTermin3 = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $cekPerjanjiankerja->suratperjanjiankerja_id, 'urutan' => 3));

    $tglterminawal1 = !empty($cekTermin1->termintanggal_awal) ? date('d M Y', strtotime($cekTermin1->termintanggal_awal)) : '';
    $tglterminakhir1 = !empty($cekTermin1->termintanggal_akhir) ? date('d M Y', strtotime($cekTermin1->termintanggal_akhir)) : '';
    $tglterminawal2 = !empty($cekTermin2->termintanggal_awal) ? date('d M Y', strtotime($cekTermin2->termintanggal_awal)) : '';
    $tglterminakhir2 = !empty($cekTermin2->termintanggal_akhir) ? date('d M Y', strtotime($cekTermin2->termintanggal_akhir)) : '';
    $tglterminawal3 = !empty($cekTermin3->termintanggal_awal) ? date('d M Y', strtotime($cekTermin3->termintanggal_awal)) : '';
    $tglterminakhir3 = !empty($cekTermin3->termintanggal_akhir) ? date('d M Y', strtotime($cekTermin3->termintanggal_akhir)) : '';
    ?>

            var jenis_termin = $('#SuratperjanjiankerjaT_jenis_termin').val();
            if (jenis_termin == '<?php echo $cekPerjanjiankerja->jenis_termin ?>') {
                $('#SuratperjanjiankerjaterminT_0_termintanggal_awal').val('<?php echo $tglterminawal1 ?>');
                $('#SuratperjanjiankerjaterminT_0_termintanggal_akhir').val('<?php echo $tglterminakhir1 ?>');
                $('#SuratperjanjiankerjaterminT_1_termintanggal_awal').val('<?php echo $tglterminawal2 ?>');
                $('#SuratperjanjiankerjaterminT_1_termintanggal_akhir').val('<?php echo $tglterminakhir2 ?>');
                $('#SuratperjanjiankerjaterminT_2_termintanggal_awal').val('<?php echo $tglterminawal3 ?>');
                $('#SuratperjanjiankerjaterminT_2_termintanggal_akhir').val('<?php echo $tglterminakhir3 ?>');
            } else {
                $('#SuratperjanjiankerjaterminT_0_termintanggal_awal').val('');
                $('#SuratperjanjiankerjaterminT_0_termintanggal_akhir').val('');
                $('#SuratperjanjiankerjaterminT_1_termintanggal_awal').val('');
                $('#SuratperjanjiankerjaterminT_1_termintanggal_akhir').val('');
                $('#SuratperjanjiankerjaterminT_2_termintanggal_awal').val('');
                $('#SuratperjanjiankerjaterminT_2_termintanggal_akhir').val('');
            }
    <?php
} else {
    $tglterminawal1 = '';
    $tglterminakhir1 = '';
    $tglterminawal2 = '';
    $tglterminakhir2 = '';
    $tglterminawal3 = '';
    $tglterminakhir3 = '';
    ?>
            $('#SuratperjanjiankerjaterminT_0_termintanggal_awal').val('');
            $('#SuratperjanjiankerjaterminT_0_termintanggal_akhir').val('');
            $('#SuratperjanjiankerjaterminT_1_termintanggal_awal').val('');
            $('#SuratperjanjiankerjaterminT_1_termintanggal_akhir').val('');
            $('#SuratperjanjiankerjaterminT_2_termintanggal_awal').val('');
            $('#SuratperjanjiankerjaterminT_2_termintanggal_akhir').val('');
<?php } ?>

        jQuery('input[name$="SuratperjanjiankerjaterminT[0][termintanggal_awal]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['en-GB'],
                        {
                            'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                        }
                ));
        jQuery('input[name$="SuratperjanjiankerjaterminT[0][termintanggal_akhir]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['en-GB'],
                        {
                            'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                        }
                ));


        jQuery('input[name$="SuratperjanjiankerjaterminT[1][termintanggal_awal]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['en-GB'],
                        {

                            'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                        }
                ));
        jQuery('input[name$="SuratperjanjiankerjaterminT[1][termintanggal_akhir]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['en-GB'],
                        {
                            'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold'
                        }
                ));


        jQuery('input[name$="SuratperjanjiankerjaterminT[2][termintanggal_awal]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['en-GB'],
                        {

                            'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                        }
                ));
        jQuery('input[name$="SuratperjanjiankerjaterminT[2][termintanggal_akhir]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['en-GB'],
                        {
                            'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold'
                        }
                ));
    }

    function hitungTermin() {
        unformatNumberSemua();
        var jenis = $('#SuratperjanjiankerjaT_jenis_termin').val();
        var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
        if (jenis == 'Jasa Konsultansi – Perencanaan') {
            var persen85 = (harga * 80) / 100;
            var persen5 = (harga * 5) / 100;
            var persen15 = (harga * 15) / 100;
            $("#SuratperjanjiankerjaterminT_0_jumlah_harga").val(persen85.toFixed(2));
            $("#SuratperjanjiankerjaterminT_1_jumlah_harga").val(persen5.toFixed(2));
            $("#SuratperjanjiankerjaterminT_2_jumlah_harga").val(persen15.toFixed(2));
        } else if (jenis == 'Periodikal') {
            tambahBarisPeriodikal();
        } else {
            var persen95 = (harga * 95) / 100;
            var persen5 = (harga * 5) / 100;
            $("#SuratperjanjiankerjaterminT_0_jumlah_harga").val(persen95.toFixed(2));
            $("#SuratperjanjiankerjaterminT_1_jumlah_harga").val(persen5.toFixed(2));
        }

        formatNumberSemua();
    }

    function tambahBarisPeriodikal() {
        var jumlah = $('#ADSuratperjanjiankerjaterminT_jumlah_termin').val();
        if (jumlah > 12) {
            window.parent.toastr.error("Jumlah termin tidak boleh lebih dari 12", "Perhatian!");
            $('#ADSuratperjanjiankerjaterminT_jumlah_termin').val(1);
            tambahBarisPeriodikal();
        } else {
            var pelaksanaankontrak_tglawal = $('#PersiapanpengadaanT_pelaksanaankontrak_tglawal').val();
            var pelaksanaankontrak_tglakhir = $('#PersiapanpengadaanT_pelaksanaankontrak_tglakhir').val();

            $.post("<?php echo $this->createUrl('/pengadaan/suratPerjanjianKerja/GetTermin'); ?>", {jumlah_termin: jumlah, pelaksanaankontrak_tglawal: pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir: pelaksanaankontrak_tglakhir},
                    function (data) {
                        if (data.return == 'gagal') {
                            window.parent.toastr.error("Jumlah termin tidak boleh lebih dari jumlah hari pelaksanaan pekerjaan", "Perhatian!");
                            $('#ADSuratperjanjiankerjaterminT_jumlah_termin').val(1);
                            tambahBarisPeriodikal();
                        } else {
                            $('#tabel-Periodikal > tbody').html('');
                            renameInputRow($("#tabel-Periodikal"));
                            $('#tabel-Periodikal > tbody').append(data.return);
                            renameInputRow($("#tabel-Periodikal"));
                        }
                    }, "json");
        }
    }

    function hitungTerminPeriodikal() {
        var jumlah_persen = 0;
        unformatNumberSemua();
        $('#tabel-Periodikal > tbody > tr').each(function () {
            var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
            var persen = parseFloat($(this).find('.jumlah_persen').val());
            var jumlah = (harga * persen) / 100;
            jumlah_persen += persen;
            $(this).find(".jumlah_harga").val(jumlah);
        });
        formatNumberSemua();
        if (jumlah_persen > 100) {
            window.parent.toastr.error('Pembayaran termin tidak boleh lebih dari 100%', 'Perhatian');
            $('#tabel-Periodikal > tbody > tr').find('.jumlah_persen').val('0,00');
            $('#tabel-Periodikal > tbody > tr').find('.jumlah_harga').val('0,00');
            return false;
        }
    }

    function tambahBarisKonstruksi() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . 'form/_rowTerminKonstruksi', array('modTermin' => $modTermin, 'i' => 1), true)); ?>';
        var tanggal_awal = $("#PersiapanpengadaanT_pelaksanaankontrak_tglawal").val();
        var tanggal_akhir = $("#PersiapanpengadaanT_pelaksanaankontrak_tglakhir").val();
        $('#tabel-Konstruksi > tbody').append(row);
        unformatNumberSemua();
        var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
        var persen95 = (harga * 95) / 100;
        var persen5 = (harga * 5) / 100;
        $('#tabel-Konstruksi > tbody > tr').find(".jumlah_harga_konstruksi_95").val(persen95);
        $('#tabel-Konstruksi > tbody > tr').find(".jumlah_harga_konstruksi_5").val(persen5);
        formatNumberSemua();
        setTimeout(function () {
            $('#tabel-Konstruksi > tbody > tr').find(".tanggal_awal").val(tanggal_awal);
            $('#tabel-Konstruksi > tbody > tr').find(".tanggal_akhir").val(tanggal_akhir);
        }, 500);
    }

    function hitungTerminKonstruksi() {
        var jumlah_persen = 0;
        unformatNumberSemua();
        $('#tabel-Konstruksi > tbody > tr').each(function () {
            var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
            var persen = parseFloat($(this).find('.jumlah_persen').val());
            var jumlah = (harga * persen) / 100;
            jumlah_persen += persen;
            $(this).find(".jumlah_harga_konstruksi").val(jumlah);
        });
        formatNumberSemua();
        if (jumlah_persen > 100) {
            window.parent.toastr.error('Pembayaran termin tidak boleh lebih dari 100%', 'Perhatian');
            $('#tabel-Konstruksi > tbody > tr').find('.jumlah_persen').val('0,00');
            $('#tabel-Konstruksi > tbody > tr').find('.jumlah_harga_konstruksi').val('0,00');
            return false;
        }
    }

    function tambahBarisPengawasan() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . 'form/_rowTerminKonsultasiPengawasan', array('modTermin' => $modTermin, 'i' => 1), true)); ?>';
        var tanggal_awal = $("#PersiapanpengadaanT_pelaksanaankontrak_tglawal").val();
        var tanggal_akhir = $("#PersiapanpengadaanT_pelaksanaankontrak_tglakhir").val();
        $('#tabel-terminKonsultasiPengawasan > tbody').append(row);
        unformatNumberSemua();
        var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
        var persen95 = (harga * 95) / 100;
        var persen5 = (harga * 5) / 100;
        $(".jumlah_harga_pengawasan_95").val(persen95);
        $(".jumlah_harga_pengawasan_5").val(persen5);
        formatNumberSemua();
        setTimeout(function () {
            $('#tabel-terminKonsultasiPengawasan > tbody > tr').find(".tanggal_awal").val(tanggal_awal);
            $('#tabel-terminKonsultasiPengawasan > tbody > tr').find(".tanggal_akhir").val(tanggal_akhir);
        }, 500);
    }

    function hitungTerminPengawasan() {
        var jumlah_persen = 0;
        unformatNumberSemua();
        $('#tabel-terminKonsultasiPengawasan > tbody > tr').each(function () {
            var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
            var persen = parseFloat($(this).find('.jumlah_persen').val());
            var jumlah = (harga * persen) / 100;
            jumlah_persen += persen;
            $(this).find(".jumlah_harga_pengawasan").val(jumlah);
        });
        formatNumberSemua();
        if (jumlah_persen > 100) {
            window.parent.toastr.error('Pembayaran termin tidak boleh lebih dari 100%', 'Perhatian');
            $('#tabel-terminKonsultasiPengawasan > tbody > tr').find('.jumlah_persen').val('0,00');
            $('#tabel-terminKonsultasiPengawasan > tbody > tr').find('.jumlah_harga_pengawasan').val('0,00');
            return false;
        }
    }


    function tambahBarisPerencanaan() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . 'form/_rowTerminKonsultasiPerencanaan', array('modTermin' => $modTermin, 'i' => 1), true)); ?>';
        var tanggal_awal = $("#PersiapanpengadaanT_pelaksanaankontrak_tglawal").val();
        var tanggal_akhir = $("#PersiapanpengadaanT_pelaksanaankontrak_tglakhir").val();
        $('#tabel-terminKonsultasiPerencanaan > tbody').append(row);
        unformatNumberSemua();
        var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
        var persen85 = (harga * 80) / 100;
        var persen5 = (harga * 5) / 100;
        var persen15 = (harga * 15) / 100;
        $("#SuratperjanjiankerjaterminT_0_jumlah_harga").val(persen85);
        $("#SuratperjanjiankerjaterminT_1_jumlah_harga").val(persen5);
        $("#SuratperjanjiankerjaterminT_2_jumlah_harga").val(persen15);
        formatNumberSemua();
        setTimeout(function () {
            $('#tabel-terminKonsultasiPerencanaan > tbody > tr').find(".tanggal_awal").val(tanggal_awal);
            $('#tabel-terminKonsultasiPerencanaan > tbody > tr').find(".tanggal_akhir").val(tanggal_akhir);
        }, 500);
    }

    function hitungTerminPerencanaan() {
        var jumlah_persen = 0;
        unformatNumberSemua();
        $('#tabel-terminKonsultasiPerencanaan > tbody > tr').each(function () {
            var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
            var persen = parseFloat($(this).find('.jumlah_persen').val());
            var jumlah = (harga * persen) / 100;
            jumlah_persen += persen;
            $(this).find(".jumlah_harga_perencanaan").val(jumlah);
        });
        formatNumberSemua();
        if (jumlah_persen > 100) {
            window.parent.toastr.error('Pembayaran termin tidak boleh lebih dari 100%', 'Perhatian');
            $('#tabel-terminKonsultasiPerencanaan > tbody > tr').find('.jumlah_persen').val('0,00');
            $('#tabel-terminKonsultasiPerencanaan > tbody > tr').find('.jumlah_harga_perencanaan').val('0,00');
            return false;
        }
    }

    function setRow(obj) {
        var no = $(obj).parents("tr").attr('data-row');
        $("#noRow").val(no);

    }

    function setBarangJasa(data, obj) {

        var cek = 0;
        $("#tabelRAB > tbody > tr").each(function () {
            if ($(this).find('.dokumenpelaksanaananggarandet_id').val() == data.dokumenpelaksanaananggarandet_id) {
                cek++;
            }
        });

        if (typeof obj === 'undefined') {
            var row = $('#noRow').val();
        } else {
            var row = $(obj).parents("tr").attr('rowdata');
        }

        if (cek > 0) {
            toastr.error("Barang dan Jasa sudah dipilih", "Perhatian!");
            $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.rencanaumumpengadaandet_nama').val($("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.tempNama').val());
            return false;
        }

        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.barang_id').val(data.barang_id);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.jenis_barang').val(data.jenis_barang);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.dokumenpelaksanaananggarandet_id').val(data.dokumenpelaksanaananggarandet_id);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.rencanaumumpengadaandet_nama').val(data.uraian);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.tempNama').val(data.uraian);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.rencanaumumpengadaandet_satuan').val(data.satuan);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.rencanaumumpengadaandet_harga').val(data.harga_satuan);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.hargaawal').val(data.harga_satuan);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.rencanaumumpengadaandet_volume').val(data.volume);
        $("#tabelRAB > tbody > tr[rowdata='" + row + "']").find('.volumeawal').val(data.volume);

        $("#<?php echo CHtml::activeId($model, 'pegawaipa_nama') ?>").blur();

        hitung();
    }

    function refreshBarangJasa() {
        var unitkerja_id = $(".unitkerja_id").val();
        var periodeanggaran_id = $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id') ?>").val();
        var subkegiatanprogram_id = $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_id') ?>").val();

        var i = 0;

        $(".barang_periodeanggaran_id").val(periodeanggaran_id);
        $(".barang_unitkerja_id").val(unitkerja_id);
        $(".barang_subkegiatanprogram_id").val(subkegiatanprogram_id);

        $.fn.yiiGridView.update('barangjasa-m-grid', {
            data: {
                "DokumenpelaksanaananggarandetT[periodeanggaran_id]": periodeanggaran_id,
                "DokumenpelaksanaananggarandetT[subkegiatanprogram_id]": subkegiatanprogram_id,
                "DokumenpelaksanaananggarandetT[unitkerja_id]": unitkerja_id,
            }
        });
    }


    function setDialogRincian(jenis, dlg, obj) {
        var jenis = $(obj).parents("tr").find('.jenis_barang').val();
        $('#noRow').val($(obj).parents("tr").attr('data-row'));
        if (jenis === 'Farmasi') {
            dlg = 'dialogObat';
        } 

        var barang_id = $(obj).parents('tr').find('input[name$="[barang_id]"]').val();
        var def = '';
        if (barang_id == "") {
            def = 'ada';
        }
        $(".obat_generik_id").val(barang_id);

        $.fn.yiiGridView.update('obat-grid', {
            data: {
                "ObatalkesM[generik_id]": barang_id,
                "ObatalkesM[default]": def,
            }
        });

        $("#" + dlg).dialog('open');
    }

    var set_ceklist_barang = {};

    function cekListBarang() {
        $("#barangjasa-m-grid > table > tbody > tr").find('.pilih').each(function () {
            if (typeof $("#tabel-hps").find('.dokumenpelaksanaananggarandet_id[value="' + $(this).attr('id-data') + '"]').val() !== 'undefined') {
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
            // Set jadi 0 supaya kalau di uncheck tetep muncul yang terakhir dicek 
            set_ceklist_barang[det_id] = 0;
        }
    }

    function loadBarangJasaByDetId() {
        var row = $('#noRow').val();
        var jenis_trans = $('#jenis_trans').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setDokumenDet'); ?>',
            data: {
                dokumenpelaksanaananggarandet_id: set_ceklist_barang,
            },
            dataType: "json",
            success: function (data) {
                if (data.html != '') {
                    $("#tabel-hps > tbody").find('tr[data-row="' + row + '"]').detach();
                    $("#tabel-hps > tbody").append(data.html);

                    set_ceklist_barang = {};

                    $("#tabel-hps").find('input[class*="integer-decimal"]').unmaskMoney();
                    $("#tabel-hps").find('input[class*="integer-decimal"]').maskMoney(
                            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );

                    $("#tabel-hps").find('input[class*="float2"]').unmaskMoney();
                    $("#tabel-hps").find('input[class*="float2"]').maskMoney(
                            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": "", "precision": 2}
                    );

                    renameInputRow($("#tabel-hps"));
                    genExt();
                    hitungTotalSeluruhnya();
                    
                    $('#tabel-hps > tbody > tr > td.rowbarang').each(function () {
                        var jenis_barang = $(this).parents('tr').find('.jenis_barang').val();
                        console.log('jenis_barang :'+jenis_barang)
                        if (jenis_barang !== 'Farmasi') {
                            $(this).find('.add-on').attr('style', 'display:none;');
                        }
                    });
                }
                $("#dialogBarangJasa").dialog('close');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hitungjangkawaktu() {
        var date1 = $('#PersiapanpengadaanT_pelaksanaankontrak_tglawal').val();
        var date2 = $('#PersiapanpengadaanT_pelaksanaankontrak_tglakhir').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/pengadaan/suratPerjanjianKerja/GetJangkaWaktu'); ?>',
            data: {
                date1: date1,
                date2: date2,
            }, //
            dataType: "json",
            success: function (data) {
                $("#SuratperjanjiankerjaT_jangka_waktu").val(data.selisih);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function () {
        var statusnya = '<?php echo $model->statusnya; ?>';
        if (statusnya == 'persiapanpengadaan') {
            hitung();
        }
        hitungjangkawaktu();
//        setValidasiCekDisabled($("#surat-perjanjian-kerja-form"), function () {
//            return true;
//        });
        $('.integer2').each(function () {
            $(this).val(formatNumber($(this).val()));
        });
        $("#tabelRAB").find('input[class*="integer-decimal"]').maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
        );
<?php if (!empty($_GET['transaksi'])) { ?>
            setJenis();
    <?php
    if ($model->cekpenawaran == 0) {
        echo 'myAlert("Penawaran dari Penyedia tidak ditemukan. <br>Pembuatan SPK akan dilakukan dengan memasukkan data penawaran secara manual.")';
    }
} else {
    ?>
            $("#surat-perjanjian-kerja-form").find('input,select,textarea').each(function () {
                $(this).attr('disabled', true);
            });
    <?php // if ($model->istermin == false || empty($model->istermin)) {  ?>
    //                setJenis();
    <?php // } else {  ?>
    //                showHideTabel($('#SuratperjanjiankerjaT_jenis_termin'));
    <?php // }  ?>
<?php } ?>


    });
</script>