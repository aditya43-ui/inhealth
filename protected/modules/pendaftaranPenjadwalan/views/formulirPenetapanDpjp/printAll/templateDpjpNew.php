<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
?>
<table class="w-100 prinout no-grid" style="text-align: center;" width='100%'>
    <tr>
        <th align="center" style="text-align:center;"><b>PENETAPAN DOKTER PENANGGUNG JAWAB PELAYANAN ( DPJP )</b></th>
    </tr>
    <tr>
        <th align="center" style="text-align:center;"><b><?= strtoupper($namars) ?></b></th>
    </tr>    
</table>
<br/>

<table class="w-100 prinout no-grid">
    <tr>
        <td colspan="4">Yang bertanda tangan dibawah ini :</td>
    </tr>    
    <tr>
        <td width="200">Nama</td>
        <td>:</td>
        <td><?= $modPendaftaran->penanggungjawab->nama_pj?></td>
        <td></td>
    </tr>
    <tr>
        <td>Tempat, Tgl lahir</td>
        <td>:</td>
        <td><?= $modPendaftaran->penanggungjawab->tempatlahir_pj.' / '.$modPendaftaran->penanggungjawab->tgllahir_pj?></td>
        <td rowspan="5"></td>
    </tr>
    <tr>
        <td>Hubungan dg pasien</td>
        <td>:</td>
        <td><?= $modPendaftaran->penanggungjawab->hubungankeluarga?></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>    
    <tr>
        <td colspan="4">
            Dengan ini memberikan persetujuan bahwa Dokter <?= $dok->namaLengkap ?><br/>
            Sebagai Dokter Penanggung Jawab Pelayanan terhadap pasien sebagai berikut :
        </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td >:</td>
        <td><?= $modPendaftaran->pasien->nama_pasien?></td>
    </tr>
    <tr>
        <td>Tempat, Tgl lahir</td>
        <td>:</td>
        <td><?= $modPendaftaran->pasien->tempat_lahir.' / '.$modPendaftaran->pasien->tanggal_lahir?></td>
    </tr>
    <tr>
        <td>Ruang tempat dirawat</td>
        <td>:</td>
        <td><?= !empty($modAdmisi->kamarruangan_nama) ? $modAdmisi->kamarruangan_nama : "-".' / '. (!empty($modAdmisi->kelaspelayanan_nama) ? $modAdmisi->kelaspelayanan_nama : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama);?></td>
    </tr>
</table>

<br/>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <td width="10">&nbsp;</td>
        <td><?= $profil->kabupaten->kabupaten_nama.', '.MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) ?></td>
        <td>&nbsp;</td>
        <td width="10">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Nama Pasien / keluarga</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>(<?= $modPendaftaran->pasien->nama_pasien ?>)</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>    
</table>













