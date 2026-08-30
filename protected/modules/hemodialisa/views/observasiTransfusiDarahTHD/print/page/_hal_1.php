<?php
$titik = new CustomFunction;
echo $this->renderPartial('application.views.headerReport._default_emr_pdf',['data'=>$data,'pemprov_logo'=>true,'page'=>'L'], true); 

$jarak = ' &nbsp;';
?>


    <table class='w100 prinout grid' autosize="0">
        <tr class="green" >
            <td class="green" colspan="17">
                Diisi oleh Dokter / Perawat / Bidan
            </td>
        </tr>   
        <tr>
            <td colspan="5" style="padding:0px;margin:0px;" width="40%">
                <table class="prinout w100 no-grid" autosize="0" >
                    <tr>
                        <td width="53%">Tanggal darah diterima di ruang rawat</td>
                        <td width="5">:</td>
                        <td >
                            <?= $titik->defaulttitik(1, (!empty($modKantong->waktu_darah_diterima)?date("d/m/Y",strtotime($modKantong->waktu_darah_diterima)):''), $jarak) ?> &nbsp; 
                            Jam : <?= $titik->defaulttitik(1, (!empty($modKantong->waktu_darah_diterima)?date("H:i:s", strtotime($modKantong->waktu_darah_diterima)):''), $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Suhu cool box</td>
                        <td>:</td>
                        <td>
                            <?= $titik->defaulttitik(1, $modKantong->suhu_coolbox, $jarak) ?> <sup>o</sup>C
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Nama DPJP</td>
                        <td>:</td>
                        <td>
                            <?= $titik->defaulttitik(1, (!empty($modKantong->pegawai->namaLengkap)?$modKantong->pegawai->namaLengkap:''), $jarak) ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td colspan="12">
                <?php
                    $obat_sebelum = [];
                    if (!empty($modKantong->set_obat_sebelum_transfusi)){
                        foreach($modKantong->set_obat_sebelum_transfusi as $det){
                            $obat_sebelum[] = $det->nama_obat;
                        }
                    }
                ?>
                Obat-obat yang diberikan sebelum transfusi : <?= $titik->defaulttitik(404, implode(', ',$obat_sebelum), $jarak) ?>
            </td>
        </tr>
        <tr>
            <td rowspan="2" align="center" class='head-padd'>No. Kantong Darah</td>
            <td rowspan="2" align="center" class='head-padd'>Jenis Darah</td>
            <td rowspan="2" align="center" class='head-padd'>Volume Darah (ml)</td>
            <td rowspan="2" align="center" class='head-padd'>Nama dan TTD Petugas yg Melakukan Transfusi</td>
            <td rowspan="2" align="center" class='head-padd'>Nama dan TTDPetugas yg Melakukan Verifikasi</td>
            <td colspan="2" align="center" class='head-padd'>Waktu Observasi</td>
            <td rowspan="2" align="center" class='head-padd'>Reaksi Transfusi (sebutkan)</td>
            <td rowspan="2" align="center" class='head-padd'>Keluhan</td>
            <td rowspan="2" align="center" class='head-padd'>Kesadaran</td>
            <td rowspan="2" align="center" class='head-padd'>Tekanan Darah (mmHg)</td>
            <td rowspan="2" align="center" class='head-padd'>Nadi</td>
            <td rowspan="2" align="center" class='head-padd'>Suhu (<sup>o</sup>C)</td>
            <td rowspan="2" align="center" class='head-padd'>Pernapasan</td>
            <td rowspan="2" align="center" class='head-padd'>Lainnya (warna dan produksi urin)</td>
            <td rowspan="2" align="center" class='head-padd'>Nama Petugas yang Melakukan Observasi</td>
            <td rowspan="2" align="center" class='head-padd'>Tanda Tangan</td>
        </tr>
        <tr>
            <td align="center" style="vertical-align: middle" class='head-padd'>Tanggal</td>
            <td align="center" style="vertical-align: middle" class='head-padd'>Jam</td>
        </tr>
        <?php
            $def = 6;
            
            if (!empty($model->set_observasi_dan_kantong_darah)){                
                
                $a = 0;
                foreach($model->set_observasi_dan_kantong_darah as $det){
                    $count = count($det['obs']);
                    $tot = $def - $count ;
                    $det_co = $count;
                    
                    echo '<tr>';                           
                    echo '<td rowspan="'.$det_co.'" style="vertical-align:middle;" align="center">'.$det['no_kantongdarah'].'</td>';
                    echo '<td rowspan="'.$det_co.'" style="vertical-align:middle;" align="center">'.$det['jeniskomponendarah_nama'].'</td>';
                    echo '<td rowspan="'.$det_co.'" style="vertical-align:middle;" align="center">'.$det['volume_darah'].'</td>';
                    echo '<td rowspan="'.$det_co.'" style="vertical-align:middle;" align="center">'.$det['petugas_transfusi_nama'].'</td>';
                    echo '<td rowspan="'.$det_co.'" style="vertical-align:middle;" align="center">'.$det['petugas_verifikasi_nama'].'</td>';                    
                    $b = 0;
                    foreach($det['obs'] as $obs){
                        if ($b != 0)
                            echo "<tr>";
                        echo '<td>'.(!empty($obs['tanggal_observasi'])?date("d/m/Y", strtotime($obs['tanggal_observasi'])):'').'</td>';
                        echo '<td>'.$obs['jam_observasi'].'</td>';
                        echo '<td>'.(!empty($obs['reaksi'])?implode(', ', $obs['reaksi']):'').'</td>';
                        echo '<td>'.$obs['keluhan'].'</td>';
                        echo '<td>'.$obs['kesadaran'].'</td>';
                        echo '<td>'.$obs['tekanan_darah'].'</td>';
                        echo '<td>'.$obs['nadi'].'</td>';
                        echo '<td>'.$obs['suhu'].'</td>';
                        echo '<td>'.$obs['pernapasan'].'</td>';
                        echo '<td>'.$obs['lainnya'].'</td>';
                        echo '<td>'.$obs['petugas_observasi_nama'].'</td>';
                        echo '<td>&nbsp;</td>';                        
                        echo "</tr>";
                        
                        $b++;
                    }
                    
//                    if ($tot >= 0 && $tot < $def){
//                        for($i=1;$i<=$tot;$i++){
//                            echo '<tr>';
//                            echo '<td>&nbsp;</td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';
//                            echo '<td></td>';                        
//                            echo '</tr>';
//                        }
//                    }
//                     echo '</tr>';
                    $a++;
                }
                                
            }else{
                for($i=1;$i<=$def;$i++){
                    echo '<tr>';
                    if ($i == 1){
                        echo '<td rowspan="6" style="vertical-align:middle;" align="center"></td>';
                        echo '<td rowspan="6" style="vertical-align:middle;" align="center"></td>';
                        echo '<td rowspan="6" style="vertical-align:middle;" align="center"></td>';
                        echo '<td rowspan="6" style="vertical-align:middle;" align="center"></td>';
                        echo '<td rowspan="6" style="vertical-align:middle;" align="center"></td>';
                    }                    
                    echo '<td>&nbsp;</td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';                        
                    echo '</tr>';
                }
            }
        ?>
        <tr>
            <td colspan="5" style="padding:0px;margin:0px;">
               <table class="prinout w100 no-grid">
                    <tr>
                        <td colspan="2"  class='head-padd'><b>&nbsp;&nbsp;&nbsp;Observasi Dilakukan Pada :</b></td>
                    </tr>
                    <tr>
                        <td width='5%' class='head-padd'>&nbsp;&nbsp;&nbsp;1.</td>
                        <td class='head-padd'>15 menit sebelum transfusi dimulai</td>
                    </tr>
                    <tr>
                        <td class='head-padd'>&nbsp;&nbsp;&nbsp;2.</td>
                        <td class='head-padd'>15 menit setelah transfusi dimulai</td>
                    </tr>
                    <tr>
                        <td class='head-padd'>&nbsp;&nbsp;&nbsp;3.</td>
                        <td class='head-padd'>Segera setelah transfusi selesai(1-15 menit)</td>
                    </tr>
                    <tr>
                        <td class='head-padd'>&nbsp;&nbsp;&nbsp;4.</td>
                        <td class='head-padd'>4 jam setelah transfusi untuk pasien rawat inap dan</td>
                    </tr>
                    <tr>
                        <td class='head-padd'></td>
                        <td class='head-padd'>1(satu) jam setelah transfusi untuk pasien rawat jalan</td>
                    </tr>
                    <tr>
                        <td class='head-padd'>&nbsp;&nbsp;&nbsp;5.</td>
                        <td class='head-padd'>Kapanpun saat terjadi reaksi transfusi</td>
                    </tr>
                </table>
            </td>
            <td colspan="12" style="padding:0px;margin:0px;">
                <table class="prinout w100 no-grid">
                    <tr>
                        <td colspan="3"  class='head-padd'><b>&nbsp;&nbsp;&nbsp;Jenis Reaksi Transfusi :</b></td>
                    </tr>
                    <tr>
                        <td width='30%' class='head-padd'><b>&nbsp;&nbsp;&nbsp;Reaksi Ringan</b></td>
                        <td width='30%' class='head-padd'><b>Reaksi Sedang</b></td>
                        <td width='39%' class='head-padd'><b>Reaksi Berat</b>: Tanda reaksi sedang ditambahi dengan</td>
                    </tr>                    
                    <tr>
                        <td class='head-padd'>&nbsp;&nbsp;&nbsp;1. Urtikaria</td>
                        <td class='head-padd'>1. Menggigil</td>
                        <td class='head-padd'>1. Nyeri dada</td>
                    </tr>
                    <tr>
                        <td class='head-padd' >&nbsp;&nbsp;&nbsp;2. Pruritus</td>
                        <td class='head-padd' >2. Demam</td>
                        <td class='head-padd' >2. Nyeri pinggang/punggung</td>
                    </tr>
                    <tr>
                        <td class='head-padd'></td>
                        <td class='head-padd'>3. Takikardi</td>
                        <td class='head-padd'>3. Hipotensi</td>
                    </tr>
                    <tr>
                        <td class='head-padd'></td>
                        <td class='head-padd'>4. Gelisah</td>
                        <td class='head-padd'>4. Perdarahan dari bekas suntikan</td>
                    </tr>
                    <tr>
                        <td class='head-padd'></td>
                        <td class='head-padd'>5. Sakit kepala</td>
                        <td class='head-padd'>5. Syok</td>
                    </tr>
                    <tr>
                        <td class='head-padd'></td>
                        <td class='head-padd'>6. Sesak nafas</td>
                        <td class='head-padd'>6. Urine berwarna gelap</td>
                    </tr>
                </table>
            </td>
    </table>
    <table class="prinout w100 no-grid">
        <tr>
            <td ><font style="font-size: 10px !important;">Revisi : 04/04/18</font></td>
            <td align="right"></td>
        </tr>
    </table>
 <?php
    echo '<div style=" page-break-after:always;"></div>';
 ?>