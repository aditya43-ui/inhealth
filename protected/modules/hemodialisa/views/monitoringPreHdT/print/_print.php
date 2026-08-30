<?php
$titik = new CustomFunction;
$masalah_perawat = LookupM::getItemsUrutan("masalah_keperawatan_hd");
$masalah_perawat = array_merge($masalah_perawat, [''=>'']);

$intervensi_look = LookupM::getItemsUrutan("intervensi_keperawatan_hd");


echo $this->renderPartial('application.views.headerReport._default_emr_pdf',['data'=>$data,'pemprov_logo'=>true]); 

function ceklis($st){
    $icon = '<span  style="font-family:FontAwesome;" >&#xf096;</span>';
    if ($st){
        $icon = '<span  style="font-family:FontAwesome;" >&#xf046;</span>';
    }
    
    return $icon;
}

?>
<style>     
    table.prinout{    
        border-collapse: collapse;
        table-layout: auto !important;
        margin-bottom: 10px;
    }   
    .green{
        background: #afdc7e;
        box-shadow:  inset -200px -200px 0px 200px rgba(175, 220, 126);
    }
</style>

    <table class='w100 prinout grid' autosize="0">
        <tr class="green">
            <td class="green" colspan="10">
                Diisi oleh Dokter dan Keperawatan
            </td>
        </tr>   
        <tr>
            <td>
                <table  autosize="0" class="no-grid w100 prinout">
                    <tr>            
                        <td>Tanggal / Jam</td>
                        <td width="2%">:</td>
                        <td colspan="4"><?= $titik->defaulttitik(20,!empty($model->waktu)?MyFormatter::formatDateTimeForUser($model->waktu):'') ?></td>
                        <td width='10%'>&nbsp;</td>
                        <td>Hemodialisis ke</td>
                        <td width="2%">:</td>
                        <td colspan="2"><?= $titik->defaulttitik(20,$model->hemodialisis_ke) ?></td>                  
                    <tr>
                    <tr>            
                        <td>Diagnosis Medis</td>
                        <td >:</td>
                        <td colspan="4"><?= $titik->defaulttitik(20,!empty($model->pasienmorbiditas->diagnosa->diagnosa_nama)?$model->pasienmorbiditas->diagnosa->diagnosa_nama:'') ?></td>
                        <td></td>
                        <td>Dialiser</td>
                        <td >:</td>
                        <td colspan="2"><?= $titik->defaulttitik(20,$model->dialiser) ?></td>                  
                    </tr>
                    <tr>            
                        <td></td>
                        <td ></td>
                        <td colspan="4"></td>
                        <td></td>
                        <td>Riwayat Alergi Obat</td>
                        <td >:</td>
                        <td><?= ceklis($model->alergi_obat_tidak).' Tidak' ?></td>                  
                        <td><?= ceklis($model->alergi_obat_ya).' Ya '.$titik->defaulttitik(10,$model->alergi_obat_keterangan) ?></td>                              
                    </tr>
                    <tr>            
                        <td>Nomor Mesin</td>
                        <td >:</td>
                        <td colspan="4"><?= $titik->defaulttitik(20,$model->nomor_mesin) ?></td>
                        <td></td>
                        <td>HbsAg</td>
                        <td >:</td>
                        <td><?= ceklis($model->hbsag_ya).' Reaktif' ?></td>                  
                        <td><?= ceklis($model->hbsag_tidak).' Non Reaktif' ?></td>                              
                    </tr>        
                    <tr>            
                        <td>Golongan Darah</td>
                        <td >:</td>
                        <td width="5%"><?= ceklis($model->gol_darah=='A'?true:false).' A' ?></td>
                        <td width="5%"><?= ceklis($model->gol_darah=='B'?true:false).' B' ?></td>
                        <td width="7%"><?= ceklis($model->gol_darah=='AB'?true:false).' AB' ?></td>
                        <td width="5%"><?= ceklis($model->gol_darah=='O'?true:false).' O' ?></td>
                        <td></td>
                        <td>HCV</td>
                        <td >:</td>
                        <td><?= ceklis($model->hcv_ya).' Ya' ?></td>                  
                        <td><?= ceklis($model->hcv_tidak).' Tidak' ?></td>
                    </tr>            
                    <tr>            
                        <td colspan="6"></td>
                        <td></td>
                        <td>HIV</td>
                        <td >:</td>
                        <td><?= ceklis($model->hiv_ya).' Ya' ?></td>                  
                        <td><?= ceklis($model->hiv_tidak).' Tidak' ?></td>
                    </tr>
                </table>
                <table  autosize="0" class="no-grid w100 prinout">
                    <tr>            
                        <td colspan="10">Kondisi Psikososial</td>            
                    </tr>
                    <tr>            
                        <td width='18%'>- Kendali Komunikasi</td>
                        <td >:</td>
                        <td colspan="3"><?= ceklis($model->kendala_komunikasi_tidakada).' Tidak ada' ?></td>
                        <td colspan="5"><?= ceklis($model->kendala_komunikasi_ada).' Ada, jelaskan'.$titik->defaulttitik(20, $model->kendala_komunikasi_keterangan) ?></td>            
                    </tr>   
                    <tr>            
                        <td>- Kondisi Saat Ini</td>
                        <td>:</td>
                        <td colspan="2"><?= ceklis($model->kondisi_saat_ini_tenang).' Tenang' ?></td>
                        <td colspan="1" width='10%'><?= ceklis($model->kondisi_saat_ini_gelisah).' Gelisah' ?></td>
                        <td colspan="2" width='25%'><?= ceklis($model->kondisi_saat_ini_takut_tindakan).' Takut Terhadap Tindakan' ?></td>
                        <td colspan="1" width='10%'><?= ceklis($model->kondisi_saat_ini_marah).' Marah' ?></td>
                        <td colspan="2"><?= ceklis($model->kondisi_saat_ini_tersinggung).' Mudah Tersinggung' ?></td>
                    </tr> 
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table autosize="0" class="prinout w100 no-grid" >
                    <tr>            
                        <td colspan="6"><b>PENGKAJIAN MEDIS DAN KEPERAWATAN</b></td>            
                    </tr>
                    <tr>            
                        <td><b>Keluhan Utama</b></td>         
                        <td width="2%">:</td>
                        <td colspan="4"><?= ceklis($model->keluhan_utama_sesak_nafas).' Sesak napas &nbsp;&nbsp;&nbsp;&nbsp;' ?>
                        <?= ceklis($model->keluhan_utama_mual_muntah).' Mual, muntah  &nbsp;&nbsp;&nbsp;&nbsp;' ?>
                        <?= ceklis(!empty($model->asesmentnyeri_id)?true:false).' Nyeri(skala 1-10): '.(!empty($model->asesmentnyeri)?$model->asesmentnyeri->score_skalanyeri:'') ?></td>
                    </tr>
                    <tr>            
                        <td colspan="6"><b>Pemeriksaan Fisik</b></td>                        
                    </tr>                    
                    <tr>            
                        <td>- GCS</td>            
                        <td >:</td> 
                        <td colspan="4">
                            E : <?= $titik->defaulttitik(10, $model->gcs_eye) ?>
                            V : <?= $titik->defaulttitik(10, $model->gcs_verbal) ?>
                            M : <?= $titik->defaulttitik(10, $model->gcs_motorik) ?>
                        </td>
                    </tr>
                    <tr>            
                        <td>- Keadaan Umum</td>            
                        <td >:</td> 
                        <td colspan="2"><?= ceklis($model->keadaan_umum_baik).' Baik' ?></td>
                        <td><?= ceklis($model->keadaan_umum_sedang).' Sedang' ?></td>
                        <td><?= ceklis($model->keadaan_umum_lainnya).' '.$model->keadaan_umum_lainnya_keterangan ?></td>
                    </tr>
                    <tr>            
                        <td>- Berat Badan</td>            
                        <td >:</td> 
                        <td width="15%">Pre HD <?= $titik->defaulttitik(5, $model->berat_badan_pre_hd) ?></td>
                        <td>kg,</td>
                        <td width="25%">Post HD yang lalu <?= $titik->defaulttitik(5, $model->berat_badan_post_hd) ?> kg,</td>
                        <td width="25%">Selisih <?= $titik->defaulttitik(5, $model->selisih) ?> kg</td>
                    </tr>
                    <tr>            
                        <td>- Tinggi Badan</td>            
                        <td >:</td> 
                        <td><?= $titik->defaulttitik(10, $model->tinggi_badan) ?></td>
                        <td>cm,</td>
                        <td colspan="2">IMT <?= $titik->defaulttitik(5, $model->imt) ?> kg/m<sup>2</sup>,</td>                        
                    </tr>
                    <tr>            
                        <td>- Tekanan Darah</td>            
                        <td >:</td> 
                        <td>
                            <?= $model->tensi_sistolik.'/'.$model->tensi_diastolik;  ?>
                        </td>                        
                        <td colspan="2">mmHg</td>
                    </tr>
                    <tr>            
                        <td>- Nadi</td>            
                        <td >:</td> 
                        <td><?= $titik->defaulttitik(10, $model->nadi) ?></td>
                        <td>x/mnt,</td>
                        <td><?= ceklis($model->nadi_reguler).' Reguler' ?></td>                        
                        <td><?= ceklis($model->nadi_irreguler).' Ireguler' ?></td>                        
                    </tr>
                    <tr>            
                        <td>- Respirasi</td>            
                        <td >:</td> 
                        <td><?= $titik->defaulttitik(10, $model->respirasi) ?></td>
                        <td colspan="3">x/mnt,</td>                        
                    </tr>
                    <tr>            
                        <td>- Suhu</td>            
                        <td >:</td> 
                        <td><?= $titik->defaulttitik(10, $model->suhu) ?></td>
                        <td colspan="3"><sup>o</sup>C</td>                        
                    </tr>
                    <tr>            
                        <td>- Kepala</td>            
                        <td >:</td> 
                        <td><?= ceklis($model->kepala_normal).' Normal' ?></td>
                        <td colspan="3"><?= ceklis($model->kepala_tidak_normal).' Tidak normal, jelaskan '.($titik->defaulttitik(20,$model->kepala_keterangan)) ?></td>                        
                    </tr>
                    <tr>            
                        <td>- Leher</td>            
                        <td >:</td> 
                        <td><?= ceklis($model->leher_normal).' Normal' ?></td>
                        <td colspan="3"><?= ceklis($model->leher_tidak_normal).' Tidak normal, jelaskan '.($titik->defaulttitik(20,$model->leher_keterangan)) ?></td> 
                    </tr>
                    <tr>            
                        <td>- Jantung</td>            
                        <td >:</td> 
                        <td><?= ceklis($model->jantung_normal).' Normal' ?></td>
                        <td colspan="3"><?= ceklis($model->jantung_tidak_normal).' Tidak normal, jelaskan '.($titik->defaulttitik(20,$model->jantung_keterangan)) ?></td>                        
                    </tr>
                    <tr>            
                        <td>- Paru</td>            
                        <td >:</td> 
                        <td><?= ceklis($model->paru_normal).' Normal' ?></td>
                        <td colspan="3"><?= ceklis($model->paru_tidak_normal).' Tidak normal, jelaskan '.($titik->defaulttitik(20,$model->paru_keterangan)) ?></td>                        
                    </tr>
                    <tr>            
                        <td>- Abdomen</td>            
                        <td >:</td> 
                        <td><?= ceklis($model->abdomen_normal).' Normal' ?></td>
                        <td colspan="3"><?= ceklis($model->abdomen_tidak_normal).' Tidak normal, jelaskan '.($titik->defaulttitik(20,$model->abdomen_keterangan)) ?></td>                        
                    </tr>
                    <tr>            
                        <td>- Kulit</td>            
                        <td >:</td> 
                        <td><?= ceklis($model->kulit_normal).' Normal' ?></td>
                        <td colspan="3"><?= ceklis($model->kulit_tidak_normal).' Tidak normal, jelaskan '.($titik->defaulttitik(20,$model->kulit_keterangan)) ?></td>                        
                    </tr>
                    <tr>            
                        <td>- Anggota Tubuh</td>            
                        <td >:</td> 
                        <td><?= ceklis($model->anggota_tubuh_normal).' Normal' ?></td>
                        <td colspan="3"><?= ceklis($model->anggota_tubuh_tidak_normal).' Tidak normal, jelaskan '.($titik->defaulttitik(20,$model->anggota_tubuh_keterangan)) ?></td>                        
                    </tr>
                    <tr>            
                        <td>- Akses Vaskular</td>            
                        <td >:</td> 
                        <td colspan="2"><?= ceklis(!empty($akses['Av Vistula'])?true:false).' Av Vistula' ?></td>
                        <td colspan="2"><?= ceklis(!empty($akses['Akses Langsung'])?true:false).' Akses Langsung' ?></td>                        
                    </tr>
                    <tr>            
                        <td></td>            
                        <td >:</td> 
                        <td colspan="4">
                            <?= ceklis(!empty($akses['HD Kateter'])?true:false).' HD kateter : &nbsp;'.ceklis(!empty($akses['HD Kateter']['hd']['Subclavia'])?true:false).' Subclavia &nbsp;' ?>
                            <?= ceklis(!empty($akses['HD Kateter']['hd']['Jugular'])?true:false).' Jugular &nbsp;'.ceklis(!empty($akses['HD Kateter']['hd']['Femoral'])?true:false).' Femoral' ?>
                        </td>
                    </tr>
                    <tr>            
                        <td><b>Gizi</b></td>  
                        <td >:</td> 
                        <td colspan="2"><?= ceklis($model->gizi_baik).' Baik' ?></td>
                        <td><?= ceklis($model->gizi_sedang).' Sedang' ?></td>
                        <td><?= ceklis($model->gizi_buruk).' Buruk' ?></td>
                    </tr>
                    <tr>            
                        <td colspan="6"><b>Risiko Jatuh</b></td>                                    
                    </tr>
                    <tr>            
                        <td>- Dewasa</td>  
                        <td >:</td> 
                        <td colspan="2"><?= ceklis($model->risiko_jatuh_dewasa_rendah).' TR (0-24)' ?></td>
                        <td colspan="2"><?= ceklis($model->risiko_jatuh_dewasa_tinggi).' TR (25-440)' ?></td>
                    </tr>
                    <tr>            
                        <td>- Anak</td>  
                        <td >:</td> 
                        <td colspan="2"><?= ceklis($model->risiko_jatuh_anak_rendah).' TR (7-11)' ?></td>
                        <td colspan="2"><?= ceklis($model->risiko_jatuh_anak_tinggi).' TR (&ge;12)' ?></td>
                    </tr>                    
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table autosize="0" class="prinout w100 no-grid" >
                    <tr>            
                        <td><b>Pemeriksaan Lab</b></td>  
                        <td >:</td> 
                        <td colspan="4">
                            <table autosize="0" class="w100 prinout grid">
                                <tr>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Tgl. Pemeriksaan</th>
                                </tr>
                                <?php
                                    if (!empty($model->set_periksa_internal_lab)){
                                        foreach($model->set_periksa_internal_lab as $det){
                                            echo '<tr>';
                                            echo '<td>'.$det->pemeriksaanlab_nama.'</td>';
                                            echo '<td>'.(!empty($det->tglhasilpemeriksaanlab)?MyFormatter::formatDateTimeForUser($det->tglhasilpemeriksaanlab):'').'</td>';
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>            
                        <td><b>Pemeriksaan Lab dari Luar</b></td>  
                        <td >:</td> 
                        <td colspan="4">
                            <table autosize="0" class="w100 prinout grid">
                                <tr>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Tgl. Pemeriksaan</th>
                                    <th>Hasil Pemeriksaan</th>
                                </tr>
                                <?php
                                    if (!empty($model->set_periksa_lab_dari_luar)){
                                        foreach($model->set_periksa_lab_dari_luar as $det){
                                            echo '<tr>';
                                            echo '<td>'.$det->nama_pemeriksaan.'</td>';
                                            echo '<td>'.(!empty($det->tgl_pemeriksaan)?MyFormatter::formatDateTimeForUser($det->tgl_pemeriksaan):'').'</td>';
                                            echo '<td>'.$det->hasil_pemeriskaan.'</td>';
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table autosize="0" class="w100 prinout no-grid">
                    <tr>
                        <td colspan="3"><b>MASALAH KEPERAWATAN</b></td>
                    </tr>
                    <?php
                        $i = 1;
                        foreach($masalah_perawat as $det){
                            if ($i == 1){
                                echo '<tr>';
                            }
                            echo '<td width="33%">'.ceklis((!empty($masalah[$det])?true:false)).' '.$i.'. '.$det.'</td>';
                            
                            if ($i % 3 == 0){
                                echo '</tr>';
                                if ($i != count($masalah_perawat)){
                                    echo '<tr>';
                                }
                            }else{
                                if ($i == count($masalah_perawat)){
                                    echo '</tr>';
                                }
                            }
                            $i++;
                        }
                    ?>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table autosize="0" class="w100 prinout no-grid">
                    <tr>
                        <td colspan="2"><b>INTERVENSI KEPERAWATAN</b></td>
                    </tr>
                    <?php
                        $i = 1;
                        foreach($intervensi_look as $det){
                            if ($i == 1){
                                echo '<tr>';
                            }
                            echo '<td width="3%">'.ceklis((!empty($intervensi[$det])?true:false)).'</td>';
                            echo '<td>'.$det.'</td>';
                            
                            if ($i % 2 == 0){
                                echo '</tr>';
                                if ($i != count($intervensi_look)){
                                    echo '<tr>';
                                }
                            }else{
                                if ($i == count($intervensi_look)){
                                    echo '</tr>';
                                }
                            }
                            $i++;
                        }
                    ?>
                </table>
            </td>
        </tr>        
    </table>

 <?php
    
 ?>