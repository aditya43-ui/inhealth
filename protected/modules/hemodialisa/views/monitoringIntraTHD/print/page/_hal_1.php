<?php
$titik = new CustomFunction;
echo $this->renderPartial('application.views.headerReport._default_emr_pdf',['data'=>$data,'pemprov_logo'=>true,'identitas'=>false], true); 

$jarak = ' &nbsp;';
$penyulit_hd = PenyulitHdM::model()->findAllByAttributes([],['order'=>'penyulit_hd_nama']);
?>


<table class='w100 prinout grid' autosize="0">    
    <tr>
        <td colspan="2">
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td width="35%"><b>PRESCRIPTION DOKTER</b></td>
                    <td width="3%">:</td>
                    <td width="10%"><?= ceklis($modPres->prescription_dokter_akut) ?> Akut</td>
                    <td width="14%"><?= ceklis($modPres->prescription_dokter_kronis) ?> Kronis</td>
                    <td width="15%"><?= ceklis($modPres->prescription_dokter_pirrt) ?> PIRRT</td>
                    <td width="45%">&nbsp;</td>
                </tr>
            </table>
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td width="3%">-</td>
                    <td>Time</td>
                    <td width="3%">:</td>
                    <td><?= $titik->defaulttitik(10,$modPres->durasi_time, $jarak) ?> <?= $modPres->time_satuan ?></td>
                    <td width="5%">&nbsp;</td>
                     <td width="3%">-</td>
                    <td>Heparinisasi</td>
                    <td width="3%">:</td>
                    <td><?= ceklis($modPres->heparinisasi_standar) ?> Standar</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Blood flow</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$modPres->blood_flow, $jarak) ?> mL/menit</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= ceklis($modPres->heparinisasi_minimal) ?> Minimal</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Dialysate flow</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$modPres->dialysate_flow, $jarak) ?> mL/menit</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= ceklis($modPres->heparinisasi_tanpaheparin) ?> Tanpa heparin, penyebab <?= $titik->defaulttitik(10,$modPres->heparinisasi_tanpaheparin_penyebab, $jarak) ?></td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Dialysate</td>
                    <td>:</td>
                    <td><?= ceklis($modPres->dialysate_bicarbonat) ?> Bicarbonat</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= ceklis($modPres->heparinisasi_lmwh) ?> LMWH, &nbsp;&nbsp; <?= ceklis($modPres->heparinisasi_lainnya) ?> <?= $titik->defaulttitik(20,$modPres->heparinisasi_lainnya_penyebab, $jarak) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= ceklis($modPres->dialysate_lainnya) ?> <?= $titik->defaulttitik(10,$modPres->dialysate_lainnya_keterangan, $jarak) ?></td>
                    <td>&nbsp;</td>
                    <td>-</td>
                    <td>Selisih BB</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$modPres->selisih_berat_badan, $jarak) ?> mL</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Dialyser</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$modPres->diayser, $jarak) ?></td>
                    <td>&nbsp;</td>
                    <td>-</td>
                    <td>Infus / transfusi</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$modPres->infus, $jarak) ?> mL</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td colspan="3">Dialysate temperature : <?= $titik->defaulttitik(10,$modPres->dialyser_temperature, $jarak) ?><sup>o</sup>C</td>
                    <td>&nbsp;</td>
                    <td>-</td>
                    <td>Ultra filtration goal</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$modPres->uf_goal, $jarak) ?> mL</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" height="50px">
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td >
                        Catatan Lain : <?= $titik->defaulttitik(181, $modPres->catatan_lain, $jarak) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-bottom:0p; margin-bottom: 0px;">
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td align="center" style="padding-bottom:0p; margin-bottom: 0px;">
                        <b>Tindakan Keperawatan</b>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
   <tr>
        <td>
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td>Akses vaskuler</td>
                    <td width="3%">:</td>
                    <td colspan="5"><?= $titik->defaulttitik(30, $model->akses_vaskular, $jarak) ?></td>
                </tr>
                <tr>
                    <td>Heparinisasi</td>
                    <td>:</td>
                    <td><?= ceklis($model->heparinisasi_ya) ?>Ya</td>
                    <td>:</td>
                    <td>- Dosis awal </td>
                    <td width="3%">:</td>
                    <td><?= $titik->defaulttitik(10, ($model->heparinisasi_ya)?$model->heparinisasi_ya_dosis_awal:'', $jarak) ?> international units</td>
                </tr>
               
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>- Dosis maintance </td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10, ($model->heparinisasi_ya)?$model->heparinisasi_ya_dosis_maintenan:'', $jarak) ?> international units</td>
                </tr>
                
                <tr>              
                    <td>&nbsp;</td>                    
                    <td>&nbsp;</td>                    
                    <td colspan="5">
                        <?= ceklis($model->heparinisasi_tidak) ?> Tidak, program bilas NaCl 0,9 % 100 cc : 
                        <?= ceklis(!empty($model->heparinisasi_tidak_per_jam)?true:false) ?> <?= $titik->defaulttitik(5, $model->heparinisasi_tidak_per_jam, $jarak) ?> / jam&nbsp;&nbsp;&nbsp;
                        <?= ceklis(!empty($model->heparinisasi_tidak_per_setengah)?true:false) ?> <?= $titik->defaulttitik(5, $model->heparinisasi_tidak_per_setengah, $jarak) ?> <sup>1</sup>/<sub>2</sub> jam
                    </td>                    
                </tr>                
            </table>
        </td>
        <td width="25%">
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td style="padding:0px;margin:0px;" colspan="2">Tanda Tangan Perawat : </td>
                </tr>
                <tr>
                    <td style="padding:0px;margin:0px;">1. </td>
                    <td style="padding:0px;margin:0px;"><?= !empty($model->perawat1->namaLengkap)?$model->perawat1->namaLengkap:null ?></td>
                </tr>
                <tr>
                    <td style="padding:0px;margin:0px;">2. </td>
                    <td style="padding:0px;margin:0px;"><?= !empty($model->perawat2->namaLengkap)?$model->perawat2->namaLengkap:null ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:0px;margin:0px;" colspan="2" height="230px">
            <table class='w100 prinout grid' autosize="0">    
                <tr>
                    <th>Observasi</th>
                    <th>Jam</th>
                    <th>Blood Flow (ml/mnt)</th>
                    <th>Tekanan Darah (mmHg)</th>
                    <th>Nadi (x/mnt)</th>
                    <th>Suhu (<sup>o</sup>C)</th>
                    <th>Respirasi (x/mnt)</th>
                    <th>Keterangan Lain</th>
                    <th>Tanda tangan & Nama terang</th>
                </tr>
                <?php
                    $penyulit = [];
                    if (!empty($model->set_intra_det)){
                        foreach($model->set_intra_det as $det){                            
                            $a = 0;
                            foreach($det['det'] as $d){
                                echo '<tr>';
                                if ($a == 0){
                                    echo '<td rowspan="'.(count($det['det'])).'">'.$det['jenis'].'</td>';
                                }
                                echo '<td>'.$d['jam_observasi'].'</td>';
                                echo '<td>'.$d['blood_flow'].'</td>';
                                echo '<td>'.$d['tensi_sistolik'].'/'.$d['tensi_diastolik'].'</td>';
                                echo '<td>'.$d['nadi'].'</td>';
                                echo '<td>'.$d['suhu'].'</td>';
                                echo '<td>'.$d['respirasi'].'</td>';
                                echo '<td>&nbsp;</td>';
                                echo '<td>&nbsp;</td>';
                                echo '</tr>';
                                $a++;
                                
                                $penyulit[$d['penyulit_hd_nama']] = $d['penyulit_hd_nama'];
                            }
                        }
                    }
                ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class='w100 prinout no-grid' autosize="0"> 
                <tr>
                    <td><b>PENYULIT SELAMA HD</b></td>
                </tr>
            </table>
             <table class='w100 prinout no-grid' autosize="0">    
                
                <?php
                    $i = 1;
                    
                    foreach($penyulit_hd as $det){
                        if ($i == 1){
                            echo '<tr>';
                        }
                        echo '<td width="24%">'.ceklis((!empty($penyulit[$det->penyulit_hd_nama])?true:false)).'&nbsp;'.$det->penyulit_hd_nama.'</td>';

                        if ($i % 4 == 0){
                            echo '</tr>';
                            if ($i != count($penyulit_hd)){
                                echo '<tr>';
                            }
                        }else{
                            if ($i == count($penyulit_hd)){
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
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td colspan="6">
                        <b>EVALUASI KEPERAWATAN POST HD</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="6"><b>Keluhan :</b> 
                        <?= ceklis($modPost->is_keluhan_sesaknafas) ?> Sesak Napas &nbsp;
                        <?= ceklis($modPost->is_keluhan_mualmuntah) ?> Mual Muntah &nbsp;
                        <?= ceklis((!empty($modPost->asesmentnyeri_id)?true:false)) ?> Nyeri &nbsp;
                        <?= ceklis($modPost->is_keluhan_keluhanlainnya) ?> Lainnya &nbsp; <?= $titik->defaulttitik(10, $modPost->keterangan_keluhanlainnya, $jarak) ?>
                    </td>
                                         
                    <tr>
                </tr>
                <tr>
                    <td colspan="6"><b>Pemeriksaan Fisik :</b></td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Berat badan</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10, $modPost->berat_badan, $jarak) ?> Kg</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Tekanan darah</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10, $modPost->tensi_sistolik.'/'.$modPost->tensi_diastolik, $jarak) ?> mmHg</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Nadi</td>
                    <td>:</td>
                    <td>Frek <?= $titik->defaulttitik(10, $modPost->nadi, $jarak) ?> (x/mnt),</td>
                    <td><?= ceklis($modPost->nadi_reguler) ?> Reguler</td>
                    <td><?= ceklis($modPost->nadi_irreguler) ?> Irreguler</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Respirasi</td>
                    <td>:</td>
                    <td>Frek <?= $titik->defaulttitik(10, $modPost->respirasi, $jarak) ?> (x/mnt),</td>                   
                </tr>
                <tr>
                    <td>-</td>
                    <td>Suhu</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10, $modPost->suhu, $jarak) ?> <sup>o</sup>C</td>                   
                </tr>
                <tr>
                    <td colspan="6"><b>Lain-lain :</b><?= $titik->defaulttitik(30, $modPost->lainnya, $jarak) ?></td>
                </tr>
            </table>
        </td>
        <td > 
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td>
                        <b>CATATAN:</b> 
                    </td>
                </tr>
                <tr>                                        
                    <td><?= ceklis($modPost->catatan_dipulangkan) ?> Dipulangkan</td>
                </tr>
                <tr>                                        
                    <td><?= ceklis($modPost->catatan_meninggal) ?> Meninggal</td>
                </tr>
                <tr>                                        
                    <td><?= ceklis($modPost->catatan_igd) ?> IGD</td>
                </tr>
                <tr>                                        
                    <td><?= ceklis($modPost->catatan_lainnya) ?> Lainnya <?= $titik->defaulttitik(10, $modPost->ket_catatan_lainnya) ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td >
                        <b>DISCHARGE PLANNING : </b> HD yang akan datang <?= $titik->defaulttitik(30, (!empty($modJadwal->jadwalhemodialisa_tgl_ke)?date("d/m/Y", strtotime($modJadwal->jadwalhemodialisa_tgl_ke)):'').' '.(!empty($modJadwal->shift->shift_hd_nama)?$modJadwal->shift->shift_hd_nama:'')) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="w100 prinout no-grid" autosize="0">
                <tr>
                    <td align="center" width="33%">
                        Tanggal <?= $titik->defaulttitik(10, date('d/m/Y'), $jarak) ?> Jam <?= $titik->defaulttitik(10, date('H:i:s'),$jarak) ?> WIB 
                    </td>
                    <td align="center" width="33%">
                        Tanggal <?= $titik->defaulttitik(10, date('d/m/Y'), $jarak) ?> Jam <?= $titik->defaulttitik(10, date('H:i:s'),$jarak) ?> WIB 
                    </td>
                    <td align="center"  width="33%">
                        Tanggal <?= $titik->defaulttitik(10, date('d/m/Y'), $jarak) ?> Jam <?= $titik->defaulttitik(10, date('H:i:s'),$jarak) ?> WIB 
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        Nama dan Tanda Tangan Perawat 1
                    </td>
                     <td align="center">
                        Nama dan Tanda Tangan Perawat 2
                    </td>
                    <td align="center">
                        Nama dan Tanda Tangan DPJP
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                         <?= $titik->defaulttitik(30, !empty($model->perawat1->namaLengkap)?$model->perawat1->namaLengkap:null,$jarak) ?>
                    </td>
                    <td align="center">
                         <?= $titik->defaulttitik(30, !empty($model->perawat2->namaLengkap)?$model->perawat2->namaLengkap:null,$jarak) ?>
                    </td>
                    <td align="center">
                         <?= $titik->defaulttitik(30, !empty($model->dpjp->namaLengkap)?$model->dpjp->namaLengkap:null,$jarak) ?> 
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="prinout w100 no-grid">
    <tr>
        <td ><font style="font-size: 10px !important;">Revisi : 17/01/17</font></td>
        <td align="right"><font style="font-size: 10px !important;">Hal 2 dari 2</font></td>
    </tr>
</table>
 <?php
    echo '<div style=" page-break-after:always;"></div>';
 ?>