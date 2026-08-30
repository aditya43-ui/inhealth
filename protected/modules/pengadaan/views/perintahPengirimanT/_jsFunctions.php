<script>
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
            row++;
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }

    function hitungHargaBaris(obj) {
        var volume = 0;
        var pagu = 0;
        var pajak = 0;
        var jumlah = 0;
        var harga_satuan = 0;
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.barang_jumlah').val();
        pajak = parseFloat($(obj).parents("tr").find('.pajak_persen').val());
        jumlah = $(obj).parents("tr").find('.jumlah_harga').val();
        if (volume !== '' && jumlah !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = 100 / (100 + pajak) * jumlah;
            harga_satuan = hit_persen / volume;
            var hit_pajak = ((volume * harga_satuan * pajak) / 100);
            $(obj).parents("tr").find('.jumlah_pajak').val(hit_pajak.toFixed(2));
            $(obj).parents("tr").find('.sebelum_pajak').val(hit_persen.toFixed(2));
            $(obj).parents("tr").find('.harga_satuan').val(harga_satuan.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }

    function hitungJumlahBaris(obj) { // hitung jumlah dari harga
        var volume = 0;
        var pagu = 0;
        var pajak = 0;
        var harga_satuan = 0;
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.barang_jumlah').val();
        pajak = $(obj).parents("tr").find('.pajak_persen').val();
        harga_satuan = $(obj).parents("tr").find('.harga_satuan').val();
        if (volume !== '' && harga_satuan !== '' && pajak !== '') {
            var hit_persen = ((volume * harga_satuan * pajak) / 100);
            var sebelum_pajak = (volume * harga_satuan);
            var total = (hit_persen) + (sebelum_pajak);
            $(obj).parents("tr").find('.jumlah_pajak').val(hit_persen.toFixed(2));
            $(obj).parents("tr").find('.sebelum_pajak').val(sebelum_pajak.toFixed(2));
            $(obj).parents("tr").find('.jumlah_harga').val(total.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }

    function hitungTotalSeluruhnya() {
        var jumlah_tagihan = 0;
        var total_pagu = 0;
        var total_sebelum_pajak = 0;
        var total_pajak = 0;
        unformatNumberSemua();
        var sisa = $("#PerintahpengirimanT_sisa_pembayaran").val();

        $("#tabelRincian > tbody > tr").each(function () {
            var jumlah_harga = parseFloat($(this).find('.jumlah_harga').val());
            var jumlah_pajak = parseFloat($(this).find('.jumlah_pajak').val());
            var sebelum_pajak = parseFloat($(this).find('.sebelum_pajak').val());
            jumlah_tagihan += jumlah_harga;
            total_sebelum_pajak += sebelum_pajak;
            total_pajak += jumlah_pajak;
        });

        if (jumlah_tagihan > sisa) {
            $("#<?= CHtml::activeId($model, 'total_harga') ?>").css('border-color', '#b94a48');
            $("#<?= CHtml::activeId($model, 'total_pembayaran') ?>").css('border-color', '#b94a48');
            $("#<?= CHtml::activeId($model, 'sisa_pembayaran') ?>").css('border-color', '#b94a48');
            window.parent.toastr.error("Total harga yang ditagihkan melebihi Sisa Pembayaran", "Perhatian!");
        } else {
            $("#<?= CHtml::activeId($model, 'total_harga') ?>").css('border-color', '');
            $("#<?= CHtml::activeId($model, 'total_pembayaran') ?>").css('border-color', '');
            $("#<?= CHtml::activeId($model, 'sisa_pembayaran') ?>").css('border-color', '');
        }

        $("#<?= CHtml::activeId($model, 'jumlah_harga') ?>").val(total_sebelum_pajak);
        $("#<?= CHtml::activeId($model, 'jumlah_pajak') ?>").val(total_pajak);
        $("#<?= CHtml::activeId($model, 'total_harga') ?>").val(jumlah_tagihan);
        $(".total_pembayaran").val(jumlah_tagihan);
        formatNumberSemua();
    }

    function cekForm() {
        if (requiredCheck($("#perintahpengiriman-t-form"))) {
            var total_harga = unformatNumber(parseFloat($("#<?= CHtml::activeId($model, 'total_harga') ?>").val()));
            var sisa = unformatNumber(parseFloat($("#PerintahpengirimanT_sisa_pembayaran").val()));

            var ok = 0;
            if (total_harga > sisa) {
                $("#<?= CHtml::activeId($model, 'total_harga') ?>").css('border-color', '#b94a48');
                $("#<?= CHtml::activeId($model, 'total_pembayaran') ?>").css('border-color', '#b94a48');
                $("#<?= CHtml::activeId($model, 'sisa_pembayaran') ?>").css('border-color', '#b94a48');
                window.parent.toastr.error("Total harga yang ditagihkan melebihi Sisa Pembayaran", "Perhatian!");
                ok = 1;
            } else {
                $("#<?= CHtml::activeId($model, 'total_harga') ?>").css('border-color', '');
                $("#<?= CHtml::activeId($model, 'total_pembayaran') ?>").css('border-color', '');
                $("#<?= CHtml::activeId($model, 'sisa_pembayaran') ?>").css('border-color', '');
                ok = 0;
            }
            
            if (ok === 0) {
                $('#perintahpengiriman-t-form').submit();
                disableOnSubmit($("#btn_submit"), 'no_unformat');
            }
            
            formatNumberSemua();
        }
        return false;
    }


    $(document).ready(function () {
        renameInputRow($("#tabelRincian"));
<?php
if ($model->isNewRecord) {
    if ($model->cek_spk == false) {
        echo 'window.parent.toastr.error("Data SPK belum dimasukkan, tidak bisa menambahkan transaksi Perintah Pengiriman.")';
    }
}
?>

    });
</script>