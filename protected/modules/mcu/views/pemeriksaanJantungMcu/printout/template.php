<h2 align="center">MCU KESEHATAN JANTUNG</h2>
<?php
    $profil = ProfilrumahsakitM::model()->find();
    $daftar = $modPendaftaran;
    $pasien = $modPasien;
?>

<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td><h3 style="color:#333;font-style: underline;"><u>DATA SUBJEKTIF (ANAMNESIS)</u></h3></td>        
    </tr>
    <tr>
        <td>
            - Keluhan Utama <br/>
            <?= !empty($model->keluhanjantung)?'- '.$model->keluhanjantung.'<br/>':'' ?>
        </td>
    </tr>
    <tr>
        <td>
            - Faktor Resiko Kardiovaskuler <br/>
            <?= ($model->diabetes)?'- Diabetes <br/>':'' ?>
            <?= ($model->lvh)?'- LVH <br/>':'' ?>
            <?= !empty($model->riwayatolahraga)?'- '.$model->riwayatolahraga:'' ?>
        </td>
    </tr>
    <tr>
        <td>
            - Riwayat Penyakit Keluarga <br/>
            <?= $model->riwayatkeluarga ?>
        </td>
    </tr>   
</table>
<br/>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td colspan="9"><h3 style="color:#333;font-style: underline;"><u>DATA OBJEKTIF (PEMERIKSAAN FISIK)</u></h3></td>        
    </tr>
    <tr>
        <td width="15%">TENSI</td>        
        <td width="2%">:</td>
        <td><?= $model->tensi ?> mmHg</td>
        <td width="15%">TINGGI BADAN</td>        
        <td width="2%">:</td>
        <td><?= $model->tinggibadan ?> cm</td>
        <td width="15%">BERAT BADAN</td>        
        <td width="2%">:</td>
        <td><?= $model->beratbadan ?> kg</td>
    </tr>   
    <tr>
        <td>PERNAPASAN</td>        
        <td>:</td>
        <td><?= $model->tensi ?> x/menit</td>
        <td>NADI</td>        
        <td>:</td>
        <td colspan="4"><?= $model->tinggibadan ?> x/menit</td>        
    </tr>  
    <tr>
        <td colspan="9">
            BENTUK DADA : <br/>
            <?= $model->bentukdada ?>
        </td>
    </tr>
    <tr>
        <td colspan="9">
            BATAS - BATAS JANTUNG : <br/>
            <?= $model->batasjantung ?>
        </td>
    </tr>
    <tr>
        <td colspan="9">
            BUNYI JANTUNG : <br/>
            <?= $model->bunyijantung ?>
        </td>
    </tr>
</table>
<br/>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td><h3 style="color:#333;font-style: underline;"><u>PEMERIKSAAN PENUNJANG</u></h3></td>        
    </tr>    
    <tr>
        <td>
            LABORATORIUM : <br/>
            <?= $model->laboratorium ?>
        </td>
    </tr>
    <tr>
        <td>
             RONTGEN THORAX : <br/>
            <?= $model->rothorax ?>
        </td>
    </tr>   
    <tr>
        <td>
             EKG : <br/>
            <?= $model->ekg ?>
        </td>
    </tr>
    <tr>
        <td>
             ECHOCARDIOGRAFI : <br/>
            <?= $model->echo ?>
        </td>
    </tr>
    <tr>
        <td>
             TREADMILL : <br/>
            <?= $model->treadmill ?>
        </td>
    </tr>
</table>
<br/>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td><h3 style="color:#333;font-style: underline;"><u>KESIMPULAN PEMERIKSAAN</u></h3></td>        
    </tr>    
    <tr>
        <td>
            <?= '- '.$model->kesimpulan ?>
        </td>
    </tr>   
</table>
<br/>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td><h3 style="color:#333;font-style: underline;"><u>REKOMENDASI</u></h3></td>        
    </tr>    
    <tr>
        <td>
            <?= '- '.$model->rekomendasi ?>
        </td>
    </tr>   
</table>
<br/>

<br/>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td width="50%">&nbsp;</td>
        <td width="50%" style="text-align:right;">
            <?= $profil->propinsi->propinsi_nama.', '.date('d').' '.MyFormatter::getMonthId(date('m')).' '.date('Y'); ?><br/>
            Koordinator Medical Check Up
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align:right;">
            (<?= !empty($model->dpjp)?$model->dpjp->namaLengkap:'-' ?>)
        </td>
    </tr>
</table>
