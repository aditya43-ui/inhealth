<div style="text-align: center;">
    <a href="#" class="tombol_main tombol_main_warna2" onclick="pilihCaraBayar('umum'); return false;">
        <div class="tombol_icon">

        </div>
        <div class="tombol_text">
            <div class="tombol_text_title">UMUM</div>
        </div>
    </a>

    <a href="#" class="tombol_main tombol_main_warna2" onclick="pilihCaraBayar('asuransi'); return false;">
        <div class="tombol_icon">

        </div>
        <div class="tombol_text">
            <div class="tombol_text_title">ASURANSI</div>
        </div>
    </a>

    <a href="#" class="tombol_main tombol_main_warna2" onclick="pilihCaraBayar('bpjs'); return false;">
        <div class="tombol_icon">

        </div>
        <div class="tombol_text">
            <div class="tombol_text_title">BPJS</div>
        </div>
    </a>
</div>
<br/>
<div class="row-fluid" style="text-align: center">
    <?php echo CHtml::htmlButton("<i class='entypo-home'></i>Kembali ke Halaman Awal", array(
        'class'=>'btn btn-info', 'onclick'=>"kembaliKeHalamanAwal();"
    )); ?>
</div>

<script>
    function pilihCaraBayar(tipe) {
        if (tipe == "umum") {
            $(".form_carabayar_id").val(<?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>);
            setFormPanel("form_cari_pasien");
        } else if (tipe == "bpjs") {
            $(".form_carabayar_id").val(<?php echo Params::CARABAYAR_ID_BPJS; ?>);
            setFormPanel("form_cari_kartu_bpjs");
        } else if (tipe == "asuransi") {
            // $(".form_carabayar_id").val(<?php echo Params::CARABAYAR_ID_ASURANSI; ?>);
        }
    }
</script>