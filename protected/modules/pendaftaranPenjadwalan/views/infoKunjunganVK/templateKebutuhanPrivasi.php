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
        <td><?= ($print)?$model->nama_pasien:$form->textField($model,'nama_pasien',['disabled'=>true]) ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?= (($print)?$model->umur_pasien:$form->textField($model,'umur_pasien',['disabled'=>true])).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jenis Kelamin : '.(($print)?$model->jeniskelamin:$form->textField($model,'jeniskelamin',['disabled'=>true])) ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?= ($print)?$model->alamat_pasien:$form->textField($model,'alamat_pasien',['disabled'=>true]) ?></td>
    </tr>
    <tr>
        <td colspan="3">Dengan ini *) diberikan kebutuhan privasi berupa :</td>
    </tr>    
    <tr>
        <td colspan="3">
            <?php echo (!$print)?$form->textArea($model, 'kebutuhanprivasi', array('rows'=>4, 'id'=>'kebutuhanprivasi')):$model->kebutuhanprivasi ?>
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
        <td><?= $profil->propinsi->propinsi_nama.', '.MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran) ?></td>
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
        <td>(<?= $model->nama_pasien ?>)</td>
        <td>(<?= !empty($model->saksi_pasien)?$model->saksi_pasien:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>)</td>
        <td>&nbsp;</td>
    </tr>    
    <tr>
        <td>&nbsp;</td>
        <td>Nama & Tandatangan</td>
        <td>Nama & Tandatangan</td>
        <td>&nbsp;</td>
    </tr> 
</table>













