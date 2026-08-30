<?php
  $rujukan = "Tidak";
  $diagnosarujukan = "-";

  if(isset($modPendaftaran->rujukan)){
    $asalrujukannama = "";
    if(isset($modPendaftaran->rujukan->asalrujukan)){
      $asalrujukannama = $modPendaftaran->rujukan->asalrujukan->asalrujukan_nama;
    }
    $rujukan = "Ya, Dari ".$asalrujukannama.' '.$modPendaftaran->rujukan->nama_perujuk;
    $diagnosarujukan = $modPendaftaran->rujukan->diagnosa_rujukan ." - ". $modPendaftaran->rujukan->kddiagnosa_rujukan;
  }

  $keluargaNama = "-";
  $keluargaAlamat = "-";
  $keluargaTelp = "-";

  if(isset($modPendaftaran->penanggungjawab)){
    $keluargaNama = $modPendaftaran->penanggungjawab->nama_pj;
    $keluargaAlamat = $modPendaftaran->penanggungjawab->alamat_pj;
    $keluargaTelp = $modPendaftaran->penanggungjawab->no_teleponpj;
  }

  $warnaTriase = "";
  if($modAsesmenTriasae->ismerah == true){
    $warnaTriase = "Merah";
  }else if($modAsesmenTriasae->iskuning == true){
    $warnaTriase = "Kuning";
  }else if($modAsesmenTriasae->ishijau == true){
    $warnaTriase = "Hijau";
  }
?>

