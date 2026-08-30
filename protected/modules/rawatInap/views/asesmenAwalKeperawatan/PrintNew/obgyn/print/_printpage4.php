<table width="100%">
  <tr>
    <td colspan="2" class="textbold padding5 borderclass">
      Pemeriksaan Fisik (Body System)
    </td>
  </tr>
  <tr>
    <td width="50%" class="textbold padding5 borderclass">
      B1 (Breathing)/ Pernapasan
    </td>
    <td width="50%" class="textbold padding5 borderclass">
      B2 (Blood) Cardiovasculer
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      <table width="100%" class="tablefont">
          <tr>
              <td width="150px">RR</td>
              <td width="10px">:</td>
              <td><?php echo $model->b1_rr; ?> x/menit</td>
          </tr>
          <tr>
              <td>Irama</td>
              <td>:</td>
              <td>
                <span class="<?php echo ((!empty($model->b1_iramapernapasan) && ($model->b1_iramapernapasan =='Teratur'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Teratur
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b1_iramapernapasan) && ($model->b1_iramapernapasan =='Tidak Teratur'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Teratur
              </td>
          </tr>
          <tr>
              <td>Jenis</td>
              <td>:</td>
              <td>
                <?php
                     $lookupJenisPernapasan = array(0=>'Dispenia',1=>'Cheyne Stoke',2=>'Kusmaul',3=>'Lain-Lain');

                     if(count((array)$lookupJenisPernapasan) > 0){
                       $htmlJenisP = "";
                       foreach($lookupJenisPernapasan as $i => $look_jenis){
                         $isJenis = false;
                         $styleJenis = "";

                         if($i > 0){
                           $styleJenis = "style='padding-left: 5px'";
                         }

                         if(count((array)$model->b1_jenispernapasan) > 0){
                           $arrOriJenisPernapasan = json_decode($model->b1_jenispernapasan);
                           foreach ($arrOriJenisPernapasan as $oriPernapasan) {
                             if($oriPernapasan == $look_jenis){
                               $isJenis = true;
                             }
                           }
                         }

                         if($look_jenis == 'Lain-Lain'){
                           $htmlJenisP .= "<span ".$styleJenis." class='".(($isJenis==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_jenis;
                           $htmlJenisP .= ", ".$model->b1jenispernapasan_lainnya;
                         }else{
                           $htmlJenisP .= "<span ".$styleJenis." class='".(($isJenis==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_jenis;
                         }

                       }
                       echo $htmlJenisP;
                     }
                 ?>
              </td>
          </tr>
          <tr>
              <td>Pola</td>
              <td>:</td>
              <td>
                <?php
                     $lookupPola = array(0=>'Cuping hidung',1=>'Thorakal',2=>'Abdominal');

                     if(count((array)$lookupPola) > 0){
                       $htmlPola = "";
                       foreach($lookupPola as $i => $look_pola){
                         $isPola = false;
                         $styleJenis = "";
                         if($i > 0){
                           $styleJenis = "style='padding-left: 5px'";
                         }

                         if(count((array)$model->b1_polapernapasan) > 0){
                           $arrOriPola = json_decode($model->b1_polapernapasan);
                           foreach ($arrOriPola as $oriPola) {
                             if($oriPola == $look_pola){
                               $isPola = true;
                             }
                           }
                         }

                         $htmlPola .= "<span ".$styleJenis." class='".(($isPola==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_pola;
                       }
                       echo $htmlPola;
                     }
                 ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Suaran Nafas</td>
              <td valign="top">:</td>
              <td>
                <?php
                     $lookupSuaraNafas = array(0=>'Bronchial',1=>'Sesak',2=>'Vesikuler',3=>'Batuk',4=>'Wheezing',5=>'Sputum',6=>'Ronchi');

                     if(count((array)$lookupSuaraNafas) > 0){
                       $htmlSuaraNafas = "";
                       $indexSuara = 0;
                       foreach($lookupSuaraNafas as $i => $look_suaranafas){
                         $isSuara = false;
                         $styleJenis = "";

                         if($i > 0){
                           $styleJenis = "style='padding-left: 5px'";
                         }

                         if($indexSuara == 4){
                           $htmlSuaraNafas .= "<br/>";
                           $indexSuara = 0;
                           $styleJenis = "";
                         }
                         $indexSuara++;
                         if(count((array)$model->b1_suaranafas) > 0){
                           $arrOriSuaraNafas = json_decode($model->b1_suaranafas);
                           foreach ($arrOriSuaraNafas as $oriSuaraNafas) {
                             if($oriSuaraNafas == $look_suaranafas){
                               $isSuara = true;
                             }
                           }
                         }

                        $htmlSuaraNafas .= "<span ".$styleJenis." class='".(($isSuara==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_suaranafas;
                       }
                       echo $htmlSuaraNafas;
                     }
                 ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Kesulitan Bernafas</td>
              <td valign="top">:</td>
              <td>
                <span class="<?php echo ((!empty($model->b1_kesulitanbernafas ) && ($model->b1_kesulitanbernafas =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                <br/>
                <span class="<?php echo ((!empty($model->b1_kesulitanbernafas ) && ($model->b1_kesulitanbernafas =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya, Memakai O2 : <?php echo $model->b1_jmloksigenperliter; ?> liter/menit
                <br/>
                <span style="padding-left: 20px">Dengan<span>
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b1_jenisterapioksigen ) && ($model->b1_jenisterapioksigen =='Nasal Kanul'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Nasal Kanul
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b1_jenisterapioksigen ) && ($model->b1_jenisterapioksigen =='Sangkup'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sangkup
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b1_jenisterapioksigen ) && ($model->b1_jenisterapioksigen =='Re-Breathin'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Re-Breathin
              </td>
          </tr>
          <tr>
              <td valign="top">Keluhan Lain</td>
              <td valign="top">:</td>
              <td>
                <?php echo $model->b1_keluhanlain; ?>
              </td>
          </tr>
      </table>
    </td>
    <td class="padding5 borderclass">
      <table width="100%" class="tablefont">
          <tr>
              <td width="150px">Tensi</td>
              <td width="10px">:</td>
              <td><?php echo $model->b2_td_systolic.'/'.$model->b2_td_diastolic; ?> mmHg</td>
          </tr>
          <tr>
              <td>Nadi</td>
              <td>:</td>
              <td><?php echo $model->b2_nadi; ?> x/menit</td>
          </tr>
          <tr>
              <td>Irama Jantung</td>
              <td>:</td>
              <td>
                <span class="<?php echo ((!empty($model->b2_denyutjantung ) && ($model->b2_denyutjantung =='Reguler'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Reguler
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b2_denyutjantung ) && ($model->b2_denyutjantung =='Ireguler'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ireguler
              </td>
          </tr>
          <tr>
              <td>Akral</td>
              <td>:</td>
              <td>
                <span class="<?php echo ((!empty($model->b2_akral) && ($model->b2_akral =='Hangat'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hangat
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b2_akral) && ($model->b2_akral =='Dingin'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Dingin
              </td>
          </tr>
          <tr>
              <td>CRT</td>
              <td>:</td>
              <td>
                <span class="<?php echo ((!empty($model->b2_crt) && ($model->b2_crt =='< 3 Detik'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> < 3 Detik
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b2_crt) && ($model->b2_crt =='> 3 Detik'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> > 3 Detik
              </td>
          </tr>
          <tr>
              <td>Nyeri Dada</td>
              <td>:</td>
              <td>
                <span class="<?php echo ((!empty($model->b2_isnyerdada) && ($model->b2_isnyerdada =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b2_isnyerdada) && ($model->b2_isnyerdada =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
              </td>
          </tr>
          <tr>
              <td valign="top">Oedem</td>
              <td valign="top">:</td>
              <td>
                <span class="<?php echo ((!empty($model->b2_isoedem) && ($model->b2_isoedem =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b2_isoedem) && ($model->b2_isoedem =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak, pada : <?php echo $model->b2_lokasioedem; ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Pendaharan</td>
              <td valign="top">:</td>
              <td>
                <span class="<?php echo (($model->b2_ispendarahan ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                <span style="padding-left: 5px" class="<?php echo (($model->b2_ispendarahan ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
              </td>
          </tr>
          <tr>
              <td valign="top">Keluhan Lain</td>
              <td valign="top">:</td>
              <td>
                <?php echo $model->b2_keluhanlain; ?>
              </td>
          </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="50%" class="textbold padding5 borderclass">
      B3 (Brain)/ Persarafan
    </td>
    <td width="50%" class="textbold padding5 borderclass">
      B4 (Bleader) Perkemihan/ Eliminasi Urin
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      <table width="100%" class="tablefont">
          <tr>
              <td width="150px">Kesadaran</td>
              <td width="10px">:</td>
              <td>
                <?php
                     $lookupKesadaran = array(0=>'Compos Mentis',1=>'Delirium',2=>'Somnolen',3=>'Sopor',4=>'Koma');

                     if(count((array)$lookupKesadaran) > 0){
                       $htmlKesadaran = "";
                       foreach($lookupKesadaran as $i => $look_kesadaran){
                         $isKesadaran = false;
                         $styleJenis = "";

                         if($i > 0){
                           $styleJenis = "style='padding-left: 5px'";
                         }

                         if(!empty($model->b3_kesadaran)){
                           if($model->b3_kesadaran == $look_kesadaran){
                             $isKesadaran = true;
                           }
                         }

                        $htmlKesadaran .= "<span ".$styleJenis." class='".(($isKesadaran==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_kesadaran;
                       }
                       echo $htmlKesadaran;
                     }
                 ?>
              </td>
          </tr>
          <tr>
              <td>GCS</td>
              <td>:</td>
              <td>E : <?php echo $model->b3_gcseye_nilai; ?> V : <?php echo $model->b3_gcsverbal_nilai; ?> M : <?php echo $model->b3_gcsmotoric_nilai; ?></td>
          </tr>
          <tr>
              <td valign="top">Reflek Cahaya</td>
              <td valign="top">:</td>
              <td>
                <span class="<?php echo ((!empty($model->b3_kesimetrisanpupil) && ($model->b3_kesimetrisanpupil =='Isokor'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Isokor
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b3_kesimetrisanpupil) && ($model->b3_kesimetrisanpupil =='Anisokor'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Anisokor
                <br/>
                Kanan :
                <span class="<?php echo ((!empty($model->b3_ukuranreflek_pupilkanan) && ($model->b3_ukuranreflek_pupilkanan =='< 3 mm'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> < 3 mm
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b3_ukuranreflek_pupilkanan) && ($model->b3_ukuranreflek_pupilkanan =='> 3 mm'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> > 3 mm
                <br/>
                Kiri :
                <span class="<?php echo ((!empty($model->b3_ukuranreflek_pupilkiri) && ($model->b3_ukuranreflek_pupilkiri =='< 3 mm'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> < 3 mm
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b3_ukuranreflek_pupilkiri) && ($model->b3_ukuranreflek_pupilkiri =='> 3 mm'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> > 3 mm
              </td>
          </tr>
          <tr>
              <td>Paresa</td>
              <td>:</td>
              <td>
                <?php echo $model->b3_paresa; ?>
              </td>
          </tr>
          <tr>
              <td>Kejang</td>
              <td>:</td>
              <td>
                <?php
                     $lookupKejang = array(0=>'Klonik',1=>'Umum',2=>'Tonik',3=>'Twiching',4=>'Koma');

                     if(count((array)$lookupKejang) > 0){
                       $htmlKejang = "";
                       foreach($lookupKejang as $i => $look_kejang){
                         $isKejang = false;
                         $styleJenis = "";

                         if($i > 0){
                           $styleJenis = "style='padding-left: 5px'";
                         }
                         if(count((array)$model->b3_kejang) > 0){
                           $arrOriKejang = json_decode($model->b3_kejang);
                           foreach ($arrOriKejang as $oriKejang) {
                             if($oriKejang == $look_kejang){
                               $isKejang = true;
                             }
                           }
                         }

                         $htmlKejang .= "<span ".$styleJenis." class='".(($isKejang==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_kejang;
                       }
                       echo $htmlKejang;
                     }
                 ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Keluhan Lain</td>
              <td valign="top">:</td>
              <td>
                <?php echo $model->b3_keluhanlain; ?>
              </td>
          </tr>
      </table>
    </td>
    <td class="padding5 borderclass" valign="top">
      <table width="100%" class="tablefont">
          <tr>
              <td width="150px">BAK</td>
              <td width="10px">:</td>
              <td>
                <?php echo $model->b4_bakfrekuensi; ?> Kali/hr
              </td>
          </tr>
          <tr>
              <td>Warna</td>
              <td>:</td>
              <td><?php echo $model->b4_bakwarnaurin; ?></td>
          </tr>
          <tr>
              <td>Nyeri Tekan Kandung Kemih</td>
              <td>:</td>
              <td>
                <span class="<?php echo ((!empty($model->b4_isnyeritekankandungkemih) && ($model->b4_isnyeritekankandungkemih =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b4_isnyeritekankandungkemih) && ($model->b4_isnyeritekankandungkemih =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
              </td>
          </tr>
          <tr>
              <td>Gangguan</td>
              <td>:</td>
              <td>
                <?php
                     $lookupGangguan = array(0=>'Anuri',1=>'Oliguria',2=>'Gross Hematuria');

                     if(count((array)$lookupGangguan) > 0){
                       $htmlGanguan = "";
                       foreach($lookupGangguan as $i => $look_gangguan){
                         $isGangguan = false;
                         $styleJenis = "";

                         if($i > 0){
                           $styleJenis = "style='padding-left: 5px'";
                         }

                         if(count((array)$model->b4_gangguan) > 0){
                           $arrOriGangguan = json_decode($model->b4_gangguan);
                           foreach ($arrOriGangguan as $oriGangguan) {
                             if($oriGangguan == $look_gangguan){
                               $isGangguan = true;
                             }
                           }
                         }

                         $htmlGanguan .= "<span ".$styleJenis." class='".(($isGangguan==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_gangguan;
                       }
                       echo $htmlGanguan;
                     }
                 ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Keluhan Lain</td>
              <td valign="top">:</td>
              <td>
                <?php echo $model->b4_keluhanlain; ?>
              </td>
          </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="50%" class="textbold padding5 borderclass">
      B5 (Bowel) Pencernaan/ Eliminasi Alvi
    </td>
    <td width="50%" class="textbold padding5 borderclass">
      B6 (Bonel) Tulang, Otot dan Integumen
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass" valign="top">
      <table width="100%" class="tablefont">
          <tr>
              <td width="150px">Nafsu Makan</td>
              <td width="10px">:</td>
              <td>
                <span class="<?php echo ((!empty($model->b5_statusnafasumakan) && ($model->b5_statusnafasumakan =='Baik'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Baik
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b5_statusnafasumakan) && ($model->b5_statusnafasumakan =='Menurun'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Menurun
              </td>
          </tr>
          <tr>
              <td>Mukosa</td>
              <td>:</td>
              <td>
                <span class="<?php echo ((!empty($model->b5_mukosamulut) && ($model->b5_mukosamulut =='Lembab'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lembab
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b5_mukosamulut) && ($model->b5_mukosamulut =='Kering'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kering
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b5_mukosamulut) && ($model->b5_mukosamulut =='Stomatitis'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Stomatitis
              </td>
          </tr>
          <tr>
              <td valign="top">Abdomen</td>
              <td valign="top">:</td>
              <td>
                <span class="<?php echo ((!empty($model->b5_abdomen_kesimetrisan) && ($model->b5_abdomen_kesimetrisan =='Simetris'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Simetris
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b5_abdomen_kesimetrisan) && ($model->b5_abdomen_kesimetrisan =='Asimetris'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Asimetris
                <br/>
                <span class="<?php echo (($model->b5_abdomen_istegang ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tegang
                <span style="padding-left: 5px" class="<?php echo (($model->b5_abdomen_isascites ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ascites
                <span style="padding-left: 5px" class="<?php echo (($model->b5_abdomen_isnyeritekan ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Nyeri Tekan, Lokasi : <?php echo $model->b5_abdomen_nyeritekanlokasi; ?>
              </td>
          </tr>
          <tr>
              <td>BAB</td>
              <td>:</td>
              <td>
                <?php echo $model->b5_babfrekuensi; ?> kali/ hari
              </td>
          </tr>
          <tr>
              <td>Warna</td>
              <td>:</td>
              <td>
                <?php echo $model->b5_warnafeces; ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Keluhan Lain</td>
              <td valign="top">:</td>
              <td>
                <?php echo $model->b5_keluhanlain; ?>
              </td>
          </tr>
      </table>
    </td>
    <td class="padding5 borderclass" valign="top">
      <table width="100%" class="tablefont">
          <tr>
              <td width="150px">Suhu Tubuh</td>
              <td width="10px">:</td>
              <td>
                <?php echo $model->b6_suhutubuh; ?> &#176; C
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b6_caraukursuhutubuh) && ($model->b6_caraukursuhutubuh =='Axilla'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Axilla
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b6_caraukursuhutubuh) && ($model->b6_caraukursuhutubuh =='Rektal'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Rektal
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b6_caraukursuhutubuh) && ($model->b6_caraukursuhutubuh =='Oral'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Oral
              </td>
          </tr>
          <tr>
              <td valign="top">Pergerakan</td>
              <td valign="top">:</td>
              <td>
                <span class="<?php echo ((!empty($model->b6_isfraktur) && ($model->b6_isfraktur =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b6_isfraktur) && ($model->b6_isfraktur =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                <br/>
                Fraktura :
                <span class="<?php echo ((!empty($model->b6_jenisfraktur) && ($model->b6_jenisfraktur =='Terbuka'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Terbuka
                <span style="padding-left: 5px" class="<?php echo ((!empty($model->b6_jenisfraktur) && ($model->b6_jenisfraktur =='Tertutup'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tertutup
                <br/>
                <span style="padding-left: 20px"></span>Pada : <?php echo $model->b6_lokasifraktur ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Warna Kulit</td>
              <td valign="top">:</td>
              <td>
                <?php
                     $lookupWarnaKulit = LookupM::model()->findAll("lookup_type = 'asesmen_warnakulit' order by lookup_urutan ASC");

                     if(count((array)$lookupWarnaKulit) > 0){
                       $htmlWarnaKulit = "";
                       $indexWarnaKulit = 0;
                       foreach($lookupWarnaKulit as $i => $look_warnakulit){
                         $isWarnaKulit = false;
                         $styleJenis = "";

                         if($i > 0){
                           $styleJenis = "style='padding-left: 5px'";
                         }

                         if($indexWarnaKulit == 3){
                           $htmlWarnaKulit .= "<br/>";
                           $indexWarnaKulit = 0;
                           $styleJenis = "";
                         }
                         $indexWarnaKulit++;
                         if(count((array)$model->b6_warnakulit) > 0){
                           $arrOriWarnaKulit = json_decode($model->b6_warnakulit);
                           foreach ($arrOriWarnaKulit as $oriWarnaKulit) {
                             if($oriWarnaKulit == $look_warnakulit->lookup_value){
                               $isWarnaKulit = true;
                             }
                           }
                         }

                         $htmlWarnaKulit .= "<span ".$styleJenis." class='".(($isWarnaKulit==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_warnakulit->lookup_value;
                       }
                       echo $htmlWarnaKulit;
                     }
                 ?>
              </td>
          </tr>
          <tr>
              <td>Otot</td>
              <td>:</td>
              <td>
                <?php
                     $lookupOtot = array(0=>'Artopi',1=>'Hipertropi',2=>'Kontraktur');

                     if(count((array)$lookupOtot) > 0){
                       $htmlOtot = "";
                       foreach($lookupOtot as $i => $look_otot){
                         $isOtot = false;
                         $styleJenis = "";

                         if($i > 0){
                           $styleJenis = "style='padding-left: 5px'";
                         }

                         if(count((array)$model->b6_otot) > 0){
                           $arrOriOtot = json_decode($model->b6_otot);
                           foreach ($arrOriOtot as $oriOtot) {
                             if($oriOtot == $look_otot){
                               $isOtot = true;
                             }
                           }
                         }

                         $htmlOtot .= "<span ".$styleJenis." class='".(($isOtot==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_otot;
                       }
                       echo $htmlOtot;
                     }
                 ?>
              </td>
          </tr>
          <tr>
              <td>Turgor Kulit</td>
              <td>:</td>
              <td>
                <?php echo $model->b6_turgorkulit; ?>
              </td>
          </tr>
          <tr>
              <td>Oedem Pada</td>
              <td>:</td>
              <td>
                <?php echo $model->b6_lokasioedema; ?>
              </td>
          </tr>
          <tr>
              <td>Berkeringat banyak</td>
              <td>:</td>
              <td>
                <?php echo $model->b6_berkeringatbanyak; ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Resiko Dekubitus</td>
              <td valign="top">:</td>
              <td>
                <span style="padding-left: 5px" class="<?php echo (($model->b6_isresikodekubitus ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                <span style="padding-left: 5px" class="<?php echo (($model->b6_isresikodekubitus ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                <br/>
                (pengisian form pengkajian risiko dekubitus) braden score: <?php echo $model->b6_skorbraden; ?>
              </td>
          </tr>
          <tr>
              <td>Luka</td>
              <td>:</td>
              <td>
                <span style="padding-left: 5px" class="<?php echo (($model->b6_isluka ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                <span style="padding-left: 5px" class="<?php echo (($model->b6_isluka ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya, Lokasi : <?php echo $model->b6_lokasiluka; ?>
              </td>
          </tr>
          <tr>
              <td valign="top">Keluhan Lain</td>
              <td valign="top">:</td>
              <td>
                <?php echo $model->b6_keluhanlain; ?>
              </td>
          </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="textbold padding5 borderclass bordernonetopclass" colspan="2">
      Psikososial Spiritual
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass" colspan="2">
      <table width="100%">
        <tr>
          <td width="50%" valign='top'>
            <table width="100%" class="tablefont">
                <tr>
                    <td width="150px">Taat Beribadah</td>
                    <td width="10px">:</td>
                    <td>
                      <span style="padding-left: 5px" class="<?php echo (($model->istaatberibadah ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                      <span style="padding-left: 5px" class="<?php echo (($model->istaatberibadah ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                    </td>
                </tr>
                <tr>
                    <td>Orang Terdekat</td>
                    <td>:</td>
                    <td>
                      <?php echo $model->orangterdekat; ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Perasaan saat ini</td>
                    <td valign="top">:</td>
                    <td>
                      <span class="<?php echo ((!empty($model->perasaansaatini) && ($model->perasaansaatini =='Cemas'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Cemas
                      <span style="padding-left: 5px" class="<?php echo ((!empty($model->perasaansaatini) && ($model->perasaansaatini =='Tenang'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tenang
                    </td>
                </tr>
            </table>
          </td>
          <td width="50%" valign='top'>
            <table width="100%" class="tablefont">
                <tr>
                    <td width="150px" valign="top">Gangguan Orientasi terhadap</td>
                    <td width="5px" valign="top">:</td>
                    <td>
                      <?php echo $model->gangguanorientasi_terhadap; ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Keluhan Lain</td>
                    <td valign="top">:</td>
                    <td>
                      <?php echo $model->psikososialspriritual_keluhanlain; ?>
                    </td>
                </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass" colspan="2">
      Verifikasi Pasien : Tgl <span style="padding-left: 150px"></span> Jam
    </td>
  </tr>
  <tr>
    <td colspan="2" class="padding5 borderclass">
      <table width="100%" class="tablefont">
        <tr>
            <td colspan="3">Dengan ini saya/keluarga menyatakan akan mengikuti aturan perawatan sesuai dengan rencana keperawatan yang berlaku,</td>
        </tr>
        <tr>
          <td width="35%" valign="top">
            <center>
              Tanda Tangan Pasien/Keluarga
              <br/><br/><br/><br/><br/>
              <?php echo $model->namapasien_verifikator; ?>
            </center>
          </td>
          <td width="30%" valign="top">
            <center>
              Tanda Tangan Perawat/Bidan
              <br/><br/><br/><br/><br/>
              <?php echo $model->paramedis_nama; ?>
            </center>
          </td>
          <td width="35%" valign="top">
            <center>
              Tanda Tangan Kepala Ruangan
              <br/><br/><br/><br/><br/>
              <?php
              $pegawaiRuangan = PegawairuanganV::model()->findByAttributes(array('ruangan_id'=>$modPasienAdmisi->ruangan_id, 'jabatan_id'=>39)); //Jabatan_id = Kepala Ruangan (39)
              echo (isset($pegawaiRuangan)?$pegawaiRuangan->namaLengkap:""); ?>
            </center>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
