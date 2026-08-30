<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
     
        height: 24px;
        padding-left:10px;
    }
    body{
/*        width: 21.7cm;*/
    }
    .content td{
        height: 12px;
    }
    .diagnosa td{
    
        border:1px solid #000 !important;
    }
   
 

</style>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent"> <?php echo $judul_print; ?> </div>
                    <br>
                    <table width="100%" border="0">

                        <tr>
                            <td style="width:20%">Nama Pasien</td>
                            <td style="width:20%"><?php echo isset($modKunjungan->namadepan) ? $modKunjungan->namadepan . $modKunjungan->nama_pasien : $modKunjungan->nama_pasien; ?></td>
                            <td style="width:20%">No MR</td>
                            <td style="width:30%"><?php echo $modKunjungan->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td style="width:20%">Jenis Kelamin</td>
                            <td style="width:20%"><?php echo $modKunjungan->jeniskelamin; ?></td>
                            <td style="width:20%">Dokter Pengirim</td>
                            <td style="width:30%"><?php echo $modKunjungan->dokterpenanggungjawab_nama; ?></td>
                        </tr>
                        <tr>
                            <td style="width:20%">Istri / Suami / Anak dari</td>
                            <td style="width:30%"><?php echo $modKunjungan->pegawaipenanggung_nama; ?></td>
                        </tr>
                        <tr>
                            <td style="width:20%">Tanggal Lahir</td>
                            <td style="width:20%"><?php echo $format::FormatDateTimeForUser($modKunjungan->tanggal_lahir); ?></td>
                        </tr>
                        <tr>
                            <td style="width:20%">Tanggal Masuk RS</td>
                            <td style="width:20%"><?php echo $format::FormatDateTimeForUser($modKunjungan->tgl_pendaftaran); ?></td>
                            <td style="width:20%">Tanggal Keluar RS</td>
                            <td style="width:20%"><?php echo $format::FormatDateTimeForUser($modResume->tglkeluarrs); ?></td>
                        </tr>
                    </table>
                    <table width="100%"  class=" table table-border">
                        <tr>
                            <td align="center" valign="middle" colspan="3" style="font-weight:bold"></td>
                        </tr>
                    <!--<tr>
                            <th>Kelompok Diagnosa</th>
                            <th>Nama Diagnosa</th>
                            <th>Kode</th>
                        </tr>-->
                        <tr class="diagnosa">
                            <td width="30%">Ikhtisar Klinik Singkat</td>
                            <td><?php echo $modResume->ikhtisarkliniksingkat; ?></td>
                        </tr>
                        <tr class="diagnosa">
                            <td>Diagnosa kelainan pada pemeriksaan fisik <i>(Pemeriksaan Fisik / Lab / Radiologi)</i></td>
                            <td><?php
                                if ((!empty($modResume->resume_pemeriksaanfisik)) && (!empty($modResume->resume_pemeriksaanlab)) && (!empty($modResume->resume_pemeriksaanrad))) {
                                    echo $modResume->resume_pemeriksaanfisik . " dan " . $modResume->resume_pemeriksaanlab . " dan " . $modResume->resume_pemeriksaanrad;
                                } elseif ((!empty($modResume->resume_pemeriksaanfisik)) && (!empty($modResume->resume_pemeriksaanlab)) && (empty($modResume->resume_pemeriksaanrad))) {
                                    echo $modResume->resume_pemeriksaanfisik . " dan " . $modResume->resume_pemeriksaanlab;
                                } elseif ((!empty($modResume->resume_pemeriksaanfisik)) && (empty($modResume->resume_pemeriksaanlab)) && (!empty($modResume->resume_pemeriksaanrad))) {
                                    echo $modResume->resume_pemeriksaanfisik . " dan " . $modResume->resume_pemeriksaanrad;
                                } elseif ((empty($modResume->resume_pemeriksaanfisik)) && (!empty($modResume->resume_pemeriksaanlab)) && (!empty($modResume->resume_pemeriksaanrad))) {
                                    echo $modResume->resume_pemeriksaanlab . " dan " . $modResume->resume_pemeriksaanrad;
                                } elseif ((!empty($modResume->resume_pemeriksaanfisik)) && (empty($modResume->resume_pemeriksaanlab)) && (empty($modResume->resume_pemeriksaanrad))) {
                                    echo $modResume->resume_pemeriksaanfisik;
                                } elseif ((empty($modResume->resume_pemeriksaanfisik)) && (!empty($modResume->resume_pemeriksaanlab)) && (empty($modResume->resume_pemeriksaanrad))) {
                                    echo $modResume->resume_pemeriksaanlab;
                                } elseif ((empty($modResume->resume_pemeriksaanfisik)) && (empty($modResume->resume_pemeriksaanlab)) && (!empty($modResume->resume_pemeriksaanrad))) {
                                    echo $modResume->resume_pemeriksaanrad;
                                }
                                ?></td>

                        </tr>
                        <tr class="diagnosa">
                            <td>Diagnosa Sementara</td>
                            <td>
                                <?php
                                if (!empty($modDiagnosaAwal->diagnosa_kode)) {
                                    echo "Diagnosa awal : " . $modDiagnosaAwal->diagnosa_kode . " - " . $modDiagnosaAwal->diagnosa_nama;
                                } else {
                                    echo "";
                                }
                                ?>

                            </td>
                        </tr>
                        <tr class="diagnosa">
                            <td>Pengobatan Sementara yang diberikan</td>
                            <td>
                                <?php echo $modResume->terapiperawatan; ?>
                            </td>
                        </tr>
                        <tr class="diagnosa">
                            <td>Diagnosa Akhir</td>
                            <td>
                                <?php
                                if (!empty($dataDiagnosa['diagnosautama'])) {
                                    echo $dataDiagnosa['diagnosautama'];
                                } else {
                                    echo "";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="diagnosa">
                            <td>Obat yang diberikan saat pulang</td>
                            <td>
                                <?php echo $modResume->terapisaatpulang; ?></td>
                        </tr>
                        <tr class="diagnosa">
                            <td>Riwayat Operasi</td>
                            <td><?php echo $modResume->riwayatoperasi; ?></td>
                        </tr>
                        <tr class="diagnosa">
                            <td>Cara Keluar</td>
                            <td><?php echo $modResume->carakeluar; ?></td>
                        </tr>
                        <tr class="diagnosa">
                            <td>keadaan /kondisi keluar</td>
                            <td><?php echo $modResume->kondisipulang; ?></td>
                        </tr>
                        <tr class="diagnosa">
                            <td>Saran/Instruksi untuk tindak lanjut</td>
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
                </div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">

        <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>
