<?php
$nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$profil = ProfilrumahsakitM::model()->find();
function cek_lis($st){
    $icon = '<span  style="font-family:FontAwesome;" >&#xf096;</span>';
    if ($st){
        $icon = '<span  style="font-family:FontAwesome;" >&#xf046;</span>';
    }
    return $icon;
}
?>
<br/>
<table class="prinout w100 no-grid">
    <tr>
        <td>
            <h3 align="left">RINCIAN PASIEN PULANG (RESUME)</h3>
        </td>
        <td align="right">
             <span align="right" style="border:4px solid #333;padding:10px;margin:10px; font-weight:bolder;">RAHASIA</span>
        </td>
    </tr>
</table>

<table class="prinout w100 grid">
    <tr>
        <td width="25%">
            <b>Nama Pasien:</b> <?= $modPas->nama_pasien ?>
        </td>
        <td width="25%">
            <b>No. RM:</b> <?= $modPas->no_rekam_medik ?><br/>
            <b>NIK:</b> <?= $modPas->no_identitas_pasien ?>
        </td>
        <td width="25%">
            <b>Tgl. Lahir:</b> <?= MyFormatter::formatDateTimeForUser($modPas->tanggal_lahir) ?><br/>
            <b>Umur</b> <?= $modDaftar->umur ?>
        </td>
        <td width="25%">
            <b>jenis Kelamin:<b> <?= $modPas->jeniskelamin ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Tangggal masuk:</b> <?= MyFormatter::formatDateTimeForUser($modDaftar->tgl_pendaftaran) ?>
        </td>
        <td colspan="2">
            <b>Tangggal keluar/meninggal:</b> <?= !empty($model)?MyFormatter::formatDateTimeForUser($model->tglkeluar):'' ?>
        </td>
        <td>
            <b>Ruang rawat terakhir:</b> <?php
            $modNomorKamar = MasukkamarT::model()->findByAttributes(array(
                'pasienadmisi_id' => $modDaftar->pasienadmisi_id,
            ));
            if(!empty($modNomorKamar)){
                echo $modNomorKamar->kamarruangan->kamarruangan_nokamar.' '.$modNomorKamar->kamarruangan->kamarruangan_nobed;
            }else{
                 echo $modAdmisi->ruangan->ruangan_nama;
            }
            
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Indikasi rawat inap:</b> 
        </td>
        <td colspan="2">
           <?= $model->indikasiri ?>
        </td>
        <td>
            <b>Penjamin:</b> <?= $modAdmisi->penjamin->penjamin_nama ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Ringkasan riwayat pasien:</b> 
        </td>
        <td colspan="3">
           <?= $model->ringkasanriwayatpenyakit ?>
        </td>       
    </tr>
    <tr>
        <td colspan="4">
            <table class="prinout w100 no-grid">
                <tr>
                    <td colspan="5">
                        <b>Pemeriksaan Fisik: </b><?= $model->pemeriksaan_fisik ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <b>Keadaan umum:</b> <?= $model->keadaanumum ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tanda vital:</b> <?= $model->tandavital ?>
                    </td>
                    <td>
                        <b>Tekanan darah:</b> <?= !empty($model->td_systolic)?$model->td_systolic:'-' ?> / <?= !empty($model->td_diastolic)?$model->td_diastolic:'-' ?>
                    </td>
                    <td>
                        <b>Suhu:</b> <?= $model->suhu ?>
                    </td>
                    <td>
                        <b>Nadi:</b> <?= $model->nadi ?>
                    </td>
                    <td>
                        <b>Frekuensi Napas:</b> <?= $model->nadi ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <b>Pemeriksaan penunjang / diagnostik terpenting:</b> 
        </td>
        <td colspan="3">
           <?= $model->pemeriksaanpenunjang ?>
        </td>       
    </tr>
    <tr>
        <td>
            <b>Terapi / Pengobatan Selama di Rumah Sakit:</b> 
        </td>
        <td colspan="3">
            <?php echo $model->terapiselamadirs ?>
        </td>       
    </tr>
    <tr>
        <td>
            <b>Hasil Konsultasi:</b> 
        </td>
        <td colspan="3">
           <?= $model->hasilkonsultasi ?>
        </td>       
    </tr>
    <tr>
        <td>
            <b>Diagnosis Primer:</b> 
            <?= $model->diagnosisprimer ?>
        </td>
        <td colspan="2">
            <b>Diagnosa sekunder:</b> <br/>
            <?= $model->diagnosissekunder ?>
        </td>
        <td >
            <b>ICD 10:</b><br/>            
            <?= $model->icd10 ?>
        </td>       
        
        
    </tr>
    <tr>
        <td>
            <b>Tindakan prosedur:</b> 
        </td>
        <td colspan="2" height="50px">   
        <?= $model->tindakanyangdipilih ?>         
            <?php
            
                // $arrid = [];
                // if(!empty($model->tindakanyangdipilih)){
                //     foreach($model->tindakanyangdipilih as $key => $val){
                //         $arrid[$key]=$key;
                //     }
                    
                //     if (!empty($arrid)){
                //         $cri = new CDbCriteria;
                //         $cri->group = $cri->select = " df.daftartindakan_nama ";
                //         $cri->join = " JOIN daftartindakan_m df ON df.daftartindakan_id = t.daftartindakan_id ";
                //         $cri->addInCondition("tindakanpelayanan_id", $arrid);
                //         $tindakan = TindakanpelayananT::model()->findAll($cri);
                        
                //         foreach($tindakan as $key => $val){
                //             echo ($key+1).'. '.$val->daftartindakan_nama.'<br/>';
                //         }
                //     }
                // }else{
                //     echo $model->tindakanyangdipilih;
                // }
            ?>
        </td>  
        <td>
            <b>ICD 9:</b><br/>            
            <?= $model->icd9 ?>
        </td>             
    </tr>
    <tr>
        <td>
            <b>Alergi (reaksi obat):</b> 
        </td>
        <td colspan="3">            
            <?= $model->alergipasien ?>
        </td>               
    </tr>
    <tr>
        <td>
            <b>Pemeriksaan penunjang (Belum keluar hasil):</b> 
        </td>
        <td colspan="3">            
            <?= $model->pemeriksaanpennunjang_blm ?>
        </td>               
    </tr>
    <tr>
        <td>
            <b>Diet:</b> 
        </td>
        <td colspan="3">            
            <?= $model->diet ?>
        </td>               
    </tr>
    <tr>
        <td>
            <b>Instruksi Ajaran dan edukasi (<em>Follow Up</em>):</b> 
        </td>
        <td colspan="3">            
            <?= $model->instruksi ?>
        </td>               
    </tr>
    <tr>
        <td>
            <b>Tanda Vital Keluar: </b>
        </td>
        <td colspan="3">
        <?= $model->tandavitalkeluar ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Kondisi ibadah sholat:</b> 
        </td>
        <td colspan="2">            
            <?= $model->kondisiibadah ?>
        </td>   
        <td colspan="2" rowspan="5">
            <?php
                echo cek_lis($model->sudahmendapatpenjelasan).' Sudah mendapat penjelasan<br/>';
                echo cek_lis($model->akseslink).' Akses link '. $profil->website .'/kerohanian.pdf<br/>';
                echo cek_lis($model->menerimsalinanformulir).' Menerima salinan formulir<br/>';
            ?>
            <table class="prinout w100 no-grid">
                <tr>
                    <td align="center">Tanda tangan pasien/keluarga</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">(<?=  $modPas->nama_pasien ?>)</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <b>Kondisi Psiko-spiritual:</b> 
        </td>
        <td colspan="2">            
            <?= $model->kondisipsiko ?>
        </td>               
    </tr>
    <tr>
        <td>
            <b>Cara keluar:</b> 
        </td>
        <td colspan="2">            
            <?= ($model->carakeluar == 'Lain-lain')?$model->lainlain:$model->carakeluar ?>
        </td>               
    </tr>
    <tr>
        <td>
            <b>Kondisi keluar:</b> 
        </td>
        <td colspan="2">            
            <?= ($model->kondisikeluar) ?>
        </td>               
    </tr>
    <tr>
        <td>
            <b>Tindak lanjut:</b> 
        </td>
        <td colspan="2">            
            <?= $model->tindakanjut ?>
        </td>               
    </tr>
    <tr>
        <td colspan="2">
            <b>Terapi Pulang</b><br/>
            <?= $model->terapipulang ?>
        </td>
        <td colspan="2">
            <table class="prinout w100 no-grid">
                <tr>
                    <td align="center">
                        Tanggal, <?= MyFormatter::formatDateTimeForUser($model->tglkeluar); ?>
                    </td>
                </tr>
                <tr>
                    <td align="center">Dokter Penanggung Jawab Pasien</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">(<?= $model->dokter_yangmerawat_nama; ?>)</td>
                </tr>
            </table>
        </td>
    </tr>
</table>