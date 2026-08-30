<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style type="text/css">
  @page {
  size: A4;
  margin: 0;
  }
  @media print {
    html, body {
      width: 210mm;
      height: 297mm;
    }

    body {
        color: black;
        font-size: 8pt !important;
    }
  }

  html{
    font-size: 11pt !important;
    color: black;
  }

  body{
      color: black !important;
      margin: 0;
      padding: 0;
      font-size: 11pt !important;
  }

  table{
    font-size: 11pt !important;
    color: black;
  }

    label{
        color: black !important;
    }

    .fa{
        font-size: 12pt;
    }

    p {
        text-align: justify;
    }

    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .textbold {
        font-weight: bold !important;
    }
    .textcenter {
        text-align: center !important;
    }

    .textright {
        text-align: right !important;
    }

    .padding10 {
        padding: 10px !important;
    }
    .padding5 {
        padding: 5px;
    }

    .table-bordercustom th, .table-bordercustom td {
        border:1px solid #000;
        padding: 10px;
    }

    .tablepadding th, .tablepadding td{
        padding: 5px;
    }

</style>
<?php
  $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
 ?>
<div class="textbold padding10">
  FRM/110/RSBM
</div>
<?php echo $this->renderPartial($this->path_view."_headerPrint", array(
     'modProfilRs'=>$modProfilRs,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran
 ), true); ?>
 <table width="100%">
   <tr>
     <td width="50%" class="padding5">Tanggal : <?php echo MyFormatter::formatDateTimeForUser($model->tanggal_catat); ?> </td>
     <td class="padding5">Pukul : <?php echo $model->jam_pengisian; ?></td>
   </tr>
   <tr>
     <td colspan="2" class="bordertopclass padding5">
       <table width="100%" class="tablepadding">
         <tr>
           <td colspan="5">1. Data Medis RS</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px">a. Diagnosa Medis</td>
           <td width="5px">:</td>
           <td width="200px" class="borderbottomclass"><?php echo $model->diagnosa_nama; ?></td>
           <td width="20px"></td>
           <td width="200px" class="borderbottomclass"><?php echo $model->diagnosatambahan; ?></td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px" valign="top">b. Penunjang Diagnosis</td>
           <td width="5px" valign="top">:</td>
           <td  colspan="3">
             <span class="<?php echo ((!empty($model->diagnosis_penunjang) && ($model->diagnosis_penunjang =='Rontgen'))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Rontgen
             <span style="padding-left: 10px" class="<?php echo ((!empty($model->diagnosis_penunjang) && ($model->diagnosis_penunjang =='Lab'))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Lab
             <span style="padding-left: 28px" class="<?php echo ((!empty($model->diagnosis_penunjang) && ($model->diagnosis_penunjang =='CT Scan'))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> CT Scan
             <br/><br/>
             <span class="<?php echo ((!empty($model->diagnosis_penunjang) && ($model->diagnosis_penunjang =='MRI'))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> MRI
             <span style="padding-left: 34px" class="<?php echo ((!empty($model->diagnosis_penunjang) && ($model->diagnosis_penunjang =='ENMG'))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> ENMG
             <span style="padding-left: 10px" class="<?php echo ((!empty($model->diagnosis_penunjang) && ($model->diagnosis_penunjang =='EEG'))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> EEG
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px">c. Resume</td>
           <td width="5px">:</td>
           <td class="borderbottomclass"  colspan="3"><?php echo $model->resume; ?></td>
         </tr>
         <tr>
           <td colspan="5">2. Anamnesis</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px">a. Keluhan</td>
           <td width="5px">:</td>
           <td class="borderbottomclass" colspan="3"><?php echo $model->keluhanutama; ?></td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px">b. Riwayat Penyakit</td>
           <td width="5px">:</td>
           <td class="borderbottomclass"  colspan="3"><?php echo $model->riwayatpenyakit; ?></td>
         </tr>
         <tr>
           <td style="padding-left: 20px !important; padding-top: 30px !important;" colspan="5"><div  class="borderbottomclass"></div></td>
         </tr>
         <tr>
           <td colspan="5">3. Pemeriksaan Umum</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">a. Tanda Vital</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px">Tensi</td>
           <td width="5px">:</td>
           <td class="borderbottomclass"><?php echo $model->td_systolic .' / '. $model->td_dyastolic; ?></td>
           <td>MmHg</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px">Frekuensi Nadi</td>
           <td width="5px">:</td>
           <td class="borderbottomclass"><?php echo $model->nadi; ?></td>
           <td>x/menit</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px">Frekuensi Respirasi</td>
           <td width="5px">:</td>
           <td class="borderbottomclass"><?php echo $model->pernapasan; ?></td>
           <td>x/menit</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" width="100px">Suhu</td>
           <td width="5px">:</td>
           <td class="borderbottomclass"><?php echo $model->suhutubuh; ?></td>
           <td>&#176; C</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">b. Inspeksi</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             Statik (Bentuk Dada)<br />
             <?php
             $lookupStatikDada = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_STATIK_DADA."' order by lookup_urutan ASC");

             if(count($lookupStatikDada) >0 ){
               $htmlRisiko = "";
               foreach($lookupStatikDada as $i => $look_risiko){
                 $paddingstyle = "";

                 if($i > 0){
                   $paddingstyle = "style='padding-left: 5px'";
                 }

                $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->inspeksi_statik_bentukdada) && ($model->inspeksi_statik_bentukdada ==$look_risiko->lookup_value))?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look_risiko->lookup_value;
               }
               echo $htmlRisiko;
             }
              ?>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             Dinamis <br />
             <?php
             $lookupStatikDinamis = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_DINAMIS."' order by lookup_urutan ASC");

             if(count($lookupStatikDinamis) >0 ){
               $htmlRisiko = "";
               foreach($lookupStatikDinamis as $i => $look_risiko){
                 $paddingstyle = "";

                 if($i > 0){
                   $paddingstyle = "style='padding-left: 5px'";
                 }

                $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->inspeksi_dinamis) && ($model->inspeksi_dinamis ==$look_risiko->lookup_value))?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look_risiko->lookup_value;
               }
               echo $htmlRisiko;
             }
              ?>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">c. Palpasi</td>
         </tr>
         <tr>
           <td style="padding-left: 30px" colspan="5">
             <table width="100%">
               <tr>
                 <td width="50%">Ekspansi Thorax</td>
                 <td width="50%">Spasme Otot</td>
               </tr>
               <tr>
                 <td width="50%" valign="top">
                   <?php
                   $lookupEkspansi = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_THORAX."' order by lookup_urutan ASC");

                   if(count($lookupEkspansi) >0 ){
                     $htmlRisiko = "";
                     foreach($lookupEkspansi as $i => $look_risiko){
                       $paddingstyle = "";

                       if($i > 0){
                         $paddingstyle = "style='padding-left: 5px'";
                       }

                      $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->palpasi_ekspansi_thorax) && ($model->palpasi_ekspansi_thorax ==$look_risiko->lookup_value))?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look_risiko->lookup_value;
                     }
                     echo $htmlRisiko;
                   }
                    ?>
                 </td>
                 <td width="50%" valign="top">
                   <table width="100%">
                     <?php
                     $lookupSpasme = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_SPASME."' order by lookup_urutan ASC");

                     if(count($lookupSpasme) >0 ){
                       $htmlRisiko = "";
                       $indxRefleks = 0;
                       foreach($lookupSpasme as $i => $look_risiko){
                         $indxRefleks++;
                         if($indxRefleks == 1){
                           $htmlRisiko .= "<tr>";
                         }
                         $htmlRisiko .= "<td width='50%'><span class='".((!empty($model->palpasi_spasme_otot) && ($model->palpasi_spasme_otot ==$look_risiko->lookup_value))?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look_risiko->lookup_value."</td>";
                         if($indxRefleks == 2){
                           $htmlRisiko .= "</tr>";
                           $indxRefleks = 0;
                         }


                       }
                       echo $htmlRisiko;
                     }
                      ?>
                   </table>
                 </td>
               </tr>
             </table>
           </td>
         </tr>
         <tr>
           <td colspan="5">4. Pemeriksaan Khusus</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">a. Perkusi</td>
         </tr>
         <tr>
           <td style="padding-left: 40px" colspan="5">
             <?php
             $lookupPerkusi = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_PERKUSI."' order by lookup_urutan ASC");

             if(count($lookupPerkusi) >0 ){
               $htmlRisiko = "";
               foreach($lookupPerkusi as $i => $look_risiko){
                 $paddingstyle = "";

                 if($i > 0){
                   $paddingstyle = "style='padding-left: 5px'";
                 }

                $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->khusus_perkusi) && ($model->khusus_perkusi ==$look_risiko->lookup_value))?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look_risiko->lookup_value;
               }
               echo $htmlRisiko;
             }
              ?>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">b. Auskultasi</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <table width="100%">
               <tr>
                 <td width="100px">Suara Nafas</td>
                 <td width="5px">:</td>
                 <td colspan="2">
                   <?php
                   $lookupSuara = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_AUSKULTASI_SUARA."' order by lookup_urutan ASC");

                   if(count($lookupSuara) >0 ){
                     $htmlRisiko = "";
                     foreach($lookupSuara as $i => $look_risiko){
                       $paddingstyle = "";

                       if($i > 0){
                         $paddingstyle = "style='padding-left: 5px'";
                       }

                      $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->khusus_auskultasi_suaranafas) && ($model->khusus_auskultasi_suaranafas ==$look_risiko->lookup_value))?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look_risiko->lookup_value;
                     }
                     echo $htmlRisiko;
                   }
                    ?>
                 </td>
               </tr>
               <tr>
                 <td>Lokasi Sputum</td>
                 <td>:</td>
                 <td width="300px" class="borderbottomclass"><?php echo $model->khusus_auskultasi_lokasisputum; ?></td>
                  <td></td>
               </tr>
             </table>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">c. Pengukuran ekspansi thoraks</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <table width="100%">
               <tr>
                 <td width="150px">Axilla</td>
                 <td width="5px">:</td>
                 <td width="200px" class="borderbottomclass"><?php echo $model->khusus_pengukuran_eksthoraks_axilla; ?></td>
                 <td>cm</td>
               </tr>
               <tr>
                 <td>ICS 5</td>
                 <td>:</td>
                <td class="borderbottomclass"><?php echo $model->khusus_pengukuran_eksthoraks_ics5; ?></td>
                <td>cm</td>
               </tr>
               <tr>
                 <td>Processus Xyphoideus</td>
                 <td>:</td>
                <td class="borderbottomclass"><?php echo $model->khusus_pengukuran_eksthoraks_processus; ?></td>
                <td>cm</td>
               </tr>
             </table>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">d. Pemeriksaan Sesak Nafas (VAS, BORG Scale)</td>
         </tr>
         <tr>
           <td style="padding-left: 40px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->pemeriksaan_sesaknafas; ?>
             </div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">e. Pemeriksaan Nyeri</td>
         </tr>
         <tr>
           <td style="padding-left: 40px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->pemeriksaan_nyeri; ?>
             </div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">f. Pemeriksaan Spirometri</td>
         </tr>
         <tr>
           <td style="padding-left: 40px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->pemeriksaan_spirometri; ?>
             </div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">g. Pemeriksaan Panjang Otot (M. Percoralis Mayor dan Minor, M. SCM, M. Ipper Trapezius)</td>
         </tr>
         <tr>
           <td style="padding-left: 40px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->pemeriksaan_panjangotot; ?>
             </div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">h. Pemendekkan Otot Bantu Nafas</td>
         </tr>
         <tr>
           <td style="padding-left: 40px" colspan="5">
             <?php
             $lookupPemendekkan= LookupM::model()->findAll("lookup_type = 'kardiopulmonal_pemendekanotot' order by lookup_urutan ASC");

             if(count($lookupPemendekkan) >0 ){
               $htmlRisiko = "";
               foreach($lookupPemendekkan as $i => $look_risiko){
                 $paddingstyle = "";
                 $ischeck = false;
                 if(!empty($model->pemendekan_otot)){
                   $arrOriPemendekan = json_decode($model->pemendekan_otot);
                   if(count($arrOriPemendekan) > 0){
                     foreach ($arrOriPemendekan as $dataPemedekan) {
                       if($look_risiko->lookup_value == $dataPemedekan){
                         $ischeck = true;
                       }
                     }
                   }
                 }

                 if($i > 0){
                   $paddingstyle = "style='padding-left: 5px'";
                 }

                $htmlRisiko .= "<span ".$paddingstyle." class='".(($ischeck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_value;
               }
               echo $htmlRisiko;
             }
              ?>
           </td>
         </tr>
         <tr>
           <td colspan="5">5. Kemampuan Fungsional</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <?php
             $lookupKemampuan= LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_KARDIOPULMONAL_FUNGSIONAL."' order by lookup_urutan ASC");

             if(count($lookupKemampuan) >0 ){
               $htmlRisiko = "";
               foreach($lookupKemampuan as $i => $look_risiko){
                 $paddingstyle = "";

                 if($i > 0){
                   $htmlRisiko .= "<br/>";
                 }

                $htmlRisiko .= "<span class='".((!empty($model->khusus_perkusi) && ($model->khusus_perkusi ==$look_risiko->lookup_value))?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look_risiko->lookup_value.' '.$look_risiko->lookup_name;
               }
               echo $htmlRisiko;
             }
              ?>
           </td>
         </tr>
         <tr>
           <td colspan="5">6. Diagnosa Fisioterapi</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->diagnosis_fisioterapi; ?>
             </div>
           </td>
         </tr>
         <tr>
           <td colspan="5">7. Program Fisioterapi</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->program_fisioterapi; ?>
             </div>
           </td>
         </tr>
         <tr>
           <td colspan="5">6. Evaluasi dan Tindak Lanjut</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->evaluasi_tindaklanjut; ?>
             </div>
           </td>
         </tr>
       </table>
     </td>
   </tr>
 </table>
 <br/>
 <br/>
 <br/>
 <table width="100%">
     <tr>
         <td style="width:70%; text-align: left;" colspan="2">
         </td>
         <td style="text-align: left;" colspan="2" nowrap>
         </td>
     </tr>
     <tr>
         <td style="width:70%; text-align: left;" colspan="2">
         </td>
         <td colspan="2" >
             <center>Fisioterapi
                 <br><br><br><br><br><br>
                 (<?php echo (isset($model->pegawai)? $model->pegawai->NamaLengkap: ""); ?>)
             </center>
         </td>
     </tr>
 </table>
