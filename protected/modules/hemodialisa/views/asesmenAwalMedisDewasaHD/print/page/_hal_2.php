<?php
$titik = new CustomFunction;

$data['judul_laporan'] = '&nbsp;';
$data['alias'] = '&nbsp;';
$data['no_dok'] = '&nbsp;';

echo $this->renderPartial('application.views.headerReport._default_emr_pdf',['data'=>$data,'pemprov_logo'=>true,'identitas'=>false], true); 

$jarak = ' &nbsp;';

?>


    <table class='w100 prinout grid' autosize="1">       
        <tr>
            <td>
                <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td width="15%">Kondisi Khusus</td>
                        <td width="3%">:</td>
                        <td colspan="2" width="12%">                            
                            <?= ceklis($model->kondisikhusus_normal) ?> Normal
                        </td>  
                        <td width="71%">
                            <?= ceklis($model->kondisikhusus_anemis) ?> Anemis &nbsp;&nbsp;
                            <?= ceklis($model->kondisikhusus_icterus) ?> Icterus &nbsp;&nbsp;
                            <?= ceklis($model->kondisikhusus_sianosis) ?> Sianosis &nbsp;&nbsp;
                            <?= ceklis($model->kondisikhusus_lainnya) ?> Lainnya &nbsp;&nbsp; <?= $titik->defaulttitik(22, $model->kondisikhusus_lainnya_ket, $jarak) ?>
                        </td> 
                    </tr>                                       
                    <tr>
                        <td>Tekanan darah</td>
                        <td>:</td>
                        <td colspan="3" >                            
                           <?= $titik->defaulttitik(7, $model->tekanandarah_sistolok.'/'.$model->tekanandarah_diastolik, $jarak) ?> mmHg, 
                           Nadi : <?= $titik->defaulttitik(5, $model->nadi, $jarak) ?> x/mnt, 
                           Pernapasan : <?= $titik->defaulttitik(5, $model->pernafasan, $jarak) ?> x/mnt, 
                           Suhu : <?= $titik->defaulttitik(5, $model->suhu, $jarak) ?> <sup>o</sup>C (Aksiler / Rectal)
                        </td> 
                    </tr> 
                    <tr>
                        <td>Nyeri</td>
                        <td>:</td>
                        <td colspan="2">                            
                            <?= ceklis($model->nyeri_ada) ?> Ya
                        </td>  
                        
                        <td>
                            <?= ceklis($model->nyeri_tidakada) ?> Tidak &nbsp;&nbsp;                            
                        </td> 
                    </tr> 
                </table>
                <table class="w100 prinout no-grid" autosize="0">                    
                    <tr>
                        <td width="20%">Kepala</td>
                        <td></td>
                        <td colspan="3" width="30%"> 
                             : <?= ceklis($model->kepala_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->kepala_tidaknormal) ?> Tidak Normal, jelaskan <?= $titik->defaulttitik(20, $model->kepala_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr> 
                    <tr>
                        <td>Mata</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->mata_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->mata_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->mata_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr> 
                    <tr>
                        <td>THT</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->tht_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->tht_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->tht_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr> 
                    <tr>
                        <td>Leher</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->leher_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->leher_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->leher_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Mulut</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->mulut_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->mulut_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->mulut_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Jantung dan pembuluh darah</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->jantung_pb_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->jantung_pb_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->jantung_pb_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Thorax, paru-paru dan payudara</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->thorax_paru_payudara_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->thorax_paru_payudara_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->thorax_paru_payudara_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Abdomen</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->abdomen_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->abdomen_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->abdomen_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Kulit dan sistem limfatik</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->kulit_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->kulit_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->kulit_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tulang belakang dan anggota tubuh</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->tulang_anggotatubuh_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->tulang_anggotatubuh_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->tulang_anggotatubuh_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Sistem saraf</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->sistemsaraf_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->sistemsaraf_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->sistemsaraf_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Genitalia, anus dan rektum</td>
                        <td></td>
                        <td colspan="3"> 
                             : <?= ceklis($model->genitalia_normal) ?> Normal &nbsp;&nbsp;&nbsp;
                             <?= ceklis($model->genitalia_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->genitalia_tidaknormal_ket, $jarak) ?>
                        </td>
                    </tr>                   
                </table>
                
                <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td width="17%">Status Lokalis</td>
                        <td width="3%">:</td>
                        <td>                            
                            <?= ceklis($model->statuslokalis_normal) ?> Normal
                        </td>  
                        
                        <td>
                            <?= ceklis($model->statuslokalis_tidaknormal) ?> Tidak Normal, jelaskan 
                            <?= $titik->defaulttitik(31, $model->statuslokalis_tidaknormal_ket, $jarak) ?>
                        </td> 
                    </tr> 
                </table>
            </td>                
        </tr>  
        <tr>
            <td>
                <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td colspan="3"><b>Pemeriksaan Penunjang Pre Dialisis</b></td>
                    </tr>
                    <tr>            
                        <td>Pemeriksaan Rad</td>  
                        <td width="3%">:</td> 
                        <td>
                            <table autosize="0" class="w100 prinout grid">
                                <tr>
                                    <td>Nama Pemeriksaan</td>
                                    <td>Tgl. Pemeriksaan</td>
                                </tr>
                                <?php
                                    if (!empty($model->set_periksa_internal_rad)){
                                        foreach($model->set_periksa_internal_rad as $det){
                                            echo '<tr>';
                                            echo '<td>'.$det->pemeriksaanrad_nama.'</td>';
                                            echo '<td>'.(!empty($det->tglpemeriksaanrad)?MyFormatter::formatDateTimeForUser($det->tglpemeriksaanrad):'').'</td>';
                                            echo '</tr>';
                                        }
                                    }else{
                                        echo '<tr><td colspan="2">Tidak ada data</td></tr>';
                                    }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>            
                        <td>Pemeriksaan Lab</td>  
                        <td width="3%">:</td> 
                        <td>
                            <table autosize="0" class="w100 prinout grid">
                                <tr>
                                    <td>Nama Pemeriksaan</td>
                                    <td>Tgl. Pemeriksaan</td>
                                </tr>
                                <?php
                                    if (!empty($model->set_periksa_internal_lab)){
                                        foreach($model->set_periksa_internal_lab as $det){
                                            echo '<tr>';
                                            echo '<td>'.$det->pemeriksaanlab_nama.'</td>';
                                            echo '<td>'.(!empty($det->tglhasilpemeriksaanlab)?MyFormatter::formatDateTimeForUser($det->tglhasilpemeriksaanlab):'').'</td>';
                                            echo '</tr>';
                                        }
                                    }else{
                                        echo '<tr><td colspan="2">Tidak ada data</td></tr>';
                                    }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>            
                        <td>Pemeriksaan Lab dari Luar</td>  
                        <td >:</td> 
                        <td>
                            <table autosize="0" class="w100 prinout grid">
                                <tr>
                                    <td>Nama Pemeriksaan</td>
                                    <td>Tgl. Pemeriksaan</td>
                                    <td>Hasil Pemeriksaan</td>
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
                                    }else{
                                        echo '<tr><td colspan="3">Tidak ada data</td></tr>';
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
                <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td colspan="3"><b>Diagnosis</b></td>
                    </tr>                
                    <tr>
                        <td>
                            <table autosize="0" class="w100 prinout grid">
                                <tr>
                                    <td>Tgl Diagnosis</td>
                                    <td>Kelompok Diagnosis</td>
                                    <td>Kasus Diagnosis</td>
                                    <td>Kode Diagnosis</td>
                                    <td>Nama Diagnosis</td>
                                </tr>
                                    <?php
                                        if (!empty($model->set_diagnosa_morbiditas)){
                                                foreach($model->set_diagnosa_morbiditas as $det){
                                                    echo '<tr>';                                            
                                                    echo '<td>'.(!empty($det->tglmorbiditas)?MyFormatter::formatDateTimeForUser($det->tglmorbiditas):'').'</td>';
                                                    echo '<td>'.$det->kelompokdiagnosa_nama.'</td>';
                                                    echo '<td>'.$det->kasusdiagnosa.'</td>';
                                                    echo '<td>'.$det->diagnosa_kode.'</td>';
                                                    echo '<td>'.$det->diagnosa_nama.'</td>';
                                                    echo '</tr>';
                                                }
                                            }else{
                                                echo '<tr><td colspan="5">Tidak ada data</td></tr>';
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
                <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td align="center" width="49%">
                            Tanggal <?= $titik->defaulttitik(30, MyFormatter::formatDateTimeForUser(date('Y-m-d'),'long'),$jarak) ?> Jam <?= $titik->defaulttitik(10, date('H:i:s'),$jarak) ?> WIB 
                        </td>
                        <td align="center"  width="49%">
                            Tanggal <?= $titik->defaulttitik(30, MyFormatter::formatDateTimeForUser(date('Y-m-d'),'long'),$jarak) ?> Jam <?= $titik->defaulttitik(10, date('H:i:s'),$jarak) ?> WIB 
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            Nama dan Tanda Tangan Dokter Pemeriksa
                        </td>
                        <td align="center">
                            Nama dan Tanda Tangan Konsultan Nefrologi
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
                        <td align="center">
                             <?= $titik->defaulttitik(30, !empty($model->konsultannefrologi->namaLengkap)?$model->konsultannefrologi->namaLengkap:null,$jarak) ?>
                        </td>
                        <td align="center">
                             <?= $titik->defaulttitik(30, !empty($model->dokterpemeriksa->namaLengkap)?$model->dokterpemeriksa->namaLengkap:null,$jarak) ?> 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="prinout w100 no-grid">
        <tr>
            <td ></td>
            <td align="right"><font style="font-size: 10px !important;">Hal 2 dari 2</font></td>
        </tr>
    </table>
 <?php
    echo '<div style=" page-break-after:always;"></div>';
 ?>