<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
/*        font-size: 8pt !important;*/
        height: 20px;
/*        padding-left:10px;*/
    }
    body{
/*        width: 21.7cm;*/
    }
    .content td{
/*        height: 48px;*/
    }
    
    .tab_skrining th, .tab_skrining td {
        color: black;
        border: 1px solid black;
/*        padding: 2px;*/
    }
    
    .tab_skrining th {
        text-align: center;
        font-weight: bold;
    }
    
    .tab_skrining tfoot td {
        font-weight: bold;
    }
</style>
<?php //echo $this->renderPartial('rawatJalan.views.anamnesa._headerPrintAnamnesa'); ?>
<?php $modul = Yii::app()->user->getState('modul_id'); ?>

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
			
                        <table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;  ?></td>
        <td style="width:20%">NO. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">Tgl. Lahir / UMUR</td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?> / <?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Jenis Kelamin</td>
        <td style="width:30%"><?php echo $modPasien->jeniskelamin; ?></td>
        <td style="width:20%">No. Pendaftaran</td>
        <td style="width:30%"><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold"><div class="judulcontent">  ANAMNESIS</div></td>
    </tr>
    <tr>
        <td style="width:30%">Perawat</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->paramedis_nama)?$modAnamnesa->paramedis_nama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Keluhan Utama</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhanutama)?$modAnamnesa->keluhanutama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Keluhan Tambahan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhantambahan)?$modAnamnesa->keluhantambahan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Perjalanan Penyakit Pasien</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatperjalananpasien)?$modAnamnesa->riwayatperjalananpasien:" - "; ?></td>
    </tr>
    <?php if($modul !== 6):?>
    <tr>
        <td style="width:30%">Lama sakit</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->lamasakit)?$modAnamnesa->lamasakit:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Penyakit Terdahulu</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatpenyakitterdahulu)?$modAnamnesa->riwayatpenyakitterdahulu:"riwayatpenyakitterdahulu "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Penyakit Keluarga</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatpenyakitkeluarga)?$modAnamnesa->riwayatpenyakitkeluarga:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Alergi Obat</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatalergiobat)?$modAnamnesa->riwayatalergiobat:" - "; ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td style="width:30%">Pengobatan yang sudah dilakukan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->pengobatanygsudahdilakukan)?$modAnamnesa->pengobatanygsudahdilakukan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Alergi Makanan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatmakanan)?$modAnamnesa->riwayatmakanan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Kelahiran</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatkelahiran)?$modAnamnesa->riwayatkelahiran:" - "; ?></td>
    </tr>
    <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurHamil())) { ?>
    <tr>
        <td style="width:30%">Apakah Pasien sedang Hamil</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->ispasienwanitahamil)?$modAnamnesa->ispasienwanitahamil:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Apakah Pasien dalam masa menyusui</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->ispasienwanitamenyusui)?$modAnamnesa->ispasienwanitamenyusui:" - "; ?></td>
    </tr>
    <?php } ?>
    <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurCongenital())) { ?>
    <tr>
        <td style="width:30%">Apakah Pasien memiliki Kelainan Kongenital</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->isbayianak_kelainanconginetal)?$modAnamnesa->isbayianak_kelainanconginetal:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Jenis Kelainan Kongenital</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->kelainanconginetal_jenis)?$modAnamnesa->kelainanconginetal_jenis:" - "; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td style="width:30%">Riwayat Imunisasi</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->riwayatimunisasi)?$modAnamnesa->riwayatimunisasi:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Operasi</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->riwayat_operasi)?$modAnamnesa->riwayat_operasi:" - "; ?></td>
    </tr>
    <?php if($modul !== 6):?>
    <tr>
        <td style="width:30%">Status Rokok</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->statusmerokok) && $modAnamnesa->statusmerokok == 1?"Ya":" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Jumlah Rokok (Batang)</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->jmlrokok_btg_hr)?$modAnamnesa->jmlrokok_btg_hr." per hari":" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Konsumsi Alkohol</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->keb_konsumsialkohol) ? $modAnamnesa->keb_konsumsialkohol : " - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Jumlah Alkohol yang rutin minum</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->jmlalkohol_rutinminum) ? $modAnamnesa->jmlalkohol_rutinminum : " - "; ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td>Kebiasaan Minum</td>
        <td>
            <ul>
                <?php echo $modAnamnesa->keb_minumkopi ? '<li>Kopi</li>' : '' ?>
                <?php echo $modAnamnesa->keb_minumteh ? '<li>Teh</li>' : '' ?>
                <?php echo $modAnamnesa->keb_minumsoda ? '<li>Soda</li>' : '' ?>
            </ul>
        </td>
    </tr>
    <tr>
        <td style="width:30%">Kebiasaan Olahraga Rutin</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keb_olahraga) ? $modAnamnesa->keb_olahraga : " - "; ?></td>
    </tr>
    <tr>
        <td>Gangguan Komunikasi</td>
        <td>
            <ul>
                <?php echo $modAnamnesa->gangguankomunikasi_bahasaindonesia ? '<li>Bahasa Indonesia</li>' : '' ?>
                <?php echo $modAnamnesa->gangguankomunikasi_gangguanpendengaran ? '<li>Gangguan Pendengaran/Tuli</li>' : '' ?>
                <?php echo $modAnamnesa->gangguankomunikasi_gangguanbicara ? '<li>Gangguan Bicara</li>' : '' ?>
                <?php echo $modAnamnesa->gangguankomunikasi_tidakada ? '<li>Tidak Ada</li>' : '' ?>
            </ul>
        </td>
    </tr>
    <tr>
        <td style="width:30%">Apakah pasien pernah diperiksa untuk diagnosa HIV</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->riwayatperiksa_diagnosahiv) ? $modAnamnesa->riwayatperiksa_diagnosahiv : " - "; 
            if ($modAnamnesa->riwayatperiksa_diagnosahiv == "Ya" && !empty($modAnamnesa->riwayatperiksa_diagnosahivhasil)) {
                echo ", Hasil : ".$modAnamnesa->riwayatperiksa_diagnosahivhasil;
            }
        ?></td>
    </tr>
    <tr>
        <td>Apakah Pasien memakai Gigi Palsu & Alat Bantu Dengar</td>
        <td>
            <ul>
                <?php echo $modAnamnesa->ismemakaigigipalsu ? '<li>Gigi Palsu</li>' : '' ?>
                <?php echo $modAnamnesa->ismemakaialatbantudengar ? '<li>Alat Bantu Dengar</li>' : '' ?>
                <?php echo $modAnamnesa->istidakmemakai_gigipalsualatbantudengar ? '<li>Tidak Ada</li>' : '' ?>
            </ul>
        </td>
    </tr>
    <tr>
        <td style="width:30%;height:86px">Keterangan</td>
        <td style="width:70%;height:86px"><?php echo isset($modAnamnesa->keterangananamesa)?$modAnamnesa->keterangananamesa:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%;height:86px">Nama Triase</td>
        <td style="width:70%;height:86px"><?php echo isset($modAnamnesa->triase_id)?$modAnamnesa->triase->triase_nama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%;height:86px">Keterangan Triase</td>
        <td style="width:70%;height:86px"><?php echo isset($modAnamnesa->triase_id)?$modAnamnesa->triase->keterangan_triase:" - "; ?></td>
    </tr>
    <?php if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEBIDANAN): ?>
    <tr>
        <td style="width:30%;height:86px">HPHT</td>
        <td style="width:70%;height:86px"><?php echo !empty($modAnamnesa->hpht)?  MyFormatter::formatDateTimeForUser($modAnamnesa->hpht):" - "; ?></td>
    </tr>	
    <tr>
        <td style="width:30%;height:86px">Tgl. Tafsiran Persalinan</td>
        <td style="width:70%;height:86px"><?php echo !empty($modAnamnesa->tgl_persalinan)?  MyFormatter::formatDateTimeForUser($modAnamnesa->tgl_persalinan):" - "; ?></td>
    </tr>
    <?php endif; ?>
    
