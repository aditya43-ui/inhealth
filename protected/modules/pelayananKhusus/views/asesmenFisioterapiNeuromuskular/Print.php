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
             Statik <br />
             <span class="<?php echo ((!empty($model->inspeksi_statik) && (strpos($model->inspeksi_statik,"Kelemahan Sebelah Tubuh") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Kelemahan Sebelah Tubuh
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->inspeksi_statik) && (strpos($model->inspeksi_statik,"Kontraktur") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Kontraktur
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->inspeksi_statik) && (strpos($model->inspeksi_statik,"Wajah Asimetris") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Wajah Asimetris
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->inspeksi_statik) && ( strpos($model->inspeksi_statik,"Lainnya") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Lainnya
             <span style="padding-left: 5px"></span><div style="width: 150px; display: inline-block;" class="borderbottomclass"><?php echo $model->inspeksi_statik_di; ?></div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             Dinamis (Adanya Perubahan dalam) <br />
             <span class="<?php echo ((!empty($model->inspeksi_dinamis) && (strpos($model->inspeksi_dinamis,"Pola Jalan") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Pola Jalan
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->inspeksi_dinamis) && (strpos($model->inspeksi_dinamis,"Sikap Tubuh") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Sikap Tubuh
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->inspeksi_dinamis) && (strpos($model->inspeksi_dinamis,"Pola Aktivitas Lain") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Pola Aktivitas Lain
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->inspeksi_dinamis) && (strpos($model->inspeksi_dinamis,"Lainnya") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Lainnya
             <span style="padding-left: 5px"></span><div style="width: 150px; display: inline-block;" class="borderbottomclass"><?php echo $model->inspeksi_dinamis_polalain; ?></div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">c. Palpasi</td>
         </tr>
         <tr>
           <td style="padding-left: 30px" colspan="5">
              <span class="<?php echo ((!empty($model->palpasi) && (strpos($model->palpasi,'Peningkatan Suhu Lokal') != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Peningkatan Suhu Lokal
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->palpasi) && (strpos($model->palpasi,'Nyeri Tekan') != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Nyeri Tekan
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->palpasi) && (strpos($model->palpasi,'Spasme') != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Spasme
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->palpasi) && (strpos($model->palpasi,'Pitting Oedema') != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Pitting Oedema
           </td>
         </tr>
         <tr>
           <td style="padding-left: 30px" colspan="5">
              <span class="<?php echo ((!empty($model->palpasi) && (strpos($model->palpasi,'Lainnya') != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Lainnya
             <span style="padding-left: 5px"></span><div style="width: 200px; display: inline-block; height: 30px; vertical-align: text-bottom; padding: 2px !important;" class="borderclass"><?php echo $model->palpasi_di; ?></div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">d. Pemeriksaan Gerak Dasar</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <?php
              if(count($oriPeriksaExtra) > 0){
                foreach ($oriPeriksaExtra as $i=> $extra) {
                  if($i > 0){
                    echo "<br/>";
                  }
                  ?>
                  <table width="100%">
                    <tr>
                      <td class="padding10 borderclass"><?php echo $extra->periksafungsigerakdasar->periksafungsigerakdasar_nama; ?></td>
                    </tr>
                    <tr>
                      <td class="padding10 borderclass">
                        <table width="100%">
                          <tr>
                            <td class="padding10 borderclass textcenter" colspan="4">Dextra</td>
                          </tr>
                          <?php
                            if(isset($extra) && count($oriPeriksaDextra) > 0){
                              foreach ($oriPeriksaDextra as $j => $oriDextra) {
                                if($oriDextra->periksafungsigerakdasar_id == $extra->periksafungsigerakdasar_id){
                                  ?>
                                  <tr>
                                    <td class="padding10 bordertopclass borderleftclass borderbottomclass" width="10%">
                                      <?php echo $oriDextra->fungsigerakdasarsinistra->fungsigerakdasarsinistra_nama; ?>
                                    </td>
                                    <td class="padding10 bordertopclass borderleftclass borderbottomclass" width="30%">
                                      <table>
                                        <tr>
                                          <td colspan="2">Aktif</td>
                                        </tr>
                                        <tr>
                                          <td width="70px">Gerakan</td>
                                          <td class="" width="200px"><div class="borderclass padding5"><?php echo $oriDextra->aktif_gerakan; ?></div></td>
                                        </tr>
                                        <tr>
                                          <td width="70px">ROM</td>
                                          <td class="" width="200px"><div class="borderclass padding5" style="width: 50px; display: inline-block;"><?php echo $oriDextra->aktif_rom; ?></div>&deg; Derajat</td>
                                        </tr>
                                      </table>
                                    </td>
                                    <td class="padding10 bordertopclass borderleftclass borderbottomclass" width="30%">
                                      <table>
                                        <tr>
                                          <td colspan="2">Pasif</td>
                                        </tr>
                                        <tr>
                                          <td width="70px">Gerakan</td>
                                          <td class="" width="200px"><div class="borderclass padding5"><?php echo $oriDextra->pasif_gerakan; ?></div></td>
                                        </tr>
                                        <tr>
                                          <td width="70px">ROM</td>
                                          <td class="" width="200px"><div class="borderclass padding5" style="width: 50px; display: inline-block;"><?php echo $oriDextra->pasif_rom; ?></div>&deg; Derajat</td>
                                        </tr>
                                      </table>
                                    </td>
                                    <td class="padding10 borderclass" width="30%">
                                      <table>
                                        <tr>
                                          <td colspan="2">Isometrik</td>
                                        </tr>
                                        <tr>
                                          <td width="70px" class="">Gerakan</td>
                                          <td class="" width="200px"><div class="borderclass padding5"><?php echo $oriDextra->isometrik_gerakan; ?></div></td>
                                        </tr>
                                        <tr>
                                          <td width="70px" class="padding5">ROM</td>
                                          <td class="" width="200px"><div class="borderclass padding5" style="width: 50px; display: inline-block;"><?php echo $oriDextra->isometrik_rom; ?></div>&deg; Derajat</td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <?php
                                }
                              }
                            }
                           ?>
                        </table>
                        <br/>
                        <table width="100%">
                          <tr>
                            <td class="padding10 borderclass textcenter" colspan="4">Sinistra</td>
                          </tr>
                          <?php
                            if(isset($extra) && count($oriPeriksaSinistra) > 0){
                              foreach ($oriPeriksaSinistra as $j => $oriSinistra) {
                                if($oriSinistra->periksafungsigerakdasar_id == $extra->periksafungsigerakdasar_id){
                                  ?>
                                  <tr>
                                    <td class="padding10 bordertopclass borderleftclass borderbottomclass" width="10%">
                                      <?php echo $oriSinistra->fungsigerakdasarsinistra->fungsigerakdasarsinistra_nama; ?>
                                    </td>
                                    <td class="padding10 bordertopclass borderleftclass borderbottomclass" width="30%">
                                      <table>
                                        <tr>
                                          <td colspan="2">Aktif</td>
                                        </tr>
                                        <tr>
                                          <td width="70px">Gerakan</td>
                                          <td class="" width="200px"><div class="borderclass padding5"><?php echo $oriSinistra->aktif_gerakan; ?></div></td>
                                        </tr>
                                        <tr>
                                          <td width="70px">ROM</td>
                                          <td class="" width="200px"><div class="borderclass padding5" style="width: 50px; display: inline-block;"><?php echo $oriSinistra->aktif_rom; ?></div>&deg; Derajat</td>
                                        </tr>
                                      </table>
                                    </td>
                                    <td class="padding10 bordertopclass borderleftclass borderbottomclass" width="30%">
                                      <table>
                                        <tr>
                                          <td colspan="2">Pasif</td>
                                        </tr>
                                        <tr>
                                          <td width="70px">Gerakan</td>
                                          <td class="" width="200px"><div class="borderclass padding5"><?php echo $oriSinistra->pasif_gerakan; ?></div></td>
                                        </tr>
                                        <tr>
                                          <td width="70px">ROM</td>
                                          <td class="" width="200px"><div class="borderclass padding5" style="width: 50px; display: inline-block;"><?php echo $oriSinistra->pasif_rom; ?></div>&deg; Derajat</td>
                                        </tr>
                                      </table>
                                    </td>
                                    <td class="padding10 borderclass" width="30%">
                                      <table>
                                        <tr>
                                          <td colspan="2">Isometrik</td>
                                        </tr>
                                        <tr>
                                          <td width="70px" class="">Gerakan</td>
                                          <td class="" width="200px"><div class="borderclass padding5"><?php echo $oriSinistra->isometrik_gerakan; ?></div></td>
                                        </tr>
                                        <tr>
                                          <td width="70px" class="padding5">ROM</td>
                                          <td class="" width="200px"><div class="borderclass padding5" style="width: 50px; display: inline-block;"><?php echo $oriSinistra->isometrik_rom; ?></div>&deg; Derajat</td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <?php
                                }
                              }
                            }
                           ?>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <?php
                }
              }
              ?>


           </td>
         </tr>
         <tr>
           <td colspan="5">4. Pemeriksaan Khusus</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">a. Nyeri</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <?php echo $this->renderPartial($this->path_view.'_formNyeriPrint',array('model'=>$model),true); ?>
           </td>
         </tr>
         <tr>
           <td colspan="5">
             <table width="100%">
               <tr>
                 <td width="50%">b. Tingkat Kesadaran</td>
                 <td width="50%">c. Refleks Patologis</td>
               </tr>
               <tr>
                 <td width="50%" valign="top">
                   <table width="100%">
                     <tr>
                       <td width="100px" valign="top">GCS :</td>
                       <td>
                       <?php
                       
                        $crit = new CDbCriteria();
                        $crit->compare('LOWER(metodegcs_singkatan)',"e");
                        $crit->addCondition('metodegcs_nilai is not null');
                        $crit->order = 'metodegcs_nilai ASC';
                        $listE = CHtml::listData(RMMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');
                        
                        
                        $crit = new CDbCriteria();
                        $crit->compare('LOWER(metodegcs_singkatan)',"m");
                        $crit->addCondition('metodegcs_nilai is not null');
                        $crit->order = 'metodegcs_nilai ASC';
                        $listM = CHtml::listData(RMMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');
                        
                        $crit = new CDbCriteria();
                        $crit->compare('LOWER(metodegcs_singkatan)',"v");
                        $crit->addCondition('metodegcs_nilai is not null');
                        $crit->order = 'metodegcs_nilai ASC';
                        $listV = CHtml::listData(RMMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');
                        
                        
                       
                       ?>
                         E : <?php echo empty($listE[$model->gcs_eye]) ? "-" : $listE[$model->gcs_eye]; ?><br/>
                         M : <?php echo empty($model->gcs_motorik) ? "-" : $listM[$model->gcs_motorik]; ?><br/>
                         V : <?php echo empty($model->gcs_verbal) ? "-" : $listV[$model->gcs_verbal]; ?>
                       </td>
                     </tr>
                   </table>
                 </td>
                 <td width="50%" valign="top">
                   <table width="100%">
                     <?php
                     $lookupReflek = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_NEUROMUSKULAR_REFLEK_PATOLOGIS."'");
                    
                     $reflek = json_decode($model->reflek_patologis);
                     $cek = false;

                     if(count($lookupReflek) >0 ){
                       $htmlRisiko = "";
                       $indxRefleks = 0;
                       foreach($lookupReflek as $i => $look_risiko){
                         $indxRefleks++;
                         if($indxRefleks == 1){
                           $htmlRisiko .= "<tr>";
                         }
                         foreach ($reflek as $r){
                            if ($r ==$look_risiko->lookup_value){
                              $cek = true;
                            }
                         }
                         $htmlRisiko .= "<td width='50%'><span class='".((!empty($model->reflek_patologis) && ($cek == true))?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look_risiko->lookup_value."</td>";
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
           <td colspan="5">
             <table width="100%">
               <tr>
                 <td width="50%">d. Tes Sensoris</td>
                 <td width="50%"></td>
               </tr>
               <tr>
                 <td width="50%" valign="top" style="padding-left: 20px">
                   <table width="100%">
                     <tr>
                       <td valign="top">Nyeri Superfisial (Tajam Tumpul)</td>
                     </tr>
                     <tr>
                       <td>
                         <?php
                         $lookupSensoris = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SENSORIS."'");

                         if(count($lookupSensoris) >0 ){
                           $htmlRisiko = "";
                           foreach($lookupSensoris as $i => $look_risiko){
                             $paddingstyle = "";

                             if($i > 0){
                               $paddingstyle = "style='padding-left: 5px'";
                             }

                            $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->tes_sensoris_nyeri_superfisial) && ($model->tes_sensoris_nyeri_superfisial ==$look_risiko->lookup_value))?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_value;
                           }
                           echo $htmlRisiko;
                         }
                          ?>
                       </td>
                     </tr>
                     <tr>
                       <td valign="top">Tekanan</td>
                     </tr>
                     <tr>
                       <td>
                         <?php
                         $lookupTekanan = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SENSORIS."'");

                         if(count($lookupTekanan) >0 ){
                           $htmlRisiko = "";
                           foreach($lookupTekanan as $i => $look_risiko){
                             $paddingstyle = "";

                             if($i > 0){
                               $paddingstyle = "style='padding-left: 5px'";
                             }

                            $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->tes_sensoris_tekanan) && ($model->tes_sensoris_tekanan ==$look_risiko->lookup_value))?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_value;
                           }
                           echo $htmlRisiko;
                         }
                          ?>
                       </td>
                     </tr>
                   </table>
                 </td>
                 <td width="50%" valign="top" style="padding-left: 20px">
                   <table width="100%">
                     <tr>
                       <td valign="top">Sentuhan Ringan</td>
                     </tr>
                     <tr>
                       <td>
                         <?php
                         $lookupSentuhan = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SENSORIS."'");

                         if(count($lookupSentuhan) >0 ){
                           $htmlRisiko = "";
                           foreach($lookupSentuhan as $i => $look_risiko){
                             $paddingstyle = "";

                             if($i > 0){
                               $paddingstyle = "style='padding-left: 5px'";
                             }

                            $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->tes_sensoris_sentuhan_ringan) && ($model->tes_sensoris_sentuhan_ringan ==$look_risiko->lookup_value))?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_value;
                           }
                           echo $htmlRisiko;
                         }
                          ?>
                       </td>
                     </tr>
                     <tr>
                       <td valign="top">Tekanan</td>
                     </tr>
                     <tr>
                       <td>
                         <?php
                         $lookupPropriseptif = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SENSORIS."'");

                         if(count($lookupPropriseptif) >0 ){
                           $htmlRisiko = "";
                           foreach($lookupPropriseptif as $i => $look_risiko){
                             $paddingstyle = "";

                             if($i > 0){
                               $paddingstyle = "style='padding-left: 5px'";
                             }

                            $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->tes_proprioseptif) && ($model->tes_proprioseptif ==$look_risiko->lookup_value))?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_value;
                           }
                           echo $htmlRisiko;
                         }
                          ?>
                       </td>
                     </tr>
                   </table>
                 </td>
               </tr>
               <tr>
                 <td width="50%">e. Tes Tremor</td>
                 <td width="50%">f. Tes Spastistas (Skala Asworth)</td>
               </tr>
               <tr>
                 <td width="50%" style="padding-left: 20px">
                   <?php
                   $lookupTremor = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_NEUROMUSKULAR_TES_TREMOR."'");

                   if(count($lookupTremor) >0 ){
                     $htmlRisiko = "";
                     foreach($lookupTremor as $i => $look_risiko){
                       $paddingstyle = "";

                       if($i > 0){
                         $paddingstyle = "style='padding-left: 5px'";
                       }

                      $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->tes_tremor) && ($model->tes_tremor ==$look_risiko->lookup_value))?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_value;
                     }
                     echo $htmlRisiko;
                   }
                    ?>
                 </td>
                 <td width="50%" style="padding-left: 20px">
                   <?php
                   $lookupSpa = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SPASTISITAS."'");

                   if(count($lookupSpa) >0 ){
                     $htmlRisiko = "";
                     foreach($lookupSpa as $i => $look_risiko){
                       $paddingstyle = "";

                       if($i > 0){
                         $paddingstyle = "style='padding-left: 5px'";
                       }

                      $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->tes_spastisitas_skala_asworth) && ($model->tes_spastisitas_skala_asworth ==$look_risiko->lookup_value))?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_value;
                     }
                     echo $htmlRisiko;
                   }
                    ?>
                 </td>
               </tr>
               <tr>
                 <td width="50%">g. Tonus Otot</td>
                 <td width="50%"></td>
               </tr>
               <tr>
                 <td width="50%" style="padding-left: 20px">
                   <?php
                   $lookupOtot = LookupM::model()->findAll("lookup_type = '".Params::LOOKUPTYPE_NEUROMUSKULAR_TONUS_OTOT."'");

                   if(count($lookupOtot) >0 ){
                     $htmlRisiko = "";
                     foreach($lookupOtot as $i => $look_risiko){
                       $paddingstyle = "";

                       if($i > 0){
                         $paddingstyle = "style='padding-left: 5px'";
                       }

                      $htmlRisiko .= "<span ".$paddingstyle." class='".((!empty($model->tonus_otot) && ($model->tonus_otot ==$look_risiko->lookup_value))?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_value;
                     }
                     echo $htmlRisiko;
                   }
                    ?>
                 </td>
                 <td width="50%" style="padding-left: 20px">
                 </td>
               </tr>
             </table>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">MMT</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <table class="table-bordercustom" width="100%">
               <thead>
                 <tr>
                   <th width="200px">Nama Pemeriksaan</th>
                   <th width="300px">Jenis Pemeriksaan</th>
                   <th>Kiri</th>
                   <th>Kanan</th>
                 </tr>
               </thead>
               <tbody>
                   <?php
                     $modMasterMMT = PemeriksaanmmtM::model()->findAllByAttributes(array('pemeriksaanmmt_aktif'=>true),array('order'=>'urutan asc'));

                     if(count($modMasterMMT) > 0){
                       $arrMMt = array();
                       foreach ($modMasterMMT as $master) {
                         $arrMMt[$master->nama_pemeriksaan][] = array('pemeriksaanmmt_id'=>$master->pemeriksaanmmt_id,'nama_pemeriksaan'=>$master->nama_pemeriksaan,'jenis_pemeriksaan'=>$master->jenis_pemeriksaan,'urutan'=>$master->urutan);
                       }

                       if(count($arrMMt)){
                         $indexMMt = 0;
                         foreach ($arrMMt as $nama => $lopMaster) {
                           ?>
                           <tr>
                             <td style="vertical-align: middle; text-align: center;" rowspan="<?php echo (count($lopMaster)+1); ?>"><?php echo $nama; ?></td>
                             <?php
                               foreach ($lopMaster as $dataLop) {
                                 $kananData = "";
                                 $kiriData = "";
                                 if(isset($modAsesmenmmtT) && count($modAsesmenmmtT) > 0){
                                   foreach ($modAsesmenmmtT as $periksafisikMMt) {
                                     if($dataLop['pemeriksaanmmt_id'] == $periksafisikMMt->pemeriksaanmmt_id){
                                       $kananData = $periksafisikMMt->kanan;
                                       $kiriData = $periksafisikMMt->kiri;
                                     }
                                   }
                                 }
                                 ?>
                                 <tr>
                                   <td>
                                     <?php echo $dataLop['jenis_pemeriksaan']; ?>
                                   </td>
                                   <td>
                                     <?php echo $kiriData; ?>
                                   </td>
                                   <td>
                                     <?php echo $kananData; ?>
                                   </td>
                                 </tr>
                                 <?php
                                 $indexMMt++;
                               }
                              ?>
                           </tr>
                           <?php
                         }
                       }
                     }
                   ?>
               </tbody>
             </table>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">h. Antropometri</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <table width="100%">
               <tr>
                 <td width="35%">
                   <table>
                     <tr>
                       <td colspan="2" class="padding5">Bone Length : </td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Dextra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->antropometri_bonelength_dextra." - ".$model->antropometri_bonelength_dextra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Sinistra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->antropometri_bonelength_sinistra." - ".$model->antropometri_bonelength_sinistra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                   </table>
                 </td>
                 <td width="30%">
                   <table>
                     <tr>
                       <td colspan="2" class="padding5">True Length : </td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Dextra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->antropometri_truelength_dextra." - ".$model->antropometri_truelength_dextra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Sinistra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->antropometri_truelength_sinistra." - ".$model->antropometri_truelength_sinistra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                   </table>
                 </td>
                 <td width="35%">
                   <table>
                     <tr>
                       <td colspan="2" class="padding5">Apparent Length : </td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Dextra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->antropometri_apparentlength_dextra." - ".$model->antropometri_apparentlength_dextra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Sinistra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->antropometri_apparentlength_sinistra." - ".$model->antropometri_apparentlength_sinistra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                   </table>
                 </td>
               </tr>
             </table>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">i. Measurement Edema</td>
         </tr>
         <tr>
           <td style="padding-left: 40px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->measurement_edema; ?>
             </div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">j. Test Khusus Sesuai Kelainan/Penyakit/Gangguan</td>
         </tr>
         <tr>
           <td style="padding-left: 40px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->test_khusus; ?>
             </div>
           </td>
         </tr>
         <tr>
           <td colspan="5">5. Kemampuan Fungsional</td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             <div class="borderbottomclass">
               <?php echo $model->kemampuan_fungsional; ?>
             </div>
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
               <?php echo $model->evaluasidantindaklanjut; ?>
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
