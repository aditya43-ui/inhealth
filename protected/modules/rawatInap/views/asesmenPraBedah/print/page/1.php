<?php
$profil = ProfilrumahsakitM::model()->find();
$kosongtab = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$this->renderPartial('application.views.headerReport.headerConcent',[
    'judulPrint'=>$judul_print,
    'alias'=>$alias,
    'koderm'=>'RM. 023',    
    'modPasien' => $modPasien
]);
$custom = new CustomFunction();

$kesadaran = [
    'Cosmos mentis' => 'Cosmos mentis',
    'Apathis' => 'Apathis',
    'Somnolent' => 'Somnolent',
    'Supor' => 'Supor',
    'Soporocoma' => 'Soporocoma',
    'Coma' => 'Coma',
];

?>

<table class="table prinout grid w100">   
    <tr>
        <td>Asal Pasien : <?= $model->ruangandibuat_nama ?></td>
    </tr>
    <tr>
        <td style="padding:0px;margin:0px;" colspan="3">
            <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                <tr>
                    <td style="padding:0px;margin:0px;" width="49%">
                        <table class="table prinout no-grid w100">
                            <tr>
                                <td colspan="12"><b>DATA UMUM</b></td>
                            </tr>
                            <tr>
                                <td colspan="4">Dokter Bedah / Operator</td>
                                <td colspan="8">: <?= $model->dokterbedah_nama ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Dokter Anastesi</td>
                                <td colspan="8">: <?= $model->dokteranestesi_nama ?></td>
                            </tr>
                            <tr>
                                <td colspan="12"><b>VITAL SIGN</b></td>
                            </tr>
                            <tr>
                                <td>TD</td>
                                <td>:</td>
                                <td><?= $model->tensi_sistolik.'/'.$model->tensi_diastolik ?></td>
                                <td>mmHg</td>
                                <td>Nadi</td>
                                <td>:</td>
                                <td><?= $model->nadi ?></td>
                                <td>x/menit</td>
                                <td>TB</td>
                                <td>:</td>
                                <td><?= $model->tinggibadan_cm ?></td>
                                <td>cm</td>
                            </tr>
                            <tr>
                                <td>RR</td>
                                <td>:</td>
                                <td><?= $model->rr ?></td>
                                <td>x/menit</td>
                                <td>SpO2</td>
                                <td>:</td>
                                <td><?= $model->spo2 ?></td>
                                <td>%</td>
                                <td>BB</td>
                                <td>:</td>
                                <td><?= $model->beratbadan_kg ?></td>
                                <td>Kg</td>
                            </tr>
                            <tr>
                                <td colspan="4">Riwayat Penyakit</td>
                                <td colspan="8"> <?= $model->riwayatpenyakit ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Riwayat Pengobatan</td>
                                <td colspan="8"> <?= $model->riwayatpengobatan ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Riwayat Alergi</td>
                                <td colspan="8"> <?= 'Makan : '.$model->riwayatalergimakanan.'<br/>Obat : '.$model->riwayatalergiobat ?></td>
                            </tr>
                        </table>
                    </td>
                    <td style="padding:0px;margin:0px;" width="49%">
                        <table class="table prinout no-grid w100">
                             <tr>
                                 <td style="text-align:center;" colspan="11"><b>VAS</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;" >
                                    <?php echo CHtml::image('images/icon_nyeri/0.png','',array('style'=>'max-width:100%;width:35px;')); ?>
                                    <span style="font-size:7px;">
                                        <br>
                                        0
                                        <br>
                                        Tidak Nyeri
                                    </span>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align: center;" >
                                    <?php echo CHtml::image('images/icon_nyeri/2.png','',array('style'=>'max-width:100%;width:35px;')); ?>
                                    <span style="font-size:7px;">
                                        <br>
                                        2
                                        <br>
                                        Sedikit Nyeri
                                    </span>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align: center;" >
                                    <?php echo CHtml::image('images/icon_nyeri/4.png','',array('style'=>'max-width:100%;width:35px;')); ?>
                                    <span style="font-size:7px;">
                                        <br>
                                        4
                                        <br>
                                        Sedikit Lebih Nyeri
                                    </span>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align: center;" >
                                    <?php echo CHtml::image('images/icon_nyeri/6.png','',array('style'=>'max-width:100%;width:35px;')); ?>
                                    <span style="font-size:7px;">
                                        <br>
                                        6
                                        <br>
                                        Lebih Nyeri
                                    </span>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align: center;" >
                                    <?php echo CHtml::image('images/icon_nyeri/8.png','',array('style'=>'max-width:100%;width:35px;')); ?>
                                    <span style="font-size:7px;">
                                        <br>
                                        8
                                        <br>
                                        Sangat Nyeri
                                    </span>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align: center;" >
                                    <?php echo CHtml::image('images/icon_nyeri/10.png','',array('style'=>'max-width:100%;width:35px;')); ?>
                                    <span style="font-size:7px;">
                                        <br>
                                        10
                                        <br>
                                        Nyeri Sangat Hebat
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                    for($i=1;$i<=11;$i++){
                                ?>
                                    <td style="text-align: center;" >
                                      <?= $custom->set_pilihan_ceklis($model->skalanyeri == $i, false, true) ?>
                                    </td>                                
                                <?php
                                    }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3">Kesadaran </td>
                                <td colspan="8">: <?= $model->kesadaran ?></td>                                                                
                            </tr>
                            <tr>
                                <td colspan="3">Keluhan Utama </td>
                                <td colspan="8">: <?= $model->keluhanutama ?></td>                                                                
                            </tr>
                            <tr>
                                <td colspan="3">Diagnosa Pre Op. </td>
                                <td colspan="8">: </td>                                                                
                            </tr>
                        </table>
                    </td>
                </tr>                                   
            </table>
        </td>
    </tr>    
    <tr>
        <td style="padding:0px;margin:0px;">
            <table class="table prinout grid w100" style="padding:0px;margin:0px;">
                <tr>
                    <td width="50%">
                        <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                            <tr>
                                <td width="25%">
                                    Konsumsi Rokok
                                </td>
                                <td width="25%">
                                    Alat bantu yang dipakai
                                </td>
                            </tr>
                            <tr>
                                <td><?= $custom->set_pilihan_ceklis($model->is_alatbantu_kacamata, false, true) ?> Kacamata</td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_alatbantu_dengar, false, true) ?> Alat bantu dengar</td>
                            </tr>
                            <tr>
                                <td><?= $custom->set_pilihan_ceklis($model->is_alatbantu_sofelens, false, true) ?> Sofelens</td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_alatbantu_pacujantung, false, true) ?> Alat pacu jantung</td>
                            </tr>
                            <tr>
                                <td><?= $custom->set_pilihan_ceklis($model->is_alatbantu_prostese, false, true) ?> Protese / Implat</td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_alatbantu_gigipalsu, false, true) ?> Gigi palsu</td>
                            </tr>
                            <tr>
                                <td><?= $custom->set_pilihan_ceklis($model->is_konsumsirokok==false, false, true) ?> Tidak pernah</td>
                                <td></td>
                            </tr>                            
                            <tr>
                                <td><?= $custom->set_pilihan_ceklis($model->is_konsumsirokok==true, false, true) ?> Konsumsi</td>
                                <td></td>
                            </tr> 
                        </table>
                    </td>
                    <td width="50%">
                        <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                            <tr>
                                <td>Penggunaan zat adiktif</td>
                            </tr>
                            <tr>
                                <td><?= $custom->set_pilihan_ceklis($model->is_zatadiktif==false, false, true) ?> Tidak Ada</td>
                            </tr>
                             <tr>
                                <td><?= $custom->set_pilihan_ceklis($model->is_zatadiktif==true, false, true) ?> Ada</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:0px;margin:0px;">
            <table class="table prinout grid w100" style="padding:0px;margin:0px;">
                <tr>
                    <td width="33%">
                        <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                            <tr>
                                <td colspan="2"><b>PEMERIKSAAN FISIK</b></td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>1.</b></td>
                                <td><b>Kepala Leher</b></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_kepalaleher === false, false, true) ?> Tidak ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_kepalaleher === true, false, true) ?> Ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>2.</b></td>
                                <td><b>Mulut dan Gigi</b></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_mulutdangigi === false, false, true) ?> Tidak ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_mulutdangigi === true, false, true) ?> Ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>3.</b></td>
                                <td><b>Thorax</b></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_thorax === false, false, true) ?> Tidak ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_thorax === true, false, true) ?> Ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>4.</b></td>
                                <td><b>Abdomen</b></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_abdomen === false, false, true) ?> Tidak ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_abdomen === true, false, true) ?> Ada kelainan</td>                                
                            </tr>
                        </table>
                    </td>
                    <td width="33%">
                       <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                            <tr>
                                <td colspan="2">&nbsp;</td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>5.</b></td>
                                <td><b>Kardiovaskuler</b></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_kardiovaskuler === false, false, true) ?> Tidak ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_kardiovaskuler === true, false, true) ?> Ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>6.</b></td>
                                <td><b>Genito Urinaria</b></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_genito === false, false, true) ?> Tidak ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_genito === true, false, true) ?> Ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>7.</b></td>
                                <td><b>Muskoloskeletal</b></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_muskuloskeletal === false, false, true) ?> Tidak ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_muskuloskeletal === true, false, true) ?> Ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>8.</b></td>
                                <td><b>Alat Reproduksi</b></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_reproduksi === false, false, true) ?> Tidak ada kelainan</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td><?= $custom->set_pilihan_ceklis($model->is_kelainan_reproduksi === true, false, true) ?> Ada kelainan</td>                                
                            </tr>
                        </table>
                    </td>
                    <td width="34%">
                       <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                            <tr>
                                <td colspan="2">&nbsp;</td>                                
                            </tr>
                            <tr>
                                <td width="10%"><b>9.</b></td>
                                <td><b>Neurologi (tingkat kesadaran)</b></td>                                
                            </tr>        
                            <?php
                                foreach($kesadaran as $key => $det){
                                    echo '<tr>';
                                    echo '<td>&nbsp;</td>';
                                    echo '<td>'.$custom->set_pilihan_ceklis( ($model->kesadaran == $det), false, true).' '.$key.'</td>';
                                    echo '</tr>';
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
            <?php
                $morbi = $model->searchMorbiditas();
                $minta = $model->searchPermintaanKepenunjangOperasi();
            ?>
            <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                <tr>
                    <td><b>Diagnosis</b></td>
                    <td><b>:</b></td>
                    <td>
                        <?php
                            $arrmorbi = [];
                            foreach($morbi->getData() as $det){
                                $arrmorbi[$det->pasienmorbiditas_id] = $det->diagnosa_kode.' - '.$det->diagnosa_nama;
                            }
                            echo implode(', ', $arrmorbi);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Rencana Tindakan</b></td>
                    <td><b>:</b></td>
                    <td>
                        <?php
                            $arrminta = [];
                            foreach($minta->getData() as $det){
                                $arrminta[$det->permintaankepenunjang_id] = $det->operasi_nama;
                            }
                            echo implode(', ', $arrminta);
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:0px;margin:0px;">
            <table class="table prinout grid w100" style="padding:0px;margin:0px;">
                <tr>
                    <td width="50%">
                        <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                            <tr>
                                <td width="50%">
                                    <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                                        <tr>
                                            <td><b>Rencana Pasca Pembedahan</b></td>                               
                                        </tr>                            
                                        <tr>
                                            <td><?= $custom->set_pilihan_ceklis($model->is_rencana_ambulatory, false, true) ?> Ambulatory</td>                               
                                        </tr>
                                        <tr>
                                            <td><?= $custom->set_pilihan_ceklis($model->is_rencana_rawatinap, false, true) ?> Rawat Inap</td>                               
                                        </tr>
                                        <tr>
                                            <td><?= $custom->set_pilihan_ceklis($model->is_rencana_icu, false, true) ?> Rawat di ICU</td>                               
                                        </tr>
                                        <tr>
                                            <td><?= $custom->set_pilihan_ceklis($model->is_rujuk, false, true) ?> Rujuk ke <?= $model->rujukke_nama ?></td>                               
                                        </tr>
                                    </table>
                                </td>                               
                            </tr>                            
                        </table>
                    </td>
                    <td width="50%" rowspan="2">
                        <table class="table prinout no-grid w100" style="padding:0px;margin:0px;">
                            <tr>
                                <td colspan="9"><b>Hasil Hasil Pemeriksaan Penunjang</b></td>
                            </tr>
                            <tr>
                                <td>Hb</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>Na</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>Glukosa</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                            </tr>                             
                            <tr>
                                <td>WBC</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>Ka</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>SGOT/SGPT</td>
                                <td></td>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td>Pits</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>PTT</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>BUN</td>
                                <td></td>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td>HcT</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>APTT</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>CREATININ</td>
                                <td></td>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td>HIV</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td>HBsAg</td>
                                <td>:</td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td>ECG</td>
                                <td></td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td>&nbsp;</td>
                            </tr>                            
                            <tr>
                                <td colspan="9">Rontgen</td>
                            </tr>                           
                            <tr>
                                <td colspan="9">USG</td>
                            </tr>                            
                            <tr>
                                <td colspan="9">CTSCAN</td>
                            </tr>                           
                            <tr>
                                <td colspan="9"><b>Catatan Khusus Dokter</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: center;padding:30px;">
                        <?= $profil->kabupaten->kabupaten_nama.', '.date('d/m/Y') ?><br/>
                        Dokter Operator
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        (<?= !empty($model->dokterbedah_nama )?$model->dokterbedah_nama :$kosong  ?>)
                    </td>                   
                </tr>
            </table>
        </td>
    </tr>
</table>       

                     