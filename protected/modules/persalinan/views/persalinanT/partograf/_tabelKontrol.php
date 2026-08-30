<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan menampilkan data pemeriksaaan partogram kontrol yang sudah ditambahkan
 * @website     <http://> 
 * RSST-1603
 */
?>
<p>&nbsp;</p>

<div class="overflow-x">
    <table width="100%" class="table table-bordered table-condensed table-striped" id="partograf-kontrol">
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align: top;">P</th>
                <th rowspan="2">Jam</th>
                <th rowspan="2">Denyut Jantung Janin</th>
                <th rowspan="2">Penyisipan</th>
                <th rowspan="2">Pembukaan Serviks (cm)</th>
                <th rowspan="2">Turunnya Kepala Janin (cm)</th>
                <th colspan="2">Kontraksi Uterus (HIB)</th>
                <th rowspan="2">Penepisan</th>
                <th rowspan="2">Perlunakan/Posisi</th>
                <th rowspan="2">Skor Pelfik</th>
                <th rowspan="2">Ketuban/Show</th>
                <th rowspan="2">Respirasi</th>
                <th colspan="3">GSC</th>
                <th colspan="2">Tensi</th>
                <th rowspan="2">Nadi</th>
                <th rowspan="2">Suhu <sup>o</sup>C</th>
                <th rowspan="2">Oksitosin<br>Unit</th>
                <th rowspan="2">Tetes<br>Menit</th>
                <th colspan="3">Urin</th>
                <th rowspan="2">Obat + Cairan IV</th>
                <th rowspan="2">Ubah</th>
                <th rowspan="2">Hapus</th>
            </tr>
            <tr>
                <th>berapa kali</th>
                <th>waktu kontraksi</th>
                <th>Eye</th>
                <th>Verbal</th>
                <th>Motorik</th>
                <th>Sistol</th>
                <th>Diastol</th>
                <th>Protein</th>
                <th>Aseton</th>
                <th>Volume</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($getPartoDet)) {
                foreach ($getPartoDet as $i => $det) {
                    $det->nourutlain = $i;
                    $arr_oa = empty($det->qty_oa) ? array() : CJSON::decode($det->qty_oa);
                    echo $this->renderPartial($this->path_view . 'partograf/_rowTabelKontrol', array('model' => $det, 'i' => $i, 'arr_oa' => $arr_oa), true);
                }
            }
            ?>
        </tbody>
    </table>

    <table id="tabel-kontrol-hapus" class="hide">
        <tbody>
        </tbody>
    </table>
</div>