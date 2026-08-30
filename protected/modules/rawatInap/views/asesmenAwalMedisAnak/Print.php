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
    <h4 style='padding-left:35px'>ASESMEN AWAL MEDIS KEPERAWATAN RAWAT JALAN</h4><br>
</div>
<table width="100%" class="table-condensed" border="1px">
    <tr style="background-color:#afdc7e">
        <td  colspan='5'><b>Diisi oleh Dokter</b></td>
    </tr>
    <tr>
        <td colspan='5'>
            <table>
                <tr>
                    <td>Waktu pemeriksaan</td>
                    <td>: Tanggal : <?php echo date('d ', strtotime($model->tgl_pemeriksaan)).MyFormatter::getMonthId(date('m', strtotime($model->tgl_pemeriksaan))).date(' Y', strtotime($model->tgl_pemeriksaan));?>, 
                              Jam : <?php echo date('H:i', strtotime($model->tgl_pemeriksaan)); ?> WIB
                    </td>
                </tr>
                <tr>
                    <td>Nama DPJP</td>
                    <td>: <?php echo !empty($model->dokterdpjp_id) ? $model->dokterdpjp->namaLengkap : '-'; ?></td>
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
                    <td>Status Psikososial</td>
                    <td>: 
                        <?php 
                        if($model->status_psikososial_pakai_napza == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Pernah menggunakan NAPZA &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Pernah menggunakan NAPZA &nbsp;&nbsp;";
                        } 
                        
                        if($model->status_psikososial_cobabunuhdiri == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Percobaan bunuh diri &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Percobaan bunuh diri &nbsp;&nbsp;";
                        } 
                        
                        if($model->status_psikososial_kdrt == true){ 
                            echo " <span class='fa fa-check-square-o'></span> KDRT &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> KDRT &nbsp;&nbsp;";
                        } 
                        ?>
                    </td>   
                </tr>
                <tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span> 
                        <?php 
                        if($model->status_psikososial_agresif == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Agresif &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Agresif &nbsp;&nbsp;";
                        } 
                        
                        if($model->status_psikososial_tidakkooperatif == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tidak Kooperatif";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tidak Kooperatif";
                        }
                        ?>
                    </td>   
                </tr>
                <tr>
                    <td>Status Fungsional</td>
                    <td>: 
                        <?php 
                        if($model->statusfungsional_mandiri == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Mandiri &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Mandiri &nbsp;&nbsp;";
                        } 
                        
                        if($model->statusfungsional_tirahbaringparsial == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tirah baring parsial &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tirah baring parsial &nbsp;&nbsp;";
                        } 
                        
                        if($model->statusfungsional_tirahbaringtotal == true){ 
                            echo " <span class='fa fa-check-square-o'></span> Tirah baring total &nbsp;&nbsp;";
                        }else{
                            echo " <span class='fa fa-square-o'></span> Tirah baring total &nbsp;&nbsp;";
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
                    <td>Pemeriksaan Penunjang(Apabila diperlukan)</td>
                    <td>: <?php echo !empty($model->pemeriksaanpenunjang_ket) ? $model->pemeriksaanpenunjang_ket : $titik ?></td>
                </tr>
                <tr>
                    <td height="150"></td>
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
                    <td style="min-width:50%; text-align:center;" >
                        <?php 
                            $ppds = PpdsM::model()->findByPk($model->ppds_id);
                            echo !empty($ppds->ppds_nama)?$ppds->ppds_nama:'';
                        ?>
                    </td>
                    <td style="min-width:50%; text-align:center" ><?php echo !empty($model->dokterdpjp_id) ? $model->dokterdpjp->namaLengkap : '-'; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>