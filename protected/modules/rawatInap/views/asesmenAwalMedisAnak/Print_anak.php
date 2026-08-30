<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
@page {
       size: 7in 9.25in;
       font-size: 11px !important;
       padding-top: 20px;
       margin-top: 0px;
       margin-bottom: 0px;
    }
    @media print {
        html, body {
            padding-top: 20px;
            width: 210mm;
            height: 297mm;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }
    @media all {
    .page-break { display: none; }
    }

    @media print {
    .page-break { display: block; page-break-before: always; }
    }
</style>
<?php $titik = "...................................................................................."; ?>
<?php $titik5 = "....."; ?>
<table width="100%" border="1px">
    <tr>
        <td rowspan="3" style="width:65%"><?php echo $this->renderPartial('rawatInap.views.asesmenAwalKeperawatan._headerPrint'); ?></td>
        <td style="width:15%" border-top="1px">Nama Lengkap</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Tgl. Lahir </td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:15%">No. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    
</table>
<span style="float:right; padding-top: 10px;"><h4>RM 05 RJ</h4></span>
<div style="padding-top: 10px; padding-bottom: 10px; text-align:center; font-weight:bold">
    <h4 style='padding-left:35px'>ASESMEN AWAL MEDIS ANAK (USIA 1 BULAN - 18 TAHUN)</h4><br>
    <h5><i>MEDICAL INITIAL ASSESMENT</i></h5>
</div>
<table width="100%" class="table-condensed" border="1px">
    <tr style="background-color:#afdc7e">
        <td  colspan='5'><b>Diisi oleh Dokter</b></td>
    </tr>
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td>Tanggal & Jam Masuk Ruangan</td>
                    <td>: <?php echo date('d ', strtotime($model->tglmasuk_rs)).MyFormatter::getMonthId(date('m', strtotime($model->tglmasuk_rs))).date(' Y', strtotime($model->tglmasuk_rs));?>  <?php echo date('H:i', strtotime($model->tglmasuk_rs)); ?> WIB</td>
                </tr>
                <tr>
                    <td>Waktu pemeriksaan</td>
                    <td>: Tanggal : <?php echo date('d ', strtotime($model->tgl_pemeriksaan)).MyFormatter::getMonthId(date('m', strtotime($model->tgl_pemeriksaan))).date(' Y', strtotime($model->tgl_pemeriksaan));?>, 
                              Jam : <?php echo date('H:i', strtotime($model->tgl_pemeriksaan)); ?> WIB, Nama DPJP : <?php echo !empty($model->dokterdpjp_id) ? $model->dokterdpjp->namaLengkap : '-'; ?>
                    </td>
                </tr>
                <tr>
                    <td>Cara Masuk</td>
                    <td>: 
                        <?php 
                        if($model->pasiendari_irj == true){ 
                            echo " <span class='fa fa-check-square-o'></span> IRJ &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> IRJ &nbsp;&nbsp;";
                        } 
                        
                        if($model->pasiendari_igd == true){ 
                            echo " <span class='fa fa-check-square-o'></span> IGD &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> IGD &nbsp;&nbsp;";
                        } 
                        
                        if($model->pasiendari_rujukan == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Rujukan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Rujukan &nbsp;&nbsp;";
                        } 
                        
                        if($model->pasiendari_lainnya == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Lain-lain : ";echo !empty($model->pasiendari_lainnya_keterangan) ? $model->pasiendari_lainnya_keterangan : '-';
                        }else{
                            echo " <span class='fa fa-square-o'></span> Lain-lain : "; echo !empty($model->pasiendari_lainnya_keterangan) ? $model->pasiendari_lainnya_keterangan : '-';
                        } 
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Diagnosa masuk RS</td>
                    <td>: <?= DiagnosaM::model()->find('diagnosa_id='.$model->diagnosa_id)->diagnosa_nama; ?></td>
                </tr>
                <tr>
                    <td>Alasan dirawat</td>
                    <td>: 
                        <?php 
                        if($model->alasandirawat_observasi == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Observasi &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Observasi &nbsp;&nbsp;";
                        } 
                        
                        if($model->alasandirawat_prosesdiagnostik == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Proses diagnostik &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Proses diagnostik &nbsp;&nbsp;";
                        } 
                        
                        if($model->alasandirawat_terapi == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Terapi &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Terapi &nbsp;&nbsp;";
                        } 
                        
                        if($model->alasandirawat_rehabilitasi == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Rehabilitasi &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Rehabilitasi &nbsp;&nbsp;";
                        } 
                        
                        ?>
                    </td>
                </tr>
            </table>          
        </td>
    </tr>
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td>Keluhan Utama</td>
                    <td>: <?php echo !empty($model->keluhan_utama) ? $model->keluhan_utama : '-' ?></td>   
                </tr>
                <tr>
                    <td>Riwayat Penyakit Sekarang</td>
                    <td height="80">: <?php echo !empty($model->riwayat_penyakit_sekarang) ? $model->riwayat_penyakit_sekarang : $titik ?></td>   
                </tr>
                <tr>
                    <td>Riwayat penyakit dahulu</td>
                    <td>: 
                        <?php 
                        if($model->riwayat_sakit_dulu_diabetes == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Diabetes &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Diabetes &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_sakit_dulu_hipertensi == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Hipertensi &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Hipertensi &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_sakit_dulu_jantung == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Penyakit Jantung &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Penyakit Jantung &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_sakit_dulu_tidakada == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak ada &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak ada &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_sakit_dulu_lainnya == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Lainnya : "; echo !empty($model->riwayat_sakit_dulu_lainnya_ket) ? $model->riwayat_sakit_dulu_lainnya_ket : '-';
                        }else{
                            echo " <span class='fa fa-square-o'></span> Lainnya : "; echo !empty($model->riwayat_sakit_dulu_lainnya_ket) ? $model->riwayat_sakit_dulu_lainnya_ket : '-';
                        }
                        ?>
                    </td>   
                </tr>
                <tr>
                    <td>Riwayat penyakit keluarga</td>
                    <td>: 
                        <?php 
                        if($model->riwayat_sakit_keluarga_diabetes == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Diabetes &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Diabetes &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_sakit_keluarga_hipertensi == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Hipertensi &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Hipertensi &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_sakit_keluarga_jantung == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Penyakit Jantung &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Penyakit Jantung &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_sakit_keluarga_tidakada == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak ada &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak ada &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_sakit_keluarga_lainnya == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Lainnya : "; echo !empty($model->riwayat_sakit_keluarga_lainnya_ket) ? $model->riwayat_sakit_keluarga_lainnya_ket : '-';
                        }else{
                            echo " <span class='fa fa-square-o'></span> Lainnya : "; echo !empty($model->riwayat_sakit_keluarga_lainnya_ket) ? $model->riwayat_sakit_keluarga_lainnya_ket : '-';
                        }
                        ?>
                    </td>   
                </tr>
                <tr>
                    <td>Riwayat Imunisasi</td>
                    <td>: 
                        <?php 
                        if($model->riwayat_imunisasi_bcg == true){ 
                            echo " <span class='fa fa-check-square-o'></span> BCG &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> BCG &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_imunisasi_polio == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Polio "; echo !empty($model->riwayat_imunisasi_polio_ket) ? $model->riwayat_imunisasi_polio_ket : $titik5; echo " kali &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Polio "; echo !empty($model->riwayat_imunisasi_polio_ket) ? $model->riwayat_imunisasi_polio_ket : $titik5; echo " kali &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_imunisasi_hepatitisb == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Hepatitis B "; echo !empty($model->riwayat_imunisasi_hepatitisb) ? $model->riwayat_imunisasi_hepatitisb : $titik5; echo " kali &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Hepatitis B "; echo !empty($model->riwayat_imunisasi_hepatitisb) ? $model->riwayat_imunisasi_hepatitisb : $titik5; echo " kali &nbsp;&nbsp;";
                        } 
                        if($model->riwayat_imunisasi_dpt == true){ 
                            echo " <span class='fa fa-check-square-o'></span> DPT "; echo !empty($model->riwayat_imunisasi_dpt) ? $model->riwayat_imunisasi_dpt : $titik5; echo " kali &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> DPT "; echo !empty($model->riwayat_imunisasi_dpt) ? $model->riwayat_imunisasi_dpt : $titik5; echo " kali &nbsp;&nbsp;";
                        } 
                        ?>
                    </td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;
                        <?php 
                        if($model->riwayat_imunisasi_campak == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Campak "; echo !empty($model->riwayat_imunisasi_campak) ? $model->riwayat_imunisasi_campak : $titik5; echo " kali &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Campak "; echo !empty($model->riwayat_imunisasi_campak) ? $model->riwayat_imunisasi_campak : $titik5; echo " kali &nbsp;&nbsp;";
                        } 

                        if($model->riwayat_imunisasi_lainnya == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Lainnya "; echo !empty($model->riwayat_imunisasi_lainnya) ? $model->riwayat_imunisasi_lainnya : $titik5; echo " kali &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Lainnya "; echo !empty($model->riwayat_imunisasi_lainnya) ? $model->riwayat_imunisasi_lainnya : $titik5; echo " kali &nbsp;&nbsp;";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Riwayat Persalinan</td>
                    <td>:
                        <?php 
                        if($model->riwayat_persalinan_normal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_persalinan_vacum == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Vacum";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Vacum";
                        }
                        if($model->riwayat_persalinan_forceps == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Forceps";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Forceps";
                        }
                        if($model->riwayat_persalinan_sc == true){ 
                            echo " <span class='fa fa-check-square-o'></span> SC";
                        }else{
                            echo " <span class='fa fa-square-o'></span> SC";
                        }
                        ?>
                    </td>   
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;
                        a. Ditolong oleh : 
                        <?php 
                        if($model->riwayat_persalinan_olehdokter == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Dokter &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Dokter &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_persalinan_olehbidan == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Bidan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Bidan &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_persalinan_olehlainnya == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Lainnya : "; echo !empty($model->riwayat_persalinan_olehlainnya_ket) ? $model->riwayat_persalinan_olehlainnya_ket : $titik5; 
                        }else{
                            echo " <span class='fa fa-square-o'></span> Lainnya : "; echo !empty($model->riwayat_persalinan_olehlainnya_ket) ? $model->riwayat_persalinan_olehlainnya_ket : $titik5; 
                        } 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;
                        b. Berat badan <?= !empty($model->riwayat_persalinan_beratbadan) ? $model->riwayat_persalinan_beratbadan : $titik5;  ?> gram, Panjang/tinggi badan <?= !empty($model->riwayat_persalinan_tinggibadan) ? $model->riwayat_persalinan_tinggibadan : $titik5;  ?> cm, Lingkar Kepala <?= !empty($model->riwayat_persalinan_lingkarkepala) ? $model->riwayat_persalinan_lingkarkepala : $titik5;  ?> cm
                    </td>   
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;
                        c. Keadaan saat lahir :
                        <?php 
                        if($model->riwayat_persalinan_segeramenangis == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Segera menangis &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Segera menangis &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_persalinan_tidaksegeramenangis == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak segera menangis &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak segera menangis &nbsp;&nbsp;";
                        } 
                         
                        ?>
                    </td>   
                </tr>
                <tr>
                    <td>Riwayat nutrisi</td>
                    <td>: a. ASI: Eksklusif <?= !empty($model->riwayat_nutrisi_asi_eksklusif) ? $model->riwayat_nutrisi_asi_eksklusif : $titik5 ?> bulan, Durasi <?= !empty($model->riwayat_nutrisi_asi_durasi) ? $model->riwayat_nutrisi_asi_durasi : $titik5 ?> bulan, Frekuensi <?= !empty($model->riwayat_nutrisi_asi_frekuensi) ? $model->riwayat_nutrisi_asi_frekuensi : $titik5 ?> kali/hari</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp; b. Susu formula : Sejak usia <?= !empty($model->riwayat_nutrisi_susuformula_usia) ? $model->riwayat_nutrisi_susuformula_usia : $titik5 ?> bulan, Frekuensi <?= !empty($model->riwayat_nutrisi_susuformula_usia) ? $model->riwayat_nutrisi_susuformula_frekuensi : $titik5 ?> kali/hari</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp; c. Bubur susu : Sejak usia <?= !empty($model->riwayat_nutrisi_bubutsusu_usia) ? $model->riwayat_nutrisi_bubutsusu_usia : $titik5 ?> bulan, Frekuensi <?= !empty($model->riwayat_nutrisi_bubursusu_frekuensi) ? $model->riwayat_nutrisi_bubursusu_frekuensi : $titik5 ?> kali/hari</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp; d. Nasi tim : Sejak usia <?= !empty($model->riwayat_nutrisi_nasitim_usia) ? $model->riwayat_nutrisi_nasitim_usia : $titik5 ?> bulan, Frekuensi <?= !empty($model->riwayat_nutrisi_nasitim_frekuensi) ? $model->riwayat_nutrisi_nasitim_frekuensi : $titik5 ?> kali/hari</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp; e. Makanan dewasa : Sejak usia <?= !empty($model->riwayat_nutrisi_makanandewasa_usia) ? $model->riwayat_nutrisi_makanandewasa_usia : $titik5 ?> bulan, Frekuensi <?= !empty($model->riwayat_nutrisi_makanandewasa_frekuensi) ? $model->riwayat_nutrisi_makanandewasa_frekuensi : $titik5 ?> kali/hari</td>
                </tr>
                <tr>
                    <td>Riwayat tumbuh kembang</td>
                    <td>: 
                        <?php 
                        if($model->riwayat_tumbuhkembang_menegakkankepala == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Menegakkan kepala "; echo !empty($model->riwayat_tumbuhkembang_menegakkankepala_ket) ? $model->riwayat_tumbuhkembang_menegakkankepala_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Menegakkan kepala "; echo !empty($model->riwayat_tumbuhkembang_menegakkankepala_ket) ? $model->riwayat_tumbuhkembang_menegakkankepala_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_tumbuhkembang_membalikbadan == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Membalik badan "; echo !empty($model->riwayat_tumbuhkembang_membalikbadan_ket) ? $model->riwayat_tumbuhkembang_membalikbadan_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Membalik badan "; echo !empty($model->riwayat_tumbuhkembang_membalikbadan_ket) ? $model->riwayat_tumbuhkembang_membalikbadan_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        } 
                        if($model->riwayat_tumbuhkembang_duduk == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Duduk "; echo !empty($model->riwayat_tumbuhkembang_duduk_ket) ? $model->riwayat_tumbuhkembang_duduk_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Duduk "; echo !empty($model->riwayat_tumbuhkembang_duduk_ket) ? $model->riwayat_tumbuhkembang_duduk_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        } 
                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;
                        <?php 
                        if($model->riwayat_tumbuhkembang_merangkak == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Merangkak "; echo !empty($model->riwayat_tumbuhkembang_merangkak_ket) ? $model->riwayat_tumbuhkembang_merangkak_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Merangkak "; echo !empty($model->riwayat_tumbuhkembang_merangkak_ket) ? $model->riwayat_tumbuhkembang_merangkak_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        } 
                        
                        if($model->riwayat_tumbuhkembang_berdiri == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Berdiri "; echo !empty($model->riwayat_tumbuhkembang_berdiri_ket) ? $model->riwayat_tumbuhkembang_berdiri_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Berdiri "; echo !empty($model->riwayat_tumbuhkembang_berdiri_ket) ? $model->riwayat_tumbuhkembang_berdiri_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        } 
                        if($model->riwayat_tumbuhkembang_berjalan == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Berjalan "; echo !empty($model->riwayat_tumbuhkembang_berjalan_ket) ? $model->riwayat_tumbuhkembang_berjalan_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Berjalan "; echo !empty($model->riwayat_tumbuhkembang_berjalan_ket) ? $model->riwayat_tumbuhkembang_berjalan_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }
                        if($model->riwayat_tumbuhkembang_bicara == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Bicara "; echo !empty($model->riwayat_tumbuhkembang_bicara_ket) ? $model->riwayat_tumbuhkembang_bicara_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Bicara "; echo !empty($model->riwayat_tumbuhkembang_bicara_ket) ? $model->riwayat_tumbuhkembang_bicara_ket : $titik5; echo " bulan &nbsp;&nbsp;";
                        }
                         
                        ?>
                    </td>
                </tr>
            </table> 
        </td>
    </tr>
<tr>
<table width="100%" class="table-condensed">
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td>Riwayat Pengobatan Sebelummnya</td>
                    <td>:</td>   
                </tr>
            </table> 
        </td>
    </tr>
</table>
<table width="100%" class="table-condensed" border="1px solid">
    <thead>
        <th>Nama Obat</th>
        <th>Dosis</th>
        <th>Cara Pemberian</th>
        <th>Waktu & Tanggal<br>Terakhir Diberikan</th>
    </thead>
    <tbody>
    <?php
        if (!empty($modObat)){
            foreach($modObat as $val){
    ?>
        <tr>
            <td><?php echo $val->nama_obat; ?></td>
            <td style="text-align:center"><?php echo $val->dosis_obat; ?></td>
            <td><?php echo $val->carapemberian; ?></td>
            <td style="text-align:center"><?php echo !empty($val->tglpemberian)? MyFormatter::formatDateTimeForUser($val->tglpemberian):''; ?></td>
        </tr>
    <?php
            }
        }else{
    ?>
        <tr>
            <td style="text-align:center" height="80"><?php echo '-' ?></td>
            <td style="text-align:center"><?php echo '-' ?></td>
            <td style="text-align:center"><?php echo '-' ?></td>
            <td style="text-align:center"><?php echo '-' ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<table width="100%" class="table-condensed">
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td style="color:red">Alergi</td>
                    <td>:</td>   
                </tr>
                <tr>
                    <td>
                        <?php 
                            if($model->riwayatalergi_obat == true) {
                                echo !empty($model->riwayatalergi_obatket) ? $model->riwayatalergi_obatket : "-";
                            }else {
                                echo '';
                            }
                        ?>
                    </td>   
                </tr>
                <tr>
                    <td>
                        <?php 
                            if($model->riwayatalergi_makanan == true) {
                                echo !empty($model->riwayatalergi_makananket) ? $model->riwayatalergi_makananket : "";
                            }else {
                                echo '';
                            }
                        ?>
                    </td>
                </tr>
            </table> 
        </td>
    </tr>
</table>
<table width="100%" class="table-condensed" border="1px">
    <tr>
        <td colspan='5'>
            <table>
    <tr>
        <td><b>Pemeriksaan Umum</b></td>
        <td></td>   
    </tr>
    <tr>
        <td>Kesadaran Kualitatif</td>
        <td>:
            <?php 
            if($model->kesadarankualitatif_composmentis == true){ 
                echo " <span class='fa fa-check-square-o'></span> Compos mentis &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Compos mentis &nbsp;&nbsp;";
            } 

            if($model->kesadarankualitatif_apatis == true){ 
                echo " <span class='fa fa-check-square-o'></span> Apatis &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Apatis &nbsp;&nbsp;";
            } 

            if($model->kesadarankualitatif_delirum == true){ 
                echo " <span class='fa fa-check-square-o'></span> Delirium &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Delirium &nbsp;&nbsp;";
            } 

            if($model->kesadarankualitatif_koma == true){ 
                echo " <span class='fa fa-check-square-o'></span> Koma &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Koma &nbsp;&nbsp;";
            }  
            ?>
        </td>   
    </tr>
    <tr>
        <td colspan="2">Kesadaran Kuantitatif (skala koma glasgow) : 
            E : <?php echo !empty($model->kesadarankuantitatif_gcs_eye) ? $model->kesadarankuantitatif_gcs_eye : ' - '; ?> ,
            V : <?php echo !empty($model->kesadarankuantitatif_gcs_verbal) ? $model->kesadarankuantitatif_gcs_verbal : ' - '; ?> ,
            M : <?php echo !empty($model->kesadarankuantitatif_gcs_motorik) ? $model->kesadarankuantitatif_gcs_motorik : ' - '; ?>
        </td>
    </tr>
    <tr>
        <td>Berat badan</td>   
        <td>:   <?php echo !empty($model->beratbadan) ? $model->beratbadan : ' - '; ?> kg,
            Tinggi badan : <?php echo !empty($model->tinggibadan) ? $model->tinggibadan : ' - '; ?> cm,
              Luas badan : <?php echo !empty($model->luasbadan) ? $model->luasbadan : ' - '; ?> kg/m2
        </td>
    </tr>
    <tr>
        <td>Kondisi khusus</td>
        <td>:
            <?php 
            if($model->kondisikhusus_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->kondisikhusus_anemis == true){ 
                echo " <span class='fa fa-check-square-o'></span> Anemis &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Anemis &nbsp;&nbsp;";
            } 

            if($model->kondisikhusus_icterus == true){ 
                echo " <span class='fa fa-check-square-o'></span> Icterus &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Icterus &nbsp;&nbsp;";
            } 

            if($model->kondisikhusus_sianosis == true){ 
                echo " <span class='fa fa-check-square-o'></span> Sianosis &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Sianosis &nbsp;&nbsp;";
            }  

            if($model->kondisikhusus_lainnya == true){ 
                echo " <span class='fa fa-check-square-o'></span> Lainnya : "; echo !empty($model->kondisikhusus_lainnya_ket) ? $model->kondisikhusus_lainnya_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Lainnya : "; echo !empty($model->kondisikhusus_lainnya_ket) ? $model->kondisikhusus_lainnya_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Tekanan darah</td>   
        <td>: <?php echo !empty($model->tekanandarah_sistolok) ? $model->tekanandarah_sistolok : ' - '; ?> / <?php echo !empty($model->tekanandarah_diastolik) ? $model->tekanandarah_diastolik : ' - '; ?> mmHg,
            Nadi : <?php echo !empty($model->nadi) ? $model->nadi : ' - '; ?> x/mnt,
      Pernapasan : <?php echo !empty($model->pernafasan) ? $model->pernafasan : ' - '; ?> x/mnt,
            Suhu : <?php echo !empty($model->pernafasan) ? $model->pernafasan : ' - '; ?> C (Aksiler/Rectal)
        </td>
    </tr>
    <tr>
        <td>Nyeri</td>
        <td>:
            <?php 
            if($model->nyeri_ada == true){ 
                echo " <span class='fa fa-check-square-o'></span> Ya &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Ya &nbsp;&nbsp;";
            } 

            if($model->nyeri_tidakada == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak &nbsp;&nbsp;";
            } 

            ?>
        </td>   
    </tr>
    <tr>
        <td>Kepala</td>
        <td>:
            <?php 
            if($model->kepala_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->kepala_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->kepala_tidaknormal_ket) ? $model->kepala_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->kepala_tidaknormal_ket) ? $model->kepala_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Mata</td>
        <td>:
            <?php 
            if($model->mata_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->mata_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->mata_tidaknormal_ket) ? $model->mata_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->mata_tidaknormal_ket) ? $model->mata_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>THT</td>
        <td>:
            <?php 
            if($model->tht_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->tht_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->tht_tidaknormal_ket) ? $model->tht_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->tht_tidaknormal_ket) ? $model->tht_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Leher</td>
        <td>:
            <?php 
            if($model->leher_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->leher_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->leher_tidaknormal_ket) ? $model->leher_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->leher_tidaknormal_ket) ? $model->leher_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Mulut</td>
        <td>:
            <?php 
            if($model->mulut_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->mulut_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->mulut_tidaknormal_ket) ? $model->mulut_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->mulut_tidaknormal_ket) ? $model->mulut_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Jantung dan pembuluh darah</td>
        <td>:
            <?php 
            if($model->jantung_pb_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->jantung_pb_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->jantung_pb_tidaknormal_ket) ? $model->jantung_pb_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->jantung_pb_tidaknormal_ket) ? $model->jantung_pb_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Thorax, paru-paru dan payudara</td>
        <td>:
            <?php 
            if($model->thorax_paru_payudara_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->thorax_paru_payudara_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->thorax_paru_payudara_tidaknormal_ket) ? $model->thorax_paru_payudara_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->thorax_paru_payudara_tidaknormal_ket) ? $model->thorax_paru_payudara_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Abdomen</td>
        <td>:
            <?php 
            if($model->abdomen_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->abdomen_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->abdomen_tidaknormal_ket) ? $model->abdomen_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->abdomen_tidaknormal_ket) ? $model->abdomen_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Kulit dan sistem limfatik</td>
        <td>:
            <?php 
            if($model->kulit_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->kulit_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan "; echo !empty($model->kulit_tidaknormal_ket) ? $model->kulit_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->kulit_tidaknormal_ket) ? $model->kulit_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Tulang belakang dan anggota tubuh</td>
        <td>:
            <?php 
            if($model->tulang_anggotatubuh_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->tulang_anggotatubuh_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->tulang_anggotatubuh_tidaknormal_ket) ? $model->tulang_anggotatubuh_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->tulang_anggotatubuh_tidaknormal_ket) ? $model->tulang_anggotatubuh_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Sistem Saraf</td>
        <td>:
            <?php 
            if($model->sistemsaraf_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->sistemsaraf_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->sistemsaraf_tidaknormal_ket) ? $model->sistemsaraf_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->sistemsaraf_tidaknormal_ket) ? $model->sistemsaraf_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Genitalia, anus dan raktum</td>
        <td>:
            <?php 
            if($model->genitalia_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->genitalia_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->genitalia_tidaknormal_ket) ? $model->genitalia_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->genitalia_tidaknormal_ket) ? $model->genitalia_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Status lokalis</td>
        <td>:
            <?php 
            if($model->statuslokalis_normal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
            } 

            if($model->statuslokalis_tidaknormal == true){ 
                echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->statuslokalis_tidaknormal_ket) ? $model->statuslokalis_tidaknormal_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->statuslokalis_tidaknormal_ket) ? $model->statuslokalis_tidaknormal_ket : '-';
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td>Status neurologis</td>
        <td>: Reflek fisiologis
            <?php 
            if($model->statusneurologis_reflekfisiologis_babinsky == true){ 
                echo " <span class='fa fa-check-square-o'></span> Babinsky &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Babinsky &nbsp;&nbsp;";
            } 

            if($model->statusneurologis_reflekfisiologis_moro == true){ 
                echo " <span class='fa fa-check-square-o'></span> Moro &nbsp;&nbsp;"; 
            }else{
                echo " <span class='fa fa-square-o'></span> Moro &nbsp;&nbsp;"; 
            } 
            ?>
        </td>   
    </tr>
    <tr>
        <td></td>
        <td>&nbsp; Reflek pathologis
            <?php 
            if($model->statusneurologis_reflekpathologis_babinsky == true){ 
                echo " <span class='fa fa-check-square-o'></span> Babinsky &nbsp;&nbsp;";
            }else{
                echo " <span class='fa fa-square-o'></span> Babinsky &nbsp;&nbsp;";
            } 

            if($model->statusneurologis_reflekpathologis_clonus == true){ 
                echo " <span class='fa fa-check-square-o'></span> Clonus &nbsp;&nbsp;"; 
            }else{
                echo " <span class='fa fa-square-o'></span> Clonus &nbsp;&nbsp;"; 
            } 
            
            if($model->statusneurologis_reflekpathologis_lainlain == true){ 
                echo " <span class='fa fa-check-square-o'></span> Lain-lain : "; echo !empty($model->statusneurologis_reflekpathologis_lainlain_ket) ? $model->statusneurologis_reflekpathologis_lainlain_ket : '-';
            }else{
                echo " <span class='fa fa-square-o'></span> Lain-lain : "; echo !empty($model->statusneurologis_reflekpathologis_lainlain_ket) ? $model->statusneurologis_reflekpathologis_lainlain_ket : '-';
            } 
            ?>
        </td>
    </tr>
    <tr>
        <td>Atropometri</td>
        <td>: Berat badan/usia : <?= !empty($model->atropometri_beratbadan) ? $model->atropometri_beratbadan : '-' ?> / <?= !empty($model->atropometri_usia) ? $model->atropometri_usia : '-' ?> &nbsp; Panjang badan/usia atau Tinggi badan/usia : <?= !empty($model->atropometri_tinggibadan) ? $model->atropometri_tinggibadan : '-' ?> / <?= !empty($model->atropometri_usia) ? $model->atropometri_usia : '-' ?></td>
    </tr>
    <tr>
        <td></td>
        <td>&nbsp; Berat badan/Tinggi badan : <?= !empty($model->atropometri_beratbadan) ? $model->atropometri_beratbadan : '-' ?> / <?= !empty($model->atropometri_tinggibadan) ? $model->atropometri_tinggibadan : '-' ?> &nbsp; Berat badan ideal : <?= !empty($model->atropometri_beratbadanideal) ? $model->atropometri_beratbadanideal : '-' ?> gram</td>
    </tr>
    <tr>
        <td></td>
        <td>&nbsp; Status nutrisi : <?= !empty($model->atropometri_statusnutrisi) ? $model->atropometri_statusnutrisi : '-' ?> % &nbsp; Lingkar kepala : <?= !empty($model->atropometri_lingkarkepala) ? $model->atropometri_lingkarkepala : '-' ?> gram</td>
    </tr>
    <tr>
        <td></td>
        <td>&nbsp; Lingkar dada : <?= !empty($model->atropometri_lingkardada) ? $model->atropometri_lingkardada : '-' ?> &nbsp; Lingkar lengan atas : <?= !empty($model->atropometri_lingkarlenganatas) ? $model->atropometri_lingkarlenganatas : '-' ?> gram</td>
    </tr>
    
    </table> 
        </td>
    </tr>
