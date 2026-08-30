<h3 align="center">MEDICAL CHECKUP</h3>
<?php
    $profil = ProfilrumahsakitM::model()->find();
    $daftar = $modPendaftaran;
    $pasien = $modPasien;
?>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td width="20%">No Pendaftaran</td>
        <td width="2%">:</td>
        <td><?= $daftar->no_pendaftaran ?></td>        
    </tr>
    <tr>
        <td>No. RM</td>
        <td>:</td>
        <td><?= $pasien->no_rekam_medik ?></td>        
    </tr>
    <tr>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><?= $pasien->nama_pasien ?></td>        
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?= $daftar->umur ?></td>        
    </tr>
    <tr>
        <td>Tanggal Pemeriksaan</td>
        <td>:</td>
        <td><?= MyFormatter::formatDateTimeForUser($model->tgl_pemeriksaan) ?></td>
    </tr>
</table>
<br/>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td colspan="3"><h2>RIWAYAT PENYAKIT</h2></td>        
    </tr>
     <tr>
        <td width="20%">Riwayat Penyakit Terdahulu</td>
        <td width="2%">:</td>
        <td><?= $model->riwayatpenyakitterdahulu ?></td>        
    </tr>
    <tr>
        <td>Riwayat Penyakit Keluarga</td>
        <td>:</td>
        <td><?= $model->riwayatpenyakitkeluarga ?></td>        
    </tr>
    <tr>
        <td>Keluhan saat ini</td>
        <td>:</td>
        <td><?= $model->keluhansaatini ?></td>        
    </tr>   
</table>
<br/>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td colspan="3"><h2>PEMERIKSAAN FISIK</h2></td>        
    </tr>
     <tr>
        <td width="20%">Keadaan umum</td>
        <td width="2%">:</td>
        <td><?= $model->keadaanumum ?></td>        
        <td>&nbsp;</td>
        <td width="15%">Tinggi Badan</td>
        <td width="2%">:</td>
        <td><?= $model->tinggibadan ?> &nbsp; cm</td>
    </tr>
    <tr>
        <td>Kesadaran</td>
        <td>:</td>
        <td><?= $model->kesadaran ?></td>    
        <td>&nbsp;</td>
        <td>Berat Badan</td>
        <td>:</td>
        <td><?= $model->beratbadan ?> &nbsp; kg</td>
    </tr>
    <tr>
        <td>Tekanan Darah</td>
        <td>:</td>
        <td><?= $model->tekanandarah_sistolik.'/'.$model->tekanandarah_diastolik ?> mmHg</td>    
        <td>&nbsp;</td>
        <td>Nadi</td>
        <td>:</td>
        <td><?= $model->nadi ?> &nbsp; x/menit</td>
    </tr>   
    <tr>
        <td>Pernafasan</td>
        <td>:</td>
        <td><?= $model->pernafasan ?> x/menit</td>    
        <td>&nbsp;</td>
        <td>Suhu</td>
        <td>:</td>
        <td><?= $model->suhu ?> &nbsp; <sup>o</sup>C</td>
    </tr>
    <tr>
        <td>Kepala</td>
        <td>:</td>
        <td colspan="4"> 
            <?= !empty($model->bentukkepala)?'Bentuk '.$model->bentukkepala.', ':'' ?>
            <?= ($model->benjolan == 'Ya')?'Terasa Benjolan '.', ':'Tidak Terasa Benjolan' ?>
            <?= !empty($model->warnarambut)?'Warna Rambut '.$model->warnarambut:'' ?>
        </td>            
    </tr>
    <tr>
        <td>Mata</td>
        <td>:</td>
        <td colspan="4"> 
            <?= ($model->mata_anemis == 'Ya')?'Anemis'.', ':'' ?>
            <?= ($model->mata_ikterik == 'Ya')?'Ikterik':'' ?>
        </td>            
    </tr>
    <tr>
        <td>Hidung</td>
        <td>:</td>
        <td colspan="4"> 
            <?= !empty($model->hidung_bentuk)?'Bentuk '.$model->hidung_bentuk.', ':'' ?>
            <?= ($model->hidung_deviasi == 'Ya')?'Ada Deviasi,':'Tidak Ada Deviasi' ?>
            <?= ($model->hidung_sekret == 'Ya')?'Ada Sekret':'Tidak Ada Sekret' ?>
        </td>            
    </tr>
    <tr>
        <td>Telinga</td>
        <td>:</td>
        <td colspan="4"> 
            <?= !empty($model->telinga_cae)?'CAE '.$model->telinga_cae.', ':'' ?>
            <?= !empty($model->telinga_mt)?'MT '.$model->telinga_mt.', ':'' ?>
            <?= !empty($model->telinga_sekret == 'Ya')?'Ada Sekret':'Tidak Ada Sekret' ?>
        </td>            
    </tr>
    <tr>
        <td>Leher</td>
        <td>:</td>
        <td colspan="4"> 
            <?= !empty($model->leher_bentuk)?'Bentuk '.$model->leher_bentuk.', ':'' ?>
            <?= !empty($model->leher_kellimfe)?'Limfe '.$model->leher_kellimfe.', ':'' ?>            
        </td>            
    </tr>
    <tr>
        <td>Tenggorokan</td>
        <td>:</td>
        <td colspan="4"> 
            <?= ($model->tenggorokan_faring != 'Tidak')?'Faring '.$model->tenggorokan_faring.' dan ':'Faring Tidak Hiperemis, Tidak Berganula dan' ?>
            <?= !empty($model->tenggorokan_tonsil)?'Tonsil '.$model->tenggorokan_tonsil.', ':'' ?>            
        </td>            
    </tr>
    <tr>
        <td>Thorax</td>
        <td>:</td>
        <td colspan="4"> 
            <?= !empty($model->thorax_pergerakan)?$model->thorax_pergerakan.' dalam diam dan pergerakan, ':'' ?>
            <?= !empty($model->thorax_stem)?'Stem fremitus kanan dan kiri '.$model->thorax_stem.', ':'' ?>            
            <?= ($model->bunyiparu_sonor == 'Ya')?'Bunyi paru Sonor, ':'' ?>            
            <?= ($model->bunyiparu_vesikuler == 'Ya')?'Vesikuler, ':'' ?>            
            <?= ($model->bunyiparu_ronchi == 'Ya')?'Ada Ronchi, ':'' ?>            
            <?= ($model->bunyiparu_wheezing == 'Ya')?'Ada Wheezing, ':'' ?>  
        </td>            
    </tr>
    <tr>
        <td>Jantung</td>
        <td>:</td>
        <td colspan="4"> 
            <?= !empty($model->jantung_bunyi)?'Bunyi Jantung '.$model->jantung_bunyi.', ':'' ?>
            <?= ($model->jantung_murmur == 'Ya')?'Ada Murmur, ':'' ?>            
            <?= ($model->jantung_gallop == 'Ya')?'Ada Gallop, ':'' ?>            
        </td>            
    </tr>
    <tr>
        <td>Abdomen</td>
        <td>:</td>
        <td colspan="4"> 
            <?= ($model->abdomen_supel == 'Ya')?'Supel, ':'' ?>            
            <?= (strpos($model->abdomen_hepar, 'Tidak') !== false)?'Hepar dan Limpa terasa membesar':'' ?>            
            
        </td>            
    </tr>
    <tr>
        <td>Ekstremitas</td>
        <td>:</td>
        <td colspan="4"> 
            <?= !empty($model->ekstermitas_akral)?'Akral '.$model->ekstermitas_akral.', ':'' ?>            
            <?= ($model->ekstermitas_adeformitas == 'Ada')?'Ada Deformitas, ':'' ?>            
            <?= ($model->ekstermitas_aoedema == 'Ada')?'Ada Oedema':'' ?>            
            
        </td>            
    </tr>