</table><br><br><br>

<table width="100%" border="1">
	<tr>
        <th width="20%">Warna Triase</th>
        <th width="20%">Nama Triase</th>
        <th width="20%">Keterangan</th>
    </tr>
	<tr>
        <td width="20%" style="background-color: #<?php echo !empty($modAnamnesa->triase_id)?$modAnamnesa->triase->kode_warnatriase:" - "; ?>"></td>
        <td width="20%"><?php echo !empty($modAnamnesa->triase_id)?$modAnamnesa->triase->triase_nama:" - "; ?></td>
        <td width="60%"><?php echo !empty($modAnamnesa->triase_id)?$modAnamnesa->triase->keterangan_triase:" - "; ?></td>
    </tr>
</table>
<br>
<?php if ($modAnamnesa->skrining_dewasa): ?>
            
        <div style="text-align: center">SKRINING GIZI DEWASA</div>
        <table width="100%" class="tab_skrining">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Kriteria.</th>
                    <th colspan="2">Jawaban</th>
                </tr>
                <tr>
                    <th>Ya<br>Skor=1</th>
                    <th>Tidak<br>Skor=0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10">1</td>
                    <td>Apakah IMT < 20,5 atau LLA < 25 cm untuk wanita dan LLA < 26,3 cm untuk pria ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria1 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria1 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah pasien kehilangan BB dalam 3 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria2 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria2 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah asupan makan pasien menurun hingga 1 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria3 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria3 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah pasien dengan penyakit berat dan atau membutuhkan terapi gizi ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria4 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria4 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SKOR</td>
                    <td colspan="2" style="text-align: right;"><?php echo $modAnamnesa->skrining_dewasa_skor ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">HASIL : <?php echo $modAnamnesa->skrining_dewasa_hasil; ?></td>
                </tr>

            </tfoot>
        </table>

        <?php endif; ?>

        <?php if ($modAnamnesa->anamnesa_anak) {
            echo $this->renderPartial('/_periksaDataPasien/_anamnesa_anak', array(
                'modAnamnesa'=>$modAnamnesa,
            ), true);
        } ?>

        <?php if ($modAnamnesa->skrining_anak): ?>
        <div style="text-align: center">SKRINING GIZI ANAK</div>
        <table width="100%" class="tab_skrining">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Kriteria.</th>
                    <th colspan="2">Jawaban</th>
                </tr>
                <tr>
                    <th>Ya<br>Skor=1</th>
                    <th>Tidak<br>Skor=0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10">1</td>
                    <td>Apakah IMT anak berada dibawah nilai cut-off tabel IMT rujukan ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria1 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria1 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah anak mengalami penurunan berat badan akhir-akhir ini ? (Seperti penurunan BB Tidak disengaja, baju menjadi lebih longgar, kenaikan BB tidak signifikan (jika <2 tahun))</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria2 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria2 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah anak mengalami penurunan intake makanan (termasuk ASI dan susu formula) setidaknya selama 1 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria3 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria3 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah status gizi anak akan dipengaruhi oleh penyakit/kondisi kesehatan setidaknya untuk 1 minggu kedepan ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria4 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria4 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SKOR</td>
                    <td colspan="2" style="text-align: right;"><?php echo $modAnamnesa->skrining_anak_skor; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">HASIL : <?php echo $modAnamnesa->skrining_anak_hasil; ?></td>
                </tr>

            </tfoot>
        </table>

<?php endif; ?>
        
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle">Pasien / Keluarga pasien</td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".date('d - M - Y'); ?><br>Dokter Pemeriksa</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle"></td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php echo (isset($modPendaftaran->pegawai->gelardepan)?$modPendaftaran->pegawai->gelardepan:'').' '.$modPendaftaran->pegawai->nama_pegawai.' '.(isset($modPendaftaran->pegawai->gelarbelakang_nama)?$modPendaftaran->pegawai->gelarbelakang_nama:''); ?></td>
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



