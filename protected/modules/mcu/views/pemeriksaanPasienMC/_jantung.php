<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
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
        width: 14.7cm;
    }
    .content td{
        height: 28px;
    }
    
    .content .sub {
        font-weight: bold;
    }
</style>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%"> <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%"> <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
<?php 
if (count((array)$riwayat)>0){
foreach ($riwayat as $i => $model){
?>
    <table width="100%" class="table-condensed" border="1px" style="margin-bottom: 10px;">
        <tr>
            <td style="border-right-color:#fff; font-weight: bold;" colspan="2">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>Tgl. Pemeriksaan</td>
                        <td>: <?php echo MyFormatter::formatDateTimeForuser($model->tgl_pemeriksaan); ?></td>
                        <td>Dokter Pemeriksa</td>
                        <td>: <?php echo empty($model->dokterpemeriksa) ? "-" : $model->dokterpemeriksa->namaLengkap; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width='100%'>
                    <tr>
                        <td colspan="4"><u> <b> Anamnesis </b> </u> </td>
                    </tr>
                    <tr>
                        <td width="20%"> Keluhan Utama: </td>
                        <td width="30%"> : <?php echo $model->keluhan_utama;?> </td>
                        <td width="20%"> Nyeri </td>
                        <td width="30%">: <?php echo $model->nyeri; ?>  </td>
                    </tr>
                    <tr>
                        <td> Palpitasi </td>
                        <td>: <?php echo $model->palpitasi; ?></td>
                        <td> Batuk </td>
                        <td>: <?php echo $model->batuk; ?> </td>
                    </tr>
                    <tr>
                        <td> Dyapneu </td>
                        <td>: <?php echo $model->dyapneu; ?></td>
                        <td> Edoma </td>
                        <td>: <?php echo $model->edoma; ?> </td>
                    </tr>
                    <tr>
                        <td> Hemoptysis </td>
                        <td>: <?php echo $model->hemoptysis; ?> </td>
                        <td> Pingsan </td>
                        <td>: <?php echo $model->pingsan; ?>  </td>
                    </tr>
                    <tr>
                        <td> Pusing </td>
                        <td>: <?php echo $model->pusing; ?> </td>
                        <td> Tonsilitis </td>
                        <td>: <?php echo $model->tonsilitas; ?>  </td>
                    </tr>
                    <tr>
                        <td> Kelainan Pencernaan : </td>
                        <td>: <?php echo $model->kelainan_pencernaan; ?> </td>
                        <td> Nephritis </td>
                        <td>: <?php echo $model->nephritis; ?>  </td>
                    </tr>
                    <tr>
                        <td> Rheumatic Fever </td>
                        <td>: <?php echo $model->rheumatic_fever; ?> </td>
                        <td> Influenza </td>
                        <td>: <?php echo $model->influenza; ?>  </td>
                    </tr>
                    <tr>
                        <td> Syphilis </td>
                        <td>: <?php echo $model->syphilis?>  </td>
                        <td> Lain-lain </td>
                        <td>: <?php echo $model->lain_lain ?> </td>
                    </tr>
                    <tr>
                        <td> Diphteria </td>
                        <td>: <?php echo $model->diphtheria; ?>  </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
        <tr>
            <td style="border-right: none; vertical-align: top;" width="50%">
                <table width='100%'>
                    <tr>
                        <td colspan="2"><u><b>Diagnostik Fisik</b></u></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="1"> N </td>
                        <td> : <?php echo $model->nadi ?> / menit.</td>
                    </tr>
                    <tr>
                        <td> T  </td>
                        <td> : <?php echo $model->tekanandarah_sistolik." / ".$model->tekanandarah_diastolik ?></td>
                    </tr>
                    <tr>
                        <td> U.V.P.   </td>
                        <td>: <?php echo $model->uvp ?> cm H2O</td>
                    </tr>
                    <tr>
                        <td> Kesan Umum  </td>
                        <td>: <?php echo $model->kesan_umum ?>  </td>
                    </tr>
                    <tr>
                        <td colspan="2"><u><b>Thorax</b></u></td>
                    </tr>
                    <tr>
                        <td>Jantung-Inspeksi</td>
                        <td>: <?php echo $model->thorax_jantung_inspeksi ?> </td>
                    </tr>
                    <tr>
                        <td>Palpasi-Apex</td>
                        <td>: <?php echo $model->thorax_palpasi_apex ?></td>
                    </tr>
                    <tr>
                        <td>Pulsasi</td>
                        <td>: <?php echo $model->thorax_pulsasi ?></td>
                    </tr>
                    <tr>
                        <td>List</td>
                        <td>: <?php echo $model->thorax_lift ?> Sternal List</td>
                    </tr>
                    <tr>
                        <td>Thrill</td>
                        <td>: <?php echo $model->thorax_thrill ?></td>
                    </tr>
                    <tr>
                        <td> Perkusi</td>
                        <td> : <?php echo $model->thorax_purkusi ?> </td>
                    </tr>
                    <tr>
                        <td>Auskultasi</td>
                        <td>: <?php echo $model->thorax_auskultasi ?>  </td>
                    </tr>
                    <tr>
                        <td> Paru </td>
                        <td> : <?php echo $model->thorax_paru ?> </td>
                    </tr>
                </table>
            </td>
            <td style="border-left: none; vertical-align: top;" width="50%">
                <table>
                    <tr>
                        <td colspan="2"><u><b>Leher</b></u></td>
                    </tr>
                    <tr>
                        <td width="40%"> Kelenjar gondok </td>
                        <td> : <?php echo $model->leher_kelenjar_gondok ?> </td>
                    </tr>
                    <tr>
                        <td> Pulsasi  </td>
                        <td> : <?php echo $model->leher_pulsasi ?>  </td>
                    </tr>
                    <tr>
                        <td> Vera melebar</td>                
                        <td> : <?php echo $model->leher_vera_melebar ?> </td>
                    </tr>
                    <tr>
                        <td> Carotid Shudder </td>
                        <td> : <?php echo $model->leher_carotid_shudder ?>  </td>
                    </tr>
                    <tr>
                        <td colspan="2"><u><b>Abdomen</b></u></td>
                    </tr>
                    <tr>
                        <td> Hati  </td>
                        <td> : <?php echo $model->abdomen_hati ?> </td>
                    </tr>
                    <tr>
                        <td> Ascites  </td>
                        <td> : <?php echo $model->abdomen_ascites ?>  </td>
                    </tr>
                    <tr>
                        <td> Limpa </td>
                        <td> : <?php echo $model->abdomen_limpa ?>  </td>
                    </tr>
                    <tr>
                        <td> Extremitas </td>                
                        <td> : <?php echo $model->extremitas ?>  </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
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
    
    
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada Riwayat Jantung</td>
    </tr> 
<?php } ?>
</table> 