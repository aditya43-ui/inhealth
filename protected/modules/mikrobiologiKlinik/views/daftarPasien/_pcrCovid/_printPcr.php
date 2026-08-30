<style>
hr {
    border: 1pt solid grey;
    text-align: center;
    width: 95%;
}

.judul {
    text-align: center;
    font-weight: bold;
    font-style: "Arial Narrow", Arial, sans-serif;
}

.judul2 {
    font-weight: bold;
    font-style: "Arial Narrow", Arial, sans-serif;
}

.content-judul2 {
    margin-left: 100px;
    font-style: "Arial Narrow", Arial, sans-serif;
}

.tab_detail {
    width: 85%; margin-left: 100px; margin-top: 50px;
}

.tab_detail th, .tab_detail td {
    border: 1px solid black;
    padding: 2px;
}

.tab_detail th {
    font-weight: bold;
    text-align: center;
}
</style>

<div>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewKabRS'); ?>
    </div>
</div>
<br>
<center>
    <hr>
</center><br>
<p>
<h3 class="judul"><u>HASIL PEMERIKSAAN MIKROBIOLOGI KLINIK</u></h3>
</p>

<table style="width: 85%; margin-left: 100px; margin-top: 50px;">
    <tr>
        <td width="150">Nama</td><td width="10">:</td><td><?= $modPasien->nama_pasien ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td><td>:</td><td><?= date('d-m-Y', strtotime($modPasien->tanggal_lahir)) ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?= $modPasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>:</td><td><?= $modPasien->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td>Tgl. Pengambilan</td><td>:</td><td><?= date('d-m-Y', strtotime($model->tgl_pemeriksaan)); ?></td>
    </tr>
    <tr>
        <td>Sample PCR</td><td>:</td><td><?= $tindakan->samplelab->samplelab_nama ?? "-"; ?></td>
    </tr>
</table>
<hr/>
<table class="tab_detail">
    <thead>
        <tr>
            <th>Jenis Pemeriksaan</th>
            <th width="100">Hasil</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $model->jenis_pemeriksaan; ?></td>
            <td><?php echo $model->is_negative ? "NEGATIVE" : "POSITIVE"; ?></td>
        </tr>
    </tbody>
</table>

<table style="width: 85%; margin-left: 100px; margin-top: 50px;">
    <tr>
        <td></td>
        <td width="300" style="text-align: center;">
            <?php
            $kabupaten = Yii::app()->user->getState('kabupaten_nama');
            $kabupaten = ucfirst(trim(str_replace("kota", "", strtolower($kabupaten))));

            echo $kabupaten.", ".date('d-m-Y', strtotime($model->tgl_pemeriksaan));
            
            ?>
            <br/>
            a.n. Direktur RSUD Dr. Saiful Anwar Malang<br/>
            Wakil Direktur Pelayanan Penunjang<br/>
            <br/><br/><br/><br/><br/>
            <?php

            echo $model->pegawai->namaLengkap;
            echo '<br/>';
            echo 'NIP. '.$model->pegawai->nomorindukpegawai;

            ?>
        </td>
    </tr>
</table>

<?php /*
<div class="content-judul2">
    <div class="judul2">A.&emsp;Sediaan Langsung&nbsp;&nbsp;:<br></div>
    <div>&emsp;&emsp;1. &emsp;Pewarnaan Garam<br>
        <div>
            <tabel style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 30%;">&emsp;&emsp;&emsp;&emsp;&bull;&emsp;Sel Epitel</td>
                        <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp;<?= $kultur->sel_epitel_kultur ?><br></td>
                    </tr>
                    <tr>
                        <td>&emsp;&emsp;&emsp;&emsp;&bull;&emsp;Sel Radang</td>
                        <td>&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp;<?= $kultur->sel_radang_kultur ?><br></td>
                    </tr>
                    <tr>
                        <td>&emsp;&emsp;&emsp;&emsp;&bull;&emsp;Sel Mikroorganisme</td>
                        <td>&nbsp;&nbsp;:&emsp;<?= $kultur->mikroorganisme ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
*/ ?>