<?php

if (count((array)$modAnamnesa) > 0) : ?>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;  ?></td>
        <td style="width:20%">NO. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">Tgl. Lahir / UMUR</td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?> / <?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Jenis Kelamin</td>
        <td style="width:30%"><?php echo $modPasien->jeniskelamin; ?></td>
        <td style="width:20%">No. Pendaftaran</td>
        <td style="width:30%"><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    
</table>

<?php 
    echo $this->renderPartial($this->path_view_pencarian . 'rawatjalan._anamnesa', array(
        'format' => $format,
        'modPendaftaran' => $modPendaftaran,
        'judul_print' => $judul_print,
        'modPasien' => $modPasien,
        'modAnamnesa' => $modAnamnesa,
    ), true);
endif; 

echo "<br>";

echo $this->renderPartial($this->path_view_pencarian . 'rawatjalan._pemeriksaanFisikRj', array(
    'format' => $format,
    'modPendaftaran' => $modPendaftaran,
    'judul_print' => $judul_print,
    'modPasien' => $modPasien,
    'modPemeriksaanFisik' => $modPemeriksaanFisik,
    'modPemeriksaanGambar' => $modPemeriksaanGambar,
    'modGambarTubuh' => $modGambarTubuh,
    'modBagianTubuh' => $modBagianTubuh
        ), true);

echo $this->renderPartial($this->path_view_pencarian.'rawatjalan._resepturRj',array(
            'modPendaftaran'=>$modPendaftaran,
            'judulLaporan'=>$judul_print,
            "modDetailResep"=>$modDetailResep, 
            'modReseptur'=>$modReseptur
     ),true);
?>