</table>
<br/>
<table class="prinout w100 no-grid" width="100%">
    <tr>
        <td colspan="3"><h2>Kesimpulan & Saran</h2></td>        
    </tr>
    <tr>
        <td width="20%" style="vertical-align: top;">Kesimpulan</td>
        <td width="2%">:</td>
        <td>
            <?php
                echo 'Dari hasil pemeriksaan yang kami lakukan,<br/>';
                echo 'kami menyimpulkan bahwa hasil MCU adalah :<br/>';
                echo '- Dari hasil pemeriksaan Fisik didapat : '.$model->radiologi_hasil.'<br/>';
                echo '- Dari hasil pemeriksaan Laboratorium didapat : <br/>';
                echo '? Darah Lengkap : '.$model->lab_darah_hasil.'<br/>';
                echo '? Fungsi Ginjal : <br/>';
                echo '- Ureum : '.$model->ginjal_ureum.'<br/>';
                echo '- Creatinin : '.$model->ginjal_creatinin.'<br/>';
                echo '- Asam Urat : '.$model->ginjal_asamurat.'<br/>';
                echo '* Anjuran : '.$model->ginjal_anjuran.'<br/>';
                echo '? Fungsi Hati :<br/>';
                echo '- SGOT : '.$model->fungsihati_sgot.'<br/>';
                echo '- SGPT : '.$model->fungsihati_sgpt.'<br/>';
                echo '? Metabolisme Glukosa :<br/>';
                echo '- Glukosa Puasa : '.$model->metabolisme_glukosapuasa.'<br/>';
                echo '* Anjuran : '.$model->metabolisme_anjuran.'<br/>';                
                echo '? Metabolisme Lemak :<br/>';
                echo '- Kolesterol Total : '.$model->lemak_kolestrol.'<br/>';
                echo '- Kolesterol HDL : '.$model->lemak_hdl.'<br/>';
                echo '- Kolesterol LDL Direct : '.$model->lemak_ldl.'<br/>';
                echo '- Trigliserida : '.$model->lemak_trigliserida.'<br/>';
                echo '* Anjuran : '.$model->lemak_anjuran.'<br/>';
                echo '? Urine Lengkap : '.$model->lemak_urinlengkap.'<br/>';
                echo '- Dari hasil pemeriksaan EKG didapat : '.$model->lemak_hasilekg.'<br/>';
                echo '- Dari hasil pemeriksaan Rontgen Thorax didapat : '.$model->lemak_hasilthorax;
                echo '- Dari hasil pemeriksaan didapat : '.$model->lemak_hasildidapat;            
            ?>
        </td>               
    </tr>
    <tr>
        <td>Kesimpulan</td>
        <td>:</td>
        <td>
            <?= $model->lemak_saran ?>
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
