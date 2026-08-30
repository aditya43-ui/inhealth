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

?>

<table width="100%">
  <tr>
      <td width="50%" class="textbold padding5 borderleftclass borderrightclass">
          DATA AWAL
      </td>
      <td width="50%" class="textright borderleftclass borderrightclass">
          Tgl : <?php echo date('d',strtotime($model->tgl_assesmen_awal)).' '.MyFormatter::getMonthId(date('m',strtotime($model->tgl_assesmen_awal))).' '.date('Y',strtotime($model->tgl_assesmen_awal)); ?>
          Jam : <?php echo date('H:i:s',strtotime($model->tgl_assesmen_awal)); ?> WITA
       </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%" class="tablefont">
          <tr>
              <td width="150px">Rujukan</td>
              <td width="5px">:</td>
              <td><?php echo $rujukan; ?></td>
          </tr>
          <tr>
              <td width="150px">Dx Rujukan</td>
              <td width="5px">:</td>
              <td><?php echo $diagnosarujukan; ?></td>
          </tr>
        </table>
        <table width="100%" class="tablefont">
          <tr>
              <td width="250px">Nama Keluarga yang Bisa Dihubungi </td>
              <td width="5px">:</td>
              <td><?php echo $keluargaNama; ?></td>
          </tr>
          <tr>
              <td>Alamat</td>
              <td>:</td>
              <td><?php echo $keluargaAlamat; ?></td>
          </tr>
          <tr>
              <td>No. Telp</td>
              <td>:</td>
              <td><?php echo $keluargaTelp; ?></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
          KEADAAN UMUM
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%">
            <tr>
                <td width="50%">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td valign="top" width="100px">Kesadaran</td>
                            <td valign="top" width="5px">:</td>
                            <td>
                              <span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Compos Mentis'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Compos Mentis
                              <span style="padding-left: 5px" class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Delirium'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Delirium
                              <span style="padding-left: 5px" class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Somnolen'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Somnolen
                              <span style="padding-left: 5px" class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Sopor'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sopor
                              <span style="padding-left: 5px" class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Koma'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Koma
                            </td>
                        </tr>
                        <tr>
                          <td colspan="3" class="textbold">Tanda-tanda vital</td>
                        </tr>
                        <tr>
                            <td>Tekanan Darah</td>
                            <td>:</td>
                            <td><?php echo $model->tekanandarah; ?> mmHg</td>
                        </tr>
                        <tr>
                            <td>Nadi</td>
                            <td>:</td>
                            <td><?php echo $model->detaknadi; ?> x/Menit</td>
                        </tr>
                        <tr>
                            <td>Suhu</td>
                            <td>:</td>
                            <td><?php echo (!empty($model->suhutubuh)?number_format($model->suhutubuh,2):"-"); ?> &#176; C</td>
                        </tr>
                        <tr>
                            <td>Pernapasan</td>
                            <td>:</td>
                            <td>
                                <?php echo (!empty($model->pernapasan)?number_format($model->pernapasan,2):"-"); ?> x/Menit
                            </td>
                        </tr>
                        <tr>
                            <td>Detak Jantung</td>
                            <td>:</td>
                            <td><?php echo $model->denyutjantung; ?></td>
                        </tr>
                        <tr>
                            <td>Tinggi Badan/ Panjang Badan</td>
                            <td>:</td>
                            <td><?php echo $model->tinggibadan_cm; ?> cm</td>
                        </tr>
                        <tr>
                            <td>Berat Badan</td>
                            <td>:</td>
                            <td><?php echo $model->beratbadan_kg; ?> Kg</td>
                        </tr>
                        <tr>
                            <td>BMI</td>
                            <td>:</td>
                            <td><?php echo $model->bb_ideal; ?> Kg/m<sup>2</sup></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="100px">Kelainan pada Bag. Tubuh</td>
                            <td width="10px">:</td>
                            <td><?php echo $model->kelainanpadabagtubuh; ?></td>
                        </tr>
                        <tr>
                            <td>Reflek Cahaya</td>
                            <td>:</td>
                            <td> <?php echo $model->tandavital_reflekcahaya; ?></td>
                        </tr>
                        <tr>
                            <td>SpO2</td>
                            <td>:</td>
                            <td> <?php echo $model->tandavital_spo2; ?> %</td>
                        </tr>
                        <tr>
                            <td valign="top">Alergi</td>
                            <td valign="top">:</td>
                            <td>
                                <table width="100%" class="tablefont">
                                    <tr>
                                        <td colspan="2"><span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien == 'Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Ada
                                            <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien == 'Tidak Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Tidak Ada
                                            <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien == 'Tidak Tahu')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Tidak Tahu</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Bila Ada: </td>
                                    </tr>
                                    <tr>
                                        <td width="170px">Riwayat Alergi Obat</td>
                                        <td>: <?php echo $model->riwayatalergiobat; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Riwayat Alergi Makanan</td>
                                        <td>: <?php echo $model->riwayatalergimakanan; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Riwayat Alergi Lainnya</td>
                                        <td>: <?php echo $model->riwayatalergilainnya; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                          <span class="<?php echo (($model->ispasangtandaalergi==true) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Gelang Tanda Alergi Dipasang (Warna Merah)
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
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        PENILAIAN NYERI
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%">
          <tr>
              <td width="40%" valign="top">
                <table width="100%" class="tablefont">
                    <tr>
                        <td width="100px" valign="top">Nyeri</td>
                        <td width="5px" valign="top">:</td>
                        <td>
                          <span class="<?php echo ((!empty($model->isadakeluhannyeri) && ($model->isadakeluhannyeri=='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                          <br/>
                          <span class="<?php echo ((!empty($model->isadakeluhannyeri) && ($model->isadakeluhannyeri=='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya, Jenis
                          <br/>
                           <span style="padding-left: 20px" class="<?php echo ((empty($model->jenisnyeri) && ($model->jenisnyeri=='Akut'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Akut
                          <br/>
                          <span style="padding-left: 20px" class="<?php echo ((empty($model->jenisnyeri) && ($model->jenisnyeri=='Kronis'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kronis
                        </td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td>:</td>
                        <td><?php echo $model->deskripsinyeri_lokasiskalanyeri; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Sistem Skoring</td>
                        <td valign="top">:</td>
                        <td>
                          <span class="fa fa-check-square-o"></span> Wong Baker Faces Pain Scale
                          <br/>
                          <span class="fa fa-square-o"></span> Numeric Rating Scale
                          <br/>
                          <span class="fa fa-square-o"></span> VAS
                        </td>
                    </tr>
                </table>
              </td>
              <td width="60%" valign="top">
                <table width="100%" class="tablefont">
                  <tr>
                    <td style="text-decoration: underline" class="textbold" colspan="3">Deskripsi Nyeri</td>
                  </tr>
                  <tr>
                      <td width="100px">Onset</td>
                      <td width="5px">:</td>
                      <td><?php echo $model->deskripsinyeri_onset.' '.$model->deskripsinyeri_onsetsatuan; ?></td>
                  </tr>
                  <tr>
                      <td>Pencetus</td>
                      <td>:</td>
                      <td><?php echo $model->deskripsinyeri_penyebabtimbul; ?></td>
                  </tr>
                    <tr>
                        <td valign="top">Kualitas</td>
                        <td valign="top">:</td>
                        <td>
                          <?php
                               $lookupKualitas = LookupM::model()->findAll("lookup_type = 'kualitasnyeri'");

                               if(count($lookupKualitas) >0 ){
                                 $htmlKualitas = "";

                                 foreach($lookupKualitas as $i => $look_risiko){
                                   $isKualitas = false;
                                   $stylKualitas = "";
                                   if($i > 0){
                                     $stylKualitas .= "style='padding-left:5px;'";
                                   }

                                   if(!empty($model->kualitasnyeri)){
                                     $oriKualitasNyeri = json_decode($model->kualitasnyeri);

                                     if(isset($oriKualitasNyeri) && count($oriKualitasNyeri) > 0){
                                       foreach ($oriKualitasNyeri as $propKualitas) {
                                         if($propKualitas == $look_risiko->lookup_value){
                                           $isKualitas = true;
                                         }
                                       }
                                     }
                                   }

                                   if($look_risiko->lookup_value == 'Lainnya'){
                                     $htmlKualitas .= "<span ".$stylKualitas." class='".(($isKualitas==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                                     $htmlKualitas .= ", ".$model->kualitasnyeri_lainnya;
                                   }else{
                                     $htmlKualitas .= "<span ".$stylKualitas." class='".(($isKualitas==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                                   }
                                 }
                                 echo $htmlKualitas;
                               }
                           ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Menjalar</td>
                        <td valign="top">:</td>
                        <td>
                          <span class="<?php echo (($model->deskripsinyeri_ismenjalar ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                          <br />
                          <span class="<?php echo (($model->deskripsinyeri_ismenjalar ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                          ke <?php echo $model->deskripsinyeri_lokasipenjalaran; ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Tingkat</td>
                        <td valign="top">:</td>
                        <td>
                          <span class="<?php echo ((!empty($model->tingkatannyeri ) && ($model->tingkatannyeri =='Ringan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ringan
                          <span style="padding-left: 5px" class="<?php echo ((!empty($model->tingkatannyeri ) && ($model->tingkatannyeri =='Sedang'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sedang
                          <span style="padding-left: 5px" class="<?php echo ((!empty($model->tingkatannyeri ) && ($model->tingkatannyeri =='Berat'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Berat
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Waktu</td>
                        <td valign="top">:</td>
                        <td>
                          <?php
                          $lookupFrekuensi = LookupM::model()->findAll("lookup_type = 'frekuensinyeri'");

                          if(count($lookupFrekuensi) >0 ){
                            $htmlFrekuensi = "";

                            foreach($lookupFrekuensi as $i => $look_risiko){
                              $isFrekuensi = false;
                              if($i > 0){
                                $htmlFrekuensi .= "<br/>";
                              }

                              if(!empty($model->deskripsinyeri_frekuensinyeri)){
                                $oriFrekensi = json_decode($model->deskripsinyeri_frekuensinyeri);

                                if(isset($oriFrekensi) && count($oriFrekensi) > 0){
                                  foreach ($oriFrekensi as $propFrekuensi) {
                                    if($propFrekuensi == $look_risiko->lookup_value){
                                      $isFrekuensi = true;
                                    }
                                  }
                                }
                              }

                              if($look_risiko->lookup_value == 'Lainnya'){
                                $htmlFrekuensi .= "<span class=".(($isFrekuensi==true)?'fa fa-check-square-o':'fa fa-square-o')."></span> ".$look_risiko->lookup_name;
                                $htmlFrekuensi .= ", ".$model->deskripsinyeri_frekuensinyerilainnya;
                              }else{
                                $htmlFrekuensi .= "<span class=".(($isFrekuensi==true)?'fa fa-check-square-o':'fa fa-square-o')."></span> ".$look_risiko->lookup_name;
                              }
                            }
                            echo $htmlFrekuensi;
                           }
                           ?>
                        </td>
                    </tr>
                  </td>
                </table>
              </td>
          </tr>
        </table>
        <br/>
        <div style="page-break-after:always;"></div>
        <?php if ($model->is_keluhannyeri_dewasa == true) { ?>
          <table width="70%">
              <tr class="borderclass">
                  <td style="padding:5px" class="textbold">Asesmen Nyeri Anak > 3 Tahun</td>
              </tr>
              <tr class="borderclass">
                  <td style="padding:10px">
                      <h2 style="text-align:center;">Intensitas "WONG BAKER FACE SCALE"</h2>
                      <br/>
                      <?php
                      echo $this->renderPartial($this->path_view.'_formAsesmenDewasaPrint', array(
                          'model' => $model
                          ), true);
                      ?>
                  </td>
              </tr>
          </table>
        <?php }else{ ?>
          <table width="100%">
              <tr class="borderclass">
                  <td style="padding:5px" class="textbold">Asesmen Nyeri Anak < 3 Tahun</td>
              </tr>
              <tr class="borderclass">
                  <td style="padding:10px">
                      <table class="borderclass" id="master_falsccs">
                          <!-- <thead> -->
                          <tr>
                              <td class="borderclass" colspan="5" style="text-align:center;">SKALA FLACSS UNTUK ANAK < 3 TAHUN</td>
                          </tr>
                          <tr>
                              <td class="borderclass" style="text-align:center;vertical-align: middle;" rowspan="2">KRITERIA</td>
                              <td class="borderclass" style="text-align:center;" colspan="3">SKOR</td>
                              <td class="borderclass" style="text-align:center;vertical-align: middle;" rowspan="2">NILAI</td>
                          </tr>
                          <tr>
                              <td class="borderclass" style="text-align:center;">0</td>
                              <td class="borderclass" style="text-align:center;">1</td>
                              <td class="borderclass" style="text-align:center;">2</td>
                          </tr>
                          <!-- </thead>
                          <tbody> -->
                          <?php
                          $sk = 0;
                          foreach ($dataFlaCcs as $det) {
                              ?>
                              <tr>
                                  <td class="borderclass"><b><?php echo $det['kategori']; ?></b></td>
                                  <td style="<?php echo!empty($det[0]['id']) ? 'border:4px solid #333 !important;' : '' ?>" class="hover params-nilai0 borderflaccs" >
                                      <?php
                                      foreach ($det[0] as $var0) {
                                          echo '<span  style="color:#333;font-size:12px;">' . $var0['keterangan'] . '</span>';
                                      }
                                      ?>
                                  </td>
                                  <td class="borderclass" style="<?php echo!empty($det[1]['id']) ? 'border:4px solid #333 !important;' : '' ?>" class="hover params-nilai1 borderflaccs">
                                      <?php
                                      foreach ($det[1] as $var0) {
                                          echo '<span  style="color:#333;font-size:12px;">' . $var0['keterangan'] . '</span>';
                                      }
                                      ?>
                                  </td>
                                  <td class="borderclass" style="<?php echo!empty($det[2]['id']) ? 'border:4px solid #333 !important;' : '' ?>" class="hover params-nilai2 borderflaccs">
                                      <?php
                                      foreach ($det[2] as $var0) {
                                          echo '<span style="color:#333;font-size:12px;">' . $var0['keterangan'] . '</span>';
                                      }
                                      ?>
                                  </td>
                                  <td class="borderclass" style="text-align:right;">
                                      <?php
                                      $modNyeriDet = new SkrinningnyerianakdetT();
                                      $modNyeriDet->skrinningnyerianakdet_id = (isset($det['val_anak_id']) ? $det['val_anak_id'] : null);
                                      $modNyeriDet->kat_skalanyeri_id = (isset($det['val_kat_id']) ? $det['val_kat_id'] : null);
                                      $modNyeriDet->skalanyeriflaccs_param = (isset($det['val_params']) ? $det['val_params'] : null);
                                      $modNyeriDet->skalanyeriflaccs_nilai = (isset($det['val_nilai']) ? $det['val_nilai'] : null);

                                      echo CHtml::activeHiddenField($modNyeriDet, '[' . $sk . ']skrinningnyerianakdet_id', array('readonly' => true, 'class' => 'nyerianak_id field'));
                                      echo CHtml::activeHiddenField($modNyeriDet, '[' . $sk . ']kat_skalanyeri_id', array('readonly' => true, 'class' => 'kategoriid field'));
                                      echo CHtml::activeHiddenField($modNyeriDet, '[' . $sk . ']skalanyeriflaccs_param', array('class' => 'params field', 'readonly' => true));
                                      echo CHtml::activeHiddenField($modNyeriDet, '[' . $sk . ']skalanyeriflaccs_nilai', array('class' => 'nilai field', 'readonly' => true));
                                      ?>
                                      <strong><span class="labelname" id="skor_<?php echo $det['kategori_id']; ?>"><?php echo $modNyeriDet->skalanyeriflaccs_nilai; ?></span></strong>
                                  </td>
                              </tr>
                              <?php
                              $sk++;
                          }
                          ?>
                          <tfoot>
                              <tr>
                                  <td class="borderclass" colspan="4" style="text-align: center;">
                                      <strong>TOTAL SKOR </strong>
                                  </td>
                                  <td class="borderclass" style="text-align: right;">
                                      <strong><span class="labelname"  id="totalskor"><?php echo $model->score_skalanyeri; ?></span></strong>
                                      <?php echo CHtml::activeHiddenField($model, 'score_skalanyeri_anak', array('readonly' => true, 'class' => ' field')) ?>
                                      <?php echo CHtml::activeHiddenField($model, 'keteranganskala_nyeri_anak', array('readonly' => true, 'class' => ' field')) ?>
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="5">
                                      <table class="" width="100%">
                                          <tr>
                                              <td colspan="3">
                                                  <b>Keterangan</b>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td width="33%">
                                                  <span id="skalanyerirange_0" min="0" max="0"><strong>0</strong> : Tidak nyeri</span>
                                              </td>
                                              <td width="33%">
                                                  <span id="skalanyerirange_1_3"  min="1" max="3"><strong>1-3</strong> : Nyeri ringan</span>
                                              </td>
                                              <td width="33%">

                                              </td>
                                          </tr>
                                          <tr>
                                              <td width="33%">
                                                  <span id="skalanyerirange_4_6"  min="4" max="6"><strong>4-6</strong> : Nyeri sedang</span>
                                              </td>
                                              <td width="33%">
                                                  <span id="skalanyerirange_7_10"  min="7" max="10"><strong>7-10</strong> : Nyeri hebat</span>
                                              </td>
                                              <td width="33%">

                                              </td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                      </table>

                  </td>
              </tr>
          </table>
          <?php } ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        PENILAIAN RESIKO JATUH
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <p class="textbold">Form Pengkajian : Skrining Resiko Jatuh Anak (Humpty Dumpty)</p>
        <table class="tableBorder" width="100%">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Parameter</th>
                    <th style="width: 250px">Kriteria</th>
                    <th style="width: 50px">Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Usia</td>
                    <td>
                        <?php echo  $model->usia_anak; ?>
                    </td>
                    <td><?php echo $model->skor_usia_anak; ?></td>
                </tr>
                 <tr>
                    <td class="textcenter">2</td>
                    <td>Jenis Kelamin</td>
                    <td>
                        <?php echo  $model->jeniskelamin_anak; ?>
                    </td>
                    <td><?php echo $model->skor_jeniskelamin_anak; ?></td>
                </tr>
                 <tr>
                    <td class="textcenter">3</td>
                    <td>Diagnose</td>
                    <td>
                        <?php echo  $model->diagnosa_asessment_anak; ?>
                    </td>
                    <td><?php echo $model->skor_diagnosa_anak; ?></td>
                </tr>
                 <tr>
                    <td class="textcenter">4</td>
                    <td>Gangguan Kognitif</td>
                    <td>
                        <?php echo  $model->gangguan_kognitif_anak; ?>
                    </td>
                    <td><?php echo $model->skor_gangguan_kognitif_anak; ?></td>
                </tr>
                 <tr>
                    <td class="textcenter">5</td>
                    <td>Faktor Lingkungan</td>
                    <td>
                        <?php echo  $model->faktor_lingkungan_anak; ?>
                    </td>
                    <td><?php echo $model->skor_faktor_lingkungan_anak; ?></td>
                </tr>
                 <tr>
                    <td class="textcenter">6</td>
                    <td>Respon Terhadap: Pembedahan, sedasi, anestesi</td>
                    <td>
                        <?php echo  $model->responterhadap_pembedahan_anak; ?>
                    </td>
                    <td><?php echo $model->skor_responterhadap_pembedahan_anak; ?></td>
                </tr>
                 <tr>
                    <td class="textcenter">6</td>
                    <td>Penggunaan Medikamentosa</td>
                    <td>
                        <?php echo  $model->penggunaan_medikamentosa; ?>
                    </td>
                    <td><?php echo $model->skor_medikamentosa_anak; ?></td>
                </tr>
                <tr>
                    <td colspan="3">Total Skor</td>
                    <td> <?php echo $model->jumlah_skor_anak; ?> </td>
                </tr>
                <tr>
                    <td colspan="2">Pasien termasuk kategori risiko jatuh : </td>
                    <td colspan="2"> <?php echo $model->keterangan_resiko_jatuh_anak; ?> </td>
                </tr>
            </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        Kontrol Risiko Infeksi
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%" class="tablefont">
            <tr>
                <td width="80px">Status</td>
                <td width="5px">:</td>
                <td>
                  <span class="<?php echo ((!empty($model->kontrolrisikoinfeksi_status ) && ($model->kontrolrisikoinfeksi_status =='Tidak Diketahui'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Diketahui
                  <span style="padding-left: 5px" class="<?php echo ((!empty($model->kontrolrisikoinfeksi_status ) && ($model->kontrolrisikoinfeksi_status =='Suspect'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Suspect
                  <span style="padding-left: 5px" class="<?php echo ((!empty($model->kontrolrisikoinfeksi_status ) && ($model->kontrolrisikoinfeksi_status =='Diketahui'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Diketahui :
                  <?php
                       $lookupJenisRisiko = LookupM::model()->findAll("lookup_type = 'jenisrisikoinfeksi'");

                       if(count($lookupJenisRisiko) >0 ){
                         $htmlRisiko = "";

                         foreach($lookupJenisRisiko as $i => $look_risiko){
                           $styleRisiko = "";
                           $isRisiko = false;

                           if($i > 0){
                             $styleRisiko = "style='padding-left: 5px'";
                           }

                           if(!empty($model->jenisrisikoinfeksi)){
                             $oriRisiko = json_decode($model->jenisrisikoinfeksi);

                             if(isset($oriRisiko) && count($oriRisiko) > 0){
                               foreach ($oriRisiko as $propRisiko) {
                                 if($propRisiko == $look_risiko->lookup_value){
                                   $isRisiko = true;
                                 }
                               }
                             }
                           }

                           if($look_risiko->lookup_value == 'Lainnya'){
                             $htmlRisiko .= "<span ".$styleRisiko." class='".(($isRisiko==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                             $htmlRisiko .= ", ".$model->jenisrisikoinfeksi_lainnya;
                           }else{
                             $htmlRisiko .= "<span ".$styleRisiko." class='".(($isRisiko==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                           }
                         }
                         echo $htmlRisiko;
                       }
                   ?>
                </td>
            </tr>
          </table>
          <table width="100%" class="tablefont">
            <tr>
                <td width="300px">Addtional Precaution yang harus dilakukan</td>
                <td width="5px">:</td>
                <td>
                  <?php
                  $lookupAddtion = LookupM::model()->findAll("lookup_type = 'addtional_precaution'");

                  if(count($lookupAddtion) >0 ){
                    $htmlAddtion = "";

                    foreach($lookupAddtion as $i => $look_risiko){
                      $styleRisiko = "";
                      $isaddtional_precaution = false;

                      if($i > 0){
                        $styleRisiko = "style='padding-left: 5px'";
                      }

                      if(!empty($model->addtional_precaution)){
                        $oriAddtional = json_decode($model->addtional_precaution);

                        if(isset($oriAddtional) && count($oriAddtional) > 0){
                          foreach ($oriAddtional as $propAddtional) {
                            if($propAddtional == $look_risiko->lookup_value){
                              $isaddtional_precaution = true;
                            }
                          }
                        }
                      }

                      if($look_risiko->lookup_value == 'Lainnya'){
                        $htmlAddtion .= "<span ".$styleRisiko." class='".(($isaddtional_precaution==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                        $htmlAddtion .= ", ".$model->jenisrisikoinfeksi_lainnya;
                      }else{
                        $htmlAddtion .= "<span ".$styleRisiko." class='".(($isaddtional_precaution==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                      }
                    }
                      echo $htmlAddtion;
                    }
                   ?>
                </td>
            </tr>
          </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        ANAMNESA
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%">
            <tr>
                <td width="50%">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px">Sumber Data</td>
                            <td width="5px">:</td>
                            <td>
                              <span class="<?php echo ((!empty($model->sumberdata ) && ($model->sumberdata =='Pasien'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pasien
                              <span style="padding-left: 5px" class="<?php echo ((!empty($model->sumberdata ) && ($model->sumberdata =='Keluarga'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga
                              <span style="padding-left: 5px" class="<?php echo ((!empty($model->sumberdata ) && ($model->sumberdata =='Lainnya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya
                              , <?php echo $model->sumberdata_lainnya; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Keluhan Utama</td>
                            <td>:</td>
                            <td><?php echo trim($model->keluhanutama); ?></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="150px">Keluhan Tambahan</td>
                          <td width="5px">:</td>
                          <td><?php echo trim($model->keluhantambahan); ?></td>
                      </tr>
                    </table>
                </td>
            </tr>
        </table>
      </td>
    </tr>
</table>
