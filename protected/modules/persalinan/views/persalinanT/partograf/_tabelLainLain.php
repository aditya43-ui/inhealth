<?php

/**
 * digunakan menampilkan data pemeriksaaan partograf lain - lain yang sudah ditambahkan
 * issue RSST-1603
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link     <http://> 
 * 
 */
?>
<p>&nbsp;</p>

<div class="overflow-x">
    <table width="100%" class="table table-bordered table-condensed table-striped" id="partograf-lainlain">
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align: top;">Pendarahan</th>
                <th colspan="3" style="text-align: center;">Diagnosis</th>
                <th colspan="2" style="text-align: center;">Intruksi Dokter</th>
                <th colspan="2" style="text-align: center;">Catatan Bidan</th>
                <th colspan="2" style="text-align: center;">Catatan Perawat</th>
                <th rowspan="2" style="vertical-align: top;">Oksigen</th>
                <th rowspan="2" style="vertical-align: top;">Oksitosin</th>
                <th rowspan="2" style="vertical-align: top;">Cairan Infus</th>
                <th rowspan="2" style="vertical-align: top;">Produksi Urine</th>
                <th rowspan="2" style="vertical-align: top;">Laboratorium</th>
                <th rowspan="2" style="vertical-align: top;">Ubah</th>
                <th rowspan="2" style="vertical-align: top;">Hapus</th>
            </tr>
            <tr>
                <th>Obstetri</th>
                <th>Non Obstetri</th>
                <th>Janin</th>
                <th>Nama</th>
                <th>Intruksi</th>
                <th>Nama</th>
                <th>Catatan</th>
                <th>Nama</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($getPartoLain)) {
                foreach ($getPartoLain as $i => $det) {
                    $det->nourutlain = $i;
                    echo $this->renderPartial($this->path_view . 'partograf/_rowTabelPartografLain', array('model' => $det, 'i' => $i), true);
                }
            }
            ?>
        </tbody>

        <table id="tabel-lainlain-hapus" class="hide">
            <tbody>
            </tbody>
        </table>
    </table>

</div>