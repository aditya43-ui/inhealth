<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
?>
<table class="w-100 prinout no-grid" style="text-align: center;" width='100%'>
    <tr>
        <th align="center" style="text-align:center;"><b>FORMULIR KEBUTUHAN PRIVASI</b></th>
    </tr>       
</table>
<br/>

<table class="w-100 prinout no-grid">
    <tr>
        <td colspan="3">Yang bertanda tangan dibawah ini :</td>
    </tr>    
    <tr>
        <td width="20">Nama</td>
        <td width="5">:</td>
        <td><?= $modPendaftaran->pasien->nama_pasien?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?= $modPendaftaran->umur.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jenis Kelamin : '.$modPendaftaran->pasien->jeniskelamin ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?= $modPendaftaran->pasien->alamat_pasien ?></td>
    </tr>
    <tr>
        <td colspan="3">Dengan ini *) diberikan kebutuhan privasi berupa :</td>
    </tr>    
    <tr>
        <td colspan="3">
            <?php 
            foreach($surat as $d){

            } 
  
            echo !empty($d->kebutuhanprivasi) ? $d->kebutuhanprivasi : '<textarea rows="5" cols="200"></textarea>';?>
        </td>
    </tr>
    <tr>
        <td colspan="3">*) Coret <i>yang tidak perlu</i></td>
    </tr>    
</table>

<br/>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <td width="10">&nbsp;</td>        
        <td>&nbsp;</td>
        <td><?= $profil->propinsi->propinsi_nama.', '.MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) ?></td>
        <td width="10">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Pemohon</td>
        <td>Saksi</td>
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
        <td>(<?= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>)</td>
        <td>&nbsp;</td>
    </tr>    
    <tr>
        <td>&nbsp;</td>
        <td>Nama & Tandatangan</td>
        <td>Nama & Tandatangan</td>
        <td>&nbsp;</td>
    </tr> 
</table>













