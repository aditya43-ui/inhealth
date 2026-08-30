<style>
    
    
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .anamnesa_content td{
        height: 48px;
        border: 1px solid black;
    }
    
    
    .tab_skrining {
        margin-right: 10px;
    }
    
    .tab_skrining th, .tab_skrining td {
        color: black;
        border: 1px solid black;
        padding: 2px;
    }
    
    .tab_skrining th {
        text-align: center;
        font-weight: bold;
    }
    
    .tab_skrining tfoot td {
        font-weight: bold;
    }
    
</style>
<table width="100%" border="0" class="anamnesa_content">
<?php 
if (count((array)$modAnamnesa)>0){
foreach ($modAnamnesa as $i => $loop){
?>
    <tr>
        <td align="center" valign="middle" colspan="7" style="font-weight:bold; border-top: 2px solid black; font-size: 14pt !important;">
            ANAMNESIS
        </td>
    </tr>
    <tr>
        <td style="width:20%">Nama Dokter</td>
        <td style="width:30%">: <?php /* echo count((array)$modAnamnesa); */ echo  (isset($loop->pegawai_id) ? $loop->pegawai->nama_pegawai :"-"); ?></td>
        <td style="width:20%">Tanggal Anamnesis</td>
        <td style="width:30%">: <?php echo (isset($loop->tglanamnesis) ? MyFormatter::formatDateTimeForUser($loop->tglanamnesis) :"-"); ?></td>
    </tr>
    <tr>
        <td>Perawat</td>
        <td>: <?php echo isset($loop->paramedis_nama)?$loop->paramedis_nama:" - "; ?></td>
        <td>Riwayat Penyakit Keluarga</td>
        <td>: <?php echo isset($loop->riwayatpenyakitkeluarga)?$loop->riwayatpenyakitkeluarga:" - "; ?></td>
    </tr>
    <tr>
        <td>Keluhan Utama</td>
        <td>: <?php echo isset($loop->keluhanutama)?$loop->keluhanutama:" - "; ?></td>
        <td>Riwayat Perjalanan Pasien</td>
        <td>: <?php echo isset($loop->riwayatperjalananpasien)?$loop->riwayatperjalananpasien:" - "; ?></td>
    </tr>
    <tr>
        <td>Keluhan Tambahan</td>
        <td>: <?php echo isset($loop->keluhantambahan)?$loop->keluhantambahan:" - "; ?></td>
        <td>Pengobatan Dilakukan</td>
        <td>: <?php echo isset($loop->pengobatanygsudahdilakukan)?$loop->pengobatanygsudahdilakukan:" - "; ?></td>
    </tr>
    <tr>
        <td>Lama sakit</td>
        <td>: <?php echo isset($loop->lamasakit)?$loop->lamasakit:" - "; ?></td>
        <td>Riwayat Alergi Makanan</td>
        <td>: <?php echo isset($loop->riwayatmakanan)?$loop->riwayatmakanan:" - "; ?></td>
    </tr>
    <tr>
        <td>Riwayat Alergi Obat</td>
        <td>: <?php echo isset($loop->riwayatalergiobat)?$loop->riwayatalergiobat:" - "; ?></td>
        <td>Riwayat Imunisasi</td>
        <td>: <?php echo isset($loop->riwayatimunisasi)?$loop->riwayatimunisasi:" - "; ?></td>
    </tr>
    <tr>
        <td>Riwayat Kelahiran</td>
        <td>: <?php echo isset($loop->riwayatkelahiran)?$loop->riwayatkelahiran:" - "; ?></td>
        <td>Riwayat Penyakit Terdahulu</td>
        <td>: <?php echo (isset($loop->riwayatpenyakitterdahulu)?$loop->riwayatpenyakitterdahulu:"-"); ?></td>
    </tr>
    <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurHamil())) { ?>
    <tr>
        <td>Apakah Pasien sedang Hamil</td>
        <td>: <?php echo !empty($loop->ispasienwanitahamil)?$loop->ispasienwanitahamil:" - "; ?></td>
        <td>Apakah Pasien dalam masa menyusui</td>
        <td>: <?php echo !empty($loop->ispasienwanitamenyusui)?$loop->ispasienwanitamenyusui:" - "; ?></td>
    </tr>
    <?php } ?>
    <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurCongenital())) { ?>
    <tr>
        <td>Apakah Pasien memiliki Kelainan Kongenital</td>
        <td>: <?php echo !empty($loop->isbayianak_kelainanconginetal)?$loop->isbayianak_kelainanconginetal:" - "; ?></td>
        <td>Jenis Kelainan Kongenital</td>
        <td>: <?php echo !empty($loop->kelainanconginetal_jenis)?$loop->kelainanconginetal_jenis:" - "; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td>Status Rokok</td>
        <td>: <?php echo isset($loop->statusmerokok) && $loop->statusmerokok == 1?"Ya":" - "; ?></td>
        <td>Jumlah Rokok (Batang)</td>
        <td>: <?php echo isset($loop->jmlrokok_btg_hr)?$loop->jmlrokok_btg_hr." per hari":" - "; ?></td>
    </tr>
    <tr>
        <td>Apakah Pasien memakai Gigi Palsu & Alat Bantu Dengar</td>
        td>Riwayat Operasi</td>
        <td>: <?php echo !empty($loop->riwayat_operasi)?$loop->riwayat_operasi:" - "; ?></td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td>Konsumsi Alkohol</td>
        <td>: <?php echo !empty($loop->keb_konsumsialkohol) ? $loop->keb_konsumsialkohol : " - "; ?></td>
        <td>Jumlah Alkohol yang rutin minum</td>
        <td>: <?php echo !empty($loop->jmlalkohol_rutinminum) ? $loop->jmlalkohol_rutinminum : " - "; ?></td>
    </tr>
    <tr>
        <td>Kebiasaan Minum</td>
        <td>
            <ul>
                <?php echo $loop->keb_minumkopi ? '<li>Kopi</li>' : '' ?>
                <?php echo $loop->keb_minumteh ? '<li>Teh</li>' : '' ?>
                <?php echo $loop->keb_minumsoda ? '<li>Soda</li>' : '' ?>
            </ul>
        </td>
        <td>Kebiasaan Olahraga Rutin</td>
        <td>: <?php echo isset($loop->keb_olahraga) ? $loop->keb_olahraga : " - "; ?></td>
    </tr>
    <tr>
        <td>Gangguan Komunikasi</td>
        <td>
            <ul>
                <?php echo $loop->gangguankomunikasi_bahasaindonesia ? '<li>Bahasa Indonesia</li>' : '' ?>
                <?php echo $loop->gangguankomunikasi_gangguanpendengaran ? '<li>Gangguan Pendengaran/Tuli</li>' : '' ?>
                <?php echo $loop->gangguankomunikasi_gangguanbicara ? '<li>Gangguan Bicara</li>' : '' ?>
                <?php echo $loop->gangguankomunikasi_tidakada ? '<li>Tidak Ada</li>' : '' ?>
            </ul>
        </td>
        <td>Apakah pasien pernah diperiksa untuk diagnosa HIV</td>
        <td>: <?php echo !empty($loop->riwayatperiksa_diagnosahiv) ? $loop->riwayatperiksa_diagnosahiv : " - "; 
            if ($loop->riwayatperiksa_diagnosahiv == "Ya" && !empty($loop->riwayatperiksa_diagnosahivhasil)) {
                echo ", Hasil : ".$loop->riwayatperiksa_diagnosahivhasil;
            }
        ?></td>
    </tr>
    <tr>
        <td>Apakah Pasien memakai Gigi Palsu & Alat Bantu Dengar</td>
        <td>
            <ul>
                <?php echo $loop->ismemakaigigipalsu ? '<li>Gigi Palsu</li>' : '' ?>
                <?php echo $loop->ismemakaialatbantudengar ? '<li>Alat Bantu Dengar</li>' : '' ?>
                <?php echo $loop->istidakmemakai_gigipalsualatbantudengar ? '<li>Tidak Ada</li>' : '' ?>
            </ul>
        </td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td style="height:86px">Keterangan</td>
        <td style="height:86px" colspan="3"><div style="float: left;">: </div> <?php echo isset($loop->keterangananamesa)?$loop->keterangananamesa:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="4" style="padding-right: 10px;">
            <?php if ($loop->skrining_dewasa): ?>
            
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
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_dewasa_kriteria1 == true ? '<i class="entypo-check">' : '' ?></td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_dewasa_kriteria1 == false ? '<i class="entypo-check">' : '' ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Apakah pasien kehilangan BB dalam 3 minggu terakhir ?</td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_dewasa_kriteria2 == true ? '<i class="entypo-check">' : '' ?></td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_dewasa_kriteria2 == false ? '<i class="entypo-check">' : '' ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Apakah asupan makan pasien menurun hingga 1 minggu terakhir ?</td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_dewasa_kriteria3 == true ? '<i class="entypo-check">' : '' ?></td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_dewasa_kriteria3 == false ? '<i class="entypo-check">' : '' ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Apakah pasien dengan penyakit berat dan atau membutuhkan terapi gizi ?</td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_dewasa_kriteria4 == true ? '<i class="entypo-check">' : '' ?></td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_dewasa_kriteria4 == false ? '<i class="entypo-check">' : '' ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>TOTAL SKOR</td>
                        <td colspan="2" style="text-align: right;"><?php echo $loop->skrining_dewasa_skor ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3">HASIL : <?php echo $loop->skrining_dewasa_hasil; ?></td>
                    </tr>

                </tfoot>
            </table>
            
            <?php endif; ?>
            
            <?php if ($loop->anamnesa_anak) {
                echo $this->renderPartial('/_periksaDataPasien/_anamnesa_anak', array(
                    'modAnamnesa'=>$loop,
                ), true);
            } ?>
            
            <?php if ($loop->skrining_anak): ?>
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
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_anak_kriteria1 == true ? '<i class="entypo-check">' : ''; ?></td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_anak_kriteria1 == false ? '<i class="entypo-check">' : ''; ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Apakah anak mengalami penurunan berat badan akhir-akhir ini ? (Seperti penurunan BB Tidak disengaja, baju menjadi lebih longgar, kenaikan BB tidak signifikan (jika <2 tahun))</td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_anak_kriteria2 == true ? '<i class="entypo-check">' : ''; ?></td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_anak_kriteria2 == false ? '<i class="entypo-check">' : ''; ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Apakah anak mengalami penurunan intake makanan (termasuk ASI dan susu formula) setidaknya selama 1 minggu terakhir ?</td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_anak_kriteria3 == true ? '<i class="entypo-check">' : ''; ?></td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_anak_kriteria3 == false ? '<i class="entypo-check">' : ''; ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Apakah status gizi anak akan dipengaruhi oleh penyakit/kondisi kesehatan setidaknya untuk 1 minggu kedepan ?</td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_anak_kriteria4 == true ? '<i class="entypo-check">' : ''; ?></td>
                        <td class="pilih_center" width="50"><?php echo $loop->skrining_anak_kriteria4 == false ? '<i class="entypo-check">' : ''; ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>TOTAL SKOR</td>
                        <td colspan="2" style="text-align: right;"><?php echo $loop->skrining_anak_skor; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3">HASIL : <?php echo $loop->skrining_anak_hasil; ?></td>
                    </tr>

                </tfoot>
            </table>
            
            <?php endif; ?>
            <br>
        </td>
    </tr>
    <tr><td colspan="6" style="font-weight: bold; border-top: 1px; border-bottom: 2px solid black; height: auto; padding: 5px; vertical-align: bottom !important;">
            <div class="pull-left">
                Dibuat Oleh : <?php 
                $login = LoginpemakaiK::model()->findByPk($loop->create_loginpemakai_id);
                if (!empty($login->pegawai)) {
                    echo $login->pegawai->namaLengkap;
                } else {
                    echo $login->nama_pemakai;
                }

                ?>
                
            </div>
            <div class="pull-right" style="text-align: right;">
                <?php 
//                if (!empty($loop->dokterverifikasi_id)) {
//                    echo "SUDAH DIVERIFIKASI<br>Oleh ";
//                    $peg = PegawaiM::model()->findByPk($loop->dokterverifikasi_id);
//                    echo $peg->namaLengkap;
//                } else {
//                    $peg_id = $modPendaftaran->pegawai_id == Yii::app()->user->getState('pegawai_id');
//                    $ruangan = RuanganM::model()->findByPk($loop->create_ruangan);
//                    
//                    if (!empty($loop->pasienadmisi_id)) {
//                        $admisi = PasienadmisiT::model()->findByPk($loop->pasienadmisi_id);
//                        
//                        $peg_id = $admisi->pegawai_id == Yii::app()->user->getState('pegawai_id')
//                                || $admisi->dpjp2_id == Yii::app()->user->getState('pegawai_id')
//                                || $admisi->dpjp3_id == Yii::app()->user->getState('pegawai_id');
//                    }
//                    
//                    if ($peg_id) {
//                        echo CHtml::htmlButton('<i class="entypo-check"></i> Verifikasi', array(
//                            'class'=>'btn btn-primary',
//                            'onclick'=>'verifikasiAnamnesa('.$loop->anamesa_id.');',
//                            'rel'=>'tooltip', 'title'=>'Klik untuk verifikasi Anamnesa Ini',
//                        ));
//                    } else {
//                        echo "BELUM DIVERIFIKASI";
//                    }
//                } 
                ?>
            </div>
    </td>
    </tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada pemeriksaan anamnesis</td>
    </tr> 
<?php } ?>
</table>