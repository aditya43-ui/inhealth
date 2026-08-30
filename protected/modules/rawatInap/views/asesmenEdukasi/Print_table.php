

<table width="100%" border="1">
    <tr>
        <td rowspan="3" style="width:70%"><?php echo $this->renderPartial('application.views.headerReport.._headerPrint'); ?></td>
        <td style="width:20%">Nama Lengkap</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Tgl. Lahir </td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">No. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
</table>
<span style="float:right; padding-top: 10px;"><h4>RM 06</h4></span>
<div style="padding-top: 10px; padding-bottom: 10px; text-align:center; font-weight:bold">
    <h4 style='padding-left:35px'>PENGKAJIAN KEBUTUHAN</h4><br>
    <h4 style='margin-top:-15px'>INFORMASI, EDUKASI,PRIVASI PASIEN DAN KELUARGA</h4><br>
    <h5 style='margin-top:-15px'><i>ASSESSMENT OF PATIENT AND FAMILY INFORMATION, EDUCATION, AND PRIVACY NEEDS</i></h5>
</div>
<table width="100%" class="table-condensed" border="1px">
    <tr style="background-color:#afdc7e">
        <td  colspan='5'>Diisi oleh Keperawatan</td>
    </tr>
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td colspan='6'> 
                        <?php 
                            if($model->instalasiawal_id == 2){ 
                                echo " <span class='fa fa-check-square-o'></span> Rawat Jalan";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Rawat Jalan";
                            }
                            
                            if($model->instalasiawal_id == 4){ 
                                echo " <span class='fa fa-check-square-o'></span> Rawat Inap";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Rawat Inap";
                            }
                            
                            if($model->instalasiawal_id == 3){ 
                                echo " <span class='fa fa-check-square-o'></span> IGD";
                            }else{
                                echo " <span class='fa fa-square-o'></span> IGD";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Pengkajian Dilakukan Tgl </td>
                    <td colspan='5'> : <?= MyFormatter::formatDateTimeForUser(date('d-F-Y'));?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td> : <?php echo !empty($model->nama_lengkap) ? $model->nama_lengkap : "...................................................."; ?></td>
                    <td>Umur : <?php echo !empty($model->umur) ? $model->umur : "............"; ?></td>
                    <td>Agama : <?php echo !empty($model->agama) ? $model->agama : ".................."; ?></td>
                    <td>Suku Bangsa : <?php echo !empty($model->sukubangsa) ? $model->sukubangsa : "................."; ?></td>
                </tr>
                <tr>
                    <td>Nilai-nilai Keyakinan</td>
                    <td colspan='5'> : <?php echo !empty($model->nilai_keyakinan) ? $model->nilai_keyakinan : "................................................................................................................................................";  ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td colspan='5'> : <?php echo !empty($model->alamat) ? $model->alamat : "................................................................................................................................................";  ?></td>
                </tr>
                <tr>
                    <td>Tingkat Pendidikan</td>
                    <td colspan='5'> : <?php echo !empty($model->tingkatpendidikan) ? $model->tingkatpendidikan : "................................................................................................................................................";  ?></td>
                </tr>
                <tr>
                    <td>Hubungan dengan Pasien</td>
                    <td colspan='4'> : <?php echo !empty($model->hub_denganpasien) ? $model->hub_denganpasien : "................................................................................................................................................";  ?></td>
                </tr>
                <tr>
                    <td style='min-width:25%'>Kesediaan menerima edukasi</td>
                    <td> :  <?php 
                            if($model->menerimaedukasi_bersedia){ 
                                echo " <span class='fa fa-check-square-o'></span> Bersedia";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Bersedia";
                            }
                            ?>
                    </td>
                    <td colspan='3'><?php
                            if($model->menerimaedukasi_tidakbersedia){ 
                                echo " <span class='fa fa-check-square-o'></span> Tidak bersedia";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Tidak bersedia";
                            }
                            ?>
                    </td>
                </tr>
                <tr>
                    <td>Bahasa</td>
                    <td> :  <?php 
                            if($model->bahasa_indonesia){ 
                                echo " <span class='fa fa-check-square-o'></span> Indonesia";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Indonesia";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->bahasa_inggis){ 
                                echo " <span class='fa fa-check-square-o'></span> Inggris";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Inggris";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->bahasa_daerah){ 
                                echo " <span class='fa fa-check-square-o'></span> Daerah : ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Daerah : ";
                            }

                            echo !empty($model->bahasa_daerah_keterangan) ? $model->bahasa_daerah_keterangan : "...............";
                            ?>
                    </td>
                    <td><?php
                            if($model->bahasa_lainnya){ 
                                echo " <span class='fa fa-check-square-o'></span> Lain-lain : ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Lain-lain : ";
                            }

                            echo !empty($model->bahasa_lainnya_ket) ? $model->bahasa_lainnya_ket : "...............";

                            ?>
                    </td>
                </tr>
                <tr>
                    <td>Kemampuan Berbahasa</td>
                    <td> :  <?php 
                            if($model->kemampuanbahasa_baik){ 
                                echo " <span class='fa fa-check-square-o'></span> Baik";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Baik";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->kemampuanbahasa_cukup){ 
                                echo " <span class='fa fa-check-square-o'></span> Cukup";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Cukup";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->kemampuanbahasa_kurang){ 
                                echo " <span class='fa fa-check-square-o'></span> Kurang ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Kurang";
                            }                            
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Kebutuhan penerjemah</td>
                    <td> :  <?php 
                            if($model->kebutuhanpenerjemah_ya){ 
                                echo " <span class='fa fa-check-square-o'></span> Ya";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Ya";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->kebutuhanpenerjemah_tidak){ 
                                echo " <span class='fa fa-check-square-o'></span> Tidak";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Tidak";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Baca dan tulis</td>
                    <td> :  <?php 
                            if($model->bacatulis_baik){ 
                                echo " <span class='fa fa-check-square-o'></span> Baik";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Baik";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->bacatulis_kurang){ 
                                echo " <span class='fa fa-check-square-o'></span> Kurang";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Kurang";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Hambatan edukasi</td>
                    <td> :  <?php 
                            if($model->hambatanedukasi_tidakada){ 
                                echo " <span class='fa fa-check-square-o'></span> Tidak ada";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Tidak ada";
                            }
                            ?>
                    </td>
                    <td colspan="2"><?php
                            if($model->hambatanedukasi_motivasikurang){ 
                                echo " <span class='fa fa-check-square-o'></span> Motivasi kurang";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Motivasi kurang";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->hambatanedukasi_kognitifterbatas){ 
                                echo " <span class='fa fa-check-square-o'></span> Kognitif terbatas";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Kognitif terbatas";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td> <span style='color:transparent'>Hambatan edukasi</span> </td>
                    <td> <span style='color:transparent'>:</span> <?php 
                            if($model->hambatanedukasi_fisiklemah){ 
                                echo " <span class='fa fa-check-square-o'></span> Fisik Lemah";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Fisik Lemah";
                            }
                            ?>
                    </td>
                    <td colspan="2"><?php
                            if($model->hambatanedukasi_penglihatanterganggu){ 
                                echo " <span class='fa fa-check-square-o'></span> Penglihatan Terganggu";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Penglihatan Terganggu";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->hambatanedukasi_pendengaranterganggu){ 
                                echo " <span class='fa fa-check-square-o'></span> Pendengaran Terganggu";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Pendengaran Terganggu";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td> Bicara </td>
                    <td> : <?php 
                            if($model->bicara_normal){ 
                                echo " <span class='fa fa-check-square-o'></span> Normal";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Normal";
                            }
                            ?>
                    </td>
                    <td colspan='4'><?php
                            if($model->bicara_gangguansejak){ 
                                echo " <span class='fa fa-check-square-o'></span> Serangan awal gangguan bicara sejak : ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Serangan awal gangguan bicara sejak : ";
                            }

                            echo !empty($model->bicara_gangguansejak_ket) ? $model->bicara_gangguansejak_ket : "...........................................................";
                        ?>

                    </td>
                </tr>
                <tr>
                    <td> Metode edukasi yang </td>
                    <td colspan="2"> : <?php 
                            if($model->metodeedukasi_audiovisual){ 
                                echo " <span class='fa fa-check-square-o'></span> Audio-Visual";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Audio-Visual";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->metodeedukasi_duskusi){ 
                                echo " <span class='fa fa-check-square-o'></span> Diskusi ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Diskusi ";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->metodeedukasi_wawancara){ 
                                echo " <span class='fa fa-check-square-o'></span> Wawancara ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Wawancara ";
                            }
                        ?>

                    </td>
                </tr>
                <tr>
                    <td> digunakan</td>
                    <td colspan="2"> <span style='color:transparent'>:</span> <?php 
                            if($model->metodeedukasi_demontrasi){ 
                                echo " <span class='fa fa-check-square-o'></span> Demonstrasi";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Demonstrasi";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->metodeedukasi_ceramah){ 
                                echo " <span class='fa fa-check-square-o'></span> Ceramah ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Ceramah ";
                            }
                            ?>
                    </td>
                    <td colspan='2'><?php
                            if($model->metodeedukasi_lainnya){ 
                                echo " <span class='fa fa-check-square-o'></span> Lain-lain : ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Lain-lain : ";
                            }

                            echo !empty($model->metodeedukasi_lainnya_ket) ? $model->metodeedukasi_lainnya_ket : "...................................................";
                        ?>

                    </td>
                </tr>
                <tr>
                    <td> Kebutuhan privasi selama </td>
                    <td colspan="2"> : <?php 
                            if($model->kebutuhanprivasi_ya){ 
                                echo " <span class='fa fa-check-square-o'></span> Ya, sebutkan :";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Ya, sebutkan :";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->kebutuhanprivasi_ya_wawancara){ 
                                echo " <span class='fa fa-check-square-o'></span> Wawancara klinis ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Wawancara klinis ";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->kebutuhanprivasi_ya_pemeriksaanfisik){ 
                                echo " <span class='fa fa-check-square-o'></span> Pemeriksaan fisik ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Pemeriksaan fisik ";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->kebutuhanprivasi_ya_tindakan){ 
                                echo " <span class='fa fa-check-square-o'></span> Tindakan ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Tindakan ";
                            }
                        ?>

                    </td>
                </tr>
                <tr>
                    <td colspan="3"> perawatan</td>
                    <td><?php 
                            if($model->kebutuhanprivasi_ya_transportasi){ 
                                echo " <span class='fa fa-check-square-o'></span> Transportasi";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Transportasi";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->kebutuhanprivasi_ya_ruangperawatan){ 
                                echo " <span class='fa fa-check-square-o'></span> Ruang perawatan ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Ruang perawatan ";
                            }
                            ?>
                    </td>
                    <td><?php
                            if($model->kebutuhanprivasi_ya_lainnya){ 
                                echo " <span class='fa fa-check-square-o'></span> Lain-lain : ";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Lain-lain : ";
                            }

                            echo !empty($model->kebutuhanprivasi_ya_lainnya_ket) ? $model->kebutuhanprivasi_ya_lainnya_ket : "..........";
                        ?>

                    </td>
                </tr>
                <tr>
                    <td> <span style='color:transparent'>:</span></td>
                    <td> <span style='color:transparent'>:</span> <?php 
                            if($model->kebutuhanprivasi_tidak){ 
                                echo " <span class='fa fa-check-square-o'></span> Tidak";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Tidak";
                            }
                        ?>
                    </td>
                </tr>
            </table>            
        </td>
    </tr>
    <thead>
    <tr>
        <td colspan='5'><div style="text-align:center; font-weight: bold">Rencana Kebutuhan Edukasi</div></td>
    </tr>
    <tr style="background-color:#afdc7e">
        <td  colspan='5'>Diisi oleh Dokter / Keperawatan / Keterapian Fisik / Tenaga Gizi / Apoteker / Tenaga Kesehatan Lain (sesuai topik edukasi)</td>
    </tr>
    </thead>
    <tr>
        <td>
            <b>Admisi :</b><br>
            <?php 
                if($model->admisi_penjaminan){ 
                    echo " <span class='fa fa-check-square-o'></span> Penjaminan";
                }else{
                    echo " <span class='fa fa-square-o'></span> Penjaminan";
                }
                ?>
            <br>
            <?php
                if($model->admisi_biayapengobatan){ 
                    echo " <span class='fa fa-check-square-o'></span> Biaya pengobatan";
                }else{
                    echo " <span class='fa fa-square-o'></span> Biaya pengobatan";
                }
                ?>
            <br>
            <?php
                if($model->admisi_pemasangangelang){ 
                    echo " <span class='fa fa-check-square-o'></span> Pemasangan gelang";
                }else{
                    echo " <span class='fa fa-square-o'></span> Pemasangan gelang";
                }
            ?>
            <br>
            <b>Medis :</b><br>
            <?php 
                if($model->medis_diagnosapenyakit){ 
                    echo " <span class='fa fa-check-square-o'></span> Diagnosa penyakit, penyebab, tanda dan gejala, prognosa";
                }else{
                    echo " <span class='fa fa-square-o'></span> Diagnosa penyakit, penyebab, tanda dan gejala, prognosa";
                }
                ?>
            <br>
            <?php
                if($model->medis_hasilpemeriksaan){ 
                    echo " <span class='fa fa-check-square-o'></span> Hasil pemeriksaan";
                }else{
                    echo " <span class='fa fa-square-o'></span> Hasil pemeriksaan";
                }
                ?>
            <br>
            <?php
                if($model->medis_tindakanmedis){ 
                    echo " <span class='fa fa-check-square-o'></span> Tindakan medis";
                }else{
                    echo " <span class='fa fa-square-o'></span> Tindakan medis";
                }
                ?>
            <br>
            <?php
                if($model->medis_penjelasankompilasi){ 
                    echo " <span class='fa fa-check-square-o'></span> Penjelasan komplikasi yang mungkin terjadi";
                }else{
                    echo " <span class='fa fa-square-o'></span> Penjelasan komplikasi yang mungkin terjadi";
                }
                ?>
            <br>
            <?php
                if($model->medis_perkiraanharirawat){ 
                    echo " <span class='fa fa-check-square-o'></span> Perkiraan hari rawat";
                }else{
                    echo " <span class='fa fa-square-o'></span> Perkiraan hari rawat";
                }
            ?>
            <br>
            <?php
                if($model->medis_lainnya){ 
                    echo " <span class='fa fa-check-square-o'></span> Lainnya";
                }else{
                    echo " <span class='fa fa-square-o'></span> Lainnya";
                }
            ?>
            <br>
            <?php echo !empty($model->medis_lainnya_ket) ? $model->medis_lainnya_ket : "<span class='fa fa-square-o'></span> ............................................................................................................"; ?>
            
            <br>
            <b>Manajemen Nyeri :</b><br>
            <?php 
                if($model->manajemennyeri_farmakologi){ 
                    echo " <span class='fa fa-check-square-o'></span> Diagnosa penyakit, penyebab, tanda dan gejala, prognosa";
                }else{
                    echo " <span class='fa fa-square-o'></span> Diagnosa penyakit, penyebab, tanda dan gejala, prognosa";
                }
                ?>
            <br>
            <?php
                if($model->manajemennyeri_nonfarmakologi){ 
                    echo " <span class='fa fa-check-square-o'></span> Hasil pemeriksaan";
                }else{
                    echo " <span class='fa fa-square-o'></span> Hasil pemeriksaan";
                }
                ?>
            <br>
            <?php
                if($model->manajemennyeri_lainnya){ 
                    echo " <span class='fa fa-check-square-o'></span>"; echo !empty($model->manajemennyeri_lainnya_ket) ? $model->manajemennyeri_lainnya_ket : " ............................................................................................................ ";
                }else{
                    echo " <span class='fa fa-square-o'></span>"; echo !empty($model->manajemennyeri_lainnya_ket) ? $model->manajemennyeri_lainnya_ket : " ............................................................................................................ ";
                }
            ?>
            <br>
            <b>Keperawatan :</b><br>
            <?php
                if($model->keperawatan_informasitentang){ 
                     echo " <span class='fa fa-check-square-o'></span> Informasi tentang";
                }else{
                    echo " <span class='fa fa-square-o'></span> Informasi tentang";
                }
            ?>
            <br>
            <table style="margin-left:15px; margin-bottom: -3px; margin-top: -3px">
                <tr><td> - Hak dan kewajiban <br> - Tata tertib berkunjung</td></tr>
            </table>
            <?php
                if($model->keperawatan_perawatanluka){ 
                     echo " <span class='fa fa-check-square-o'></span> Perawatan luka";
                }else{
                    echo " <span class='fa fa-square-o'></span> Perawatan luka";
                }
            ?>
            <br>
            <?php
                if($model->keperawatan_penggunaanalatmedis){ 
                     echo " <span class='fa fa-check-square-o'></span> Penggunaan alat medis secara efektif dan aman";
                }else{
                    echo " <span class='fa fa-square-o'></span> Penggunaan alat medis secara efektif dan aman";
                }
            ?>
            <br>
            <?php
                if($model->keperawatan_penangananperawatan){ 
                     echo " <span class='fa fa-check-square-o'></span> Penanganan dan cara perawatan lanjutan di rumah";
                }else{
                    echo " <span class='fa fa-square-o'></span> Penanganan dan cara perawatan lanjutan di rumah";
                }
            ?>
            <br>
            <?php
                if($model->keperawatan_keamananperawatan){ 
                     echo " <span class='fa fa-check-square-o'></span> Keamanan lingkungan perawatan dan alat yang perlu disiapkan di rumah";
                }else{
                    echo " <span class='fa fa-square-o'></span> Keamanan lingkungan perawatan dan alat yang perlu disiapkan di rumah";
                }
            ?>
            <br>
            <?php
                if($model->keperawatan_cucitangan){ 
                     echo " <span class='fa fa-check-square-o'></span> Cuci tangan";
                }else{
                    echo " <span class='fa fa-square-o'></span> Cuci tangan";
                }
            ?>
            <br>
            <?php
                if($model->keperawatan_edukasikhusus){ 
                     echo " <span class='fa fa-check-square-o'></span> Edukasi khusus <span style='font-style:italic'>discharge planning</span> pasien : DM, Stroke, Kemoterapi dan Jantung";
                }else{
                    echo " <span class='fa fa-square-o'></span> Edukasi khusus <span style='font-style:italic'>discharge planning</span> pasien : DM, Stroke, Kemoterapi dan Jantung";
                }
            ?>
            <br>
            <?php
                if($model->keperawatan_postcatherisasi){ 
                     echo " <span class='fa fa-check-square-o'></span> Perawatan post catheterisasi";
                }else{
                    echo " <span class='fa fa-square-o'></span> Perawatan post catheterisasi";
                }
            ?>
            <br>
            <?php
                if($model->keperawatan_lainnya){ 
                     echo " <span class='fa fa-check-square-o'></span> Lain-lain ";
                }else{
                    echo " <span class='fa fa-square-o'></span> Lain-lain";
                }
            ?>
            <br>
            <?php
                if($model->keperawatan_lainnya){ 
                    echo " <span class='fa fa-check-square-o'></span>"; echo !empty($model->keperawatan_lainnya_ket) ? $model->keperawatan_lainnya_ket : " ............................................................................................................ ";
                }else{
                    echo " <span class='fa fa-square-o'></span>"; echo !empty($model->keperawatan_lainnya_ket) ? $model->keperawatan_lainnya_ket : " ............................................................................................................ ";
                }
            ?>
        </td>
        <td>
            <b>Pengobatan :</b><br>
            <?php 
                if($model->pengobatan_namakegunaanobat){ 
                    echo " <span class='fa fa-check-square-o'></span> Nama obat dan kegunaannya";
                }else{
                    echo " <span class='fa fa-square-o'></span> Nama obat dan kegunaannya";
                }
                ?>
            <br>
            <?php
                if($model->pengobatan_aturanpakaiobat){ 
                    echo " <span class='fa fa-check-square-o'></span> Aturan pemakaian dan dosis obat";
                }else{
                    echo " <span class='fa fa-square-o'></span> Aturan pemakaian dan dosis obat";
                }
                ?>
            <br>
            <?php
                if($model->pengobatan_jumlahobatdiberikan){ 
                    echo " <span class='fa fa-check-square-o'></span> Jumlah obat yang diberikan";
                }else{
                    echo " <span class='fa fa-square-o'></span> Jumlah obat yang diberikan";
                }
                ?>
            <br>
            <?php
                if($model->pengobatan_carapenyimpanan){ 
                    echo " <span class='fa fa-check-square-o'></span> Cara penyimpanan obat";
                }else{
                    echo " <span class='fa fa-square-o'></span> Cara penyimpanan obat";
                }
                ?>
            <br>
            <?php
                if($model->pengobatan_efeksamping){ 
                    echo " <span class='fa fa-check-square-o'></span> Efek samping obat";
                }else{
                    echo " <span class='fa fa-square-o'></span> Efek samping obat";
                }
            ?>
            <br>
            <?php
                if($model->pengobatan_kontraindikasi){ 
                    echo " <span class='fa fa-check-square-o'></span> Kontra indikasi obat";
                }else{
                    echo " <span class='fa fa-square-o'></span> Kontra indikasi obat";
                }
            ?>
            <br>
            <?php
                if($model->pengobatan_lainnya){ 
                    echo " <span class='fa fa-check-square-o'></span>"; echo !empty($model->pengobatan_lainnya_ket) ? $model->pengobatan_lainnya_ket : " ........................................................................";
                }else{
                    echo " <span class='fa fa-square-o'></span>"; echo !empty($model->pengobatan_lainnya_ket) ? $model->pengobatan_lainnya_ket : " ........................................................................";
                }
            ?>
            <br>
            <b>Rehabilitasi Medis :</b><br>
            <table style="margin-left:-5px; margin-bottom: -3px; margin-top: -3px">
                <tr>
                    <td>
                        <?php 
                            if($model->rehabmedis_fisioterapi){ 
                                echo " <span class='fa fa-check-square-o'></span> Fisioterapi";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Fisioterapi";
                            }
                        ?>
                        <br>
                        <?php
                            if($model->rehabmedis_okupasiterapi){ 
                                echo " <span class='fa fa-check-square-o'></span> Okupasi terapi";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Okupasi terapi";
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($model->rehabmedis_fisioterapi){ 
                                echo " <span class='fa fa-check-square-o'></span> Fisioterapi";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Fisioterapi";
                            }
                        ?>
                        <br>
                        <?php
                            if($model->rehabmedis_okupasiterapi){ 
                                echo " <span class='fa fa-check-square-o'></span> Okupasi terapi";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Okupasi terapi";
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <?php echo " <span class='fa fa-square-o'></span> ........................................................................";?>
            
            <br>
            <b>Diet dan Nutrisi : </b><br>
            <?php 
                if($model->dietnutrisi_dietnutrisi){ 
                    echo " <span class='fa fa-check-square-o'></span> Diet dan nutrisi";
                }else{
                    echo " <span class='fa fa-square-o'></span> Diet dan nutrisi";
                }
                ?>
            <br>
            <?php
                if($model->dietnutrisi_lainnya){ 
                    echo " <span class='fa fa-check-square-o'></span> Lainnya";
                }else{
                    echo " <span class='fa fa-square-o'></span> Lainnya";
                }
                ?>
            <br>
            <?php
                if($model->dietnutrisi_lainnya){ 
                    echo " <span class='fa fa-check-square-o'></span>"; echo !empty($model->dietnutrisi_lainnya_ket) ? $model->dietnutrisi_lainnya_ket : " ........................................................................";
                }else{
                    echo " <span class='fa fa-square-o'></span>"; echo !empty($model->dietnutrisi_lainnya_ket) ? $model->dietnutrisi_lainnya_ket : " ........................................................................";
                }
            ?>
            <br>
            <b>Pelayanan Kerohanian :</b><br>
            <table style="margin-left:-5px; margin-bottom: -3px; margin-top: -3px">
                <tr>
                    <td>
                        <?php 
                            if($model->pelrohani_bimbinganrohani){ 
                                echo " <span class='fa fa-check-square-o'></span> Bimbingan rohani";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Bimbingan rohani";
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($model->pelrohani_konselingrohani){ 
                                echo " <span class='fa fa-check-square-o'></span> Konseling rohani";
                            }else{
                                echo " <span class='fa fa-square-o'></span> Konseling rohani";
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <b>Penunjang :</b><br>
            <?php
                if($model->penunjang_patologiklinik){ 
                    echo " <span class='fa fa-check-square-o'></span> Patologi klinik";
                }else{
                    echo " <span class='fa fa-square-o'></span> Patologi klinik";
                }
                ?>
            <br>
            <?php
                if($model->penunjang_patologianatomi){ 
                     echo " <span class='fa fa-check-square-o'></span> Patologi anatomi";
                }else{
                    echo " <span class='fa fa-square-o'></span> Patologi anatomi";
                }
            ?>
            <br>
            <?php
                if($model->penunjang_mikrobiologi){ 
                    echo " <span class='fa fa-check-square-o'></span> Mikrobiologi";
                }else{
                    echo " <span class='fa fa-square-o'></span> Mikrobiologi";
                }
                ?>
            <br>
            <?php
                if($model->penunjang_radiodiagnostik){ 
                     echo " <span class='fa fa-check-square-o'></span> Radiodiagnostik";
                }else{
                    echo " <span class='fa fa-square-o'></span> Radiodiagnostik";
                }
            ?>
            <br>
            <b>Radioterapi :</b><br>
            <?php
                if($model->radioterapi != null){ 
                    echo " <span class='fa fa-check-square-o'></span>"; echo !empty($model->radioterapi) ? $model->radioterapi : " ........................................................................";
                }else{
                    echo " <span class='fa fa-square-o'></span>"; echo !empty($model->radioterapi) ? $model->radioterapi : " ........................................................................";
                }
            ?>
            <br>
            <b>ITD :</b><br>
            <?php
                if($model->itd_pelbotomi){ 
                     echo " <span class='fa fa-check-square-o'></span> Pelbotomi";
                }else{
                    echo " <span class='fa fa-square-o'></span> Pelbotomi";
                }
            ?>
            <br>
            <?php
                if($model->itd_lainnya){ 
                    echo " <span class='fa fa-check-square-o'></span> Lainnya";
                }else{
                    echo " <span class='fa fa-square-o'></span> Lainnya";
                }
                ?>
            <br>
            <?php
                if($model->itd_lainnya){ 
                    echo " <span class='fa fa-check-square-o'></span>"; echo !empty($model->itd_lainnya_ket) ? $model->itd_lainnya_ket : " ........................................................................";
                }else{
                    echo " <span class='fa fa-square-o'></span>"; echo !empty($model->itd_lainnya_ket) ? $model->itd_lainnya_ket : " ........................................................................";
                }
            ?>
        </td>
    </tr>
</table>
<table width="100%" >
    <tr>
        <td style="text-align: left;"><span style="color:transparent">s</span></td>
        <td style="text-align: right;"></td>
    </tr>
</table>



   
        

        
    
   
