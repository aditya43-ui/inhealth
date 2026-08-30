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
        <td><?= ($print)?$model->nama_pj:$form->textField($model,'nama_pj',['disabled'=>true]) ?></td>
        <td></td>
    </tr>
    <tr>
        <td>Tempat, Tgl lahir</td>
        <td>:</td>
        <td><?= (($print)?$model->tempatlahir_pj:$form->textField($model,'tempatlahir_pj',['disabled'=>true])).' / '.(($print)?$model->tgllahir_pj:$form->textField($model,'tgllahir_pj',['disabled'=>true])) ?></td>
        <td rowspan="5"></td>
    </tr>
    <tr>
        <td>Hubungan dg pasien</td>
        <td>:</td>
        <td><?= ($print)?$model->hubungankeluarga:$form->textField($model,'hubungankeluarga',['disabled'=>true]) ?></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>    
    <tr>
        <td colspan="4">
            Dengan ini memberikan persetujuan bahwa Dokter <?= $model->dokter_dpjp1_nama ?><br/>
            Sebagai Dokter Penanggung Jawab Pelayanan terhadap pasien sebagai berikut :
        </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td >:</td>
        <td><?= ($print)?$model->nama_pasien:$form->textField($model,'nama_pasien',['disabled'=>true]) ?></td>
    </tr>
    <tr>
        <td>Tempat, Tgl lahir</td>
        <td>:</td>
        <td><?= (($print)?$model->tempat_lahir:$form->textField($model,'tempat_lahir',['disabled'=>true])).' / '.(($print)?$model->tanggal_lahir:$form->textField($model,'tanggal_lahir',['disabled'=>true])) ?></td>
    </tr>
    <tr>
        <td>Ruang tempat dirawat</td>
        <td>:</td>
        <td><?= (($print)?$model->kamarruangan_nama:$form->textField($model,'kamarruangan_nama',['disabled'=>true])).' / '.(($print)?$model->kelaspelayanan_nama:$form->textField($model,'kelaspelayanan_nama',['disabled'=>true])) ?></td>
    </tr>
</table>

<br/>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <td width="10">&nbsp;</td>
        <td><?= $profil->propinsi->propinsi_nama.', '.MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran) ?></td>
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
        <td>(<?= $model->nama_pasien ?>)</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>    
</table>













