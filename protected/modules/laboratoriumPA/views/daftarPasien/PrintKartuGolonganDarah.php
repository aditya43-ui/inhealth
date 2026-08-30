<style>
    .goldarah{
        font-family: tahoma;
        font-size: 24pt;
        vertical-align: bottom;
        text-align: center;
    }
    table{
        font-family: tahoma;
        vertical-align: bottom;
        font-size: 8pt;
        width: 100%;
    }
</style>

<table width="100%">
    <tr>
        <td width="30%"></td>
        <td width="60%"></td>
        <td rowspan="2" class="goldarah"><?php echo $modPeriksaGolonganDarah->hasilpemeriksaan?></td>
    </tr>
    <tr>
        <td>No. Pasien</td>
        <td>: <?php echo $modPasien->no_rekam_medik;?></td>
        <td></td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>: <b><?php echo $modPasien->namadepan.' '.$modPasien->nama_pasien; ?></b></td>
        <td></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: <?php echo $modPasien->jeniskelamin;?></td>
        <td></td>
    </tr>
    <tr>
        <td>Tmp/Tgl. Lahir</td>
        <td>: <?php echo $modPasien->tempat_lahir.", ".$modPasien->tanggal_lahir;?></td>
        <td><b><center><?php echo $modPeriksaRhesus->hasilpemeriksaan;?></center></b></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $modPasien->alamat_pasien;?></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>&nbsp;&nbsp;<?php echo (!empty($modPasien->rt)) ? "RT.".$modPasien->rt."/RW.".$modPasien->rw : "";?></td>
        <td></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>: <?php echo $modPendaftaran->no_pendaftaran;?></td>
        <td></td>
    </tr>
    <tr>
        <td>Tgl. Periksa</td>
        <td>: <?php echo date('d M Y',  strtotime($modPeriksaGolonganDarah->create_time));?></td>
        <td></td>
    </tr>
    
</table>