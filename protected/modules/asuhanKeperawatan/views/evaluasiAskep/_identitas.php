<?php
$model->load_all = true;
?>

<table with="100%" class="status">
    <tr class="identitas">
        <td width="20%">No. Rekam Medik</td>
        <td wdith="2%">:</td>
        <td><?= $rencana->no_rekam_medik; ?></td>
        <td width="10%"></td>
        <td width="20%">Tanggal Lahir</td>
        <td width="2%">:</td>
        <td><?= MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
    </tr>
    <tr class="identitas">
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?= $rencana->nama_pasien; ?></td>
        <td></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?= $rencana->jeniskelamin; ?></td>
    </tr>
    <tr class="identitas">
        <td >Ruangan</td>
        <td>:</td>
        <td><?= $rencana->ruangan_nama; ?></td>
    </tr>
</table>