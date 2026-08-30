<?php
$p_id = isset($_GET['id'])?$_GET['id']:$model->persiapanpengadaan_id;
?>
<script>

    function setRow(obj) {
        var no = $(obj).parents("tr").attr('data-row');
        $("#no_row").val(no);
    }

    function clearFarmasi(obj) {
        $(obj).parents("tr").find('.obatalkes_id').val('');
        $(obj).parents("tr").find('.barang_nama').val('');
    }

    function setSupplier(data) {
        $("#SuratperjanjiankerjaT_nama_supplier").val(data.direktursupplier);
        $("#SuratperjanjiankerjaT_jabatan_supplier").val(data.supplier_cp_jabatan);
        $("#SuratperjanjiankerjaT_alamat_supplier").val(data.supplier_alamat);
        $("#SuratperjanjiankerjaT_nomor_rekening").val(data.supplier_norekening);
    }

    function loadAnggaran(obj) {
        var tahun_anggaran = $("#SuratperjanjiankerjaT_tahunanggaran").val();
        var no_dpa = $("#SuratperjanjiankerjaT_tahunanggaran :selected").data('nodpa');

        $("#SuratperjanjiankerjaT_no_dpa").val("");
        $("#SuratperjanjiankerjaT_no_dpa").val(no_dpa);
    }

    /**
     * Hitung Harga dari Jumlah 
     * @param {type} obj
     * @returns {undefined}
     */
    function hitungHargaBaris(obj) {
        var volume = 0;
        var pajak = 0;
        var jumlah = 0;
        var harga_satuan = 0;
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.persenpajak').val());
        jumlah = $(obj).parents("tr").find('.total_harga').val();
        if (volume !== '' && jumlah !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = 100 / (100 + pajak) * jumlah;
            harga_satuan = hit_persen / volume;
            var hitung_pajak = ((volume * harga_satuan * pajak) / 100);
            $(obj).parents("tr").find('.harga_satuan').val(harga_satuan.toFixed(2));
            $(obj).parents("tr").find('.pajak').val(hitung_pajak.toFixed(2));
            $(obj).parents("tr").find('.sebelum_pajak').val(hit_persen.toFixed(2));
        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }

    /**
     * Hitung dari Harga, Volume dan Pajak
     * @param {type} obj
     * @returns {undefined}
     */
    function hitungJumlahBaris(obj) {
        var volume = 0;
        var pajak = 0;
        var harga_satuan = 0;
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.persenpajak').val());
        harga_satuan = $(obj).parents("tr").find('.harga_satuan').val();
        if (volume !== '' && harga_satuan !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = ((volume * harga_satuan * pajak) / 100);
            var sebelum_pajak = (volume * harga_satuan);
            var total = (hit_persen) + (sebelum_pajak);
            $(obj).parents("tr").find('.total_harga').val(total.toFixed(2));
            $(obj).parents("tr").find('.pajak').val(hit_persen.toFixed(2));
            $(obj).parents("tr").find('.sebelum_pajak').val(sebelum_pajak.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }

    function hitungTotalSeluruhnya() {
        var total_harga = 0;
        var total_pagu = 0;
        var total_pajak = 0;
        var total_sebelumpajak = 0;
        unformatNumberSemua();
        var cara_bayar = $("#<?php echo CHtml::activeId($model, 'kontrakcarapembayaran') ?>").val();
        var ok = 0;
        var total = 0;
        $("#tabel-hps > tbody > tr").each(function () {
            var jumlah_harga = parseFloat($(this).find('.total_harga').val());
            var pajak = parseFloat($(this).find('.pajak').val());
            var sebelum_pajak = parseFloat($(this).find('.sebelum_pajak').val());
            var sisa_pagu = parseFloat($(this).find('.sisa_pagu').val());
            total_harga += jumlah_harga;
            total_pajak += pajak;
            total_sebelumpajak += sebelum_pajak;
            total_pagu += sisa_pagu;

            if (cara_bayar !== '<?= Params::JENIS_CARA_BAYAR_SPK_LUMSUM ?>') {
                if (jumlah_harga > sisa_pagu) {
                    ok = 1;
                    $(this).find('td').attr('style', 'background: #ffcece !important');
                } else {
                    ok = 0;
                    $(this).find('td').attr('style', 'background: white !important');
                }
            }
            total += ok;
        });

        $("#<?php echo CHtml::activeId($model, 'jumlah_harga') ?>").val(total_sebelumpajak.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'jumlah_pajak') ?>").val(total_pajak.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").val(total_harga.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_pembulatan') ?>").val(total_harga.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'nilaikontrak') ?>").val(total_harga.toFixed(2));
              
        if (cara_bayar == '<?= Params::JENIS_CARA_BAYAR_SPK_LUMSUM ?>') {
            if (total_harga > total_pagu) {
                window.parent.toastr.error("Jumlah yang diadakan melebihi pagu", "Perhatian!");
                $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").css('border-color', '#b94a48');
                $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").css('border-color', '#b94a48');
            } else {
                $('#tabel-hps > tbody > tr').attr('style', 'background: white !important');
                $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").css('border-color', '');
                $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").css('border-color', '');
            }
        } else {
            if (total > 0) {
                window.parent.toastr.error("Jumlah yang diadakan melebihi pagu", "Perhatian!");
            }
        }
        formatNumberSemua();
        hitungTerminPeriodikal();
        hitungTerminKonstruksi();
        hitungTerminPengawasan();
        hitungTerminPerencanaan();
    }


    function requiredChecks(obj) {
        var kosong = 0;
        var attr = '';
        $(obj).find('input:not(".multiselect-search"),select,textarea').each(function () {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true) {
                $(this).parents(".control-group").removeClass("error").removeClass("success");
            }
        });
        $(obj).find('input:not(".multiselect-search"),select,textarea').each(function () {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {
                if ($(this).is(":disabled")) {
                    //                return false;
                } else {
                    if (($(this).val() === "")) {
                        if ($(this).is(":hidden")) { //untuk element type:hidden 
                            var radio_checked = false;
                            $(this).parent().find(".radio").each(function () { //mengecek element radio button
                                if ($(this).find("input").is(":checked")) {
                                    radio_checked = true;
                                }
                            });
                            if (radio_checked == false) {
                                $(this).parents(".control-group").addClass("error");
                                $(this).addClass("error");
                                //console.log($(this));
                                kosong++;
                            } else {
                                $(this).parents(".control-group").removeClass("error");
                                $(this).removeClass("error");
                                //console.log($(this));
                            }
                        } else {
                            if (attr == '') {
                                attr = $(this);
                            }
                            $(this).parents(".control-group").addClass("error");
                            $(this).addClass("error");
                            //console.log($(this));
                            kosong++;
                        }
                    } else {
                        $(this).parents(".control-group").removeClass("error");
                        $(this).removeClass("error");
                    }
                }

            }
        });
        if (kosong > 0) {
            if (attr != '') {
                attr.focus();
            }
            window.parent.myAlert("Silahkan isi yang bertanda bintang <span class='required'>*</span> !");//("+kosong+" input)
            return false;
        } else {
            disableOnSubmit($(obj).find("button[type='submit']"));
            return true;
        }
    }

    function cekForm() {

        var nilai_kontrak = parseFloat(unformatNumber($("#SuratperjanjiankerjaT_nilaikontrak").val()));
        var total_pembulatan = parseFloat(unformatNumber($("#SuratperjanjiankerjaT_total_pembulatan").val()));
        var total_hargaseluruhnya = parseFloat(unformatNumber($("#SuratperjanjiankerjaT_total_hargaseluruhnya").val()));

        if (nilai_kontrak != total_hargaseluruhnya) {
            window.parent.toastr.warning("Maaf, total harga harus sama dengan nilai kontrak", "Perhatian!");
            return false;
        }

        if (total_pembulatan > nilai_kontrak) {
            window.parent.toastr.warning("Maaf, total pembulatan tidak boleh lebih dari nilai kontrak", "Perhatian!");
            return false;
        }

        if (requiredChecks($("#surat-perjanjian-kerja-form"))) {
//            unformatNumberSemua();
            var cara_bayar = $("#<?php echo CHtml::activeId($model, 'kontrakcarapembayaran') ?>").val();
            var total = 0;
            var ok = 0;
            var total_pagu = parseFloat(($("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").val()));
            var total_harga = parseFloat(($("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").val()));
            $("#tabel-hps > tbody > tr").each(function () {
                var jumlah_harga = parseFloat($(this).find('.total_harga').val());
                var sisa_pagu = parseFloat($(this).find('.sisa_pagu').val());

                if (cara_bayar !== '<?= Params::JENIS_CARA_BAYAR_SPK_LUMSUM ?>') {
                    if (jumlah_harga > sisa_pagu) {
                        ok = 1;
                        $(this).find('td').attr('style', 'background: #ffcece !important');
                    } else {
                        ok = 0;
                        $(this).find('td').attr('style', 'background: white !important');
                    }
                }
                total += ok;
            });
            if (cara_bayar == '<?= Params::JENIS_CARA_BAYAR_SPK_LUMSUM ?>') {
                if (total_harga > total_pagu) {
                    total =1;
                    window.parent.toastr.error("Jumlah yang diadakan melebihi pagu", "Perhatian!");
                    $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").css('border-color', '#b94a48');
                    $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").css('border-color', '#b94a48');
                } else {
                    $("#<?php echo CHtml::activeId($model, 'total_pagu') ?>").css('border-color', '');
                    $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").css('border-color', '');
                }
            } else {
                if (total > 0) {
                    window.parent.toastr.error("Jumlah yang diadakan melebihi pagu", "Perhatian!");
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

    function hitungjangkawaktu() {
        var date1 = $('#PersiapanpengadaanT_pelaksanaankontrak_tglawal').val();
        var date2 = $('#PersiapanpengadaanT_pelaksanaankontrak_tglakhir').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetJangkaWaktu'); ?>',
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

    function genExt() {
        $(".integer2").unmaskMoney('destroy');

        $(".integer2").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": "", "thousands": ".", "precision": 0}
        );
    }

    function setJenis(obj) {
        var jenis = $('#SuratperjanjiankerjaT_istermin');
        if (jenis.is(" :checked")) {
            $('#jenistermin').show();
            $("#SuratperjanjiankerjaT_jenis_termin").attr('class', 'required');
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


    /**
     * Generate picker
     * @returns {undefined}
     */
    function loadtgl() {
<?php
$cekPerjanjiankerja = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $p_id, 'isbatal' => false, 'isaddendum' => true));
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

            $.post("<?php echo $this->createUrl('GetTermin'); ?>", {jumlah_termin: jumlah, pelaksanaankontrak_tglawal: pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir: pelaksanaankontrak_tglakhir},
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

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).attr('data-row', row + 1);
            $(this).find('.no_urut', row + 1);
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
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
        genExt();
    }

    function genExtAuto() {
        $(".barang_nama").autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 2,
                    'focus': function (event, ui) {
                        $(this).val(ui.item.label);
                        return false;
                    },
                    'select': function (event, ui) {
                        setObatAlkesAuto(ui.item, $(this));
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo $this->createUrl('autocompleteObat'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                                generik_id: getGenerik(this),
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }
                });
    }

    function getGenerik(obj) {
        var norow = $("#no_row").val();

        return $("#tabel-hps > tbody > tr[data-row='" + norow + "']").find('.barang_id').val();
    }

    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        var no = $(obj).parents("tr").data('row');
        $("#no_row").val(parseInt(no));
        dialog = "#dialogObat";
        $(dialog).attr("parent-dialog", parent);
        var barang_id = $(obj).parents('tr').find('input[name$="[barang_id]"]').val();
        var def = '';
        if (barang_id == "") {
            def = 'ada';
        }
        $(".obat_generik_id").val(barang_id);

//        setTimeout(function () {
        $.fn.yiiGridView.update('obat-grid', {
            data: {
                "ObatalkesM[generik_id]": barang_id,
                "ObatalkesM[default]": def,
            }
        });
//        }, 500);

        $(dialog).dialog("open");
    }

    function setObatAlkes(obatalkes_id) {
        var dialog = "#dialogObat";
        var no = $('#no_row').val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);

        var ada = 0;
        $("#tabel-hps > tbody > tr").each(function () {
            var obatalkes_id_temp = $(this).find('input[name$="[obatalkes_id]"]').val();
            if (obatalkes_id == obatalkes_id_temp) {
                ada++;
            }
        });

        console.log(no);
        console.log(ada);

//        if(ada==0){
        $.get('<?php echo $this->createUrl('AutocompleteObat'); ?>', {obatalkes_id: obatalkes_id}, function (data) {
            $("#tabel-hps > tbody > tr").each(function () {
                if ($(this).attr('data-row') == no) {
                    setObatAlkesAuto($(this).find('input[name$="[obatalkes_id]"]'), data[0]);
                }
            });

        }, "json");
//        }else{
//            toastr.error("Data Obat sudah ditambahkan di tabel, silahkan pilih data Obat yang lain", "Perhatian!");
//        }
        $(dialog).dialog("close");
    }

    function setObatAlkesAuto(obj, item) {
        console.log(item);
//        var ada = 0;        
//        $("#tabel-hps > tbody > tr").each(function(){
//            var obatalkes_id_temp = $(this).find('input[name$="[obatalkes_id]"]').val();
//            if(item.obatalkes_id == obatalkes_id_temp){
//                ada++;
//            }
//        });

        $(obj).parents('tr').find('.obatalkes_id').val(item.obatalkes_id);
        $(obj).parents('tr').find('.barang_nama').val(item.obatalkes_nama);
//        if(ada==0){
//        }else{
//            toastr.error("Data Obat sudah ditambahkan di tabel, silahkan pilih data lain!", "Perhatian!");
//            $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val('');
//            $(obj).val('');
//        }
    }

    function setUangMuka() {
        var uangmuka = $("#SuratperjanjiankerjaT_isuangmuka");
        if (uangmuka.is(" :checked")) {
            $(".uang-muka").removeAttr('hidden');
            $("#SuratperjanjiankerjaT_uangmuka_persen").attr('class', 'span2 integer-decimal required');
            $("#SuratperjanjiankerjaT_uangmuka_jumlah").attr('class', 'span3 integer-decimal required');
        } else {
            $(".uang-muka").attr('hidden', true);
            $("#SuratperjanjiankerjaT_uangmuka_persen").val('').attr('class', 'span2');
            $("#SuratperjanjiankerjaT_uangmuka_jumlah").val('').attr('class', 'span3');
        }
    }

    function hitungUangMuka() {
        unformatNumberSemua();
        var uang_muka = $("#SuratperjanjiankerjaT_uangmuka_persen").val();
        var harga = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val());
        var persen = (harga * uang_muka) / 100;
        if (uang_muka > 30) {
            window.parent.toastr.error('Uang muka tidak boleh lebih dari 30%', 'Perhatian!');
            var persen = (harga * 30) / 100;
            $("#SuratperjanjiankerjaT_uangmuka_persen").val(30);
            $("#SuratperjanjiankerjaT_uangmuka_jumlah").val(persen);
        }

        $("#SuratperjanjiankerjaT_uangmuka_jumlah").val(persen);

        formatNumberSemua();
    }

    $(document).ready(function () {
        renameInputRow($("#tabel-hps"));

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
<?php if ($model->isNewRecord) { ?>
            setJenis();
    <?php
    if ($model->cekpenawaran == 0) {
        echo 'myAlert("Penawaran dari Penyedia tidak ditemukan. <br>Pembuatan SPK akan dilakukan dengan memasukkan data penawaran secara manual.")';
    }
} else {
    ?>      setUangMuka();
            <?php if (!isset($_GET['ubah'])){ ?>
            $("#surat-perjanjian-kerja-form").find('input,select,textarea').each(function () {
                $(this).attr('disabled', true);
            });
            <?php } ?>
    <?php if ($model->istermin == false || empty($model->istermin)) { ?>
                setJenis();
    <?php } else { ?>
                showHideTabel($('#SuratperjanjiankerjaT_jenis_termin'));
    <?php } ?>
<?php } ?>


    });

</script>