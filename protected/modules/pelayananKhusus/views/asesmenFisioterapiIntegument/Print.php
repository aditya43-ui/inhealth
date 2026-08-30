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
             <span class="<?php echo ((!empty($model->statik) && (strpos($model->statik,"Kelemahan Sebelah Tubuh") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Kelemahan Sebelah Tubuh
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->statik) && (strpos($model->statik,"Kontraktur") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Kontraktur
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->statik) && (strpos($model->statik,"Wajah Asimetris") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Wajah Asimetris
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->statik) && ( strpos($model->statik,"Lainnya") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Lainnya
             <span style="padding-left: 5px"></span><div style="width: 150px; display: inline-block;" class="borderbottomclass"><?php echo $model->static_lainnya; ?></div>
           </td>
         </tr>
         <tr>
           <td style="padding-left: 20px" colspan="5">
             Dinamis (Adanya Perubahan dalam) <br />
             <span class="<?php echo ((!empty($model->dinamis) && (strpos($model->dinamis,"Pola Jalan") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Pola Jalan
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->dinamis) && (strpos($model->dinamis,"Sikap Tubuh") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Sikap Tubuh
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->dinamis) && (strpos($model->dinamis,"Pola Aktivitas Lain") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Pola Aktivitas Lain
             <span style="padding-left: 5px" class="<?php echo ((!empty($model->dinamis) && (strpos($model->dinamis,"Lainnya") != 0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Lainnya
             <span style="padding-left: 5px"></span><div style="width: 150px; display: inline-block;" class="borderbottomclass"><?php echo $model->dinamis_lainnya; ?></div>
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
             <span style="padding-left: 5px"></span><div style="width: 200px; display: inline-block; height: 30px; vertical-align: text-bottom; padding: 2px !important;" class="borderclass"><?php echo $model->palpasi_lainnya; ?></div>
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
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->bonelength_dextra." - ".$model->bonelength_dextra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Sinistra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->bonelength_sinistra." - ".$model->bonelength_sinistra2; ?></td>
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
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->truelength_dextra." - ".$model->truelength_dextra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Sinistra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->truelength_sinistra." - ".$model->truelength_sinistra2; ?></td>
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
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->apparent_dextra." - ".$model->apparent_dextra2; ?></td>
                       <td class="padding5" width="20px">cm</td>
                     </tr>
                     <tr>
                       <td class="padding5" width="70px">Sinistra</td>
                       <td class="padding5 borderbottomclass" width="100px"><?php echo $model->apparent_sinistra." - ".$model->apparent_sinistra2; ?></td>
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
           <td colspan="5">
             <table width="100%">
               <tr>
                 <td width="50%" class="borderclass padding5">Luas Area Luka Bakar</td>
                 <td width="50%" class="borderclass padding5">Table Pemeriksaan</td>
               </tr>
               <tr>
                 <td width="50%" valign="top" class="borderclass padding5">
                   <?php echo $this->renderPartial($this->path_view.'_formGambarPemeriksaanPrint',array('modGambarTubuh'=>$modGambarTubuh)) ?>
                 </td>
                 <td width="50%" valign="top" class="borderclass padding5">
                   <table class="table-bordercustom" width="100%">
                     <thead>
                       <tr>
                         <th width='30'>No.</th>
                         <th>Bagian Tubuh</th>
                         <th>Keterangan</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php
                         if((!empty($modPemeriksaanGambar))) {
                           $nourut = 1;
                           foreach($modPemeriksaanGambar as $ii => $vv){
                              $vv->namabagtubuh = $vv->bagiantubuh->namabagtubuh;
                              $vv->kordinat_tubuh_x = number_format($vv->kordinat_tubuh_x,7);
                              $vv->kordinat_tubuh_y = number_format($vv->kordinat_tubuh_y,7);
                              ?>
                                <tr>
                                  <td><?php echo $nourut; ?></td>
                                  <td><?php echo $vv->namabagtubuh; ?></td>
                                  <td><?php echo $vv->keterangan_periksa_gbr; ?></td>
                                </tr>
                              <?php
                              $nourut++;
                            }
                         }else{
                           echo '<tr><td colspan="3">Data Tidak Ditemukan</td></td>';
                         } ?>
                     </tbody>
                   </table>
                 </td>
               </tr>
             </table>
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
