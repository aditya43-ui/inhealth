<script>

    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->banegosiasi_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    function cekRiwayat(obj) {
        var persiapanpengadaan_id = <?php echo $persiapanpengadaan_id ?>;
        if (persiapanpengadaan_id !== "") {
            $.post("<?php echo $urlGetRiwayat ?>", {persiapanpengadaan_id: persiapanpengadaan_id, },
                    function (data) {
                        $("#tableRiwayat").children("tbody").append(data.tr);
                    }, "json");
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }

    function cekHasil() {
        var tidak_semua = 0;
        $('#tabel_lampiran').find("tbody > tr").each(function () {
            if ($(this).find('.hasil_pemeriksaan').is(":checked")) {
            } else {
                tidak_semua++;
            }
        });

        if (tidak_semua == 0) {
            $("#<?= CHtml::activeId($model, 'banegosiasi_hasil') ?>").val('Sesuai Kontrak');
        } else {
            $("#<?= CHtml::activeId($model, 'banegosiasi_hasil') ?>").val('Tidak Sesuai Kontrak');
        }
    }

    function hitungPenawaran() {
        var total_harga = 0;
        var total_pajak = 0;
        var grandtotal = 0;

        unformatNumberSemua();
        $("#tabel_lampiran > tbody > tr").each(function () {
            var volume = $(this).find(".volume").val();
            var harga = $(this).find(".harga_penawaran").val();
            var pajak = $(this).find(".pajak_penawaran").val();

            var total = 0;
            var hit_pajak = 0;
            var harga_vol = 0;

            if (volume != '' && harga != '') {
                volume = volume;
                harga = harga;
                pajak = pajak;

                hit_pajak = ((volume * harga * pajak) / 100);
                harga_vol = (volume * harga);

                total = (harga_vol) + (hit_pajak);
                total_harga += harga_vol;
                total_pajak += hit_pajak;
                grandtotal += total;
                $(this).find('.jumlah_penawaran').val(total);
            }
        });

        formatNumberSemua();
        hitungTotalPenawaran();
    }

    function hitungJumlahPenawaran(obj) {
        var volume = 0;
        var pagu = 0;
        var pajak = 0;
        var harga_satuan = 0;
        var jumlah_penawaran = 0;
        var jumlah_tagihan = 0;
        var total_pagu = 0;
        var hit_pajak = 0;

        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.volume').val();
        jumlah_penawaran = $(obj).parents("tr").find('.jumlah_penawaran').val();
        pajak = parseFloat($(obj).parents("tr").find('.pajak_penawaran').val());

        if (volume !== '' && jumlah_penawaran !== '' && pajak !== '') {
            var hit_persen = (100 / (100 + pajak)) * jumlah_penawaran;
            harga_satuan = hit_persen / volume;
            $(obj).parents("tr").find('input[class$="harga_penawaran"]').val(harga_satuan);
        }
        formatNumberSemua();
        hitungTotalPenawaran();
    }

    function hitungTotalPenawaran() {
        var total_harga = 0;
        var total_pajak = 0;
        var grandtotal = 0;

        unformatNumberSemua();
        $("#tabel_lampiran > tbody > tr").each(function () {
            var volume = $(this).find(".volume").val();
            var harga = $(this).find(".harga_penawaran").val();
            var pajak = $(this).find(".pajak_penawaran").val();
            var jumlah = parseFloat($(this).find(".jumlah_penawaran").val());

            var total2 = 0;
            var hit_pajak2 = 0;
            var harga_vol2 = 0;

            if (volume !== '' && harga !== '') {
                hit_pajak2 = ((volume * harga * pajak) / 100);
                harga_vol2 = (volume * harga);

                total2 = jumlah;
                total_harga += harga_vol2;
                total_pajak += hit_pajak2;
                grandtotal += total2;
            }
        });

        $("#<?php echo CHtml::activeId($model, 'jumlah_penawaran') ?>").val(total_harga.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'pajak_penawaran') ?>").val(total_pajak.toFixed(2));
        var pajak_penawaran = $("#<?php echo CHtml::activeId($model, 'pajak_penawaran') ?>").val();
        $("#<?php echo CHtml::activeId($model, 'total_penawaran') ?>").val(grandtotal);
        var total_negosiasi = $("#<?php echo CHtml::activeId($model, 'total_negosiasi') ?>").val();
        $("#<?php echo CHtml::activeId($model, 'pembulatan_negosiasi') ?>").val(total_negosiasi);
        $("#<?php echo CHtml::activeId($model, 'pembulatan_penawaran') ?>").val(grandtotal);
        var pembulatan_negosiasi = $("#<?php echo CHtml::activeId($model, 'pembulatan_negosiasi') ?>").val();
        var pembulatan_penawaran = $("#<?php echo CHtml::activeId($model, 'pembulatan_penawaran') ?>").val();

        var selisih = pembulatan_penawaran - pembulatan_negosiasi;

        $("#<?php echo CHtml::activeId($model, 'selisih_harga') ?>").val(selisih);
        $("#<?php echo CHtml::activeId($model, 'harga_setelah_negosiasi') ?>").val(total_negosiasi);
        formatNumberSemua();

    }


    function hitungNegosiasi() {
        var total_harga2 = 0;
        var total_pajak2 = 0;
        var grandtotal2 = 0;

        unformatNumberSemua();
        $("#tabel_lampiran > tbody > tr").each(function () {
            var volume2 = $(this).find(".volume").val();
            var harga2 = $(this).find(".harga_negosiasi").val();
            var pajak2 = $(this).find(".pajak_negosiasi").val();

            var total2 = 0;
            var hit_pajak2 = 0;
            var harga_vol2 = 0;

            if (volume2 != '' && harga2 != '') {
                volume2 = volume2;
                harga2 = harga2;
                pajak2 = pajak2;

                hit_pajak2 = ((volume2 * harga2 * pajak2) / 100);
                harga_vol2 = (volume2 * harga2);

                total2 = (harga_vol2) + (hit_pajak2);
                total_harga2 += harga_vol2;
                total_pajak2 += hit_pajak2;
                grandtotal2 += total2;

                $(this).find('.jumlah_negosiasi').val(total2);
            }
        });
        formatNumberSemua();
        hitungTotalNegosiasi();
    }

    function hitungJumlahNegosiasi(obj) {
        var volume = 0;
        var pagu = 0;
        var pajak = 0;
        var harga_satuan = 0;
        var jumlah = 0;
        var total_pagu = 0;
        var hit_pajak = 0;

        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.volume').val();
        jumlah = $(obj).parents("tr").find('.jumlah_negosiasi').val();
        pajak = parseFloat($(obj).parents("tr").find('.pajak_negosiasi').val());

        if (volume !== '' && jumlah !== '' && pajak !== '') {
            var hit_persen = (100 / (100 + pajak)) * jumlah;
            harga_satuan = hit_persen / volume;
            $(obj).parents("tr").find('input[class$="harga_negosiasi"]').val(harga_satuan);
        }
        formatNumberSemua();
        hitungTotalNegosiasi();
    }

    function hitungTotalNegosiasi() {
        var total_harga = 0;
        var total_pajak = 0;
        var grandtotal = 0;

        unformatNumberSemua();
        $("#tabel_lampiran > tbody > tr").each(function () {
            var volume = $(this).find(".volume").val();
            var harga = $(this).find(".harga_negosiasi").val();
            var pajak = $(this).find(".pajak_negosiasi").val();
            var jumlah = parseFloat($(this).find(".jumlah_negosiasi").val());

            var total2 = 0;
            var hit_pajak2 = 0;
            var harga_vol2 = 0;

            if (volume !== '' && harga !== '') {
                hit_pajak2 = ((volume * harga * pajak) / 100);
                harga_vol2 = (volume * harga);

                total2 = jumlah;
                total_harga += harga_vol2;
                total_pajak += hit_pajak2;
                grandtotal += total2;
            }
        });

        $("#<?php echo CHtml::activeId($model, 'jumlah_negosiasi') ?>").val(total_harga.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'pajak_negosiasi') ?>").val(total_pajak.toFixed(2));
        var pajak_penawaran = $("#<?php echo CHtml::activeId($model, 'pajak_negosiasi') ?>").val();
        $("#<?php echo CHtml::activeId($model, 'total_negosiasi') ?>").val(grandtotal);
        var total_penawaran = $("#<?php echo CHtml::activeId($model, 'total_penawaran') ?>").val();
        $("#<?php echo CHtml::activeId($model, 'pembulatan_negosiasi') ?>").val(grandtotal);
        $("#<?php echo CHtml::activeId($model, 'pembulatan_penawaran') ?>").val(total_penawaran);
        var pembulatan_negosiasi = $("#<?php echo CHtml::activeId($model, 'pembulatan_negosiasi') ?>").val();
        var pembulatan_penawaran = $("#<?php echo CHtml::activeId($model, 'pembulatan_penawaran') ?>").val();

        var selisih = pembulatan_penawaran - pembulatan_negosiasi;

        $("#<?php echo CHtml::activeId($model, 'selisih_harga') ?>").val(selisih);
        $("#<?php echo CHtml::activeId($model, 'harga_setelah_negosiasi') ?>").val(pembulatan_negosiasi);
        
        formatNumberSemua();
//        cekButtonSimpan(); 
    }

    function cekNegosiasi() {
        unformatNumberSemua();
        var total_negosiasi = $("#<?php echo CHtml::activeId($model, 'total_negosiasi') ?>").val();
        var pembulatan_negosiasi = $("#<?php echo CHtml::activeId($model, 'pembulatan_negosiasi') ?>").val();
        var pembulatan_penawaran = $("#<?php echo CHtml::activeId($model, 'pembulatan_penawaran') ?>").val();
        if (pembulatan_negosiasi > total_negosiasi) {
            myAlert('Pembulatan tidak boleh melebihi harga total');
            $("#<?php echo CHtml::activeId($model, 'pembulatan_negosiasi') ?>").val(total_negosiasi);
        }

        $("#<?php echo CHtml::activeId($model, 'harga_setelah_negosiasi') ?>").val(pembulatan_negosiasi);

        var selisih = pembulatan_penawaran - pembulatan_negosiasi;
        $("#<?php echo CHtml::activeId($model, 'selisih_harga') ?>").val(selisih);
        formatNumberSemua();
    }

    function cekPenawaran() {
        unformatNumberSemua();
        var total_penawaran = $("#<?php echo CHtml::activeId($model, 'total_penawaran') ?>").val();
        var pembulatan_penawaran = $("#<?php echo CHtml::activeId($model, 'pembulatan_penawaran') ?>").val();
        var pembulatan_negosiasi = $("#<?php echo CHtml::activeId($model, 'pembulatan_negosiasi') ?>").val();
        if (pembulatan_penawaran > total_penawaran) {
            myAlert('Pembulatan tidak boleh melebihi harga total');
            $("#<?php echo CHtml::activeId($model, 'pembulatan_penawaran') ?>").val(total_penawaran);
        }

        var selisih = pembulatan_penawaran - pembulatan_negosiasi;
        $("#<?php echo CHtml::activeId($model, 'selisih_harga') ?>").val(selisih);
        formatNumberSemua();
    }

    function cekButtonSimpan() {
        var total_negosiasi = parseFloat($("#total_harga").val());
        if (total_negosiasi < 10000000) {
            $("#btn_submit").attr('disabled', true);
        } else {
            $("#btn_submit").removeAttr('disabled');
        }
    }

    $(document).ready(function () {
        cekButtonSimpan();
        <?php if (isset($_GET['sukses'])) { ?>
            $('input').attr('readonly', true);
            $('.add-on').hide();
        <?php } ?>
        cekHasil();
//        hitungPenawaran();
//        hitungNegosiasi();
    });

    document.getElementById("BanegosiasiT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            myAlert("ukuran maks : 5Mb");
            $("#BanegosiasiT_dokumen_pendukung").attr("src", "blank");
            $('#BanegosiasiT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BanegosiasiT_dokumen_pendukung').unwrap();
            return false;
        }
        if (this.files[0].type.indexOf("pdf") == -1) {
            myAlert("Tipe file harus PDF");
            $("#BanegosiasiT_dokumen_pendukung").attr("src", "blank");
            $('#BanegosiasiT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BanegosiasiT_dokumen_pendukung').unwrap();
            return false;
        }
    };
</script>