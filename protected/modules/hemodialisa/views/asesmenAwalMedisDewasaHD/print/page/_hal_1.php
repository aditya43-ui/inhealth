<?php
$titik = new CustomFunction;
echo $this->renderPartial('application.views.headerReport._default_emr_pdf',['data'=>$data,'pemprov_logo'=>true], true); 

$tgl = (date('d', strtotime($model->tgl_pemeriksaan)));
$bulan = MyFormatter::getMonthId(date('m', strtotime($model->tgl_pemeriksaan)));
$tahun = (date('Y', strtotime($model->tgl_pemeriksaan)));
$jam = date('H:i:s', strtotime($model->tgl_pemeriksaan));
$jarak = ' &nbsp;';
?>


    <table class='w100 prinout grid' autosize="1">
        <tr class="green" >
            <td class="green" colspan="4">
                Diisi oleh Dokter
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table class="w100 prinout no-grid" autosize="0">                                    
                    <tr>
                        <td>Waktu pemeriksaan</td>
                        <td>:</td>
                        <td>
                            Tanggal : <?= $titik->defaulttitik(10, $tgl,$jarak) ?> 
                            Bulan : <?= $titik->defaulttitik(20, $bulan,$jarak) ?> 
                            Tahun : <?= $titik->defaulttitik(5, $tahun,$jarak) ?> 
                            , Jam : <?= $titik->defaulttitik(8, $jam,$jarak) ?>  WIB
                        </td>                        
                    </tr>  
                    <tr>
                        <td>Konsultan nefrologi</td>
                        <td>:</td>
                        <td>
                            <?= $titik->defaulttitik(45, !empty($model->konsultannefrologi->namaLengkap)?$model->konsultannefrologi->namaLengkap:null,$jarak) ?>  
                            Dokter pemeriksa : <?= $titik->defaulttitik(30, !empty($model->dokterpemeriksa->namaLengkap)?$model->dokterpemeriksa->namaLengkap:null,$jarak) ?>
                        </td>                        
                    </tr>
                    <tr>
                        <td>Dialisis pertama pada</td>
                        <td>:</td>
                        <td>
                            <?= $titik->defaulttitik(63, !empty($model->dialisis_pertama_pada)?MyFormatter::formatDateTimeForUser($model->dialisis_pertama_pada,'long'):null,$jarak) ?>                              
                        </td>                        
                    </tr>
                </table>
            </td>                
        </tr>        
        <tr>
            <td colspan="4">
                <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td width="25%">Keluhan utama</td>
                        <td width="3%">:</td>
                        <td colspan="2" height="50px">                            
                            <?php                                 
                                if ($model->is_keluhan_nyeridada){
                                    echo 'Nyeri Dada, Sejak '.$model->keluhan_nyeridada_sejak.' Tahun<br/>';
                                }
                                if ($model->is_keluhan_sesak){
                                    echo 'Sesak, Sejak '.$model->keluhan_sesak_sejak.' Tahun<br/>';
                                }
                                if ($model->is_keluhan_sakitperut){
                                    echo 'Sakit Perut, Sejak '.$model->keluhan_sakitperut_sejak.' Tahun<br/>';
                                }
                                if ($model->is_keluhan_demam){
                                    echo 'Sakit Perut, Sejak '.$model->keluhan_demam_sejak.' Tahun<br/>';
                                }
                                if ($model->is_keluhan_bengkak){
                                    echo 'Sakit Perut, Sejak '.$model->keluhan_bengkak_sejak.' Tahun<br/>';
                                }
                                if ($model->is_keluhan_lainnya){
                                    echo $model->keterangan_keluhan_lainnya.', Sejak '.$model->keluhan_lainnya_sejak.' Tahun<br/>';
                                }
                            ?>
                        </td>                        
                    </tr>                                       
                    <tr>
                        <td >Riwayat penyakit sekarang</td>
                        <td >:</td>
                        <td width="10%">                            
                            <?= ceklis($model->riwayat_sakit_skr_diabetes) ?> Diabetes
                        </td>  
                       <td width="60%">           
                           <?= ceklis($model->riwayat_sakit_skr_hipertensi) ?> Hipertensi &nbsp;
                           <?= ceklis($model->riwayat_sakit_skr_jantung) ?> Penyakit Jantung &nbsp;
                           <?= ceklis($model->riwayat_sakit_skr_tidakada) ?> Tidak ada &nbsp;
                           <?= ceklis($model->riwayat_sakit_skr_lainnya) ?> Lainnya <?= $titik->defaulttitik(7, $model->riwayat_sakit_skr_lainnya_ket) ?>
                        </td>                        
                    </tr>  
                    <tr>
                        <td >Riwayat penyakit dahulu</td>
                        <td >:</td>
                        <td width="10%">                            
                            <?= ceklis($model->riwayat_sakit_dulu_diabetes) ?> Diabetes
                        </td>  
                       <td width="60%">           
                           <?= ceklis($model->riwayat_sakit_dulu_hipertensi) ?> Hipertensi &nbsp;
                           <?= ceklis($model->riwayat_sakit_dulu_jantung) ?> Penyakit Jantung &nbsp;
                           <?= ceklis($model->riwayat_sakit_dulu_tidakada) ?> Tidak ada &nbsp;
                           <?= ceklis($model->riwayat_sakit_dulu_lainnya) ?> Lainnya <?= $titik->defaulttitik(7, $model->riwayat_sakit_dulu_lainnya_ket) ?>
                        </td>  
                    </tr>  
                    <tr>
                        <td >Riwayat penyakit keluarga</td>
                        <td >:</td>
                        <td width="12%">                            
                            <?= ceklis($model->riwayat_sakit_keluarga_diabetes) ?> Diabetes
                        </td>  
                       <td width="58%">           
                           <?= ceklis($model->riwayat_sakit_keluarga_hipertensi) ?> Hipertensi &nbsp;
                           <?= ceklis($model->riwayat_sakit_keluarga_jantung) ?> Penyakit Jantung &nbsp;
                           <?= ceklis($model->riwayat_sakit_keluarga_tidakada) ?> Tidak ada &nbsp;
                           <?= ceklis($model->riwayat_sakit_keluarga_lainnya) ?> Lainnya <?= $titik->defaulttitik(7, $model->riwayat_sakit_keluarga_lainnya_ket) ?>
                        </td>  
                    </tr> 
                    <tr>
                        <td colspan="4">Status psikososial</td>                        
                    </tr> 
                    <tr>
                        <td><span style="font-weight: bold;font-size:20px;">.</span>Kebiasaan</td>
                        <td>:</td>
                        <td >                            
                            <?= ceklis($model->kebiasaan_merokok) ?> Merokok
                        </td>  
                       <td >           
                           <?= ceklis($model->kebiasaan_alkohol) ?> Alkohol &nbsp;
                           <?= ceklis($model->kebiasaan_obat) ?> Obat-obatan <?= $titik->defaulttitik(12, $model->kebiasaan_obat_keterangan) ?>&nbsp;
                           <?= ceklis($model->kebiasaan_lainnya) ?> Lain-lain <?= $titik->defaulttitik(11, $model->kebiasaan_lainnya_keterangan) ?>                           
                        </td>  
                    </tr>
                    <tr>
                        <td><span style="font-weight: bold;font-size:20px;">.</span>Perilaku</td>
                        <td>:</td>
                        <td >                            
                            <?= ceklis($model->perilaku_agresif) ?> Agresif
                        </td>  
                       <td >           
                           <?= ceklis($model->perilaku_tidakkooperatif) ?> Tidak Operatif &nbsp;                           
                        </td>  
                    </tr>
                    <tr>
                        <td><span style="font-weight: bold;font-size:20px;">.</span>Masalah perkawinan</td>
                        <td>:</td>
                        <td >                            
                            <?= ceklis($model->masalah_perkawinan_tidak_ada) ?> Tidak ada
                        </td>  
                       <td >           
                           <?= ceklis($model->masalah_perkawinan_ada) ?> Ada, <?= $titik->defaulttitik(30, $model->masalah_perkawinan_keterangan) ?>
                        </td>  
                    </tr>
                    <tr>
                        <td><span style="font-weight: bold;font-size:20px;">.</span>Mengalami kekerasan fisik</td>
                        <td>:</td>
                        <td >                            
                            <?= ceklis($model->kekerasan_fisik_tidak_ada) ?> Tidak ada
                        </td>  
                       <td >           
                           <?= ceklis($model->kekerasan_fisik_ada) ?> Ada, Mencederai diri/orang lain : <?= ceklis($model->mencederai_orang_pernah) ?> Pernah &nbsp;<?= ceklis($model->mencederai_orang_tidak_pernah) ?> Tidak Pernah 
                        </td>  
                    </tr>
                    <tr>
                        <td><span style="font-weight: bold;font-size:20px;">.</span>Trauma dalam kehidupan</td>
                        <td>:</td>
                        <td >                            
                            <?= ceklis($model->trauma_kehidupan_tidak_ada) ?> Tidak ada
                        </td>  
                       <td >           
                           <?= ceklis($model->trauma_kehidupan_ada) ?> Ada, <?= $titik->defaulttitik(50, $model->trauma_kehidupan_ada_keterangan) ?>
                        </td>  
                    </tr>
                    <tr>
                        <td><span style="font-weight: bold;font-size:20px;">.</span>Gangguan tidur</td>
                        <td>:</td>
                        <td >                            
                            <?= ceklis($model->gangguan_tidur_tidak_ada) ?> Tidak ada
                        </td>  
                       <td >           
                           <?= ceklis($model->gangguan_tidur_ada) ?> Ada
                        </td>  
                    </tr>
                    <tr>
                        <td><span style="font-weight: bold;font-size:20px;">.</span>Konsultasi dengan psikiater</td>
                        <td>:</td>
                        <td >                            
                            <?= ceklis($model->konsultasi_psikiater_tidak_ada) ?> Tidak ada
                        </td>  
                       <td >           
                           <?= ceklis($model->konsultasi_psikiater_ada) ?> Ada
                        </td>  
                    </tr>
                    <tr>
                        <td>Tempat tinggal</td>
                        <td>:</td>
                        <td colspan="2">                            
                            <?= ceklis($model->tempattinggal_rumahpribadi) ?> Rumah pribadi &nbsp;
                            <?= ceklis($model->tempattinggal_rumahkeluarga) ?> Rumah keluarga &nbsp;
                            <?= ceklis($model->tempattinggal_kontrak) ?> Kontrak &nbsp;
                            <?= ceklis($model->tempattinggal_panti) ?> Panti &nbsp;
                            <?= ceklis($model->tempattinggal_lainnya) ?> Lain-lain <?= $titik->defaulttitik(8, $model->tempattinggal_lainnya_keterangan) ?>
                        </td>  
                    </tr>
                    <tr>
                        <td>Tinggal bersama</td>
                        <td>:</td>
                        <td colspan="2">                            
                            <?= ceklis($model->tinggalbersama_suamiistri) ?> Suami/Istri &nbsp;
                            <?= ceklis($model->tinggalbersama_anak) ?> Anak &nbsp;
                            <?= ceklis($model->tinggalbersama_orangtua) ?> Orang tua &nbsp;
                            <?= ceklis($model->tinggalbersama_sendiri) ?> Sendiri &nbsp;
                            <?= ceklis($model->tinggalbersama_lainnya) ?> Lain-lain <?= $titik->defaulttitik(18, $model->tinggalbersama_lainnya_keterangan) ?>
                        </td>  
                    </tr>
                    <tr>
                        <td>Status fungsional</td>
                        <td>:</td>
                        <td colspan="2">                            
                            <?= ceklis($model->statusfungsional_mandiri) ?> Mandiri &nbsp;
                            <?= ceklis($model->statusfungsional_ketergantungan) ?> Ketergantungan &nbsp;
                            <?= ceklis($model->statusfungsional_tirahbaringparsial) ?> Tirah baring parsial &nbsp;
                            <?= ceklis($model->statusfungsional_tirahbaringtotal) ?> Tirah baring total &nbsp;
                        </td>  
                    </tr>
                    <tr>
                        <td colspan="4">Penanggung jawab perawatan di rumah <i>(care giver)</i> : <?= $titik->defaulttitik(50, $model->penanggungjawab_perawatanrumah) ?>                    
                        </td>  
                    </tr>
                </table>
            </td>                
        </tr>  
        <tr>
            <td colspan="4">Riwayat pengobatan sebelumnya :</td>
        </tr>
        <tr>
            <td align="center" style="vertical-align: middle;">Nama Obat</td>
            <td align="center" style="vertical-align: middle;">Dosis</td>
            <td align="center" style="vertical-align: middle;">Cara Pemberian</td>
            <td align="center" style="vertical-align: middle;">Waktu & Tanggal<br/>Terakhir Diberikan</td>
        </tr>
        <?php
            if (!empty($model->riwayat_obat)){
                $total = count($model->riwayat_obat);
                foreach($model->riwayat_obat as $det){
                    $det->tglpemberian = !empty($det->tglpemberian)?MyFormatter::formatDateTimeForUser($det->tglpemberian,'long'):'';
                    echo $this->renderPartial('print/page/row/_riwayat_obat_sebelum',['model'=>$det], true);
                }
                
                if ($total < 5){
                    for($i=1;$i<5-$total;$i++){
                        echo $this->renderPartial('print/page/row/_riwayat_obat_sebelum',['model'=>new RiwayatobatsebelumnyaT], true);
                    }
                }
            }else{
                for($i=1;$i<5;$i++){
                    echo $this->renderPartial('print/page/row/_riwayat_obat_sebelum',['model'=>new RiwayatobatsebelumnyaT], true);
                }
            }
            
        ?>
        <tr>
            <td colspan="4">
                 <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td width="20%"><span style="color:red">Alergi</span></td> 
                        <td width="3%">:</td>
                        <td width="76%"><?= $model->riwayatalergi_obatket.(!empty($model->riwayatalergi_makananket)?', '.$model->riwayatalergi_makananket:'') ?></td>
                    </tr>
                 </table>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                 <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td colspan="6"><b>Pemerikssaan Umum</b></td>                         
                    </tr>
                    <tr>
                        <td width="20%">Kesadaran kualitatif</td>                         
                        <td width="3%">:</td>
                        <td><?= ceklis($model->kesadarankualitatif_composmentis) ?> Compos mentis</td>
                        <td><?= ceklis($model->kesadarankualitatif_apatis) ?> Apatis</td>
                        <td><?= ceklis($model->kesadarankualitatif_delirum) ?> Delirum</td>
                        <td><?= ceklis($model->kesadarankualitatif_koma) ?> Koma</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            Kesadaran kuantitatif(skala koma glasgow): 
                            E : <?= $titik->defaulttitik(10,$model->kesadarankuantitatif_gcs_eye) ?> 
                            V : <?= $titik->defaulttitik(10,$model->kesadarankuantitatif_gcs_verbal) ?> 
                            M : <?= $titik->defaulttitik(10,$model->kesadarankuantitatif_gcs_motorik) ?>  
                        </td>                                                 
                    </tr>
                    <tr>
                        <td >Berat badan</td>                         
                        <td >:</td>
                        <td colspan="4" width="76%">
                            <?= $titik->defaulttitik(10,$model->beratbadan) ?> kg, 
                            Tinggi badan : <?= $titik->defaulttitik(10,$model->tinggibadan) ?> cm,  
                            Luas badan : <?= $titik->defaulttitik(10,$model->luasbadan) ?> kg/m<sup>2</sup>, 
                        </td>
                        
                    </tr>
                    <tr>
                        <td colspan="6">
                            <table class="w100 prinout grid" autosize="1">
                                <tr>
                                    <td align="center">Status Gizi / Nutrisi</td>                         
                                    <td align="center" colspan="2">Penilaian</td>
                                </tr>
                                <tr>
                                    <td>1. Pasien kehilangan berat badan 5% dalam waktu 3 bulan terakhir ?</td>
                                    <td width="15%"><?= ceklis($model->statusgizi_kehilanganberatbadan) ?> Ya</td>
                                    <td width="15%"><?= ceklis(!$model->statusgizi_kehilanganberatbadan) ?> Tidak</td>
                                </tr>
                                <tr>
                                    <td>2. Asupan makan pasien kurang dalam 1 minggu terakhir ?</td>
                                    <td><?= ceklis($model->statusgizi_asupanmakankurang) ?> Ya</td>
                                    <td><?= ceklis(!$model->statusgizi_asupanmakankurang) ?> Tidak</td>
                                </tr>
                                <tr>
                                    <td>3. Pasien menderita penyakit yang berat ?</td>
                                    <td><?= ceklis($model->statusgizi_menderitapenyakitberat) ?> Ya</td>
                                    <td><?= ceklis(!$model->statusgizi_menderitapenyakitberat) ?> Tidak</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                 </table>
            </td>
        </tr>
    </table>
    <table class="prinout w100 no-grid">
        <tr>
            <td ><font style="font-size: 10px !important;">Revisi : 17/01/17</font></td>
            <td align="right"><font style="font-size: 10px !important;">Hal 1 dari 2</font></td>
        </tr>
    </table>
 <?php
    echo '<div style=" page-break-after:always;"></div>';
 ?>