<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
@page {
   size: 7in 9.25in;
   margin: 27mm 16mm 27mm 16mm;
   font-size: 10px !important;
    padding-top: 60px;
    margin-top: 0px;
    margin-bottom: 0px;
}
@media print {
  html, body {
        padding-top: 60px;
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
.page-break { display: block; page-break-before: always;}
}
</style>

<table width="100%" border="1px">
    <tr>
        <td rowspan="3" style="width:70%"><?php echo $this->renderPartial('rawatInap.views.asesmenAwalKeperawatan._headerPrint'); ?></td>
        <td style="width:20%" border-top="1px">Nama Lengkap</td>
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
<span style="float:right; padding-top: 10px;"><h4>RM 05</h4></span>
<div style="padding-top: 10px; padding-bottom: 10px; text-align:center; font-weight:bold">
    <h4 style='padding-left:35px'>ASESMEN AWAL KEPERAWATAN DEWASA (USIA DIATAS 18 TAHUN)</h4><br>
    <h5 style='margin-top:-15px'><i>NURSING INITIAL ASSESMENT</i></h5>
</div>
<table width="100%" class="table-condensed" border="1px">
    <tr style="background-color:#afdc7e">
        <td  colspan='5'><b>Diisi oleh Keperawatan (Perawat / Bidan)</b></td>
    </tr>
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td>Tanggal & Jam Masuk Ruangan</td>
                    <td>: 
                    <?php 
                        $caripasien = InfopasienmasukkamarV::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
                        echo !empty($caripasien->tglmasukkamar) ? $caripasien->tglmasukkamar :"-";
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>Waktu pemeriksaan</td>
                    <td>: Tanggal : <?php echo date('d M Y', strtotime($model->tgl_asesmen_keperawatan)); ?>, Jam : <?php echo date('H:i:s', strtotime($model->tgl_asesmen_keperawatan)); ?> WIB </td>   
                </tr>
                
                <tr>
                    <td>Riwayat kesehatan  </td>
                    <td>: <?php echo $model->riwayat_kesehatan; ?></td>  
                </tr>
                <tr>
                    <td>Keluhan </td>
                    <td>: <?php echo $model->alasan_masuk; ?></td>  
                </tr>
                <tr>
                    <td>Pernah dirawat  </td>
                    <td>:<?php if($model->pernahdirawat_ya){ 
                        echo " <span class='fa fa-check-square-o'></span> Ya  <span class='fa fa-square-o'></span> Tidak";
                        }else{
                        echo " <span class='fa fa-square-o'></span> Ya  <span class='fa fa-check-square-o'></span> Tidak";
                        } ?>
                    </td>  
                </tr>
                <tr>
                    <td>Obat dari rumah  </td>
                    <td>:<?php if($model->obatdarirumah_ada){ 
                        echo " <span class='fa fa-check-square-o'></span> Tidak  <span class='fa fa-square-o'></span> Ada (diserahkan kepada farmasi)";
                        }else{
                        echo " <span class='fa fa-check-square-o'></span> Tidak ada  <span class='fa fa-square-o'></span> Ada (diserahkan kepada farmasi)";
                        } ?>
                    </td>  
                </tr>
                <tr>
                    <td>Berasal dari daerah endemik malaria  </td>
                    <td>:<?php if($model->dariedemikmalaria_ya){ 
                        echo " <span class='fa fa-check-square-o'></span> Ya  <span class='fa fa-square-o'></span> Tidak";
                        }else{
                        echo " <span class='fa fa-square-o'></span> Ya  <span class='fa fa-check-square-o'></span> Tidak";
                        } ?>
                    </td>  
                </tr>
            </table>          
        </td>
    </tr>
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td><h4>B1 PERNAPASAN</h4></td>
                    <td> </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            Kesulitan bernapas : <?php if($model->pernafasan_sulitbernafas_ya){ 
                                                echo " <span class='fa fa-check-square-o'></span> Ya  <span class='fa fa-square-o'></span> Tidak.";
                                                }else{
                                                echo " <span class='fa fa-square-o'></span> Ya  <span class='fa fa-check-square-o'></span> Tidak.";
                                                } ?>
                            RR :<?php echo !empty($model->pernafasan_respiratorrate) ? $model->pernafasan_respiratorrate : "......"; ?>
                                <?php if($model->pernafasan_iscyanosis){ 
                                        echo " <span class='fa fa-check-square-o'></span> Cyanossis";
                                      }else{
                                        echo " <span class='fa fa-square-o'></span> Cyanossis";
                                      } 
                                ?>
                            <br>

                            Memakai O2 : <?php 
                                        if($model->pernafasan_pakai_o2_tidak){ 
                                            echo " <span class='fa fa-check-square-o'></span> Tidak";
                                          }else{
                                            echo " <span class='fa fa-square-o'></span> Tidak";
                                          }

                                          if($model->pernafasan_pakai_o2_ya){ 
                                            echo " <span class='fa fa-check-square-o'></span> Ya : "; echo !empty($model->pernafasan_pakai_o2) ? $model->pernafasan_pakai_o2 : "......"; echo 'menit';
                                          }else{
                                            echo " <span class='fa fa-square-o'></span> Ya ";
                                          }
                                ?> : 
                                <?php if($model->pernafasan_pakai_casalcanul){ 
                                        echo " <span class='fa fa-check-square-o'></span> Nasal canule";
                                      }else{
                                        echo " <span class='fa fa-square-o'></span> Nasal canule";
                                      }

                                      if($model->pernafasan_pakai_sangkup){ 
                                        echo " <span class='fa fa-check-square-o'></span> Sungkup";
                                      }else{
                                        echo " <span class='fa fa-square-o'></span> Sungkup";
                                      }

                                      if($model->pernafasan_pakai_nonbreathing){ 
                                        echo " <span class='fa fa-check-square-o'></span> Re/Non-breathing mask";
                                      }else{
                                        echo " <span class='fa fa-square-o'></span> Re/Non-breathing mask";
                                      }
                                ?>
                        </p>
                    </td>
                </tr>
            </table> 
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <table>
                <tr>
                    <td><h4>B2 SIRKULASI</h4></td>
                    <td> </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            Tensi : <?php echo !empty($model->sirkulasi_tensi_sistolik) ? $model->sirkulasi_tensi_sistolik.'/' : "......"; echo !empty($model->sirkulasi_tensi_diastolik) ? $model->sirkulasi_tensi_diastolik.',' : "......".','; ?>
                            Nadi : <?php echo !empty($model->sirkulasi_nadi) ? $model->sirkulasi_nadi.',' : "......".','; ?>
                            Suhu : <?php echo !empty($model->suhu) ? $model->suhu.',' : "......".','; ?>
                            Perfusi : <?php echo !empty($model->pernafasan_pakai_o2) ? $model->pernafasan_pakai_o2 : "......"; ?>
                            <?php if($model->perfus_hangatkeringmerah){ 
                                    echo " <span class='fa fa-check-square-o'></span> Hangat kering merah";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Hangat kering merah";
                                  }

                                  if($model->perfus_dinginpucat){ 
                                    echo " <span class='fa fa-check-square-o'></span> Dingin pucat basah";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Dingin pucat basah";
                                  }

                                  if($model->perfusi_sao2){ 
                                    echo " <span class='fa fa-check-square-o'></span> SaO 2 :";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> SaO 2 :";
                                  }
                            echo !empty($model->perfusi_sao2_keterangan) ? $model->perfusi_sao2_keterangan : "......";

                                  if($model->perfusi_islainnya){ 
                                    echo " <span class='fa fa-check-square-o'></span> Dll :";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Dll :";
                                  }
                            echo !empty($model->perfusi_islainnya_keterangan) ? $model->perfusi_islainnya_keterangan : "......";

                            ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <table>
                <tr>
                    <td><h4>B3 PERSARAFAN</h4></td>
                    <td> </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            Kesadaran : GCS : <?php echo !empty($model->persarafan_total_gcs) ? $model->persarafan_total_gcs : "........................"; ?>
                            <?php if($model->persarafan_nilai_berubah){ 
                                    echo " <span class='fa fa-check-square-o'></span> Berubah";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Berubah";
                                  }

                                  if($model->persarafan_gcs_normal){ 
                                    echo " <span class='fa fa-check-square-o'></span> Normal";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Normal";
                                  }               
                            ?>
                            <br>
                            Psikologis :
                            <?php if($model->persarafan_psikologis_tenang){ 
                                    echo " <span class='fa fa-check-square-o'></span> Tenang";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Tenang";
                                  }

                                  if($model->persarafan_psikologis_cemas){ 
                                    echo " <span class='fa fa-check-square-o'></span> Cemas";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Cemas";
                                  }

                                  if($model->persarafan_psikologis_takut){ 
                                    echo " <span class='fa fa-check-square-o'></span> Takut";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Takut";
                                  }

                                  if($model->persarafan_psikologis_marah){ 
                                    echo " <span class='fa fa-check-square-o'></span> Marah";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Marah";
                                  }

                                  if($model->persarafan_psikologis_sedih){ 
                                    echo " <span class='fa fa-check-square-o'></span> Sedih";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Sedih";
                                  }

                                  if($model->persarafan_psikologis_lainnya){ 
                                    echo " <span class='fa fa-check-square-o'></span> Lainnya ";
                                  }else{
                                    echo " <span class='fa fa-square-o'></span> Lainnya ";
                                  }
                            ?>
                            : <?php echo !empty($model->persarafan_psikologis_lainketerangan) ? $model->persarafan_psikologis_lainketerangan : "......"; ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <table>
                <tr>
                    <td style="min-width: 20%"><h4>B4 ELIMINASI</h4></td>
                </tr>
                <tr>
                    <td> Masalah perkemihan :<br><span style="color:transparent">..</span></td>
                    <td>
                        <?php if($model->eliminasi_tidakada){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak Ada";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak Ada";
                            }

                            if($model->eliminasi_ada){ 
                              echo " <span class='fa fa-check-square-o'></span> Ada :";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Ada :";
                            }

                            if($model->eliminasi_ada_stoma){ 
                              echo " <span class='fa fa-check-square-o'></span> Stoma";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Stoma";
                            }

                            if($model->eliminasi_ada_striktur_uretra){ 
                              echo " <span class='fa fa-check-square-o'></span> Striktur uretra";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Striktur uretra";
                            }

                            if($model->eliminasi_ada_retensi){ 
                              echo " <span class='fa fa-check-square-o'></span> Retensi urin";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Retensi urin";
                            }

                            if($model->eliminasi_ada_inkontinensia){ 
                              echo " <span class='fa fa-check-square-o'></span> Inkontinensia urin ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Inkontinensia urin ";
                            }

                            if($model->eliminasi_ada_dialissi){ 
                              echo " <span class='fa fa-check-square-o'></span> Dialisis ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dialisis ";
                            }

                            if($model->eliminasi_ada_kencingspontan){ 
                              echo " <span class='fa fa-check-square-o'></span> Kencing Spontan ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Kencing Spontan ";
                            }

                            if($model->eliminasi_ada_dowerkateter){ 
                              echo " <span class='fa fa-check-square-o'></span> Dower Kateter ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dower Kateter ";
                            }

                            if($model->eliminasi_ada_lainnya){ 
                              echo " <span class='fa fa-check-square-o'></span> Dll : ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dll : ";
                            }

                            echo !empty($model->eliminasi_ada_keterangan) ? $model->eliminasi_ada_keterangan : ".................................................................."; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <table>
                <tr>
                    <td><h4>B5 PENCERNAAN DAN NUTRISI</h4></td>
                </tr>
                <tr>
                    <td> Masalah defekasi :
                        <?php if($model->nutrisi_defekasi_tidakada){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak Ada";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak Ada";
                            }

                            if($model->nutrisi_defekasi_ada){ 
                              echo " <span class='fa fa-check-square-o'></span> Ada :";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Ada :";
                            }

                            if($model->nutrisi_defekasi_ada_stoma){ 
                              echo " <span class='fa fa-check-square-o'></span> Stoma";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Stoma";
                            }

                            if($model->nutrisi_defekasi_ada_atresiaani){ 
                              echo " <span class='fa fa-check-square-o'></span> Atresia ani";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Atresia ani";
                            }

                            if($model->nutrisi_defekasi_ada_konstipasi){ 
                              echo " <span class='fa fa-check-square-o'></span> Konstipasi";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Konstipasi";
                            }

                            if($model->nutrisi_defekasi_ada_inkontinensia){ 
                              echo " <span class='fa fa-check-square-o'></span> Inkontinensia alvi ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Inkontinensia alvi ";
                            }

                            if($model->nutrisi_defekasi_ada_diare){ 
                              echo " <span class='fa fa-check-square-o'></span> Diare ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Diare";
                            }
                        ?> 
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <table width="100%" border="1px">
                <tr>
                    <td style="text-align:center">Status Gizi / Nutrisi</td>
                    <td style="text-align:center" colspan="2">Penilaian</td>
                </tr>
                <tr border="1px transparent">
                    <td style="padding-left:5px"> 
                        1. Pasien kehilangan berat badan 5 % dalam waktu 3 bulan terakhir? <br>
                        2. Asupan makan pasien kurang dalam 1 minggu terakhir?             <br>
                        3. Pasien menderita penyakit yang berat?
                    </td>
                    <td style="padding-left:5px"> 
                        <?php  
                            if($model->nutrisi_status_beratbadanhilang_ya){ 
                            echo " <span class='fa fa-check-square-o'></span> Ya";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Ya";
                            }
                        ?> <br>
                        <?php  
                            if($model->nutrisi_status_asupankurang_ya){ 
                            echo " <span class='fa fa-check-square-o'></span> Ya";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Ya";
                            }
                        ?> <br>
                        <?php  
                            if($model->nutrisi_status_deritapenyakit_ya){ 
                            echo " <span class='fa fa-check-square-o'></span> Ya";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Ya";
                            }
                        ?>
                    </td>
                    <td style="padding-left:5px"> 
                        <?php  if($model->nutrisi_status_beratbadanhilang_tidak){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak";
                            }
                        ?> <br> 
                        <?php  
                            if($model->nutrisi_status_asupankuran_tidak){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak";
                            }
                        ?> <br>
                        <?php  
                            if($model->nutrisi_status_deritapenyakit_tidak){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Jika ada jawaban “Ya” lebih dari 1 maka sudah harus dilanjutkan ke Asesmen Awal Gizi (RM 05d K)</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <table width="100%" border="0px">
                <tr>
                    <td><h4>B6 KULIT DAN MUSKULOSKELETAL</h4></td>
                </tr>
                <tr>
                    <td> Kulit dan mukosa :
                        <?php if($model->kulit_icterus){ 
                            echo " <span class='fa fa-check-square-o'></span> Icterus";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Icterus";
                            }

                            if($model->kulit_luka){ 
                              echo " <span class='fa fa-check-square-o'></span> Luka";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Luka";
                            }

                            if($model->kulit_normal){ 
                              echo " <span class='fa fa-check-square-o'></span> Normal";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Normal";
                            }

                            if($model->kulit_lainnya){ 
                              echo " <span class='fa fa-check-square-o'></span> Dll : ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dll : ";
                            }

                            echo !empty($model->kulit_keterangan) ? $model->kulit_keterangan : "............................................................................................."; ?>
                        <br>
                        Muskuloskeletal <span style="color:transparent">a</span>:
                        <?php if($model->muskuloskeletal_deformitas){ 
                            echo " <span class='fa fa-check-square-o'></span> Deformitas";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Deformitas";
                            }

                            if($model->muskuloskeletal_decubitus){ 
                              echo " <span class='fa fa-check-square-o'></span> Decubitus";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Decubitus";
                            }

                            if($model->muskuloskeletal_normal){ 
                              echo " <span class='fa fa-check-square-o'></span> Normal";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Normal";
                            }

                            if($model->muskuloskeletal_kekuatanotot){ 
                              echo " <span class='fa fa-check-square-o'></span> Kekuatan otot :";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Kekuatan otot :";
                            }

                            if($model->muskuloskeletal_kekuatanotot_ket == 'PARALYSE'){ 
                              echo " <strike>Parese</strike> / Paralyse";
                            }elseif($model->muskuloskeletal_kekuatanotot_ket == 'PARESE'){
                              echo " Parese / <strike>Paralyse</strike>";
                            }else{
                              echo " Parese / Paralyse";
                            }

                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="page-break"></div>
<br style="margin-top: 70px !important">
<table width="100%" class="table-condensed" border="1px">    
    <tr>
        <td colspan="5">
            <table>
                <tr>
                    <td colspan="2"><h4>LAIN-LAIN</h4></td>
                </tr>
                <tr>
                    <td style="min-width:3%"><h4>a.</h4></td>
                    <td><h4>SOSIAL DAN EKONOMI</h4></td>
                </tr>
                <tr>
                    <td></td>
                    <td> Hubungan pasien dengan anggota keluarga :
                        <?php if($model->sosial_hubkeluarga_baik){ 
                            echo " <span class='fa fa-check-square-o'></span> Baik";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Baik";
                            }

                            if($model->sosial_hubkeluarga_tidakbaik){ 
                              echo " <span class='fa fa-check-square-o'></span> Tidak baik";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak baik";
                            }
                        ?>
                        <br>
                        Tempat tinggal :
                        <?php if($model->sosial_tempattinggal_rumahpribadi){ 
                            echo " <span class='fa fa-check-square-o'></span> Rumah pribadi";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Rumah pribadi";
                            }

                            if($model->sosial_tempattinggal_rumahkeluarga){ 
                              echo " <span class='fa fa-check-square-o'></span> Rumah keluarga";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Rumah keluarga";
                            }

                            if($model->sosial_tempattinggal_kontrak){ 
                              echo " <span class='fa fa-check-square-o'></span> Kontrak";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Kontrak";
                            }

                            if($model->sosial_tempattinggal_pantijompo){ 
                              echo " <span class='fa fa-check-square-o'></span> Panti jompo";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Panti jompo";
                            }

                            if($model->sosial_tempattinggal_lainnya){ 
                              echo " <span class='fa fa-check-square-o'></span> Lain2 : ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Lain2 : ";
                            }

                            echo !empty($model->sosial_tempattinggal_keteranganlain) ? $model->sosial_tempattinggal_keteranganlain : "........................"; ?>
                        <br>
                        Penanggung jawab perawatan di rumah ( care giver ) : <?php echo !empty($model->sosial_penanggungjawab) ? $model->sosial_penanggungjawab : ".........................................................................."; ?>
                    </td>
                </tr>
            </table>
            <br><br><br><br>
            <table>
                <tr>
                    <td style="min-width:3%"><h4>b.</h4></td>
                    <td><h4>KETERGANTUNGAN SAAT MELAKSANAKAN ADL ( Actifity Daily Life )</h4></td>
                    <td><h4>ALAT BANTU</h4></td>
                </tr>
                <tr>
                    <td></td>
                    <td> Mobilisasi <span style="color:transparent">aa.</span> :
                        <?php if($model->tergantung_mobilisasi_mandiri){ 
                            echo " <span class='fa fa-check-square-o'></span> Mandiri";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Mandiri";
                            }

                            if($model->tergantung_mobilisasi_dibantu){ 
                              echo " <span class='fa fa-check-square-o'></span> Dibantu";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dibantu";
                            }

                            if($model->tergantung_mobilisasi_tergantungpenuh){ 
                              echo " <span class='fa fa-check-square-o'></span> Tergantung Penuh";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tergantung Penuh";
                            }
                        ?>
                        <br>
                        Personal <span style="color:transparent">aAA</span> :
                        <?php if($model->tergantung_personal_mandiri){ 
                            echo " <span class='fa fa-check-square-o'></span> Mandiri";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Mandiri";
                            }

                            if($model->tergantung_personal_dibantu){ 
                              echo " <span class='fa fa-check-square-o'></span> Dibantu";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dibantu";
                            }

                            if($model->tergantung_personal_tergantungpenuh){ 
                              echo " <span class='fa fa-check-square-o'></span> Tergantung Penuh";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tergantung Penuh";
                            }
                        ?>
                        <br>
                        Toileting <span style="color:transparent">aaa..</span> :
                        <?php if($model->tergantung_toileting_mandiri){ 
                            echo " <span class='fa fa-check-square-o'></span> Mandiri";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Mandiri";
                            }

                            if($model->tergantung_toileting_dibantu){ 
                              echo " <span class='fa fa-check-square-o'></span> Dibantu";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dibantu";
                            }

                            if($model->tergantung_toileting_tergantungpenuh){ 
                              echo " <span class='fa fa-check-square-o'></span> Tergantung Penuh";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tergantung Penuh";
                            }
                        ?>   
                        <br>
                        Berpakaian <span style="color:transparent">.A</span> :
                        <?php if($model->tergantung_berpakaian_mandiri){ 
                            echo " <span class='fa fa-check-square-o'></span> Mandiri";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Mandiri";
                            }

                            if($model->tergantung_berpakaian_dibantu){ 
                              echo " <span class='fa fa-check-square-o'></span> Dibantu";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dibantu";
                            }

                            if($model->tergantung_berpakaian_tergantungpenuh){ 
                              echo " <span class='fa fa-check-square-o'></span> Tergantung Penuh";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tergantung Penuh";
                            }
                        ?>
                        <br>
                        Makan/Minum :
                        <?php if($model->tergantung_mamin_mandiri){ 
                            echo " <span class='fa fa-check-square-o'></span> Mandiri";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Mandiri";
                            }

                            if($model->tergantung_mamin_dibantu){ 
                              echo " <span class='fa fa-check-square-o'></span> Dibantu";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Dibantu";
                            }

                            if($model->tergantung_mamin_tergantungpenuh){ 
                              echo " <span class='fa fa-check-square-o'></span> Tergantung Penuh";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tergantung Penuh";
                            }
                        ?>
                        <br>
                    </td>
                    <td>
                    <?php if($model->alatbantu_tidakada){ 
                        echo " <span class='fa fa-check-square-o'></span> Tidak ada";
                        }else{
                          echo " <span class='fa fa-square-o'></span> Tidak ada";
                        }

                        if($model->alatbantu_ada){ 
                          echo " <span class='fa fa-check-square-o'></span> Ada, bila ada :";
                        }else{
                          echo " <span class='fa fa-square-o'></span> Ada, bila ada :";
                        }
                    ?>
                        <br>
                    <?php if($model->alatbantu_ada_pendengaran){ 
                        echo " <span class='fa fa-check-square-o'></span> Pendengaran";
                        }else{
                          echo " <span class='fa fa-square-o'></span> Pendengaran";
                        }

                        if($model->alatbantu_ada_gigi){ 
                          echo " <span class='fa fa-check-square-o'></span> Gigi";
                        }else{
                          echo " <span class='fa fa-square-o'></span> Gigi";
                        }
                        ?>
                        <br>
                        <?php
                        if($model->alatbantu_ada_penglihatan){ 
                          echo " <span class='fa fa-check-square-o'></span> Penglihatan";
                        }else{
                          echo " <span class='fa fa-square-o'></span> Penglihatan";
                        }

                        if($model->alatbantu_ada_lainnya){ 
                          echo " <span class='fa fa-check-square-o'></span> Lain2";
                        }else{
                          echo " <span class='fa fa-square-o'></span> Lain2";
                        }
                        ?>
                        <br>
                        <?php
                        if($model->alatbantu_ada_gerak){ 
                          echo " <span class='fa fa-check-square-o'></span> Gerak";
                        }else{
                          echo " <span class='fa fa-square-o'></span> Gerak";
                        }
                        ?>
                        <br>
                        <?php
                        if($model->alatbantu_ada_jantung){ 
                          echo " <span class='fa fa-check-square-o'></span> Jantung";
                        }else{
                          echo " <span class='fa fa-square-o'></span> Jantung";
                        }
                    ?>
                    </td>
                        <br>
                    </td>
                </tr>
            </table>
            
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:3%"><h4>c.</h4></td>
                    <td><h4> GANGGUAN FUNGSIONAL</h4></td>
                </tr>
                <tr>
                    <td></td>
                    <td> 
                        <?php if($model->gangguanfungsi_buta){ 
                            echo " <span class='fa fa-check-square-o'></span> Buta";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Buta";
                            }

                            if($model->gangguanfungsi_tuli){ 
                              echo " <span class='fa fa-check-square-o'></span> Tuli";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tuli";
                            }

                            if($model->gangguanfungsi_dayaingat){ 
                              echo " <span class='fa fa-check-square-o'></span> Penurunan daya ingat";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Penurunan daya ingat";
                            }

                            if($model->gangguanfungsi_lemahanggotagerak){ 
                              echo " <span class='fa fa-check-square-o'></span> Kelemahan anggota gerak";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Kelemahan anggota gerak";
                            }

                            if($model->gangguanfungsi_normal){ 
                              echo " <span class='fa fa-check-square-o'></span> Normal";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Normal";
                            }
                        ?>
                        <br>

                    </td>
                </tr>
            </table>
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:3%"><h4>e.</h4></td>
                    <td><h4> SKRINING NYERI</h4></td>
                </tr>
                <tr>
                    <td></td>
                    <td> Nyeri : 
                        <?php if($model->skrining_nyeri_ada){ 
                            echo " <span class='fa fa-check-square-o'></span> Ada";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Ada";
                            }

                            if($model->skrining_nyeri_tidakada){ 
                              echo " <span class='fa fa-check-square-o'></span> Tidak ada";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak ada";
                            }
                        ?>            
                    </td>
                </tr>
            </table>
            
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:3%"><h4>f.</h4></td>
                    <td><h4> RISIKO INFEKSI</h4></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php if($model->resikoinfeksi_ada){ 
                            echo " <span class='fa fa-check-square-o'></span> Ada : ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Ada : ";
                            }

                            if($model->resikoinfeksi_ada_mrsa){ 
                            echo " <span class='fa fa-check-square-o'></span> MRSA";
                            }else{
                              echo " <span class='fa fa-square-o'></span> MRSA";
                            }
                            if($model->resikoinfeksi_ada_esbl){ 
                            echo " <span class='fa fa-check-square-o'></span> ESBL";
                            }else{
                              echo " <span class='fa fa-square-o'></span> ESBL";
                            }
                            if($model->resikoinfeksi_ada_tb){ 
                            echo " <span class='fa fa-check-square-o'></span> TB";
                            }else{
                              echo " <span class='fa fa-square-o'></span> TB";
                            }
                            if($model->resikoinfeksi_ada_vap){ 
                            echo " <span class='fa fa-check-square-o'></span> VAP";
                            }else{
                              echo " <span class='fa fa-square-o'></span> VAP";
                            }
                            if($model->resikoinfeksi_ada_lainnya){ 
                            echo " <span class='fa fa-check-square-o'></span> Lainnya : ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Lainnya : ";
                            }
                            echo !empty($model->resikoinfeksi_ada_keterangan) ? $model->resikoinfeksi_ada_keterangan : "........................................................................";

                        ?>  
                        <br>
                        <?php 

                            if($model->resikoinfeksi_tidakada){ 
                              echo " <span class='fa fa-check-square-o'></span> Tidak ada";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak ada";
                            }
                        ?>
                        <br>
                        <?php 

                            if($model->resikoinfeksi_tidakdiketahui){ 
                              echo " <span class='fa fa-check-square-o'></span> Tidak diketahui";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak diketahui";
                            }
                        ?>
                        <br>
                        Pencegahan yang harus dilakukan :
                        <?php 

                            if($model->pencegahan_droplet){ 
                              echo " <span class='fa fa-check-square-o'></span> Droplet";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Droplet";
                            }
                            if($model->pencegahan_udara){ 
                              echo " <span class='fa fa-check-square-o'></span> Udara";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Udara";
                            }
                            if($model->pencegahan_kontakkulit){ 
                              echo " <span class='fa fa-check-square-o'></span> Kontak langsung/kulit";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Kontak langsung/kulit";
                            }
                            if($model->pencegahan_cairankulit){ 
                              echo " <span class='fa fa-check-square-o'></span> Cairan kulit";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Cairan kulit";
                            }
                            if($model->pencegahan_cairantubuh){ 
                              echo " <span class='fa fa-check-square-o'></span> Cairan tubuh";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Cairan tubuh";
                            }
                        ?>
                    </td>
                </tr>
            </table>
            
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:3%"><h4>g.</h4></td>
                    <td><h4> RISIKO SOSIAL</h4></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php if($model->resikososial_hidupsendiri){ 
                            echo " <span class='fa fa-check-square-o'></span> Hidup sendiri ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Hidup sendiri";
                            }
                            ?>  
                        <br>
                        <?php 
                            if($model->resikososial_tidaktetap){ 
                            echo " <span class='fa fa-check-square-o'></span> Tempat tinggal tidak tetap";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tempat tinggal tidak tetap";
                            }
                            ?>  
                        <br>
                        <?php 
                            if($model->resikososial_tidakada){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak ada";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Tidak ada";
                            }
                            ?>  
                        <br>
                        
                    </td>
                </tr>
            </table>
            
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:3%"><h4>h.</h4></td>
                    <td><h4> KONDISI PSIKOLOGIS PASIEN</h4></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php if($model->kondisipasien_denial){ 
                            echo " <span class='fa fa-check-square-o'></span> Denial (menolak) ";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Denial (menolak)";
                            }
                            ?>  
                        <br>
                        <?php 
                            if($model->kondisipasien_marah){ 
                            echo " <span class='fa fa-check-square-o'></span> Marah";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Marah";
                            }
                            ?>  
                        <br>
                        <?php 
                            if($model->kondisipasien_bargaining){ 
                            echo " <span class='fa fa-check-square-o'></span> Bargaining";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Bargaining";
                            }
                            ?>  
                        <br>
                        <?php 
                            if($model->kondisipasien_depresi){ 
                            echo " <span class='fa fa-check-square-o'></span> Depresi/cemas";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Depresi/cemas";
                            }
                        ?> 
                        <br>
                        <?php 
                            if($model->kondisipasien_pasrah){ 
                            echo " <span class='fa fa-check-square-o'></span> Pasrah";
                            }else{
                              echo " <span class='fa fa-square-o'></span> Pasrah";
                            }
                        ?> 
                    </td>
                </tr>
            </table>
            
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:3%"><h4>i.</h4></td>
                    <td><h4> MASALAH KEPERAWATAN</h4></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php echo !empty($model->masalahkeperawatan) ? $model->masalahkeperawatan : "......................................................................................................................................................"
                                                                                             .'<br>'."......................................................................................................................................................"
                                                                                             .'<br>'."......................................................................................................................................................"
                                                                                             .'<br>'."......................................................................................................................................................"
                                                                                             .'<br>'."......................................................................................................................................................";       
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
                    <td style="min-width:50%; text-align:center" >Tanggal <?= MyFormatter::formatDateTimeForUser(date('d, F Y'));?> Jam <?= date('H:i')?> WIB</td>
                    <td style="min-width:50%; text-align:center" >Tanggal <?= MyFormatter::formatDateTimeForUser(date('d, F Y'));?> Jam <?= date('H:i')?> WIB</td>
                </tr>
                <tr rowspan='3'>
                    <td style="min-width:50%; text-align:center" >Nama dan Tanda Tangan Verifikasi DPJP Utama</td>
                    <td style="min-width:50%; text-align:center" >Nama dan Tanda Tangan Perawat / PPJP</td>
                </tr>

            </table>
            <br><br><br><br><br>
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:50%; text-align:center" ><?php echo $model->dpjp_nama ?></td>
                    <td style="min-width:50%; text-align:center" ><?php echo $model->perawat_nama ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>