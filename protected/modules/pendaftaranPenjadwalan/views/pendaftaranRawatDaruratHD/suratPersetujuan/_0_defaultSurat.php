<tr>
    <td width="5%"> </td>
    <td width="25%"> Nama </td>
    <td> : <?= $modPenanggungJawab->nama_pj ?> </td>
</tr>
<tr>
    <td> </td>
    <td> Tempat/Tanggal Lahir </td>
    <td> : 
        <?php
        $val = $modPenanggungJawab->tempatlahir_pj . "/" . MyFormatter::formatDateTimeForUser($modPenanggungJawab->tgllahir_pj);
        $modPenanggungJawab->tempatlahir_pj = $val;
        ?>
        <?= $val ?>
    </td>
</tr>
<tr>
    <td> </td>
    <td> Jenis Kelamin </td>
    <td> : <?= $modPenanggungJawab->jeniskelamin ?> </td>
</tr>
<tr>
    <td> </td>
    <td> No Identitas </td>
    <td> : <?= $modPenanggungJawab->no_identitas ?> </td>
</tr>
<tr>
    <td> </td>
    <td> Hubungan dengan pasien </td>
    <td> : <?= $modPenanggungJawab->hubungankeluarga ?> </td>
</tr>
<tr>
    <td> </td>
    <td> Alamat </td>
    <td> : <?= $modPenanggungJawab->alamat_pj ?> </td>
</tr>
<tr>
    <td> <br> </td>
</tr>
<tr>
    <td style="margin-top: 1rem !important"> </td>
    <td colspan="2" style="margin-top: 1rem !important">
        Adalah diri saya sendiri sebagai <?= $modPenanggungJawab->hubungankeluarga ?> 
        Penanggung jawab pasien
    </td>
</tr>
<tr>
    <td width="5%"> </td>
    <td width="20%"> Nama </td>
    <td> : <?= $modPasien->nama_pasien ?> </td>
</tr>
<tr>
    <td> </td>
    <td> No. Rekam Medis </td>
    <td> : <?= $modPasien->no_rekam_medik ?> </td>
</tr>
<tr>
    <td> </td>
    <td> Tempat/Tanggal Lahir </td>
    <td> : 
        <?php
        $val_2 = $modPasien->tempat_lahir . "/" . MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
        $modPasien->tempat_lahir = $val_2;
        ?>
        <?= $val_2 ?>
    </td>
</tr>
<tr>
    <td> </td>
    <td> Umur </td>
    <td> : <?= $modPendaftaran->umur ?> </td>
</tr>
<tr>
    <td> </td>
    <td> Jenis Kelamin </td>
    <td> : <?= $modPasien->jeniskelamin ?> </td>
</tr>