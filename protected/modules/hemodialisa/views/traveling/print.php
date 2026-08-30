<?php
$profil = ProfilrumahsakitM::model()->find();
function ceklis($st){
    $icon = '<span  style="font-family:FontAwesome;" >&#xf096;</span>';
    if ($st){
        $icon = '<span  style="font-family:FontAwesome;" >&#xf046;</span>';
    }
    
    return $icon;
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    
<style type='text/css'>
    hr{
        margin:0px !important;        
        border: 1px solid #7f7b7b;
        box-shadow: inset 0 0 0 1000px gold;
    }
</style>
<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultOneLogoTanpaProfil',[
        'judulLaporan' => '<u>SURAT PENGANTAR HEMODIALISIS</u><br/><i>TRAVELING DIALYSIS</i>'
    ]);
?>
  
<table class='prinout no-grid w100' width='100%' style="padding:0px;margin:0px;">
    <tr>
        <td width='20%'>
            Nama Pasien
            <hr width='90px' />
            <i>Patient Name</i>
        </td>
        <td>
            <?= !empty($model->nama_pasien)?$model->nama_pasien:'&nbsp;' ?>
            <hr  />
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            Usia
            <hr width='90px' />
            <i>Age</i>
        </td>
        <td>
            <table>
                <tr>
                    <td align="center"style="padding-left:0px;">
                        <?= !empty($model->umur_pasien)?$model->umur_pasien:'&nbsp;&nbsp&nbsp;' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun
                        <hr  />
                        <i>years old</i>
                    </td>
                    <td align="center">
                        Jenis Kelamin &nbsp;&nbsp;&nbsp; :
                        <hr width="90px"  />
                        <i>Gender</i>
                    </td>
                    <td>
                        <?= ceklis($model->jk_lk) ?>
                    </td>
                    <td>
                        Pria
                        <hr width="30px"  />
                        <i>Male</i>
                    </td>
                    <td> <?= ceklis($model->jk_pr) ?>
                    </td>
                     <td>
                         Wanita
                        <hr width="40px"  />
                        <i>Female</i>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Alamat
            <hr width='90px' />
            <i>Address</i>
        </td>
        <td>
            <?= !empty($model->alamat_pasien)?$model->alamat_pasien:'&nbsp;' ?>
            <hr  />
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            Diagnosa
            <hr width='90px' />
            <i>Diagnosis</i>
        </td>
        <td>
            <?= !empty($model->diagnosa_nama)?$model->diagnosa_nama:'&nbsp;' ?>
            <hr  />
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            Hemodialisis Pertama
            <hr width='90px' />
            <i>First Dialysis</i>
        </td>
        <td>
            <table>
                <tr>
                    <td align=""style="padding-left:0px;">
                        Tanggal <?= !empty($model->hd_pertama)?date('d', strtotime($model->hd_pertama)):'&nbsp;&nbsp&nbsp;' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <hr  />
                        <i>Date</i>
                    </td>
                    <td align="">
                        Bulan <?= !empty($model->hd_pertama)?date('m', strtotime($model->hd_pertama)):'&nbsp;&nbsp&nbsp;' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <hr width="90px"  />
                        <i>Month</i>
                    </td>
                    <td align="">
                        Tahun <?= !empty($model->hd_pertama)?date('Y', strtotime($model->hd_pertama)):'&nbsp;&nbsp&nbsp;' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <hr width="90px"  />
                        <i>Years</i>
                    </td>                    
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Hemodialisis Terakhir
            <hr width='90px' />
            <i>Last Dialysis</i>
        </td>
        <td>
            <table>
                <tr>
                    <td align=""style="padding-left:0px;">
                        Tanggal <?= !empty($model->hd_terakhir)?date('d', strtotime($model->hd_terakhir)):'&nbsp;&nbsp&nbsp;' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <hr  />
                        <i>Date</i>
                    </td>
                    <td align="">
                        Bulan <?= !empty($model->hd_terakhir)?date('m', strtotime($model->hd_terakhir)):'&nbsp;&nbsp&nbsp;' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <hr width="90px"  />
                        <i>Month</i>
                    </td>
                    <td align="">
                        Tahun <?= !empty($model->hd_terakhir)?date('Y', strtotime($model->hd_terakhir)):'&nbsp;&nbsp&nbsp;' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <hr width="90px"  />
                        <i>Years</i>
                    </td>                    
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Dialiser
            <hr width='90px' />
            <i>Dialyzer</i>
        </td>
        <td>
            <table>
                <tr>
                    <td align="" style="padding-left:0px;">
                        <?= !empty($model->dialiser)?$model->dialiser:'&nbsp;&nbsp&nbsp;' ?> 
                        <hr width="150px" />
                        &nbsp;
                    </td>
                    <td align="">
                        Jenis Dialisat
                        <hr width="90px"  />
                        <i>Dialysate Type</i>
                    </td>
                    <td align="">
                        <?= ceklis($model->bicarbonate) ?>  Bicarbonate
                        <br/>
                        &nbsp;
                    </td>                    
                    <td align="">
                        <?= ceklis($model->asetat) ?>  Asetat
                        <br/>
                        &nbsp;
                    </td> 
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Frekuensi Dialisis
            <hr width='90px' />
            <i>Frequency Dialysis</i>
        </td>
        <td>
            <table>
                <tr>
                    <td style="padding-right:4px;padding-left: 0px; ">
                        <?= ceklis($model->minggu_1x) ?> 
                    </td>
                    <td align="" style="padding-left:0px;">
                        1x/week
                        <hr width="150px" />
                        <i>1x/week</i>
                    </td>
                    <td style="padding-right:4px;">
                        <?= ceklis($model->minggu_2x) ?>
                    </td>
                    <td align="" style="padding-left:0px;">
                         2x/week
                        <hr width="150px" />
                        <i>2x/week</i>
                    </td>
                     <td style="padding-right:4px;">
                        <?= ceklis($model->minggu_3x) ?>
                    </td>
                    <td align="" style="padding-left:0px;">
                        3x/week
                        <hr width="150px" />
                        <i>3x/week</i>
                    </td> 
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Kecepatan Aliran Dialisat
            <hr width='90px' />
            <i>Quick Dialysat (QD)</i>
        </td>
        <td>
            <table>
                <tr>
                    <td align="" style="padding-left:0px;">
                         <?= ceklis($model->menit_300ml) ?> 300 ml/mnt
                    </td>                    
                     <td align="" >
                         <?= ceklis($model->menit_400ml) ?> 400 ml/mnt
                    </td>
                     <td align="" >
                         <?= ceklis($model->menit_500ml) ?> 500 ml/mnt
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Lama Hemodialisis
            <hr width='90px' />
            <i>Duration Dialysis</i>
        </td>
        <td>
            <table>
                <tr>
                    <td style="padding-right:4px;padding-left: 0px; ">
                        <?= ceklis($model->tigajam) ?> 
                    </td>
                    <td align="" style="padding-left:0px;">
                        3 jam
                        <hr width="150px" />
                        <i>e Hours</i>
                    </td>
                    <td style="padding-right:4px;">
                        <?= ceklis($model->empatjam) ?>
                    </td>
                    <td align="" style="padding-left:0px;">
                         4 jam
                        <hr width="150px" />
                        <i>4 Hours</i>
                    </td>
                     <td style="padding-right:4px;">
                        <?= ceklis($model->limajam) ?>
                    </td>
                    <td align="" style="padding-left:0px;">
                        5 jam
                        <hr width="150px" />
                        <i>5 Hoursk</i>
                    </td> 
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>
        <td>
            Akses Vaskuler
            <hr width='90px' />
            <i>Vascular Access</i>
        </td>
        <td>
            <table>
                <tr>
                    <td style="padding-left: 0px; ">
                        <?= ceklis($model->femoral) ?> Femoral
                    </td>
                    <td align="" >
                        <?= ceklis($model->av_fistula) ?> Av Fistula
                    </td>
                    <td align="" >
                        Catheter Lumen : <?= ceklis($model->catlumen_lugular) ?> Lugural
                    </td>
                    <td align="" >
                        <?= ceklis($model->catlumen_subclavia) ?> Subclavia
                    </td>
                    <td align="" >
                        <?= ceklis($model->catlumen_femoral) ?> Femoral
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>
        <td>
            Heparinisasi
            <hr width='90px' />
            <i>Heparinization</i>
        </td>
        <td>
            <table>
                <tr>
                    <td style="padding-left: 0px; ">
                        <br/>
                        <?= !empty($model->heparinisasi)?$model->heparinisasi:'&nbsp;&nbsp&nbsp;' ?> 
                        <hr width='70px;' />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td align="" >
                         Bolus
                        <hr  />
                        <i>Bolus</i>
                    </td>
                     <td align="" >
                         Dosis
                        <hr  />
                        <i>Doze</i>
                    </td>
                    <td align="" >
                        <br/>
                        <?= !empty($model->dosis)?$model->dosis:'&nbsp;&nbsp&nbsp;' ?> 
                        <hr width='70px;' />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td style="padding-right:4px;">
                        <?= ceklis($model->unit_perjam) ?> 
                    </td>
                    <td align="" style="padding-left:0px;">
                        UI/Jam
                        <hr width="150px" />
                        <i>UI/Hours</i>
                    </td>
                    <td style="padding-right:4px;">
                        <?= ceklis($model->tanpa_heparin) ?> 
                    </td>
                    <td align="" style="padding-left:0px;">
                       Tanpa Heparin
                        <hr width="150px" />
                        <i>Free Heparin</i>
                    </td>
                    <td style="padding-right:4px;">
                        <?= ceklis($model->lmwh) ?> 
                    </td>
                    <td align="" style="padding-left:0px;">
                       LMWH
                        <hr width="150px" />
                        <i>LMWH</i>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Tekanan Darah
            <hr width='90px' />
            <i>Blood Pressure</i>
        </td>
        <td>
            <table>
                <tr>
                    <td style="padding-left: 0px; ">
                        <br/>
                        <?= !empty($model->tensi_sistolik)?$model->tensi_sistolik:'&nbsp;&nbsp&nbsp;' ?> 
                        <hr width='70px;' />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td align="" >
                         &nbsp;
                     <br/>
                        <i>Systolic</i>
                    </td>
                    <td style="padding-left: 0px; ">
                        <br/>
                        <?= !empty($model->tensi_diastolik)?$model->tensi_diastolik:'&nbsp;&nbsp&nbsp;' ?> 
                        <hr width='70px;' />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td align="" >
                         &nbsp;
                       <br/>
                        <i>Diastolic</i>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Hasil Laboratorium Terakhir
            <hr width='150px' />
            <i>Recent Laboratory Data</i>
        </td>
        <td>
            <?= !empty($model->hasil_lab)?$model->hasil_lab:'' ?>
            <hr />
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            Berat Badan Kering
            <hr width='90px' />
            <i>Dry Weight</i>
        </td>
        <td style="padding-right: 4px;">
           
            <table>
                <tr>
                    <td style="padding-left: 0px; ">
                        <?= !empty($model->bb_kering)?$model->bb_kering:'' ?>
                        <hr />
                        &nbsp;
                    </td>
                    <td align="" >
                        kg
                    </td>
                    <td style="padding-left: 0px; ">
                        Kenaikan Berat Badan
                        <hr />
                        <i>Average Weight Gain</i>
                    </td>
                    <td style="padding-right:4px;" >
                        <?= !empty($model->kenaikan_bb)?$model->kenaikan_bb:'' ?>
                        <hr />
                        &nbsp;
                    </td>                   
                     <td align="" >
                        kg
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Masalah yang sering terjadi 
            <hr width='220px' />
            <i>Problem During Dialysis And Comment</i>
        </td>
        <td>
            <?= !empty($model->masalah_seringterjadi)?$model->masalah_seringterjadi:'' ?>
            <hr />
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            Obat - obatan
            <hr width='90px' />
            <i>Medication</i>
        </td>
        <td>
            <?= !empty($model->obat)?$model->obat:'' ?>
            <hr />
            &nbsp;
        </td>
    </tr>
</table>
<br/>
<table width='100%'>
    <tr>
        <td width='5%'></td>
        <td width='45%'></td>
        <td width='45%' align='center'>
            <?= $profil->kabupaten->kabupaten_nama.' '.date('d').' '.MyFormatter::getMonthId(date('m')).' '.date('Y') ?>
        </td>
        <td width='5%'></td>
    </tr>
    <tr>
        <td ></td>
        <td></td>
        <td  align='center'>
            Mengetahui
        </td>
        <td width='5%'></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td ></td>
        <td></td>
        <td  align='center'>
            <?= '('.(!empty($model->dpjp)?$model->dpjp->namaLengkap:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').')' ?>
        </td>
        <td width='5%'></td>
    </tr>
</table>