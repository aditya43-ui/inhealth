<style>

    .tombol_main {
        width: 250px;
        margin: 40px;
        height: 120px;
        display: inline-block;
        margin-top: calc(50vh - 60px);
    }

    .tombol_main_warna1 {
        background-color: limegreen;
    }
    .tombol_main_warna2 {
        background-color: lightblue;
    }
    .tombol_main_warna3 {
        background-color: lightcoral;
    }

    .tombol_text {
        color: black;
        padding-top: 30px;
    }

    .tombol_text_title {
        font-weight: bold;
        font-size: 20px;
    }

    .tombol_text_desc {
        text-decoration: underline;
    }

</style>

<div style="text-align: center;">
    <a href="#" class="tombol_main tombol_main_warna1" onclick="pilihTipe('pasien_baru'); return false;">
        <div class="tombol_icon">

        </div>
        <div class="tombol_text">
            <div class="tombol_text_title">PASIEN BARU</div>
            <div class="tombol_text_desc">Pendaftaran Pasien Baru</div>
        </div>
    </a>

    <a href="#" class="tombol_main tombol_main_warna2" onclick="pilihTipe('pasien_lama'); return false;">
        <div class="tombol_icon">

        </div>
        <div class="tombol_text">
            <div class="tombol_text_title">PASIEN LAMA</div>
            <div class="tombol_text_desc">Pendaftaran Pasien Lama</div>
        </div>
    </a>

    <a href="#" class="tombol_main tombol_main_warna3" onclick="pilihTipe('pasien_jkn'); return false;">
        <div class="tombol_icon">

        </div>
        <div class="tombol_text">
            <div class="tombol_text_title">CHECK-IN</div>
            <div class="tombol_text_desc">Mobile JKN - Mobile Pasien</div>
        </div>
    </a>
</div>
