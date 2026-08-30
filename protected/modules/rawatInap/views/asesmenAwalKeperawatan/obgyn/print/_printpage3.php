<table width="100%">
  <tr>
    <td colspan="2" class="textbold padding5 borderclass bordernonetopclass">
      PENILAIAN NYERI
    </td>
  </tr>
  <tr>
    <td colspan="2" class="padding5 borderclass">
      <?php if(!empty($model->kesadaranpasien_pengkajiannyeri) && $model->kesadaranpasien_pengkajiannyeri=="Tidak Sadar"){ ?>
        <table width="100%" class="tablefont">
            <tr>
              <td>
                Keadaan Pasien : <?php echo $model->kesadaranpasien_pengkajiannyeri; ?>
              </td>
            </tr>
            <tr>
              <td style="font-weight: bold">
                Behaviour Pain Scale
              </td>
            </tr>
            <tr>
                <td width="80%">
                    <table class="tableBorder" width="80%">
                        <thead>
                            <tr>
                                <th style="width: 250px">Paramater</th>
                                <th style="width: 250px">Penilaian</th>
                                <th style="width: 50px">Skor</th>
                            </tr>
                       </thead>
                        <tr>
                            <td>Ekspresi Wajah</td>
                            <td><?php echo $model->skriningnyeribps_ekspresiwajahpenilaian; ?></td>
                            <td><?php echo $model->skriningnyeribps_ekspresiwajahskor; ?></td>
                        </tr>
                        <tr>
                            <td>Ekstremitas Atas</td>
                            <td><?php echo $model->skriningnyeribps_ekstremitasataspenilaian; ?></td>
                            <td><?php echo $model->skriningnyeribps_ekstremitasatasskor; ?></td>
                        </tr>
                        <tr>
                            <td>Kepatuhan dengan Vetilator</td>
                            <td><?php echo $model->skriningnyeribps_kepatuhanventilatorpenilaian; ?></td>
                            <td><?php echo $model->skriningnyeribps_kepatuhanventilatorskor; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold;">Total Skor</td>
                            <td><?php echo $model->score_skalanyeri; ?></td>
                       </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold;">Kriteria Skor Nyeri</td>
                            <td><?php echo $model->keteranganskala_nyeri; ?></td>
                       </tr>
                    </table>
                </td>
            </tr>
        </table>
      <?php } else if(!empty($model->kesadaranpasien_pengkajiannyeri) && $model->kesadaranpasien_pengkajiannyeri=="Sadar"){ ?>
        <table width="100%">
          <tr>
              <td width="50%">
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
                </table>
              </td>
              <td width="50%">
                <table width="100%" class="tablefont">
                  <tr>
                      <td width="150px">Lokasi</td>
                      <td width="5px">:</td>
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
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td colspan="2" style="text-decoration: underline; font-weight: bold; color: black">Deskripsi Nyeri</td>
          </tr>
          <tr>
              <td width="50%">
                <table width="100%" class="tablefont">
                  <tr>
                      <td width="150px">Onsite</td>
                      <td width="5px">:</td>
                      <td><?php echo $model->deskripsinyeri_onset.' '.$model->deskripsinyeri_onsetsatuan; ?></td>
                  </tr>
                  <tr>
                      <td width="150px">Pencetus</td>
                      <td width="5px">:</td>
                      <td><?php echo $model->deskripsinyeri_penyebabtimbul; ?></td>
                  </tr>
                    <tr>
                        <td width="100px" valign="top">Kualitas</td>
                        <td width="5px" valign="top">:</td>
                        <td>
                          <?php
                               $lookupKualitas = LookupM::model()->findAll("lookup_type = 'kualitasnyeri'");

                               if(count((array)$lookupKualitas) >0 ){
                                 $htmlKualitas = "";

                                 foreach($lookupKualitas as $i => $look_risiko){
                                   $isKualitas = false;
                                   if($i > 0){
                                     $htmlKualitas .= "<br/>";
                                   }

                                   if(!empty($model->kualitasnyeri)){
                                     $oriKualitasNyeri = json_decode($model->kualitasnyeri);

                                     if(isset($oriKualitasNyeri) && count((array)$oriKualitasNyeri) > 0){
                                       foreach ($oriKualitasNyeri as $propKualitas) {
                                         if($propKualitas == $look_risiko->lookup_value){
                                           $isKualitas = true;
                                         }
                                       }
                                     }
                                   }

                                   if($look_risiko->lookup_value == 'Lainnya'){
                                     $htmlKualitas .= "<span class='".(($isKualitas==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                                     $htmlKualitas .= ", ".$model->kualitasnyeri_lainnya;
                                   }else{
                                     $htmlKualitas .= "<span class='".(($isKualitas==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                                   }
                                 }
                                 echo $htmlKualitas;
                               }
                           ?>
                        </td>
                    </tr>
                </table>
              </td>
              <td width="50%">
                <table width="100%" class="tablefont">
                  <tr>
                      <td width="150px" valign="top">Menjalar</td>
                      <td width="5px" valign="top">:</td>
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

                          if(count((array)$lookupFrekuensi) >0 ){
                            $htmlFrekuensi = "";

                            foreach($lookupFrekuensi as $i => $look_risiko){
                              $isFrekuensi = false;
                              if($i > 0){
                                $htmlFrekuensi .= "<br/>";
                              }

                              if(!empty($model->deskripsinyeri_frekuensinyeri)){
                                $oriFrekensi = json_decode($model->deskripsinyeri_frekuensinyeri);

                                if(isset($oriFrekensi) && count((array)$oriFrekensi) > 0){
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
                </table>
              </td>
          </tr>
          <tr>
            <td colspan="2" style="text-decoration: underline; font-weight: bold; color: black">Skor Nyeri</td>
          </tr>
          <tr>
            <td colspan="2">
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
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="textbold padding5 borderclass">
      STATUS NUTRISI
    </td>
  </tr>
  <tr>
    <td colspan="2" class="padding5 borderclass">
      <table width="100%" class="tablefont">
        <tr>
            <td>Berat Badan (BB) biasanya : <?php echo $model->beratbadan_biasanya ?> Kg</td>
            <td>Berat Badan (BB) sekarang : <?php echo $model->beratbadan_kg ?> Kg</td>
            <td>Tinggi Badan/ Panjang Badan : <?php echo $model->tinggibadan_cm ?> cm</td>
            <td>BMI : <?php echo $model->bb_ideal ?> Kg/m<sup>2</sup></td>
        </tr>
      </table>
      <br/>
      <table width="100%" class="tableBorder">
          <thead>
              <tr>
                  <th colspan="4" style="text-align: center">Skrining Gizi pada Dewasa <br /> Berdasarkan Metode Strong MST (usia > 18 th)</th>
              </tr>
              <tr>
                  <th style="width: 10px">No</th>
                  <th>Parameter</th>
                  <th style="width: 150px">Nilai</th>
              </tr>
         </thead>
          <tr>
              <td style="border-bottom: none;">1</td>
              <td style="border-bottom: none;">Apakah pasien mengalami penurunan berat badan yang tidak direncanakan/tidak diinginkan dalam 6 bulan terakhir?</td>
              <td style="border-bottom: none;">
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none;">Tidak</td>
              <td style="border-bottom: none; border-top: none;" class="textcenter">
                   <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 0
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none;">Tidak tahu berapa kg penurunan</td>
              <td style="border-bottom: none; border-top: none;" class="textcenter">
                  <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Tidak tahu berapa kg penurunan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 2
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none;">Ya, ada penurunan BB Sebanyak :</td>
              <td style="border-bottom: none; border-top: none;"></td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none; padding-left: 10px"> Ada penurunan BB sebanyak 1 - 5 Kg</td>
              <td style="border-bottom: none; border-top: none;" class="textcenter">
                  <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Ada penurunan BB sebanyak 1-5 kg'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 1
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none; padding-left: 10px"> Ada penurunan BB sebanyak 6 - 10 Kg</td>
              <td style="border-bottom: none; border-top: none;" class="textcenter">
                  <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Ada penurunan BB sebanyak 6-10 kg'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 2
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none; padding-left: 10px">Ada penurunan BB sebanyak 11 - 15 Kg</td>
              <td style="border-bottom: none; border-top: none;" class="textcenter">
                  <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Ada penurunan BB sebanyak 11-15 kg'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 3
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none; padding-left: 10px">Ada penurunan BB sebanyak > 15 Kg</td>
              <td style="border-bottom: none; border-top: none;" class="textcenter">
                  <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Ada penurunan BB sebanyak >15 kg'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 4
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none;">2</td>
              <td style="border-bottom: none;">Apakah asuhan makan pasien berkurang karena penurunan nafsu makan/kesulitan menerima makan?</td>
              <td style="border-bottom: none;">
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none;">Ya</td>
              <td style="border-bottom: none; border-top: none;" class="textcenter">
                  <span class="<?php echo ((!empty($model->skrinninggizi_jwb_asupanmakanan_dewasa) && ($model->skrinninggizi_jwb_asupanmakanan_dewasa=='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 1
              </td>
          </tr>
          <tr>
              <td style="border-bottom: none; border-top: none;"></td>
              <td style="border-bottom: none; border-top: none;">Tidak</td>
              <td style="border-bottom: none; border-top: none;" class="textcenter">
                  <span class="<?php echo ((!empty($model->skrinninggizi_jwb_asupanmakanan_dewasa) && ($model->skrinninggizi_jwb_asupanmakanan_dewasa=='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 0
              </td>
          </tr>
          <tr>
              <td colspan="2">Total Skor</td>
              <td class="textcenter"> <?php echo $model->skrinninggizi_skor_totaldewasa; ?> </td>
          </tr>
          <tr>
              <td colspan="2">Resiko</td>
              <td> <?php echo $model->skrininggizidewasa_resiko; ?> </td>
          </tr>
          <tr>
              <td colspan="2">Tindakan</td>
              <td> <?php echo $model->skrininggizidewasa_tindakanygdilakukan; ?> </td>
          </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="textbold padding5 borderclass">
      RIWAYAT MENSTRUASI & PERKAWINAN
    </td>
  </tr>
  <tr>
    <td colspan="2" class="padding5 borderclass">
      <table width="100%">
        <tr>
          <td class="padding5 borderclass">
            Riwayat Menstruasi
          </td>
        </tr>
        <tr>
          <td class="padding5 borderclass">
            <table width="100%">
              <tr>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px">Siklus Haid</td>
                          <td width="5px">:</td>
                          <td><?php echo $model->obgyn_siklushaid; ?> Hari</td>
                      </tr>
                      <tr>
                          <td>Menarche Umur</td>
                          <td>:</td>
                          <td><?php echo $model->obgyn_menarcheumur; ?> Tahun</td>
                      </tr>
                      <tr>
                          <td>Menstruasi Terakhir</td>
                          <td>:</td>
                          <td><?php echo (!empty($model->obgyn_mensterakhir)? MyFormatter::formatDateTimeForUser($model->obgyn_mensterakhir):""); ?></td>
                      </tr>
                      <tr>
                          <td>Keluhan saat haid</td>
                          <td>:</td>
                          <td><?php echo $model->obgyn_keluhansaathaid; ?></td>
                      </tr>
                      <tr>
                          <td>banyaknya</td>
                          <td>:</td>
                          <td><?php echo $model->obgyn_banyaknyahaid; ?> ml</td>
                      </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px">Haid Teratur</td>
                          <td width="5px">:</td>
                          <td>
                            <span class="<?php echo ((!empty($model->obgyn_keteraturanhaid) && ($model->obgyn_keteraturanhaid =='Teratur'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Teratur
                            <span style="padding-left: 5px" class="<?php echo ((!empty($model->obgyn_keteraturanhaid) && ($model->obgyn_keteraturanhaid =='Tidak Teratur'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Teratur
                          </td>
                      </tr>
                      <tr>
                          <td>Lama Haid</td>
                          <td>:</td>
                          <td><?php echo $model->obgyn_lamahaid; ?> Hari</td>
                      </tr>
                      <tr>
                          <td>Taksiran tanggal persalinan</td>
                          <td>:</td>
                          <td><?php echo (!empty($model->obgyn_taksiranpersalinan)? MyFormatter::formatDateTimeForUser($model->obgyn_taksiranpersalinan) : ""); ?></td>
                      </tr>
                      <tr>
                          <td>Usia Kehamilan menurut HPHT</td>
                          <td>:</td>
                          <td><?php echo $model->obgyn_usiakehamilanhpht; ?> Minggu</td>
                      </tr>
                    </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="padding5 borderclass">
            Riwayat Perkawinan
          </td>
        </tr>
        <tr>
          <td class="padding5 borderclass">
            <table width="100%">
              <tr>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px" valign="top">Status</td>
                          <td width="5px" valign="top">:</td>
                          <td>
                            <span class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Belum Kawin'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Belum Kawin
                            <br/><span class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Cerai'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Cerai
                            <br/><span class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Kawin'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kawin
                            <br/><span style="padding-left: 15px"></span> Jumlah : <?php echo $model->obgyn_jumlahperkawainan; ?> Kali
                          </td>
                      </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px">Umur waktu kawin pertama</td>
                          <td width="5px">:</td>
                          <td>
                            <?php echo $model->obgyn_umurkawinpertama; ?> Tahun
                          </td>
                      </tr>
                      <tr>
                          <td>Golongan Darah</td>
                          <td>:</td>
                          <td><?php echo $model->obgyn_golongandarah; ?></td>
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
      RIWAYAT KEHAMILAN
    </td>
  </tr>
  <tr>
    <td colspan="2" class="padding5 borderclass">
      <table width="100%">
        <tr>
          <td class="padding5 borderclass">
            Riwayat Kehamilan
          </td>
        </tr>
        <tr>
          <td class="padding5 borderclass">
            <table class="tableBorder" style="width: 100%">
              <thead>
                <tr>
                    <th rowspan="2" class="textcenter">Hamil Ke-</th>
                    <th rowspan="2" class="textcenter">Umur Kehamilan <b/>(Minggu)</th>
                    <th colspan="2" class="textcenter textbold">Sex</th>
                    <th rowspan="2" class="textcenter">Cara Persalinan</th>
                    <th rowspan="2" class="textcenter">Penolong Persalinan</th>
                    <th rowspan="2" class="textcenter">Tempat Persalinan</th>
                    <th colspan="2" class="textcenter textbold">Abortus</th>
                    <th rowspan="2" class="textcenter">Komplikasi/ Keterangan</th>
                </tr>
                <tr>
                    <th width="50px" class="textcenter">L</th>
                    <th width="50px" class="textcenter">P</th>
                    <th width="50px" class="textcenter">Ya</th>
                    <th width="50px" class="textcenter">Tidak</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(!empty($modRiwayatObstertikpasien)){
                      foreach($modRiwayatObstertikpasien as $rwyt_kehamilan){
                        ?>
                        <tr>
                          <td><?php echo $rwyt_kehamilan->kehamilan_hamilke ?></td>
                          <td><?php echo $rwyt_kehamilan->kehamilan_umur ?></td>
                          <td><?php echo ((!empty($rwyt_kehamilan->anak_jeniskelamin) && $rwyt_kehamilan->anak_jeniskelamin  == 'Laki-laki')? "<i class='fa fa-check'></i>": ""); ?></td>
                          <td><?php echo ((!empty($rwyt_kehamilan->anak_jeniskelamin) && $rwyt_kehamilan->anak_jeniskelamin  == 'Perempuan')? "<i class='fa fa-check'></i>": ""); ?></td>
                          <td><?php echo $rwyt_kehamilan->persalinan_cara ?></td>
                          <td><?php echo $rwyt_kehamilan->persalinan_penolong ?></td>
                          <td><?php echo $rwyt_kehamilan->persalinan_tempat ?></td>
                          <td><?php echo (($rwyt_kehamilan->isabortur  == true)? "<i class='fa fa-check'></i>": ""); ?></td>
                          <td><?php echo (($rwyt_kehamilan->isabortur  == false)? "<i class='fa fa-check'></i>": ""); ?></td>
                          <td><?php echo $rwyt_kehamilan->persalinan_komplikasiket ?></td>
                        </tr>
                        <?php
                      }
                    }
                 ?>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td class="padding5 borderclass">
            Riwayat Hamil Ini
          </td>
        </tr>
        <tr>
          <td class="padding5 borderclass">
            <table width="100%">
              <tr>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px" valign="top">Ante Natal Care</td>
                          <td width="5px" valign="top">:</td>
                          <td>
                            <span class="<?php echo ((!empty($model->obgyn_antenatalcare_status) && ($model->obgyn_antenatalcare_status =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                            <br/><span class="<?php echo ((!empty($model->obgyn_antenatalcare_status) && ($model->obgyn_antenatalcare_status =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                            <br/><span style="padding-left: 17px"></span> Di :
                            <span style="padding-left: 5px" class="<?php echo ((!empty($model->obgyn_antenatalcare_tempat) && ($model->obgyn_antenatalcare_tempat =='Dokter Kandungan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Dokter Kandungan
                            <br/><span style="padding-left: 47px" class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Dokter Umum'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Dokter Umum
                            <br/><span style="padding-left: 47px" class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Bidan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bidan
                            <br/><span style="padding-left: 47px" class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Lainnya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya
                            , <?php echo $model->obgyn_antenatalcare_tempatlainnya; ?>
                            <br/><span style="padding-left: 15px"></span> Frekuensi :
                            <span style="padding-left: 5px" class="<?php echo ((!empty($model->obgyn_antenatalcare_frekuensi) && ($model->obgyn_antenatalcare_frekuensi =='1x'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 1x
                            <span style="padding-left: 5px" class="<?php echo ((!empty($model->obgyn_antenatalcare_frekuensi) && ($model->obgyn_antenatalcare_frekuensi =='2x'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 2x
                            <span style="padding-left: 5px" class="<?php echo ((!empty($model->obgyn_antenatalcare_frekuensi) && ($model->obgyn_antenatalcare_frekuensi =='3x'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 3x
                            <span style="padding-left: 5px" class="<?php echo ((!empty($model->obgyn_antenatalcare_frekuensi) && ($model->obgyn_antenatalcare_frekuensi =='> 3x'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> > 3x
                          </td>
                      </tr>
                      <tr>
                          <td valign="top">Imunisasi TT</td>
                          <td valign="top">:</td>
                          <td>
                            <span class="<?php echo ((!empty($model->obgyn_imunisasittstatus) && ($model->obgyn_imunisasittstatus =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                            <br/><span class="<?php echo ((!empty($model->obgyn_imunisasittstatus) && ($model->obgyn_imunisasittstatus =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                            , Jelaskan : <?php echo $model->obgyn_imunisasittket; ?>
                          </td>
                      </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px" valign="top">Keluhan saat hamil</td>
                          <td width="5px" valign="top">:</td>
                          <td>
                            <?php
                            $look_keluhansaathamil = array(0=>'Mual',1=>'Muntah',2=>'Pendarahaan',3=>'Sakit Kepala',4=>'Lainnya');
                              $html_keluhanhamil = "";
                              foreach($look_keluhansaathamil as $i => $look){
                                $ischeck = false;
                                if($i > 0){
                                  $html_keluhanhamil .= "<br/>";
                                }

                                if(!empty($model->obgyn_keluhansaathamil)){
                                  $arrkeluhansaathamil = json_decode($model->obgyn_keluhansaathamil);

                                  if(!empty($arrkeluhansaathamil)){
                                    foreach($arrkeluhansaathamil as $orikeluhan){
                                      if($orikeluhan == $look){
                                        $ischeck = true;
                                      }
                                    }
                                  }
                                }

                                $html_keluhanhamil .= "<span class='".(($ischeck ==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look;
                                if($look == 'Lainnya'){
                                    $html_keluhanhamil .= ', '.$model->obgyn_keluhansaathamillainnya;
                                }
                              }
                              echo $html_keluhanhamil;
                             ?>
                             <br/> Jelaskan : <?php echo $model->obgyn_penjelasankeluhan; ?>
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
