<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    /*
    td, th{
     
        height: 24px;
        padding-left:10px;
    }
    */
    .content td, .content strong{
        height: 12px;
        font-size:10px !important;
    }
    
    .table_resume td {
        padding-bottom: 10px;
        vertical-align: top;
    }

    .table_header_resume {
        width: 100%;
    }
    .table_header_resume td {
        vertical-align: top;
    }
    .header_border {
        border: 1px solid black;
    }

    .header_head {
        width: 100px;
        display: inline-block;
    }
   
 

</style>
<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$modPasien = PasienM::model()->findByPk($modKunjungan->pasien_id);
$pulang = PasienpulangT::model()->findByAttributes(array(
    'pendaftaran_id'=>$modKunjungan->pendaftaran_id,
), array(
    'condition'=>'dokterpenerima_id is not null'
));
$dokterPenerima = null;
if (!empty($pulang)) {
    $dokterPenerima = PegawaiM::model()->findByPk($pulang->dokterpenerima_id);
}
?>

<div class="anamnesis_judul">RESUME (DISCHARGE SUMMARY)</div>
                    <table class="anamnesa_content table_header_resume">
                        <tr>
                            <td rowspan="2" colspan="3"></td>
                            <td class="header_border" colspan="2"><strong>RM.</strong> <?php echo $modKunjungan->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td class="header_border" colspan="2"><strong>No.</strong> <?php echo $modKunjungan->no_pendaftaran; ?></td>
                        </tr>
                        <tr>
                            <td class="header_border">
                                <div class="header_head"><strong>Nama Pasien</strong> </div>: <?php echo $modKunjungan->nama_pasien; ?><br/>
                                <div class="header_head"><strong>Pekerjaan</strong> </div>: <?php echo $modPasien->pekerjaan->pekerjaan_nama; ?>
                            </td>
                            <td class="header_border">
                                <strong>Tgl. Lahir</strong><br/>
                                <?php echo $format::FormatDateTimeForUser($modKunjungan->tanggal_lahir); ?>
                            </td>
                            <td class="header_border" colspan="2">
                                <strong>No. Peg</strong>

                            </td>
                            <td class="header_border">
                                <strong>Bagian</strong>
                                
                            </td>
                        </tr>
                        <tr>
                            <td class="header_border">
                                <strong>Dokter yang mengirim</strong><br/>
                                <?php echo $modKunjungan->dokterpenanggungjawab_nama ?? "-"; ?>
                            </td>
                            <td class="header_border">
                                <strong>Dokter yang merawat</strong><br/>
                                <?php echo $dokterPenerima->namaLengkap ?? "-"; ?>
                            </td>
                            <td class="header_border">
                                <strong>Ruangan</strong><br/>
                                <?php 
                                $ruangan = RuanganM::model()->findByPk($modResume->ruanganterahkir_id);
                                echo $ruangan->ruangan_nama ?? "-"; 
                                
                                ?>
                            </td>
                            <td class="header_border">
                                <strong>Tgl. Masuk</strong><br/>
                                <?php echo !empty($modResume->tglmasukrs) ? MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modResume->tglmasukrs))) : "-"; ?>
                            </td>
                            <td class="header_border">
                                <strong>Tgl. Keluar</strong><br/>
                                <?php echo !empty($modResume->tglkeluarrs) ? MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modResume->tglkeluarrs))) : "-"; ?>
                            </td>
                        </tr>
                    </table>

                    <table width="100%"  class="anamnesa_content table_resume">
                        <tr>
                            <td align="center" valign="middle" colspan="3" style="font-weight:bold"></td>
                        </tr>
                        <tr>
                            <td width="30%">Anamnesa</td>
                            <td width="10">:</td>
                            <td><?php echo $modResume->ikhtisarkliniksingkat; ?></td>
                        </tr>
                        <tr>
                            <td>Pemeriksaan Fisik</td>
                            <td width="10">:</td>
                            <td><?php echo $modResume->resume_pemeriksaanfisik ?? "-"; ?></td>
                        </tr>
                        <tr>
                            <td>Pemeriksaan Penunjang</i></td>
                            <td width="10">:</td>
                            <td><?php

                                if (!empty($modResume->resume_pemeriksaanlab)) {
                                    echo "<strong>Laboratorium</strong><br/>".$modResume->resume_pemeriksaanlab."<br/>";
                                }

                                if (!empty($modResume->resume_pemeriksaanrad)) {
                                    echo "<strong>Radiologi</strong><br/>".$modResume->resume_pemeriksaanrad."<br/>";
                                }

                                if (!empty($modResume->resume_rehabmedis)) {
                                    echo "<strong>Rehab Medis</strong><br/>".$modResume->resume_rehabmedis."<br/>";
                                }


                                ?></td>

                        </tr>
                        <tr>
                            <td>Diagnosa Akhir</td>
                            <td width="10">:</td>
                            <td>
                                <?php
                                if (!empty($dataDiagnosa['diagnosautama'] && $dataDiagnosa['diagnosautama'] != "")) {
                                    echo $dataDiagnosa['diagnosautama'];
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Therapi</td>
                            <td width="10">:</td>
                            <td>
                                <?php echo $modResume->resume_rehabmedis ?? "-"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Perjalanan Penyakit</td>
                            <td width="10">:</td>
                            <td><?php echo $modResume->perjalananpenyakit ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>Saran</td>
                            <td width="10">:</td>
                            <td><?php echo $modResume->saran_resume; ?></td>
                        </tr>
                    </table>
                    <br>
                    <table style="width: 100%; border: none;">
                   
                        <tr>
                            <td align="center" valign="middle" width="50%"></td>
                         
                            <td align="center" valign="middle" width="50%"><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br></td>
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
                            <td align="center" valign="middle"></td>
                       
                            <td align="center" valign="middle"><?php echo (isset($modKunjungan->pegawai->gelardepan) ? $modKunjungan->pegawai->gelardepan : '') . ' ' . $modKunjungan->pegawai->nama_pegawai . ' ' . (isset($modKunjungan->pegawai->gelarbelakang_nama) ? $modKunjungan->pegawai->gelarbelakang_nama : ''); ?></td>
                        </tr>

                    </table>
            