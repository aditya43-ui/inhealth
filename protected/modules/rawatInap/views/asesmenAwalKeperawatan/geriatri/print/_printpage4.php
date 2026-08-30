<table width="100%">
  <tr>
      <td class="textbold padding5 borderclass bordernonetopclass">
          MINI MENTAL STATE EXAMINATION (MMSE)
      </td>
  </tr>
  <tr>
    <td colspan="2" class="padding10 borderclass">
      <?php
      $sumTotalMMSE = 0;
       ?>
       <table class="tableBorder" width="100%">
         <thead>
             <tr>
                 <th style="text-align: center">Variabel</th>
                 <th style="width: 50px; text-align: center">Nilai Maksimum</th>
                 <th style="width: 200px; text-align: center">Nilai Responden</th>
                 <th style="width: 200px; text-align: center">Keterangan</th>
             </tr>
         </thead>
         <tbody>
           <?php
            $modMinimentalexamMParent = MinimentalexamM::model()->findAllByAttributes(array('isaktif'=>true,'parent_id'=>null),array('order'=>'urutan ASC'));

            if(count((array)$modMinimentalexamMParent) > 0){
              $indexNourut = 0;
              foreach($modMinimentalexamMParent as $dataParent){
                ?>
                <tr>
                  <td style="font-weight: bold;">
                    <?php echo $dataParent->variabel; ?>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php
                $modMinimentalexamM = MinimentalexamM::model()->findAllByAttributes(array('isaktif'=>true,'parent_id'=>$dataParent->minimentalexam_id),array('order'=>'urutan ASC'));
                  if(count((array)$modMinimentalexamM) > 0){
                    foreach($modMinimentalexamM as $dataChild){
                      $sumTotalMMSE += $dataChild->nilai_maksimum;
                      $nilairespone = 0;
                      $ket_mmse = "";
                      if(count((array)$modMinimentalexampasienT) > 0){
                        foreach($modMinimentalexampasienT as $dataMiniMentalExP){
                          if($dataMiniMentalExP->minimentalexam_id == $dataChild->minimentalexam_id){
                            $nilairespone = $dataMiniMentalExP->nilai_responden;
                            $ket_mmse = $dataMiniMentalExP->keterangan;
                          }
                        }
                      }
                      ?>
                      <tr>
                        <td>
                          <?php
                              echo $dataChild->variabel;
                              if($dataChild->isupload_gambar==true && !empty($dataChild->gambar)){
                                echo '<br/> <img src="'.Params::urlMasterMinimentalexam().$dataChild->gambar.'" />';
                              }
                           ?>
                        </td>
                        <td style="text-align: center"><?php echo $dataChild->nilai_maksimum; ?></td>
                        <td style="text-align: center">
                          <?php
                            if($dataChild->isupload_gambar==true){
                              echo 'Hasil Gambar : <br/>';
                              if(count((array)$modMinimentalexampasiendetT)>0){

                                foreach($modMinimentalexampasiendetT as $k => $dataDetMmseOri){
                                  if($k > 0){
                                    echo '<br/>';
                                  }

                                  if(!empty($dataDetMmseOri->gambar)){
                                      echo '<img src="'.Params::urlMasterMinimentalexam().$dataDetMmseOri->gambar.'" width="60px" height="60px" />';
                                  }
                                }
                              }
                            }else{
                              echo $nilairespone;
                            }
                          ?>
                        </td>
                        <td>
                          <?php echo $ket_mmse; ?>
                        </td>
                      </tr>
                      <?php
                      $indexNourut++;
                    }
                  }
              }
            }
            ?>
         </tbody>
         <tfoot>
           <tr>
             <td>Total Nilai</td>
             <td style="text-align: center"><?php echo $sumTotalMMSE; ?></td>
             <td style="text-align: center"><?php echo $modAskepgeriatriT->minimentalexam_skor; ?></td>
             <td style="text-align: center"><?php echo $modAskepgeriatriT->minimentalexam_keterangan; ?></td>
           </tr>
         </tfoot>
       </table>

       <br/>
       <table width="100%">
         <tr>
           <td>Pedoman Skor Kognitif Global (Secara Umum) : </td>
         </tr>
         <tr>
           <td>Nilai : 24-30 (Normal)</td>
         </tr>
         <tr>
           <td>Nilai : 17-23 (Probable Gangguan Kognitif)</td>
         </tr>
         <tr>
           <td>Nilai : 0-16 (Definite Gangguan Kognitif)</td>
         </tr>
       </table>
    </td>
  </tr>
  <tr>
      <td class="textbold padding5 borderclass">
          TERAPI, MASALAH KEPERAWATAN DAN RENCANA TINDAK LANJUT
      </td>
  </tr>
  <tr>
    <td colspan="2" class="padding10 borderclass">
      <table width="100%" class="tablefont">
        <tr>
            <td colspan="3" style="text-decoration: underline; font-weight: bold;">TERAPI</td>
        </tr>
        <tr>
            <td width="150px" valign="top">Terapi yang diberikan</td>
            <td width="5px" valign="top">:</td>
            <td>
              <?php
              $returTerapi = "-";
              $modObatalkespasienT = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'returresepdet_id'=>null, 'oa'=>'OA'));
              //
              if(count((array)$modObatalkespasienT) > 0){
                foreach($modObatalkespasienT as $i => $oriObatAlkespasien){
                  if($i > 0){
                    $returTerapi .= '<br/>';
                  }
                  $returTerapi .= '- '.$oriObatAlkespasien->obatalkes->obatalkes_nama.' '.$oriObatAlkespasien->obatalkes->kekuatan.' '.$oriObatAlkespasien->obatalkes->satuankekuatan.', '.$oriObatAlkespasien->qty_oa.' '.$oriObatAlkespasien->obatalkes->satuankecil->satuankecil_id;
                }
              }

              echo $returTerapi;
              ?>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-decoration: underline; font-weight: bold;">Masalah Keperawatan</td>
        </tr>
        <tr>
            <td colspan="3">
              <?php echo (!empty($masalahKeperawatan)?$masalahKeperawatan:"-"); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-decoration: underline; font-weight: bold;">Rencana Tindak Lanjut</td>
        </tr>
        <tr>
            <td colspan="3">
              <?php echo $modAskepgeriatriT->rencana_tindaklanjut; ?>
            </td>
        </tr>
      </table>
    </td>