<table width="100%">
  <tr>
      <td width="25%" class="padding5 borderleftclass borderrightclass" valign="top">
          Tanggal : <?php echo MyFormatter::formatDateTimeForUser($model->tgl_assesmen_awal); ?>
      </td>
      <td width="40%" class="padding5 borderleftclass borderrightclass" valign="top">
          Waktu Kedatangan : WIB<br/>
          Waktu Pemeriksaan : WIB
       </td>
       <td width="35%" class="padding5 borderleftclass borderrightclass" valign="top">
           Perawat Pengkaji : <?php echo $model->paramedis_nama; ?>
        </td>
    </tr>
    <tr>
        <td width="25%" class="padding5 borderclass" valign="top">
            Keluhan Utama : <?php echo $model->keluhanutama; ?>
        </td>
        <td width="40%" class="padding5 borderclass" valign="top">
            <table width="100%" class="tablefont">
              <tr>
                <td width="35%" valign="top">
                  <span class="<?php echo (($modAsesmenTriasae->istrauma==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Trauma <br/>
                  <span class="<?php echo (($modAsesmenTriasae->isobstetri==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Obstetri <br/>
                  <span class="<?php echo (($modAsesmenTriasae->istrauma==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Non Trauma
                </td>
                <td width="30%" valign="top">
                  <span class="<?php echo (($modAsesmenTriasae->iskecelakaan==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kecelakan <br/>
                  <span class="<?php echo (($modAsesmenTriasae->iskecelakaansebab_tunggal==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tunggal <br/>
                  <span class="<?php echo (($modAsesmenTriasae->iskecelakaansebab_adalawan==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada Lawan
                </td>
                <td width="35%" valign="top">
                  <span class="<?php echo (($modAsesmenTriasae->iskecelakaansebab_sepedamotor==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sepeda Motor <br/>
                  <span class="<?php echo (($modAsesmenTriasae->iskecelakaansebab_mobil==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Mobil
                </td>
              </tr>
            </table>
         </td>
         <td width="35%" class="padding5 borderclass" valign="top">
             Riwayat Alergi Obat : <?php echo $model->riwayatalergiobat; ?>
             <br/>
             Riwayat Alergi Makanan : <?php echo $model->riwayatalergimakanan; ?>
        </td>
    </tr>
  </table>
  <table width="100%">
    <tr>
        <td width="20%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
            AIRWAY
        </td>
        <td width="20%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
            BREATHING
         </td>
         <td width="25%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
             CIRCULATION
        </td>
        <td width="35%" class="padding5 borderclass" valign="top" style="border-top: none !important;"s>
            DISABILITY
       </td>
    </tr>
    <tr>
        <td width="20%" class="padding5 borderclass" valign="top">
          <?php
            $triaseMAirway = Triase::model()->findAllByAttributes(array('triase_aktif'=>TRUE,'triase_pemeriksaan'=>'JALAN NAPAS', 'warna_triase'=>$warnaTriase),array('order'=>'triase_urutan ASC'));

            if(count((array)$triaseMAirway)>0){
              $htmlAirway = "";
              foreach ($triaseMAirway as $i => $trsAir) {
                $checkAirway = false;

                if(isset($modAsesmenTriasaedet) && count((array)$modAsesmenTriasaedet) > 0){
                  foreach ($modAsesmenTriasaedet as $detTriase) {
                    if($detTriase->triase_id == $trsAir->triase_id){
                      $checkAirway = true;
                    }
                  }
                }
                if($i>0){
                  $htmlAirway .= "<br/>";
                }
                $htmlAirway .= "<span class='".(($checkAirway==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$trsAir->triase_nama;
              }
              echo $htmlAirway;
            }

           ?>
        </td>
        <td width="20%" class="padding5 borderclass" valign="top">
          <?php
            $triaseMBreathing = Triase::model()->findAllByAttributes(array('triase_aktif'=>TRUE,'triase_pemeriksaan'=>'PERNAPASAN', 'warna_triase'=>$warnaTriase),array('order'=>'triase_urutan ASC'));

            if(count((array)$triaseMBreathing)>0){
              $htmlBreathing = "";
              foreach ($triaseMBreathing as $i => $trsBreathing) {
                $checkTriase = false;

                if(isset($modAsesmenTriasaedet) && count((array)$modAsesmenTriasaedet) > 0){
                  foreach ($modAsesmenTriasaedet as $detTriase) {
                    if($detTriase->triase_id == $trsBreathing->triase_id){
                      $checkTriase = true;
                    }
                  }
                }
                if($i>0){
                  $htmlBreathing .= "<br/>";
                }
                $htmlBreathing .= "<span class='".(($checkTriase==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$trsBreathing->triase_nama;
              }
              echo $htmlBreathing;
            }

           ?>
         </td>
         <td width="25%" class="padding5 borderclass" valign="top">
           <?php
             $triaseMCirc = Triase::model()->findAllByAttributes(array('triase_aktif'=>TRUE,'triase_pemeriksaan'=>'SIRKULASI', 'warna_triase'=>$warnaTriase),array('order'=>'triase_urutan ASC'));

             if(count((array)$triaseMCirc)>0){
               $htmlCirc = "";
               foreach ($triaseMCirc as $i => $trsCirc) {
                 $checkTriase = false;

                 if(isset($modAsesmenTriasaedet) && count((array)$modAsesmenTriasaedet) > 0){
                   foreach ($modAsesmenTriasaedet as $detTriase) {
                     if($detTriase->triase_id == $trsCirc->triase_id){
                       $checkTriase = true;
                     }
                   }
                 }
                 if($i>0){
                   $htmlCirc .= "<br/>";
                 }
                 $htmlCirc .= "<span class='".(($checkTriase==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$trsCirc->triase_nama;
               }
               echo $htmlCirc;
             }

            ?>
        </td>
        <td width="35%" class="padding5 borderclass" valign="top">
            <table width="100%" class="tablefont">
              <tr>
                <td width="50%">
                  Respon
                </td>
                <td width="50%">
                  Pupil
                </td>
              </tr>
              <tr>
                <td width="50%">
                  <span class="<?php echo (($modAsesmenTriasae->isdisability_respon_alert==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Alert
                  <span style="padding-left: 10px" class="<?php echo (($modAsesmenTriasae->isdisability_respon_pain==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pain
                  <br/>
                  <span class="<?php echo (($modAsesmenTriasae->isdisability_respon_unrespons==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Unrespons
                  <span style="padding-left: 10px" class="<?php echo (($modAsesmenTriasae->isdisability_respon_verbal==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Verbal
                </td>
                <td width="50%">
                  <span class="<?php echo (($modAsesmenTriasae->isdisability_pupil_isokor==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Isokor
                  <span style="padding-left: 10px" class="<?php echo (($modAsesmenTriasae->isdisability_pupil_anisokor==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Anisokor
                  <br/>
                  <span class="<?php echo (($modAsesmenTriasae->isdisability_pupil_midriasis==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Midriasis
                  <span style="padding-left: 10px" class="<?php echo (($modAsesmenTriasae->isdisability_pupil_pintpoint==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pin Point
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  Reflek Pupil : <?php echo $modAsesmenTriasae->isdisability_reflekspupil_midriasis; ?>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  GCS : E <span style="padding-right: 30px;" class="borderbottomclass"><?php echo $modAsesmenTriasae->gcs_eye; ?></span>
                  V <span style="padding-right: 30px;" class="borderbottomclass"><?php echo $modAsesmenTriasae->gcs_verbal; ?></span>
                  M <span style="padding-right: 30px;" class="borderbottomclass"><?php echo $modAsesmenTriasae->gcs_motorik; ?></span>
                </td>
              </tr>
            </table>
       </td>
    </tr>
  </table>
  <table width="100%">
    <tr>
        <td width="25%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
            TD : <span style="padding-right: 40px;" class="borderbottomclass"><?php echo $model->td_systolic; ?></span>
            /
            TD <span style="padding-right: 40px;" class="borderbottomclass"><?php echo $model->td_diastolic; ?></span>
            mmHG
        </td>
        <td width="25%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
            N : <span style="padding-right: 100px;" class="borderbottomclass"><?php echo $model->detaknadi; ?></span>
            x/menit
         </td>
         <td width="25%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
           RR : <span style="padding-right: 100px;" class="borderbottomclass"><?php echo $model->pernapasan; ?></span>
           x/menit
        </td>
        <td width="25%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
          T : <span style="padding-right: 100px;" class="borderbottomclass"><?php echo (!empty($model->suhutubuh) ? number_format($model->suhutubuh, 2) : "-"); ?></span>
          &#176 C;
       </td>
    </tr>
  </table>
  <table width="100%">
    <tr>
        <td width="15%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
            KLASIFIKASI TRIAGE
        </td>
        <td width="25%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
            Kondisi Umum
         </td>
         <td width="60%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
           Asesmen Nyeri
        </td>
    </tr>
    <tr>
        <td width="15%" class="padding5 borderclass" valign="top">
            <?php if($modAsesmenTriasae->ismerah == true){ ?>
            <div style="width: 100px; height: 30px; border: 1px solid black; color: black; background: #949494; text-align: center; vertical-align: middle;">
              MERAH /P1
            </div><br/>
          <?php }
            if($modAsesmenTriasae->iskuning == true){
          ?>
            <div style="width: 100px; height: 30px; border: 1px solid black; color: black; background: #949494; text-align: center; vertical-align: middle;">
              KUNING /P2
            </div><br/>
          <?php }
            if($modAsesmenTriasae->ishijau == true){
          ?>
            <div style="width: 100px; height: 30px; border: 1px solid black; color: black; background: #949494; text-align: center; vertical-align: middle;">
              HIJAU /P3
            </div><br/>
          <?php }
            if($modAsesmenTriasae->ishitam == true){
          ?>
            <div style="width: 100px; height: 30px; border: 1px solid black; color: black; background: #949494; text-align: center; vertical-align: middle;">
              HITAM /P4
            </div>
          <?php } ?>
        </td>
        <td width="25%" class="padding5 borderclass" valign="top">
            <table>
              <?php
                $look_kondisi = LookupM::model()->findAllByAttributes(array('lookup_type'=>'asesmentriage_kondisiumum'),array('order'=>'lookup_urutan ASC'));

                if(count((array)$look_kondisi)>0){
                  $htmlLook = "";
                  $indexLook = 0;

                  $len = count((array)$look_kondisi);
                  foreach ($look_kondisi as $i => $look) {
                    $checkLook = false;
                    $textLain = "";

                    if(!empty($modAsesmenTriasae->kondisiumum)){
                      $arrKondisi = CJSON::decode($modAsesmenTriasae->kondisiumum);

                      $textLain = $arrKondisi['lainnya'];
                      foreach ($arrKondisi['ceklis'] as $oriKondisi) {
                          if($oriKondisi == $look->lookup_value){
                            $checkLook = true;
                          }
                      }
                    }
                    $indexLook++;

                    if($indexLook == 1){
                      $htmlLook .= "<tr>";
                    }
                    $htmlLook .= "<td>";
                    $htmlLook .= "<span class='".(($checkLook==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                    $htmlLook .= "</td>";
                    if ($i == $len - 1) {
                      $htmlLook .= "<td>";
                      $htmlLook .= "<span class='".((!empty($textLain))?'fa fa-check-square-o':'fa fa-square-o')."'></span> Lainnya, <br/>".$textLain;
                      $htmlLook .= "</td>";
                    }
                    if($indexLook == 2){
                      $htmlLook .= "</tr>";
                      $indexLook = 0;
                    }
                  }
                  echo $htmlLook;
                }

               ?>
            </table>
         </td>
         <td width="60%" class="padding5 borderclass" valign="top">
           <?php echo $this->renderPartial($this->path_view."anak/print/_printNyeriFisik", array(
                 'modFisik'=>$modFisik
             ), true); ?>
        </td>
    </tr>
  </table>
  <table width="100%">
    <tr>
        <td width="50%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
            Diagnosa Pasien
        </td>
        <td width="50%" class="padding5 borderclass" valign="top" style="border-top: none !important;">
            Pasien Resiko Tinggi
        </td>
    </tr>
    <tr>
        <td width="50%" class="padding5 borderclass" valign="top">
          Diagnosa Utama : <?php echo $model->diagnosa_utama; ?>
          <br/><br/>
          Diagnosa Tambahan : <?php echo $model->diagnosa_tambahan; ?>
        </td>
        <td width="50%" class="padding5 borderclass" valign="top">
            <table width="100%">
              <?php
                $look_resiko = LookupM::model()->findAllByAttributes(array('lookup_type'=>'resikotinggipasien'),array('order'=>'lookup_urutan ASC'));

                if(count((array)$look_resiko)>0){
                  $htmlResiko = "";
                  $indexResiko = 0;

                  foreach ($look_resiko as $i => $look) {
                    $checkResiko = false;

                    if(!empty($model->resikotinggi_pasien)){
                      $arrResiko = CJSON::decode($model->resikotinggi_pasien);

                      foreach ($arrResiko as $oriResiko) {
                          if($oriResiko == $look->lookup_value){
                            $checkResiko = true;
                          }
                      }
                    }
                    $indexResiko++;

                    if($indexResiko == 1){
                      $htmlResiko .= "<tr>";
                    }
                    $htmlResiko .= "<td>";
                    $htmlResiko .= "<span class='".(($checkResiko==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                    $htmlResiko .= "</td>";

                    if($indexResiko == 4){
                      $htmlResiko .= "</tr>";
                      $indexResiko = 0;
                    }
                  }
                  echo $htmlResiko;
                }

               ?>
            </table>
         </td>
    </tr>
  </table>
  <table width="100%">
    <tr>
        <td class="padding5 borderclass" valign="top" style="border-top: none !important;">
            PENGKAJIAN PSIKO-SOSIAL DAN EDUKASI
        </td>
    </tr>
    <tr>
      <td class="padding5 borderclass" valign="top">
        <table width="100%" class="tablefont">
          <tr>
              <td width="150px">Sumber Data</td>
              <td width="5px">:</td>
              <td><?php echo $model->sumberdata; ?></td>
          </tr>
        </table>
        <br/>
        <table width="100%" class="tablefont">
          <tr>
            <td class="padding5 borderclass" valign="top">PSIKOLOGI</td>
          </tr>
          <tr>
            <td class="padding5 borderclass">
              <table width="100%" class="tablefont">
                <tr>
                  <td width="60%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="250px">Masalah Perkawinan</td>
                          <td width="5px">:</td>
                          <td>
                              <span class="<?php echo ((!empty($model->neonatus_masalahperkawinanortu) && $model->neonatus_masalahperkawinanortu=='Tidak Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                              <span style="padding-left: 10px;" class="<?php echo ((!empty($model->neonatus_masalahperkawinanortu) && $model->neonatus_masalahperkawinanortu=='Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                          </td>
                      </tr>
                      <tr>
                          <td>Mengalami Kekerasan Fisik</td>
                          <td>:</td>
                          <td>
                              <span class="<?php echo ((!empty($model->neonatus_kekerasanfisikortu) && $model->neonatus_kekerasanfisikortu=='Tidak Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                              <span style="padding-left: 10px;" class="<?php echo ((!empty($model->neonatus_kekerasanfisikortu) && $model->neonatus_kekerasanfisikortu=='Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada Menederai diri/ Orang Lain
                          </td>
                      </tr>
                      <tr>
                          <td>Trauma Dalam Kehidupan</td>
                          <td>:</td>
                          <td>
                              <span class="<?php echo ((!empty($model->neonatus_traumadlmhiduportu) && $model->neonatus_traumadlmhiduportu=='Tidak Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                              <span style="padding-left: 10px;" class="<?php echo ((!empty($model->neonatus_traumadlmhiduportu) && $model->neonatus_traumadlmhiduportu=='Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                          </td>
                      </tr>
                      <tr>
                          <td>Gangguan tidur</td>
                          <td>:</td>
                          <td>
                            <span class="<?php echo ((!empty($model->gangguantidur_status) && $model->gangguantidur_status=='Tidak Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                            <span style="padding-left: 10px;" class="<?php echo ((!empty($model->gangguantidur_status) && $model->gangguantidur_status=='Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                          </td>
                      </tr>
                      <tr>
                          <td>Konsultasi dengan psikolog/psikiatri</td>
                          <td>:</td>
                          <td>
                            <span class="<?php echo ((!empty($model->neonatus_konsulpsikologortu) && $model->neonatus_konsulpsikologortu=='Tidak Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                            <span style="padding-left: 10px;" class="<?php echo ((!empty($model->neonatus_konsulpsikologortu) && $model->neonatus_konsulpsikologortu=='Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                          </td>
                      </tr>
                    </table>
                  </td>
                  <td width="40%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="100px">Keterangan</td>
                          <td width="5px">:</td>
                          <td>
                              <div class="borderbottomclass" style="width: 80%;">
                                <?php echo $model->neonatus_masalahperkawinanortuket; ?>
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td>Keterangan</td>
                          <td>:</td>
                          <td>
                            <div class="borderbottomclass" style="width: 80%;">
                              <?php echo $model->kekerasanfisiket; ?>
                            </div>
                          </td>
                      </tr>
                      <tr>
                          <td>Keterangan</td>
                          <td>:</td>
                          <td>
                            <div class="borderbottomclass" style="width: 80%;">
                              <?php echo $model->neonatus_traumadlmhiduportuket; ?>
                            </div>
                          </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <br/>
        <table width="100%" class="tablefont">
          <tr>
            <td class="padding5 borderclass" valign="top">SOSIAL</td>
          </tr>
          <tr>
            <td class="padding5 borderclass">
              <table width="100%" class="tablefont">
                <tr>
                  <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="150px">Status Pernikahan</td>
                          <td width="5px">:</td>
                          <td>
                            <div class="borderbottomclass" style="width: 50%;">
                              <?php echo $model->neonatus_kebsosialekonomi_statusperkawinan; ?>
                            </div>
                          </td>
                      </tr>
                      <tr>
                          <td>Anak</td>
                          <td>:</td>
                          <td>
                              <span class="<?php echo ((!empty($model->isada_anak) && $model->isada_anak=='Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                              <span style="padding-left: 10px;" class="<?php echo ((!empty($model->isada_anak) && $model->isada_anak=='Tidak Ada')?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                          </td>
                      </tr>
                      <tr>
                          <td></td>
                          <td></td>
                          <td>
                            Jumlah Anak :
                              <?php echo $model->jml_anak; ?>
                          </td>
                      </tr>
                    </table>
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="150px">Pendidikan Terakhir</td>
                          <td width="5px">:</td>
                          <td>
                            <div class="borderbottomclass" style="width: 50%;">
                              <?php echo $model->neonatus_pendidikanortu; ?>
                            </div>
                          </td>
                      </tr>
                      <tr>
                          <td>Warga Negara</td>
                          <td>:</td>
                          <td>
                            <div class="borderbottomclass" style="width: 50%;">
                              <?php echo $model->neonatus_warganegaraortu; ?>
                            </div>
                          </td>
                      </tr>
                    </table>
                  </td>
                  <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="180px">Pekerjaan</td>
                          <td width="5px">:</td>
                          <td>
                              <div class="borderbottomclass" style="width: 50%;">
                                <?php echo $model->neonatus_masalahperkawinanortuket; ?>
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td>Tinggal Bersama</td>
                          <td>:</td>
                          <td>
                            <?php echo $model->neonatus_tinggalbersama .''.(!empty($model->neonatus_tinggalbersamalainnya_nama)? ', '.$model->neonatus_tinggalbersamalainnya_nama : ""); ?>
                          </td>
                      </tr>
                    </table>
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="180px">Kebiasaan</td>
                          <td width="5px">:</td>
                          <td>
                              <div class="borderbottomclass" style="width: 50%;">
                                <?php echo $model->neonatus_kebiasaanortualkohol_status; ?>
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td>Jenis dan Jumlah perhari</td>
                          <td>:</td>
                          <td>
                            <div class="borderbottomclass" style="width: 50%;">
                              <?php echo $model->neonatus_kebiasaanortualkohol_jenis.' '.$model->neonatus_kebiasaanortualkohol_jml; ?>
                            </div>
                          </td>
                      </tr>
                      <tr>
                          <td>Agama</td>
                          <td>:</td>
                          <td>
                            <div class="borderbottomclass" style="width: 50%;">
                              <?php echo $model->neonatus_agamaortu; ?>
                            </div>
                          </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <br/>
        <table width="100%" class="tablefont">
          <tr>
            <td class="padding5 borderclass" valign="top">EDUKASI</td>
          </tr>
          <tr>
            <td class="padding5 borderclass">
              <table width="100%" class="tablefont">
                <tr>
                  <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="150px" valign="top">Bicara</td>
                          <td width="5px" valign="top">:</td>
                          <td>
                            <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bicara_status) && $modAsesmenkebutuhanEdukasiT->bicara_status=='Normal')? 'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Normal
                            <br/>
                            <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bicara_status) && $modAsesmenkebutuhanEdukasiT->bicara_status=='Serangan Awal Bicara')? 'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Serangan awal gangguan bicara
                            <br/>
                            Kapan <?php echo $modAsesmenkebutuhanEdukasiT->mulaiseranganawal; ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Bahasa Sehari Hari</td>
                          <td>:</td>
                          <td>
                              <?php echo $modAsesmenkebutuhanEdukasiT->bahasadaerah_nama; ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Perlu Penerjemah</td>
                          <td>:</td>
                          <td>
                              <?php echo $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status; ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Bahasa Isyarat</td>
                          <td>:</td>
                          <td>
                              <?php echo $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status; ?>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="3">Hambatan Belajar</td>
                      </tr>
                      <tr>
                          <td colspan="3">
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
                    </table>
                  </td>
                  <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td colspan="3">Cara Belajar yang disukai</td>
                      </tr>
                      <tr>
                          <td colspan="3">
                            <table width="100%" class="tablefont">
                              <tr>
                                <td width="50%">
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
                                  </table>
                                </td>
                                <td width="50%">
                                  <table width="100%" class="tablefont">
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
                            </table>
                          </td>
                      </tr>
                      <tr>
                          <td width="180px">Tingkat Pendidikan</td>
                          <td width="5px">:</td>
                          <td>
                              <?php echo (isset($modAsesmenkebutuhanEdukasiT->pendidikan)?$modAsesmenkebutuhanEdukasiT->pendidikan->pendidikan_nama:""); ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Kesediaan Menerima Edukasi</td>
                          <td>:</td>
                          <td>
                            <table width="100%" class="tablefont">
                                <tr>
                                    <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->kesediaanmenerimaedukasi_status==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak</td>
                                </tr>
                                <tr>
                                    <td>Alasan tidak bersedia : <?php echo (!empty($modAsesmenkebutuhanEdukasiT->kesediaanmenerimaedukasi_alasantidak)?$modAsesmenkebutuhanEdukasiT->kesediaanmenerimaedukasi_alasantidak:"-"); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->kesediaanmenerimaedukasi_status==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" class="tablefont">
                                            <tr>
                                                <td>Pihak Penerima Edukasi</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_pasien==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pasien</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_keluargapasien==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga Pasien
                                                    , <?php echo $modAsesmenkebutuhanEdukasiT->penerimaedukasi_namakeluargapasien; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_lainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga Pasien
                                                    , <?php echo $modAsesmenkebutuhanEdukasiT->penerimaedukasi_lainnyanama; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="3">Pengkajian Kebutuhan Edukasi</td>
                      </tr>
                      <tr>
                          <td colspan="3">
                            <table width="100%" class="tablefont">
                              <?php
                                  $modLookupData = LookupM::model()->findAll("lookup_type = 'edukasipasien'");

                                  if(count((array)$modLookupData)>0){
                                    $indexEdukasi = 0;
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
                                              $indexEdukasi++;
                                              if($indexEdukasi == 1){
                                                ?>
                                                  <tr>
                                                <?php
                                              }

                                              if($dataLook->lookup_value == 'LAIN-LAIN'){ ?>
                                                  <td><span class="<?php echo ((!empty($ModAsseEdu->isedukasipasien) && ($ModAsseEdu->isedukasipasien==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> <?php echo $dataLook->lookup_name; ?>, <?php echo $ModAsseEdu->edukasipasien_lainnya; ?></td>
                                          <?php }else{  ?>
                                                  <td><span class="<?php echo ((!empty($ModAsseEdu->isedukasipasien) && ($ModAsseEdu->isedukasipasien==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> <?php echo $dataLook->lookup_name; ?></td>
                                                  <?php
                                                 }
                                             if($indexEdukasi == 2){
                                               ?>
                                                 </tr>
                                               <?php
                                               $indexEdukasi = 0;
                                             }
                                          }
                                      }
                                   ?>
                            </table>
                          </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
