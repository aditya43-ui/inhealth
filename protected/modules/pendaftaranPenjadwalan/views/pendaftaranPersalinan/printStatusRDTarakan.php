<style>
    td, th{
        font-size: 8pt;
    }
    p {
        text-align: right;
        width:13cm;
    }
    body{
        margin: 2.8cm 5.8cm 20.8cm 1.2cm;
    }
    @page{
        width: 21.6cm;
        height: 29.2cm;
    }
</style>
<?php // echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); ?>
<?php echo "<p><b>No. RM : ".$modPasien->no_rekam_medik."</b></p>"; ?>
<body>
<table style="width: 100%; border: none;">
    <tr>
    
    <tr>
        <td style="width:3.5cm;"></td>
        <td style ="width:5cm;"><?php echo MyFormatter::formatDateTimeId(substr($modPendaftaran->tgl_pendaftaran,0,-9)); ?></td>
<!--<td>&nbsp;</td>-->
        <td style="width:1.5cm;"></td>
        <td style="width:4cm;"><?php echo substr($modPendaftaran->tgl_pendaftaran,11,9); ?></td>
    </tr>
    <tr>
        <td align="center" valig="middle">&nbsp;</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td><?php echo ": ".$modPasien->nama_pasien.", ".$modPasien->namadepan; ?></td>
        <td>Kelamin</td>
        <td><?php echo ": ".$modPasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>Tgl. lahir/umur</td>
        <td><?php echo isset($modPasien->tanggal_lahir)?": ".MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir)." / ".substr(CustomFunction::hitungUmur($modPasien->tanggal_lahir),0,-13):' '; ?></td>
        <td>Status</td>
        <td><?php echo ": ".$modPasien->statusperkawinan; ?></td>
    </tr>
    <tr>
        <td>Agama</td>
        <td><?php echo isset($modPasien->agama)?": ".$modPasien->agama:': '; ?></td>
        <td>Pendidikan</td>
        <td><?php echo isset($modPasien->pendidikan_id)?": ".$modPasien->pendidikan->pendidikan_nama:': '; ?></td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td><?php echo isset($modPasien->pekerjaan_id)?": ".$modPasien->pekerjaan->pekerjaan_nama:': '; ?></td>
        <td>Bangsa</td>
        <td><?php echo ": ".$modPasien->warga_negara; ?></td>
    </tr>
    <tr>
        <td>Suku</td>
        <td><?php echo isset($modPasien->suku_id)?": ".$modPasien->suku->suku_nama:': '; ?></td>
    </tr>
    <tr>
        <td>Alamat lengkap</td>
        <td><?php echo ": ".$modPasien->alamat_pasien." ".(isset($modPasien->kabupaten_id)?$modPasien->kabupaten->kabupaten_nama:""); ?></td>
    </tr>
    <tr>
        <td>Kelurahan</td>
        <td><?php echo ": ".$modPasien->kelurahan->kelurahan_nama; ?></td>
    </tr>
    <tr>
        <td>Keluarga yang dapat dihubungi</td>
        <td><?php echo isset($modPenanggungjawab->alamat_pj)?": ".$modPenanggungjawab->alamat_pj:': '; ?>
            <?php echo isset($modPenanggungjawab->no_teleponpj)?" / ".$modPenanggungjawab->no_teleponpj:''; ?>
            <?php echo isset($modPenanggungjawab->no_mobilepj)?" / ".$modPenanggungjawab->no_mobilepj:''; ?>
        </td>
    </tr>
</table>
</body>