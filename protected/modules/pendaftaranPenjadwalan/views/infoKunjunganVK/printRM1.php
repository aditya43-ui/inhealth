<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    

<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo');    
?>
  
<table width="100%">
    <tr>
        <td style="text-align: center;"><b><?= $judul_print ?></b></td>
    </tr>
</table>
<br/>

<table width="100%">
    <tr>
        <td>NAMA PASIEN</td>
        <td width="1%">:</td>
        <td><?= $modPasien->nama_pasien ?></td>
        <td width="2%"></td>
        <td>NO. RM</td>
        <td width="1%">:</td>
        <td><?= $modPasien->no_rekam_medik ?></td>
    </tr>
    <tr>
        <td>Penjamin</td>
        <td>:</td>
        <td><?= $model->penjamin_nama ?></td>
        <td></td>
        <td>NO. REG</td>
        <td>:</td>
        <td><?= $modDaftar->no_pendaftaran ?></td>
    </tr>
    <tr>
        <td></td>
        <td>:</td>
        <td></td>
        <td></td>
        <td>Bagian</td>
        <td >:</td>
        <td></td>
    </tr>
    <tr>
        <td>Nama Pegawai</td>
        <td>:</td>
        <td><?php
                $user = LoginpemakaiK::model()->findByPk($modDaftar->create_loginpemakai_id);
                $peg = PegawaiM::model()->findByPk($user->pegawai_id);
                echo $peg->namaLengkap;
            ?></td>
        <td></td>
        <td>Hubungan</td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>No Pegawai/Polis</td>
        <td>:</td>
        <td><?= $peg->nomorindukpegawai ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="3">
            <table width="100%">
                <tr>
                    <td>UMUR</td>
                    <td>TGL-BULAN-THN</td>
                </tr>
                <tr>
                    <td>
                        <?php
                            $umur = explode(' ',$modDaftar->umur);
                            echo $umur[0].' tahun';
                        ?>
                    </td>
                    <td><?= $format->formatDateTimeForUser($modPasien->tanggal_lahir) ?></td>
                </tr>    
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">PEKERJAAN</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?= !empty($modPasien->pekerjaan)?$modPasien->pekerjaan->pekerjaan_nama:'' ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">STATUS PERKAWINAN</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?= $modPasien->statusperkawinan ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">ALAMAT</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?= $modPasien->alamat_pasien ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        NAMA PENANGGUNG JAWAB : <?= $modPPJ->nama_pj ?> 
                        <br/>
                        PEKERJAAN : 
                        <br/>
                        ALAMAT : <?= $modPPJ->alamat_pj ?>
                    </td>
                </tr>     
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: right;"><?= $model->kelaspelayanan_nama ?></td>
                </tr>  
                <tr>
                    <td colspan="2">BAGIAN :</td>
                </tr>
                <tr>
                    <td>
                        <ol>
                            <li>P. Dalam</li>
                            <li>Bedah</li>
                            <li>Kes. Anak</li>
                            <li>Kebidanan dan P. Kandungan</li>
                            <li>THT</li>
                            <li>Mata</li>
                        </ol>
                    </td>
                    <td>
                        <ol start="7">
                            <li>Paru-paru</li>
                            <li>Gigi & Mulut</li>
                            <li>Jantung</li>
                            <li>Kulit Kelamin</li>
                            <li>Syaraf</li>
                            <li>Orthopedi</li>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <!-- <tr>
                    <td style="text-align: center;">DIAGNOSIS MASUK</td>
                    <td>
                        UTAMA : <?php  //echo $model->diagnosisutama_masuk ?>                       
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">DIAGNOSIS AKHIR<br/>(jgn disingkat Tulis dg Huruf Cetak)</td>
                    <td>
                        UTAMA : <?php //echo $model->diagnosisutama_akhir ?>      
                        <br/>
                        KOMPLIKASI : -
                    </td>
                </tr> -->
            </table>
        </td>
        <td>&nbsp;</td>
        <td colspan="3">
            <table width="100%">
                <tr>
                    <td>AGAMA</td>
                    <td>JENIS KELAMIN</td>
                </tr>
                <tr>
                    <td>
                        <?= $modPasien->agama ?>
                    </td>
                    <td><?= $modPasien->jeniskelamin ?></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>PENDIDIKAN</td>
                    <td>CARA MASUK</td>
                </tr>
                <tr>
                    <td>
                        <?= !empty($modPasien->pendidikan)?$modPasien->pendidikan->pendidikan_nama:'' ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>  
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>KASUS POLISI</td>
                    <td>PESERTA BPDPK/ASKES</td>
                </tr>
                <tr>
                    <td>
                        <ol>
                            <li>Ya</li>
                            <li>Tidak</li>
                        </ol>
                    </td>
                    <td>
                        <ol>
                            <li>Ya, no</li>
                            <li>Tidak</li>
                        </ol>
                    </td>
                </tr>     
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">DIKIRIM OLEH</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <ol>
                            <li>RS</li>
                            <li>PUSKESMAS</li>
                            <li>DOKTER</li>
                            <li>BIDAN</li>
                            <li>PERAWAT</li>
                            <li>KEMAUAN SENDIRI</li>
                        </ol>
                    </td>                    
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width='100%'>
                            <tr>
                                <td></td>
                                <td>TANGGAL</td>
                                <td>BULAN</td>
                                <td>TAHUN</td>
                            </tr>
                            <tr>
                                <td>TANGGAL MASUK</td>
                                <td><?= date('d', strtotime($model->tgl_pendaftaran)) ?></td>
                                <td><?= date('M', strtotime($model->tgl_pendaftaran)) ?></td>
                                <td><?= date('Y', strtotime($model->tgl_pendaftaran)) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3">JAM : <?= date('H:i:s', strtotime($model->tgl_pendaftaran)) ?></td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td>TANGGAL</td>
                                <td>BULAN</td>
                                <td>TAHUN</td>
                            </tr>
                            <tr>
                                <td>TANGGAL KELUAR</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3">JAM : </td>                                
                            </tr>                            
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        LAMA DIRAWAT : ............... HARI
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Dokter yang menerima : <?= !empty($model->nama_pegawai)?$model->namaDokter:'' ?> </td>
                </tr>
                <!-- <tr>
                    <td colspan="2">Dokter yang merawat : <?= !empty($model->pegawai)?$model->pegawai->namaLengkap:'' ?> </td>
                </tr> -->
            </table>
        </td>
    </tr>  
    <tr>
        <td colspan="7">
            <table width='100%'>
                <tr>
                    <td>&nbsp;</td>
                    <td>NAMA OPERASI/BIOPSI</td>
                    <td>TANGGAL</td>
                    <td>NO KODE</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <table width='100%'>
                <tr>
                    <td>IMUNISASI</td>
                    <td>1. BCG</td>
                    <td>2. DPT</td>
                    <td>3. DT</td>
                    <td>4. Campak</td>
                    <td>5. Polio</td>
                    <td>6. Tetanus</td>
                </tr>                
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <table width='100%'>
                <tr>
                    <td colspan="2">KEADAAN KELUAR</td>                    
                </tr>                
                <tr>
                    <td>
                        <ol>
                            <li>Sembuh</li>
                            <li>Mulai Sembuh</li>
                            <li>Belum Sembuh</li>
                            <li>Cacat</li>                            
                        </ol>
                    </td>
                    <td>
                        <ol start='5'>
                            <li>Mati < 4 Jam</li>
                            <li>Mati < 24 Jam</li>
                            <li>Mati < 48 Jam</li>
                            <li>Mati > 48 Jam</li>                            
                        </ol>
                    </td>
                </tr>
            </table>
        </td>
        <td>&nbsp;</td>
        <td colspan="3">
            <table width='100%'>
                <tr>
                    <td>CARA KELUAR</td>                    
                    <td>TRANSFUSI</td>                    
                </tr>                
                <tr>
                    <td>
                        <ol>
                            <li>Perintah Dokter</li>
                            <li>Permintaan Sendiri</li>
                            <li>Kabur</li>
                            <li>Pindah RS Lain</li>                            
                        </ol>
                    </td>
                    <td style="vertical-align: top;">
                        <ol start='5'>
                            <li>Ya, ........ cc</li>
                            <li>Tidak</li>
                        </ol>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