</tr>
<tr>
  <td colspan="2" class="textbold padding5 borderclass bordernonetopclass">
    KEBUTUHAN EDUKASI <font style="font-size: 8pt; font-style: italic;">(untuk pasien dan atau keluarga)</font>
  </td>
</tr>
<tr>
  <td colspan="2" class="padding5 borderclass">
    <table width="100%">
        <tr>
            <td width="50%">
                <table width="100%" class="tablefont">
                  <tr>
                      <td valign="top" width="200px">Hambatan Belajar</td>
                      <td valign="top" width="5px">:</td>
                      <td>
                          <table width="100%" class="tablefont">
                              <tr>
                                  <td width="50%">
                                      <table width="100%" class="tablefont">
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_bahasa) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_bahasa==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bahasa</td>
                                          </tr>
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_pendengaran) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_pendengaran==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pendengaran</td>
                                          </tr>
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_penglihatan) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_penglihatan==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Penglihatan</td>
                                          </tr>
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_motivasi) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_motivasi==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Motivasi</td>
                                          </tr>
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_fisik) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_fisik==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Fisik</td>
                                          </tr>
                                      </table>
                                  </td>
                                  <td width="50%">
                                      <table width="100%" class="tablefont">
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_emosi) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_emosi==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Emosi</td>
                                          </tr>
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_butahuruf) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_butahuruf==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Buta Huruf</td>
                                          </tr>
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_usia) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_usia==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Usia</td>
                                          </tr>
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_kognitif) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_kognitif==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kognitif</td>
                                          </tr>
                                          <tr>
                                              <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_tidakada) && ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_tidakada==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak</td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                          </table>
                      </td>
                  </tr>
                  <tr>
                      <td valign="top">Cara Belajar yang disukai</td>
                      <td valign="top">:</td>
                      <td>
                          <table width="100%" class="tablefont">
                              <tr>
                                  <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_menulis) && ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_menulis==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Menulis</td>
                              </tr>
                              <tr>
                                  <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_audiovisual) && ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_audiovisual==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Audio-Visual/ Gambar</td>
                              </tr>
                              <tr>
                                  <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_diskusi) && ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_diskusi==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Diskusi</td>
                              </tr>
                              <tr>
                                  <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_demonstrasi) && ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_demonstrasi==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Demostrasi</td>
                              </tr>
                              <tr>
                                  <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_membaca) && ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_membaca==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Membaca</td>
                              </tr>
                              <tr>
                                  <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_mendengarkan) && ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_mendengarkan==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Mendengarkan</td>
                              </tr>
                          </table>
                      </td>
                  </tr>
                  <tr>
                      <td valign="top" width="200px">Potensial kebutuhan pembelajaran</td>
                      <td valign="top" width="10px">:</td>
                      <td>
                          <table width="100%" class="tablefont">
                              <?php
                                  $modLookupData = LookupM::model()->findAll("lookup_type = 'edukasipasien'");

                                  if(count((array)$modLookupData)>0){

                                      foreach ($modLookupData as $i => $dataLook){
                                              $html = "";
                                              $ModAsseEdu = new AsesmenkebutuhanEdukasidetT();
                                              if(is_array($modAsesmenkebutuhanEdukasidetT) && count((array)$modAsesmenkebutuhanEdukasidetT)>0){
                                                  foreach ($modAsesmenkebutuhanEdukasidetT as $dataKebEduDet){
                                                      if($dataKebEduDet->edukasipasien == $dataLook->lookup_value){
                                                          $ModAsseEdu->isedukasipasien = true;
                                                          $ModAsseEdu->edukasipasien_lainnya = $dataKebEduDet->edukasipasien_lainnya;
                                                      }
                                                  }
                                              }
                                              if($dataLook->lookup_value == 'LAIN-LAIN'){
                                                  ?>
                                                      <tr>
                                                          <td><span class="<?php echo ((!empty($ModAsseEdu->isedukasipasien) && ($ModAsseEdu->isedukasipasien==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> <?php echo $dataLook->lookup_name; ?>, <?php echo $ModAsseEdu->edukasipasien_lainnya; ?></td>
                                                      </tr>
                                                  <?php
                                                 }else{
                                                     ?>
                                                      <tr>
                                                          <td><span class="<?php echo ((!empty($ModAsseEdu->isedukasipasien) && ($ModAsseEdu->isedukasipasien==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> <?php echo $dataLook->lookup_name; ?></td>
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
            </td>
            <td width="50%" valign="top">
                <table width="100%" class="tablefont">
                  <tr>
                      <td width="200px" valign="top">Perlu Penerjemah</td>
                      <td width="5px" valign="top">:</td>
                      <td>
                        <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status) && ($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                        <br/>
                        <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status) && ($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                        , <?php echo $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa; ?>
                      </td>
                  </tr>
                </table>
            </td>
        </tr>
    </table>
  </td>
</tr>
<tr>
  <td colspan="2" class="textbold padding5 borderclass">
    PERENCANAAN PULANG
  </td>
</tr>
<tr>
  <td colspan="2" class="padding5 borderclass">
    <table class="tableBorder" width="100%">
        <thead>
            <tr>
                <th style="text-align: center">Komponen Penilaian</th>
                <th style="text-align: center" width="50px">Ya</th>
                <th style="text-align: center" width="50px">Tidak</th>
                <th style="text-align: center" width="300px">Keterangan</th>
            </tr>
         </thead>
         <tbody>
           <?php
             $look_rencanapul = LookupM::model()->findAll("lookup_type = 'penilaianrencanpulang' order by lookup_urutan ASC");

               if(count((array)$look_rencanapul) > 0){
                 foreach ($look_rencanapul as $i => $look) {
                     $penilaian_lainnya = "";
                     $hasil = "";
                     $keterangan = "";
                     $penilaianrencanapulang_id = null;

                     if(count((array)$modPenilaianRenPulang) > 0){
                       foreach($modPenilaianRenPulang as $oriNilaiRenPulang){
                         if($look->lookup_name == $oriNilaiRenPulang->penilaian){
                           $penilaianrencanapulang_id = $oriNilaiRenPulang->penilaianrencanapulang_id;
                           $penilaian_lainnya = $oriNilaiRenPulang->penilaian_lainnya;
                           $hasil = $oriNilaiRenPulang->hasil;
                           $keterangan = $oriNilaiRenPulang->keterangan;
                         }
                       }
                     }
                   ?>
                   <tr>
                     <td>
                       <?php
                         echo $look->lookup_name .' : '.(!empty($penilaian_lainnya)? $penilaian_lainnya:"");
                       ?>

                     </td>
                     <td style="text-align: center">
                       <span class="<?php echo ((!empty($hasil) && ($hasil =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                     </td>
                     <td style="text-align: center">
                       <span class="<?php echo ((!empty($hasil) && ($hasil =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                     </td>
                     <td>
                       <?php echo $keterangan; ?>
                     </td>
                   </tr>
                   <?php
                 }
               }
            ?>
         </tbody>
    </table>

  </td>
</tr>
</table>
<br/>
<table width="100%" class="tablefont">
  <tr>
    <td width="35%" valign="top">

    </td>
    <td width="20%" valign="top">

    </td>
    <td width="45%" valign="top">
      <center>
        Singaraja, <?php echo date('d').' '.MyFormatter::getMonthId(date('m')).' '.date('Y').' '.date('H:i:s'); ?>
        <br/>
        Perawat yang melakukan pengkajian
        <br/><br/><br/><br/><br/>
        <?php
        echo $model->paramedis_nama; ?>
      </center>
    </td>
  </tr>
</table>
