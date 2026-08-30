<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
@page {
       size: 7in 9.25in;
       font-family: Arial, sans-serif;
       font-size: 11px !important;
       padding-top: 30px;
       margin-top: 0;
       margin-bottom: 0;
       
    }
    @media print {
      html, body {
        padding-top: 30px;
        padding-left: 10px;
        width: 210mm;
        height: 297mm;
        line-height: 1.3;
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

<table width="100%" border="1px">
    <tr>
        <td rowspan="3" style="width:65%"><?php echo $this->renderPartial('mcu.views.pemeriksaanUmumMcu._headerPrint'); ?></td>
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
<div style="padding-top: 10px; padding-bottom: 10px; text-align:center; font-weight:bold">
    <h4>KARTU CHECK-UP</h4>
</div>
<table width="100%" class="table-condensed" border="1px">
    <tr>
        <td style="border-right-color:#fff">
            <table>
                <tr>
                    <td> Jenis Keperluan </td>
                    <td> :
                    <?php 
                        if (!empty($model->jeniskeperluanmcu)) {
                            echo $model->jeniskeperluanmcu;
                        } else {
                            echo "-";
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>Keperluan MCU </td>
                    <td>:
                    <?php 
                        if(!empty($model->diagnosis)){ 
                            echo $model->diagnosis;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Tekanan Darah</td>
                    <td>:
                    <?php 
                        if(!empty($model->tekanandarah_sistolik)){ 
                            echo $model->tekanandarah_sistolik." / ";
                        }else{
                            echo "- / ";
                        }
                        
                        if(!empty($model->tekanandarah_diastolik)){ 
                            echo $model->tekanandarah_diastolik." mmHg";
                        }else{
                            echo "- mmHg";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Nadi</td>
                    <td>:
                    <?php 
                        if(!empty($model->nadi)){ 
                            echo $model->nadi." x/menit";
                        }else{
                            echo "- x/menit";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Berat Badan</td>
                    <td>:
                    <?php 
                        if(!empty($model->beratbadan)){ 
                            echo $model->beratbadan." kg";
                        }else{
                            echo "- kg";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Tinggi Badan</td>
                    <td>:
                    <?php 
                        if(!empty($model->tinggibadan)){ 
                            echo $model->tinggibadan." cm";
                        }else{
                            echo "- cm";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>BMI</td>
                    <td>:
                    <?php 
                        if(!empty($model->nilai_bmi)){ 
                            echo $model->nilai_bmi;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php 
                        if(!empty($model->bmi_kategori)){ 
                            echo $model->bmi_kategori;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Kepala</td>
                    <td>:
                    <?php 
                        if($model->kepala_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }else if($model->kepala_normal == false){
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp; ";
                        }
                        if($model->kepala_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->kepala_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }
                        ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php 
                        if(!empty($model->kepala_keterangan)){ 
                            echo $model->kepala_keterangan;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Jantung</td>
                    <td>:
                    <?php 
                        if($model->jantung_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->jantung_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->jantung_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->jantung_abnormal == false){
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php 
                        if(!empty($model->jantung_keterangan)){ 
                            echo $model->jantung_keterangan;
                        }else{
                            echo "-";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td>Hepar</td>
                    <td>:
                    <?php 
                        if($model->hepar_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;  ";
                        }elseif($model->hepar_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;  ";
                        }
                        if($model->hepar_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->hepar_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php 
                        if(!empty($model->hepar_keterangan)){ 
                            echo $model->hepar_keterangan;
                        }else{
                            echo "-";
                        }
                    ?>
                    </td> 
                </tr>
                <tr>
                    <td>Limpa</td>
                    <td>:
                    <?php 
                        if($model->limpa_takteraba == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Tak Teraba <span style='color:transparent'>a</span>";
                        }elseif($model->limpa_takteraba == false){ 
                            echo "<span class='fa fa-square-o'></span> Tak Teraba &nbsp;  ";
                        }
                        if($model->limpa_teraba == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Teraba";
                        }elseif($model->limpa_teraba == false){ 
                            echo "<span class='fa fa-square-o'></span> Teraba";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php 
                        if(!empty($model->limpa_keterangan)){ 
                            echo $model->limpa_keterangan;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Ekstremitas</td>
                    <td>:
                    <?php 
                        if($model->extremitas_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->extremitas_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->extremitas_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->extremitas_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td><span style="color:transparent">Tulang/Persendian</span></td>
                    <td><span style="color:transparent">:</span>
                    <?php if(!empty($model->extremitas_keterangan)){ 
                                echo $model->extremitas_keterangan;
                            }else{
                                echo "-";
                            } ?>
                    </td> 
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td><span style="color:transparent">Tulang/Persendian</span></td>
                    <td>&nbsp;</td> 
                </tr>
                <tr>
                <td>Gizi</td>
                    <td>:
                    <?php 
                        if($model->gizi_baik == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Baik &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->gizi_baik == false){ 
                            echo "<span class='fa fa-square-o'></span> Baik &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->gizi_kurang == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Kurang";
                        }elseif($model->gizi_kurang == true){ 
                            echo "<span class='fa fa-square-o'></span> Kurang";
                        }
                        ?>
                    </td> 
                </tr>
                <tr>
                    <td>Anemia</td>
                    <td>:
                    <?php 
                        if($model->anemia_positif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;";
                        }elseif($model->anemia_positif == false){ 
                            echo "<span class='fa fa-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;";
                        }
                        if($model->anemia_negatif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> -";
                        }elseif($model->anemia_negatif == false){ 
                            echo "<span class='fa fa-square-o'></span> -";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Sesak</td>
                    <td>:
                    <?php 
                        if($model->sesak_positif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;";
                        }elseif($model->sesak_positif == false){ 
                            echo "<span class='fa fa-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;";
                        }
                        if($model->sesak_negatif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> -";
                        }elseif($model->sesak_negatif == false){ 
                            echo "<span class='fa fa-square-o'></span> -";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Ikterus</td>
                    <td>:
                    <?php 
                        if($model->ikterus_positif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;";
                        }elseif($model->ikterus_positif == false){ 
                            echo "<span class='fa fa-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;";
                        }
                        if($model->ikterus_negatif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> -";
                        }elseif($model->ikterus_negatif == false){ 
                            echo "<span class='fa fa-square-o'></span> -";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td>Sembab</td>
                    <td>:
                    <?php 
                        if($model->sembab_positif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;";
                        }elseif($model->sembab_positif == false){ 
                            echo "<span class='fa fa-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;";
                        }
                        if($model->sembab_negatif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> -";
                        }elseif($model->sembab_negatif == false){ 
                            echo "<span class='fa fa-square-o'></span> -";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php 
                        if(!empty($model->sembab_keterangan)){ 
                            echo $model->sembab_keterangan;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Leher</td>
                    <td>:
                    <?php 
                        if($model->leher_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->leher_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->leher_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->leher_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php if(!empty($model->leher_keterangan)){ 
                                echo $model->leher_keterangan;
                            }else{
                                echo "-";
                            }?>
                    </td> 
                </tr>
                <tr>
                    <td>Paru</td>
                    <td>:
                    <?php 
                        if($model->paru_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->paru_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->paru_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->paru_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }  ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php if(!empty($model->paru_keterangan)){ 
                                echo $model->paru_keterangan;
                            }else{
                                echo "-";
                            }?>
                    </td> 
                </tr>
                <tr>
                    <td>Abdomen</td>
                    <td>:
                    <?php 
                        if($model->abdomen_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->abdomen_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->abdomen_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->abdomen_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }  ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php if(!empty($model->abdomen_keterangan)){ 
                                echo $model->abdomen_keterangan;
                            }else{
                                echo "-";
                            }?>
                    </td> 
                </tr>
                <tr>
                    <td>Tulang/Persendian</td>
                    <td>:
                    <?php 
                        if($model->tulangpersendian_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->tulangpersendian_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->tulangpersendian_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->tulangpersendian_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }  ?>
                    </td> 
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php if(!empty($model->tulangpersendian_keterangan)){ 
                                echo $model->tulangpersendian_keterangan;
                            }else{
                                echo "-";
                            }?>
                    </td> 
                </tr>
                <tr>
                    <td>Foto Thorax</td>
                    <td>:
                    <?php 
                        if($model->fotothorax_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->fotothorax_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->fotothorax_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->fotothorax_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }  ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td><span style="color:transparent">:</span>
                    <?php if(!empty($model->fotothorax_keterangan)){ 
                                echo $model->fotothorax_keterangan;
                            }else{
                                echo "-";
                            }?>
                    </td> 
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan='2'><b>Pemeriksaan Laboratorium</b></td>
    </tr>
    <tr>
        <td style="border-right-color:#fff">
            <table>
                <tr>
                    <td>BILL D</td>
                    <td>:
                    <?php                         
                        if(!empty($model->bill_d)){ 
                            echo $model->bill_d;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>BILL T</td>
                    <td>:
                    <?php 
                        if(!empty($model->bill_t)){ 
                            echo $model->bill_t;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>LDL</td>
                    <td>:
                    <?php 
                        if(!empty($model->ldl)){ 
                            echo $model->ldl;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Hb</td>
                    <td>:
                    <?php 
                        if(!empty($model->hb)){ 
                            echo $model->hb;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">g%</span>
                    </td> 
                </tr>
                <tr>
                    <td>Lekosit</td>
                    <td>:
                    <?php 
                        if(!empty($model->lekosit)){ 
                            echo $model->lekosit;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">/mm3</span>
                    </td> 
                </tr>
                <tr>
                    <td>Hitung Jenis</td>
                    <td>: Eo 
                    <?php 
                        if(!empty($model->hitungjenis_eo)){ 
                            echo $model->hitungjenis_eo;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td>: Ba
                    <?php 
                        if(!empty($model->hitungjenis_ba)){ 
                            echo $model->hitungjenis_ba;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td><span style="color:transparent">Tulang/Persendian</span></td>
                    <td>: St
                    <?php 
                        if(!empty($model->hitungjenis_st)){ 
                            echo $model->hitungjenis_st;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td>: Sgm
                    <?php 
                        if(!empty($model->hitungjenis_sgm)){ 
                            echo $model->hitungjenis_sgm;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td>: Ly
                    <?php 
                        if(!empty($model->hitungjenis_ly)){ 
                            echo $model->hitungjenis_ly;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td>: h 
                    <?php 
                        if(!empty($model->hitungjenis_h)){ 
                            echo $model->hitungjenis_h;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>BSN</td>
                    <td>:
                    <?php 
                        if(!empty($model->bsn)){ 
                            echo $model->bsn;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">mg%</span>
                    </td> 
                </tr>
                <tr>
                    <td>2JPP</td>
                    <td>:
                    <?php 
                        if(!empty($model->dua_jpp)){ 
                            echo $model->dua_jpp;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">mg%</span>
                    </td> 
                </tr>
                <tr>
                    <td>Kolesterol total</td>
                    <td>:
                    <?php 
                        if(!empty($model->kolesterol_total)){ 
                            echo $model->kolesterol_total;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">mg%</span>
                    </td> 
                </tr>
                <tr>
                    <td>SGOT</td>
                    <td>:
                    <?php 
                        if(!empty($model->sgot)){ 
                            echo $model->sgot;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">S FU</span>
                    </td> 
                </tr>
                <tr>
                    <td>SGPT</td>
                    <td>:
                    <?php 
                        if(!empty($model->sgpt)){ 
                            echo $model->sgpt;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">S FU</span>
                    </td> 
                </tr>
                
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>ALK</td>
                    <td>:
                    <?php                         
                        if(!empty($model->alk)){ 
                            echo $model->alk;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>HDL</td>
                    <td>:
                    <?php 
                        if(!empty($model->hdl)){ 
                            echo $model->hdl;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>LED</td>
                    <td>:
                    <?php 
                        if(!empty($model->led)){ 
                            echo $model->led;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td><span style="color:transparent">Tulang/Persendian</span></td>
                    <td>&nbsp;</td> 
                </tr>
                <tr>
                    <td>Golongan Darah</td>
                    <td>:
                    <?php 
                        if(!empty($model->golongandarah)){ 
                            echo $model->golongandarah;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Urine</td>
                    <td>:  
                    <?php 
                        if($model->urine_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->urine_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->urine_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->urine_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td>:
                    <?php 
                        if($model->urine_abnormal == true){ 
                            if(!empty($model->urine_keterangan)){ 
                                echo $model->urine_keterangan;
                            }else{
                                echo "-";
                            }
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Foses</td>
                    <td>:
                    <?php 
                        if($model->foses_normal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->foses_normal == false){ 
                            echo "<span class='fa fa-square-o'></span> Normal &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->foses_abnormal == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Abnormal";
                        }elseif($model->foses_abnormal == false){ 
                            echo "<span class='fa fa-square-o'></span> Abnormal";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td></td>
                    <td>:
                    <?php 
                        if($model->foses_abnormal == true){ 
                            if(!empty($model->foses_keterangan)){ 
                                echo $model->foses_keterangan;
                            }else{
                                echo "-";
                            }
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Triglisarida</td>
                    <td>: 
                    <?php 
                        if(!empty($model->triglisarida)){ 
                            echo $model->triglisarida;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">mg%</span>
                </tr>
                <tr>
                    <td>BUN</td>
                    <td>:  
                    <?php 
                        if(!empty($model->bun)){ 
                            echo $model->bun;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">mg%</span>
                    </td> 
                </tr>
                <tr>
                    <td>Kreatinin</td>
                    <td>:
                    <?php 
                        if(!empty($model->kreatinin)){ 
                            echo $model->kreatinin;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">mg%</span>
                    </td> 
                </tr>
                <tr>
                    <td>Asam Urat</td>
                    <td>:
                    <?php 
                        if(!empty($model->asamurat)){ 
                            echo $model->asamurat;
                        }else{
                            echo "-";
                        } ?>
                        <span style="float:right">mg%</span>
                    </td> 
                </tr>
                <tr>
                    <td>HbeAg</td>
                    <td>:
                    <?php 
                        if($model->hbeag_positif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;";
                        }elseif($model->hbeag_positif == false){ 
                            echo "<span class='fa fa-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;";
                        }
                        if($model->hbeag_negatif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> -";
                        }elseif($model->hbeag_negatif == false){ 
                            echo "<span class='fa fa-square-o'></span> -";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td>Anti Hbe</td>
                    <td>:
                    <?php 
                        if($model->antihbe_positif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;";
                        }elseif($model->antihbe_positif == false){ 
                            echo "<span class='fa fa-square-o'></span> + &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;";
                        }
                        if($model->antihbe_negatif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> -";
                        }elseif($model->antihbe_negatif == false){ 
                            echo "<span class='fa fa-square-o'></span> -";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td> 
                </tr>
            </table>
        </td> 
    </tr>
    <tr>
        <td style="border-right-color:#fff">
            <table>
                <tr>
                    <td>Kesimpulan</td>
                    <td>:
                    <?php 
                        if($model->kesimpulan_kesehatan == 'Sehat'){ 
                            echo "<span class='fa fa-check-square-o'></span> Sehat &nbsp; &nbsp; &nbsp; &nbsp;";
                        }elseif($model->kesimpulan_kesehatan != 'Sehat'){ 
                            echo "<span class='fa fa-square-o'></span> Sehat &nbsp; &nbsp; &nbsp; &nbsp;";
                        }
                        if($model->kesimpulan_kesehatan == 'Ada Kelainan'){ 
                            echo "<span class='fa fa-check-square-o'></span> Ada Kelainan";
                        }elseif($model->kesimpulan_kesehatan != 'Ada Kelainan'){ 
                            echo "<span class='fa fa-square-o'></span> Ada Kelainan";
                        }?>
                    </td> 
                </tr>
                <tr>
                    <td>Dugaan Diagnosis</td>
                    <td>:
                    <?php 
                        if(!empty($model->dugaan_diagnosis)){ 
                            echo $model->dugaan_diagnosis;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>Terapi</td>
                    <td>:
                    <?php 
                        if(!empty($model->terapi)){ 
                            echo $model->terapi;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Saran</td>
                    <td>:
                    <?php 
                        if(!empty($model->saran)){ 
                            echo $model->saran;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
            </table>
        </td> 
    </tr>
</table>
<!--<div class="page-break"></div>-->
<table style="width: 100%; border: none;">
    <tr>
        <td width="65%">&nbsp;</td>
        <td width="35%" style="text-align: center;">    
            <br>
            <?php echo date('d ', strtotime($model->tgl_pemeriksaan)).MyFormatter::getMonthId(date('m', strtotime($model->tgl_pemeriksaan))).date(' Y', strtotime($model->tgl_pemeriksaan)).date(' H:i', strtotime($model->tgl_pemeriksaan))." WIB";  ?><br>
            Pemeriksa
            <br><br><br><br><br><br>

            <?php 
            $cekPegawai = PegawaiM::model()->findByPk($model->dokterpemeriksa_id);
            echo $cekPegawai->namaLengkap;
            echo '<br>NIP. '.$cekPegawai->nomorindukpegawai;  ?>

        </td>
    </tr>
</table>