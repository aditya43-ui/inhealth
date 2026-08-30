<?php
$profil = ProfilrumahsakitM::model()->find();
?>
<em>* Lembar untuk diisi dokter</em>

<table class="prinout w100">
    <tr>
        <th width="40%" align="left">ANAMNESA</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->anamnesa ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th  align="left">RIWAYAT ALERGI</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->riwayatalergi ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th  align="left">DIAGNOSA</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->diagnosa_akhir ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th  align="left">PLANNING & TERAPI/ TINDAKAN</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->planningdanterapi ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th  align="left">TERAPI YANG SEDANG BERJALAN</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->terapiyangberjalan ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th  align="left">TINDAKAN BEDAH YANG DILAKUKAN</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->riwayatbedah ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th  align="left">RIWAYAT PENGOBATAN</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->riwayatobat ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th  align="left">PEMERIKSAAN PENUNJANG YANG DILAKUKAN</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->pemeriksaanpenunjang ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th  align="left">ANJURAN</th>       
        <td height="100px" style="border:1px solid #333 !important;">
            <?= $model->anjuran ?>
        </td>
    </tr>
</table>

<table class="prinout w100">
    <tr>
        <td style="border-bottom: 5px double #333;"></td>
    </tr>    
    <tr>
        <td>Dengan ini saya selaku pasien/ tertanggung, mengizinkan <?= $profil->nama_rumahsakit ?> untuk memberikan keterangan dengan lengkap mengenai keadaan penyakit data medis kepada pihak ketiga yang ditunjuk secara sah.</td>
    </tr>
</table>