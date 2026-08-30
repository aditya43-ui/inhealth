<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
    
    $custom = new CustomFunction;
?>
<table class="w-100 prinout no-grid" style="text-align: center;"  width='100%'>
    <tr>
        <th align="center" style="text-align:center;"><b>FORMULIR PERMINTAAN PELAYANAN KEROHANIAN</b></th>
    </tr>       
</table>
<br/>

<table class="w-100 prinout no-grid">
    <tr>
        <td width='10'>1.</td>
        <td>KEBUTUHAN ROHANI YANG DIMINTA PASIEN</td>
    </tr> 
    <tr>
        <td>&nbsp;</td>
        <td>
            <?php
                echo (!$print)?$form->textArea($model, 'kebutuhanrohani', array('rows'=>4, 'id'=>'kebutuhanrohani')):$model->kebutuhanrohani 
            ?>
        </td>
    </tr>
    <tr>
        <td width='10'>2.</td>
        <td>PERMINTAAN KHUSUS PELANGAN KEROHANIAN</td>
    </tr> 
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_ruqyah', array('id'=>'permintaan_ruqyah')): $custom->set_pilihan_ceklis($model->kebutuhanrohani)  
            ?> <label for='permintaan_ruqyah'>Ruqyah syar'iyah</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_terapidzikir', array('id'=>'permintaan_terapidzikir')): $custom->set_pilihan_ceklis($model->permintaan_terapidzikir)  
            ?> <label for='permintaan_terapidzikir'>Terapi dzikir</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_terapitahajud', array('id'=>'permintaan_terapitahajud')): $custom->set_pilihan_ceklis($model->permintaan_terapitahajud)  
            ?> <label for='permintaan_terapitahajud'>Terapi sholat tahajud</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_talqin', array('id'=>'permintaan_talqin')): $custom->set_pilihan_ceklis($model->permintaan_talqin)  
            ?> <label for='permintaan_talqin'>Talqin</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_konsulkeagamaan', array('id'=>'permintaan_konsulkeagamaan')): $custom->set_pilihan_ceklis($model->permintaan_konsulkeagamaan)  
            ?> <label for='permintaan_konsulkeagamaan'>Konsultasi keagamaan pasien/keluarga/karyawan</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_pendampingannonmus', array('id'=>'permintaan_pendampingannonmus')): $custom->set_pilihan_ceklis($model->permintaan_pendampingannonmus)  
            ?> <label for='permintaan_pendampingannonmus'>Pendampingan rohani non muslim</label>
        </td>
    </tr>
    <tr>
        <td width='10'>3.</td>
        <td>PERMINTAAN PELAYANAN JENAZAH</td>
    </tr> 
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_pemulasaran', array('id'=>'permintaan_pemulasaran')): $custom->set_pilihan_ceklis($model->permintaan_pemulasaran)  
            ?> <label for='permintaan_pemulasaran'>Pemulasaran, pemandian dan pengkafanan</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_pengantaran', array('id'=>'permintaan_pengantaran')): $custom->set_pilihan_ceklis($model->permintaan_pengantaran)  
            ?> <label for='permintaan_pengantaran'>Pengantaran jenazah</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_pengawetan', array('id'=>'permintaan_pengawetan')): $custom->set_pilihan_ceklis($model->permintaan_pengawetan)  
            ?> <label for='permintaan_pengawetan'>Pengawetan jenazah</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_mensholatkan', array('id'=>'permintaan_mensholatkan')): $custom->set_pilihan_ceklis($model->permintaan_mensholatkan)  
            ?> <label for='permintaan_mensholatkan'>Mensholatkan jenazah</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                (!$print)?$form->checkBox($model, 'permintaan_lainnya', array('id'=>'permintaan_lainnya')): $custom->set_pilihan_ceklis($model->permintaan_lainnya)  
            ?> <label for='permintaan_lainnya'>Lainnya ...</label>
        </td>
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
        <td>Mengetahui,</td>
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
        <td>(<?= !empty($model->petugas_admisi)?$model->petugas_admisi:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>)</td>
        <td>&nbsp;</td>
    </tr>    
    <tr>
        <td>&nbsp;</td>
        <td>Nama & Tandatangan</td>
        <td>Nama & Tandatangan</td>
        <td>&nbsp;</td>
    </tr> 
</table>

<br/>
<br/>
<br/>
<b><i>HPK 1.1 Akreditasi SNARS Edisi 1.1</i></b>
<br/>
<b><i>SPBK 2 / Sertifikasi Syariah 1441 N</i></b>












