<?php

$jenis = ($model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "Persetujuan" : "Penolakan";
$jenis2 = ($model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "menyetujui" : "menolak";

?>

<style>
    p{
        text-align: justify;
    }
    tr, td {
        padding: 7px;
    }
    table#persetujuan {
        
        text-align: center;
    }
</style>
    <h3><center><?php echo $model->jenissurat; ?> TINDAKAN ANASTESI</center></h3>
<br>
<p align="justify">
    Setelah mendapat informasi mengenai tindakan anastesi, maka yang bertanda tangan di bawah ini :
</p>
<table width="100%">
<tr>
    <td width="200">Nama</td>
    <td width="10">:</td>
    <td> <?php echo $model->namapenanggungjawab; ?> </td>
</tr>
<tr>
    <td>Umur</td>
    <td>:</td>
    <td> <?php echo $model->umurpenanggungjawab; ?></td>
</tr>
<tr>
    <td>Jenis Kelamin</td>
    <td>:</td>
    <td> <?php echo $model->jeniskelamin_penanggungjawab; ?></td>
</tr>
<tr>
    <td>Alamat</td>
    <td>:</td>
    <td> <?php echo $model->alamat_penanggungjawab; ?></td>
</tr>
<tr>
    <td>No. Kartu Identitas</td>
    <td>:</td>
    <td> <?php echo $model->noidentitas_penanggungjawab; ?></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td> <?php echo $model->jenisidentitas_penanggungjawab; ?></td>
</tr>
</table>
<br>
<p align="justify">
   Menyatakan <?php echo $model->jenissurat; ?> untuk dilakukan tindakan <?php echo $informasi->jenisanestesi; ?>
</p>

<br>
<p align="justify">
   Terhadap <?php echo $informasi->penerimainformasi_hubungandgnpasien; ?> Saya :
</p>
<table cellpadding="10" width="100%">
    <tr>
        <td width="200">Nama</td>
        <td width="10">:</td>
        <td><?=$modPasien->nama_pasien?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?=$modPasien->no_rekam_medik?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php
        $umur = explode(" ", $modPendaftaran->umur);
        
        echo $umur[0] ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?=$modPasien->jeniskelamin ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?=$modPasien->alamat_pasien ?></td>
    </tr>
    
</table>
<br>
<p align="justify">
   Dan saya menyatakan bahwa :
</p>
<p align="justify">
   1. Saya memahami perlunya dan manfaat tindakan anestesi tersebut sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk
   risiko dan komplikasi yang mungkin timbul, apabila tindakan tersebut tidak dilakukan, serta telah diberi kesempatan untuk bertanya
   dan berdiskusi dengan dokter.
</p>
<p align="justify">
   2. Saya juga menyadari bahwa oleh karena ilmu kedokteran adalah bukan ilmu pasti, maka keberhasilan anestesi kedokteran bukanlah 
   keniscayaan, melainkan sangat bergantung pada izin Tuhan Yang Maha Esa.
</p>
<p align="justify">
   3. Saya juga menyadari bahwa pelayanan di rumah sakit ini merupakan kerja sama team (dokter dan perawat anestesi) dan bahwasanya 
   anestesi untuk tindakan operasi ini akan dilakukan dibawah pengawasan Dokter <?php 
   
   $dokterA = PegawaiM::model()->findByPk($model->dokteranestesi_id);
   echo empty($dokterA) ? "-" : $dokterA->namaLengkap;
   
   
   ?>.
</p>
<p align="justify">
   4. Saya mempunyai kewajiban untuk memberikan informasi kepada dokter mengenai semua penyakit dan obat yang saya/pasien minum seperti aspirin, 
   pengencer darah, kontrasepsi, obat-obat flu, narkotika, marijuana, kokain, dan lain-lain, mengingat hal tersebut dapat menimbulkan komplikasi 
   bagi anestesi maupun pembedahan.
</p>

<p align="justify">
    Berdasrkan hal-hal tersebut di atas, saya menjamin sepenuhnya bahwa tindakan saya untuk <?php echo $jenis2; ?> tindakan anestesi di atas adalah untuk mewakili kepentingan saya/pasien 
    dan keluarga pasien, dan saya bertanggung jawab sepenuhnya apabila terdapat pihak lain yang mengajukan keberatan atas <?php echo $jenis; ?> ini.
</p>
<p align="justify">
    Demikian surat <?php echo $jenis; ?> ini dibuat dengan penuh kesadaran dan tanpa paksaan dari pihak manapun juga.
</p>

<table width="100%" id="persetujuan">
    <tr>
        <td></td>
        <td><?= Yii::app()->user->getState('kabupaten_nama'); ?>, <?= date(' d M Y', strtotime($model->create_time))." pukul ".date('H:i:s', strtotime($model->create_time)); ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>Yang membuat pernyataan,</td>
        <td></td>
        <td></td>
        <td>Dokter,</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo $model->namapenanggungjawab; ?></td>
        <td></td>
        <td></td>
        <td><?php echo empty($model->doktermenyetujui) ? "-" : $model->doktermenyetujui->namaLengkap; ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>Saksi Pihak Keluarga,</td>
        <td></td>
        <td></td>
        <td>Saksi Pihak RS,</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo $model->nama_pihakkeluarga; ?></td>
        <td></td>
        <td></td>
        <td>
            <?php echo $model->pegawaisaksi->namaLengkap; ?>
        </td>
    </tr>
    <tr>    
        <td></td>
        <td>No. KTP/SIM : <?php echo $model->noidentitas; ?></td>
        <td></td>
    </tr>
</table>