</table>
<br>
<div class="page-break" style="padding-bottom:60px"></div>
<br>
<table width="100%" class="table-condensed" border="1px">
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td><b>Pemeriksaan Penunjang Pre Rawat Inap</b></td>
                </tr>
                <tr>
                    <td>Laboratorium</td>
                    <td>: 
                        <?php 
                        if($model->laboratorium_normal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
                        } 

                        if($model->laboratorium_tidaknormal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->laboratorium_tidaknormal_ket) ? $model->laboratorium_tidaknormal_ket : '-'; 
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->laboratorium_tidaknormal_ket) ? $model->laboratorium_tidaknormal_ket : '-';
                        } 

                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Radiologi</td>
                </tr>
                <tr>
                    <td>Thorax foto</td>
                    <td>: 
                        <?php 
                        if($model->radiologi_thorax_normal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
                        } 

                        if($model->radiologi_thorax_tidaknormal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->radiologi_thorax_tidaknormal_ket) ? $model->radiologi_thorax_tidaknormal_ket : '-'; 
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->radiologi_thorax_tidaknormal_ket) ? $model->radiologi_thorax_tidaknormal_ket : '-';
                        } 

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>CT Scan .....</td>
                    <td>: 
                        <?php 
                        if($model->radiologi_ctscan_normal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
                        } 

                        if($model->radiologi_ctscan_tidaknormal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->radiologi_ctscan_tidaknormal_ket) ? $model->radiologi_ctscan_tidaknormal_ket : '-';
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->radiologi_ctscan_tidaknormal_ket) ? $model->radiologi_ctscan_tidaknormal_ket : '-';
                        } 

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>MRI .....</td>
                    <td>: 
                        <?php 
                        if($model->radiologi_mri_normal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
                        } 

                        if($model->radiologi_mri_tidaknormal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->radiologi_mri_tidaknormal_ket) ? $model->radiologi_mri_tidaknormal_ket : '-';
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->radiologi_mri_tidaknormal_ket) ? $model->radiologi_mri_tidaknormal_ket : '-';
                        } 

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>USG .....</td>
                    <td>: 
                        <?php 
                        if($model->radiologi_usg_normal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Normal &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Normal &nbsp;&nbsp;";
                        } 

                        if($model->radiologi_usg_tidaknormal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->radiologi_usg_tidaknormal_ket) ? $model->radiologi_usg_tidaknormal_ket : '-';
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak Normal, Jelaskan : "; echo !empty($model->radiologi_usg_tidaknormal_ket) ? $model->radiologi_usg_tidaknormal_ket : '-';
                        } 

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Lain-lain</td>
                    <td>: <?= !empty($model->radiologi) ? $model->radiologi : $titik ?></td>
                </tr>
            </table> 
        </td>
    </tr>
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td>Diagnosis Awal</td>
                    <td>:
                        <?php 
                        if(!empty($model->diagnosisawal)){ 
                            echo $model->diagnosisawal;
                        }else{
                            echo $titik;
                        } 
                        
                        ?>
                    </td>   
                </tr>
                <tr>
                    <td>Diagnosis Banding</td>
                    <td height="150">:
                        <?php 
                        if(!empty($model->diagnosisbanding)){ 
                            echo $model->diagnosisbanding;
                        }else{
                            echo $titik;
                        } 
                        
                        ?>
                    </td>   
                </tr>
            </table> 
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:50%; text-align:center" >Tanggal <?php echo date('d ').MyFormatter::getMonthId(date('m')).date(' Y').", Jam :".date(' H:i')." WIB"; ?></td>
                    <td style="min-width:50%; text-align:center" >Tanggal <?php echo date('d ').MyFormatter::getMonthId(date('m')).date(' Y').", Jam :".date(' H:i')." WIB"; ?></td>
                </tr>
                <tr rowspan='3'>
                    <td style="min-width:50%; text-align:center" >Nama dan Tanda Tangan Dokter Pemeriksa</td>
                    <td style="min-width:50%; text-align:center" >Nama dan Tanda Tangan DPJP</td>
                </tr>

            </table>
            <br><br><br><br><br>
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:50%; text-align:center">
                        <?php 
                            $ppds = PpdsM::model()->findByPk($model->ppds_id);
                            echo $ppds->ppds_nama; 
                        ?>
                    </td>
                    <td style="min-width:50%; text-align:center" ><?php echo !empty($model->dokterdpjp_id) ? $model->dokterdpjp->namaLengkap : '-'; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
