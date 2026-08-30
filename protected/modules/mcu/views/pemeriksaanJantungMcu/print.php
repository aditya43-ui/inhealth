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
<div class="row">
    <table width="100%" border="1px">
        <tr>
            <td rowspan="3" style="width:60%"><?php echo $this->renderPartial('mcu.views.pemeriksaanJantungMcu.headerPrint'); ?></td>
            <td style="width:15%" border-top="1px">Nama Lengkap</td>
            <td style="width:35%"><?php echo $modPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td style="width:15%">Tgl. Lahir </td>
            <td style="width:35%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
        </tr>
        <tr>
            <td style="width:15%">No. Rekam Medik</td>
            <td style="width:35%"><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
    </table>
    <div style="padding-top: 10px; padding-bottom: 10px; text-align:center; font-weight:bold">
        <h3> <b> CHECK-UP KHUSUS JANTUNG </b> </h3>
    </div>
    <table width="100%" class="table-condensed" border="1px">
        <tr>
            <td>
                <table>
                    <tr>
                        <td colspan="9"><u> <b> Anamnesis </b> </u> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width='100%'>
                    <tr> 
                        <td width="10%"> Keluhan Utama: </td>
                        <td width="80%" colspan="8"> : <?php echo $model->keluhan_utama;?> </td>
                    </tr>
                    <tr>
                        <td width="10%"> Palpitasi </td>
                        <td width="1%"> : </td>
                        <td width="15%"> <?php echo $model->palpitasi; ?></td>
                        <td width="10%"> Nyeri </td>
                        <td width="1%"> : </td>
                        <td width="30%" colspan="4"> <?php echo $model->nyeri; ?>  </td>
                    </tr>
                    <tr>
                        <td width="10%"> Dyapneu </td>
                        <td width="1%"> : </td>
                        <td width="15%"> <?php echo $model->dyapneu; ?>  </td>
                        <td width="10%"> Batuk </td>
                        <td width="1%"> : </td>
                        <td width="10%"> <?php echo $model->batuk; ?> </td>
                        <td width="10%"> Hemoptysis </td>
                        <td width="1%"> : </td>
                        <td width="10%"> <?php echo $model->hemoptysis; ?> </td>
                    </tr>
                    <tr>
                        <td width="10%"> Edoma </td>
                        <td width="1%"> : </td>
                        <td width="15%"> <?php echo $model->edoma; ?> </td>
                        <td width="10%"> Pusing </td>
                        <td width="1%"> : </td>
                        <td width="10%"> <?php echo $model->pusing; ?> </td>
                        <td width="10%"> Pingsan </td>
                        <td width="1%"> : </td>
                        <td width="10%"> <?php echo $model->pingsan; ?>  </td>
                    </tr>
                    <tr> 
                        <td width="10%"> Kelainan Pencernaan : </td>
                        <td width="1%"> : </td>
                        <td width="80%" colspan="6"> <?php echo $model->kelainan_pencernaan; ?> </td>
                    </tr>
                    <tr>
                        <td width="15%"> Rheumatic Fever </td>
                        <td width="1%"> : </td>
                        <td width="1%"> <?php echo $model->rheumatic_fever; ?> </td>
                        <td width="10%"> Syphilis </td>
                        <td width="1%"> : </td>
                        <td width="10%">  <?php echo $model->syphilis?>  </td>
                        <td width="10%"> Diphteria </td>
                        <td width="1%"> : </td>
                        <td width="10%"> <?php echo $model->diphtheria; ?>  </td>
                    </tr>
                    <tr>
                        <td width="10%"> Tonsilitis </td>
                        <td width="1%"> : </td>
                        <td width="15%"> <?php echo $model->tonsilitas; ?>  </td>
                        <td width="10%"> Nephritis </td>
                        <td width="1%"> : </td>
                        <td width="10%"> <?php echo $model->nephritis; ?>  </td>
                        <td width="10%"> Influenza </td>
                        <td width="1%"> : </td>
                        <td width="10%">  <?php echo $model->influenza; ?>  </td>
                    </tr>
                    <tr>
                        <td width="10%"> Lain-lain </td>
                        <td width="1%"> : </td>
                        <td colspan="7"> <?php echo $model->lain_lain ?> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width='100%'>
                    <tr>
                        <td width="15%"> Diagnostik fisik: </td>
                        <td colspan="2"> N : <?php echo $model->nadi ?> / menit. </td>
                        <td colspan="2"> T : <?php echo $model->tekanandarah_sistolik." / ".$model->tekanandarah_diastolik ?>  </td>
                        <td colspan="3"> U.V.P. : <?php echo $model->uvp ?> cm H2O  </td>
                    </tr>
                    <tr>
                        <td width="15%"> Kesan Umum  </td>
                        <td colspan="9"> : <?php echo $model->kesan_umum ?>  </td>
                    </tr>
                    <tr>
                        <td width="15%"> Thorax : </td>
                        <td colspan="2"> Jantung : Inspeksi : </td>
                        <td colspan="7"> : <?php echo $model->thorax_jantung_inspeksi ?>  </td>
                    </tr>
                    <tr>
                        <td>  </td>
                        <td colspan="2"> Palpasi :  Apex :</td>
                        <td colspan="7"> : <?php echo $model->thorax_palpasi_apex ?> </td>
                    </tr>
                    <tr>
                        <td>  </td>
                        <td colspan="2"> Pulsasi :  <?php echo $model->thorax_pulsasi ?>  </td>                
                        <td colspan="1"> Sternal Lift </td>
                        <td colspan="2"> : <?php echo $model->thorax_lift ?> </td>
                        <td colspan="1"> Thrill </td>
                        <td colspan="2"> : <?php echo $model->thorax_thrill ?>  </td>
                    </tr>
                    <tr>
                        <td>  </td>
                         <td> Purkusi  </td>
                         <td colspan="8"> : <?php echo $model->thorax_purkusi ?> </td>
                    </tr>
                    <tr>
                        <td>  </td>
                        <td> Auskultasi  </td>
                        <td colspan="8"> : <?php echo $model->thorax_auskultasi ?>  </td>
                    </tr>
                    <tr>
                        <td>  </td>
                        <td> Paru </td>
                        <td colspan="8"> : <?php echo $model->thorax_paru ?> </td>
                    </tr>
                    <tr>
                        <td colspan="1"> Leher   </td>                
                        <td colspan="1"> Kelenjar gondok </td>
                        <td colspan="3"> : <?php echo $model->leher_kelenjar_gondok ?> </td>
                        <td colspan="1"> Pulsasi  </td>
                        <td colspan="4"> : <?php echo $model->leher_pulsasi ?>  </td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td colspan="1"> Vera melebar</td>                
                        <td colspan="3"> : <?php echo $model->leher_vera_melebar ?> </td>
                        <td colspan="1"> Carotid Shudder </td>
                        <td colspan="4"> : <?php echo $model->leher_carotid_shudder ?>  </td>
                    </tr>
                     <tr>
                        <td colspan="1"> Abdomen :  </td>                
                        <td colspan="1"> Hati  </td>
                        <td colspan="3"> : <?php echo $model->abdomen_hati ?> </td>
                        <td colspan="1"> Ascites  </td>
                        <td colspan="4"> : <?php echo $model->abdomen_ascites ?>  </td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td> Limpa </td>
                        <td colspan="8"> : <?php echo $model->abdomen_limpa ?>  </td>
                    </tr>
                     <tr>
                        <td colspan="1"> Extremitas </td>                
                        <td colspan="9"> : <?php echo $model->extremitas ?>  </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="pemeriksaan" width='100%'>
                    <tr>
                        <td width="20%"> Pemeriksaan Sinar X  </td>
                        <td colspan="4"> : <?php echo $model->pemeriksaan_sinarx ?>  </td>
                    </tr>
                    <tr>
                        <td width="20%"> Elektrokardiogram  </td>
                        <td colspan="4"> : <?php echo $model->elektrokardiogram ?> </td>
                    </tr>
                    <tr>
                        <td width="20%"> Treadmill  </td>
                        <td colspan="4"> : <?php echo $model->treadmill ?>  </td>
                    </tr>
                    <tr>
                        <td width="20%"> Hasil Laboratorium </td>
                        <td colspan="4"> : <?php echo $model->hasil_laboratorium ?> </td>
                    </tr>
                    <tr>
                        <td width="20%"> Diagnosis Sementara  </td>
                        <td colspan="4"> : <?php echo $model->diagnosis_sementara ?>  </td>
                    </tr>
                    <tr>
                        <td width="20%"> Definitif  </td>
                        <td colspan="4"> : <?php echo $model->definitif ?>    </td>
                    </tr>
                    <tr>
                        <td rowspan="4" style="vertical-align: top"> Terapi  </td>
                        <td rowspan="4" style="vertical-align: top" colspan="1" width='50%'> : <?php echo $model->terapi ?>   </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
        <table style="width: 100%; border: none;">
            <tr>
                <td width="60%"> </td>
                <td width="40%" style="text-align: center">    
                    <br>
                    <?php echo date('d ', strtotime($model->tgl_pemeriksaan)).MyFormatter::getMonthId(date('m', strtotime($model->tgl_pemeriksaan))).date(' Y', strtotime($model->tgl_pemeriksaan))." ".date('H:i').' WIB';  ?><br>
                    Pemeriksa
                    <br><br><br><br><br><br>

                    <?php 
                    $cekPegawai = PegawaiM::model()->findByPk($model->dokterpemeriksa_id);
                    echo $cekPegawai->namaLengkap;
                    echo '<br>NIP. '.$cekPegawai->nomorindukpegawai;  ?>

                </td>
            </tr>
        </table>
                    
</div>
