<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style type="text/css">
.tablefont td{
        color: black;
        padding: 5px;
    }
    .borderclass {
        border: 1px solid black;
    }
    .fa{
        font-size: 11pt;
    }
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }
    .textcenter{
      text-align: center !important;
    }
    .textbold{
      font-weight: bold;
    }
</style>
<?php
  $hidden = false;

  if($model->jenisasesmen == 'asesmen_dewasa'){
    $hidden = true;
  }

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
<div style="text-align: right; font-weight: bold; color: black">
  FRM/73.12 Rev.01/RSBM
</div>
<br/>
<div class="pageDetail" id="pageDetail_1">
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Data Awal</strong></div>
     </div>
      <div class="panel-body">
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
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>INFORMASI PENGKAJIAN</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td width="50%">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px">Tanggal Pengkajian</td>
                          <td width="10px">:</td>
                          <td><?php echo date('d', strtotime($model->tgl_assesmen_awal)).' '.MyFormatter::getMonthId(date('m', strtotime($model->tgl_assesmen_awal))).' '.date('Y', strtotime($model->tgl_assesmen_awal)); ?></td>
                      </tr>
                      <tr>
                          <td width="200px">Jam Masuk Ruangan</td>
                          <td width="10px">:</td>
                          <td><?php echo $model->jam_masukruangan; ?> WIB</td>
                      </tr>
                      <tr>
                          <td width="200px">Perawat Pengkajian</td>
                          <td width="10px">:</td>
                          <td><?php echo $model->paramedis_nama; ?></td>
                      </tr>
                    </table>
                  </td>
                  <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px">Nama Pasien/ Keluarga Verifikator</td>
                          <td width="10px">:</td>
                          <td><?php echo $model->namapasien_verifikator; ?></td>
                      </tr>
                      <tr>
                          <td>Dokter Pemeriksa</td>
                          <td>:</td>
                          <td> <?php echo $model->dokterpemeriksa->namaLengkap; ?></td>
                      </tr>
                    </table>
                  </td>
              </tr>
          </table>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>KEADAAN UMUM</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td width="50%">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td valign="top" width="200px">Kesadaran</td>
                              <td valign="top" width="10px">:</td>
                              <td>
                                  <table width="100%" class="tablefont">
                                      <tr>
                                          <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Compos Mentis'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Compos Mentis</td>
                                      </tr>
                                      <tr>
                                          <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Delirium'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Delirium</td>
                                      </tr>
                                      <tr>
                                          <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Somnolen'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Somnolen</td>
                                      </tr>
                                      <tr>
                                          <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Sopor'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sopor</td>
                                      </tr>
                                      <tr>
                                          <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Koma'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Koma</td>
                                      </tr>
                                  </table>
                              </td>
                          </tr>
                          <tr>
                              <td>Tekanan Darah</td>
                              <td>:</td>
                              <td><?php echo $model->tekanandarah; ?> mmHg</td>
                          </tr>
                          <tr>
                              <td>Nadi</td>
                              <td>:</td>
                              <td><?php echo $model->detaknadi; ?> /Menit</td>
                          </tr>
                          <tr>
                              <td>Suhu</td>
                              <td>:</td>
                              <td><?php echo (!empty($model->suhutubuh)?number_format($model->suhutubuh,2):"-"); ?> &#176; Celcius</td>
                          </tr>
                          <tr>
                              <td>Pernapasan</td>
                              <td>:</td>
                              <td>
                                  <?php echo (!empty($model->pernapasan)?number_format($model->pernapasan,2):"-"); ?> /Menit
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
                              <td><?php echo $model->bb_ideal; ?> Kg/m</td>
                          </tr>
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="200px">Kelainan pada Bag. Tubuh</td>
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
                                          <td colspan="2"><span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada &nbsp; &nbsp;
                                          <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada &nbsp; &nbsp;
                                          <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Tidak Tahu'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Tahu</td>
                                      </tr>
                                      <tr>
                                          <td colspan="2">Bila Ada: </td>
                                      </tr>
                                      <tr>
                                          <td width="150px">Riwayat Alergi Obat</td>
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
                                  </table>
                              </td>
                          </tr>
                      </table>
                  </td>
              </tr>
          </table>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>PENILAIAN NYERI</strong></div>
     </div>
      <div class="panel-body">
        <div class="panel panel-success panel-shadow">
          <div class="panel-heading">
              <div class="panel-title">Penilaian Nyeri</div>
          </div>
           <div class="panel-body">
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
           </div>
       </div>
       <div class="panel panel-success panel-shadow">
         <div class="panel-heading">
             <div class="panel-title">Deskripsi Nyeri</div>
         </div>
          <div class="panel-body">
            <table width="100%">
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

                                   if(count($lookupKualitas) >0 ){
                                     $htmlKualitas = "";

                                     foreach($lookupKualitas as $i => $look_risiko){
                                       $isKualitas = false;
                                       if($i > 0){
                                         $htmlKualitas .= "<br/>";
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
                                    $htmlFrekuensi .= "<span class='".(($isFrekuensi==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                                    $htmlFrekuensi .= ", ".$model->deskripsinyeri_frekuensinyerilainnya;
                                  }else{
                                    $htmlFrekuensi .= "<span class='".(($isFrekuensi==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
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
            </table>
          </div>
      </div>

          <?php if($model->is_keluhannyeri_dewasa==true){ ?>
          <div class="panel panel-success panel_nyeri" id="nyeri_dewasa" >
                  <div class="panel-heading">
                      <div class="panel-title">Asesmen Nyeri Dewasa</div>
                  </div>
                  <div class="panel-body" >

                      <h2 style="text-align:center;">Intensitas "WONG BAKER FACE SCALE"</h2>
                      <br/>
                      <?php
                      echo $this->renderPartial($this->path_view.'_formAsesmenDewasaDetail', array(
                          'model' => $model
                              ), true);
                      ?>


                  </div>
              </div>
          <?php }else{ ?>
              <div class="panel panel-success panel_nyeri" id="nyeri_anak" >
                  <div class="panel-heading">
                      <div class="panel-title">Asesmen Nyeri Anak < 3 Tahun</div>
                  </div>
                  <div class="panel-body">

                      <?php

                      echo $this->renderPartial($this->path_view.'_formAsesmenAnakDetail', array(
                          'model' => $model,
                          'dataFlaCcs' => $dataFlaCcs,
                          'getFlaCcs' => $getFlaCcs,
                          'modNyeriAnakDet'=>$modSkrinningnyerianakdetT
                              ), true);
                      ?>


                  </div>
              </div>
          <?php } ?>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>PENILAIAN RESIKO JATUH</strong></div>
     </div>
      <div class="panel-body">
            <div class="panel panel-default panel-shadow">
               <div class="panel-heading">
                   <div class="panel-title"><strong>Skrinning Resiko Jatuh Dewasa (Morse Falls Scale)</strong></div>
               </div>
                <div class="panel-body">
                  <table class="items table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">No</th>
                            <th>Risiko</th>
                            <th style="width: 250px">Penilaian</th>
                            <th style="width: 50px">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Riwayat Jatuh, Apakah pasien pernah jatuh dalam 3 bulan terakhir</td>
                            <td>
                                <?php echo  $model->riwayatjatuh_penilaian; ?>
                            </td>
                            <td><?php echo $model->riwayatjatuh_skor; ?></td>
                        </tr>
                         <tr>
                            <td>2</td>
                            <td>Diagnosa Sekunder, Apakah pasien memiliki lebih dari satu penyakit?</td>
                            <td>
                                <?php echo  $model->diagnosismedis_penilaian; ?>
                            </td>
                            <td><?php echo $model->diagnosismedis_skor; ?></td>
                        </tr>
                         <tr>
                            <td>3</td>
                            <td>Alat Bantu Jalan</td>
                            <td>
                                <?php echo $model->alatbantujalan_penilaian; ?>
                            </td>
                            <td><?php echo $model->alatbantujalan_skor; ?></td>
                        </tr>
                         <tr>
                            <td>4</td>
                            <td>Terapi Intrevena, Apakah saat ini pasien terpasang infustd</td>
                            <td>
                                <?php echo  $model->memakaiterapiheparin_penilaian; ?>
                            </td>
                            <td><?php echo $model->memakaiterapiheparin_skor; ?></td>
                        </tr>
                         <tr>
                            <td>5</td>
                            <td>Cara Berjalan/ Berpindah</td>
                            <td>
                                <?php echo $model->caraberjalan_penilaian; ?>
                            </td>
                            <td><?php echo $model->caraberjalan_skor; ?></td>
                        </tr>
                         <tr>
                            <td>6</td>
                            <td>Status Mental</td>
                            <td>
                                <?php echo $model->statusmental_penilaian; ?>
                            </td>
                            <td><?php echo $model->statusmental_skor; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3">Total Skor</td>
                            <td> <?php echo $model->resikojatuh_skor; ?> </td>
                        </tr>
                        <tr>
                            <td colspan="2">Pasien termasuk kategori risiko jatuh : </td>
                            <td colspan="2"> <?php echo $model->resikojatuh_keterangan; ?> </td>
                        </tr>
                    </tbody>
                </table>
              </div>
          </div>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Kontrol Risiko Infeksi</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%" class="tablefont">
            <tr>
                <td width="100px">Status</td>
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
                  <td width="200px">Addtional Precaution yang harus dilakukan</td>
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
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>ANAMNESA</strong></div>
     </div>
      <div class="panel-body">
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
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>RIWAYAT MENSTRUASI & PERKAWINAN</strong></div>
     </div>
      <div class="panel-body">
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title">Riwayat Menstruasi</div>
           </div>
            <div class="panel-body">
              <table width="100%">
                  <tr>
                      <td width="50%">
                          <table width="100%" class="tablefont">
                              <tr>
                                  <td width="150px">Siklus Haid</td>
                                  <td width="5px">:</td>
                                  <td>
                                    <?php echo $model->obgyn_siklushaid; ?> Hari
                                  </td>
                              </tr>
                              <tr>
                                  <td>Menarche umur</td>
                                  <td>:</td>
                                  <td><?php echo $model->obgyn_menarcheumur; ?> Tahun</td>
                              </tr>
                              <tr>
                                  <td>Menstruasi Terakhir</td>
                                  <td>:</td>
                                  <td><?php echo (!empty($model->obgyn_mensterakhir)?MyFormatter::formatDateTimeForUser($model->obgyn_mensterakhir):""); ?></td>
                              </tr>
                              <tr>
                                  <td>Keluhan saat haid</td>
                                  <td>:</td>
                                  <td><?php echo $model->obgyn_keluhansaathaid; ?></td>
                              </tr>
                              <tr>
                                  <td>Banyaknya</td>
                                  <td>:</td>
                                  <td><?php echo $model->obgyn_banyaknyahaid; ?> ml</td>
                              </tr>
                          </table>
                      </td>
                      <td width="50%" valign="top">
                          <table width="100%" class="tablefont">
                            <tr>
                                <td width="150px">Haid Teratur</td>
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
                                <td><?php echo (!empty($model->obgyn_taksiranpersalinan)? MyFormatter::formatDateTimeForUser($model->obgyn_taksiranpersalinan): ""); ?></td>
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
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title">Riwayat Perkawinan</div>
           </div>
            <div class="panel-body">
              <table width="100%">
                  <tr>
                      <td width="50%">
                          <table width="100%" class="tablefont">
                              <tr>
                                  <td width="150px" valign="top">Status</td>
                                  <td width="5px" valign="top">:</td>
                                  <td>
                                    <span class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Belum Kawin'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Belum Kawin
                                    <br/>
                                    <span class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Cerai'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Cerai
                                    <br/>
                                    <span class="<?php echo ((!empty($model->obgyn_statuskawin) && ($model->obgyn_statuskawin =='Kawin'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kawin
                                    <br/>
                                    <span style="padding-left: 20px"></span> Jumlah : <?php echo $model->obgyn_jumlahperkawainan; ?> Kali
                                  </td>
                              </tr>
                          </table>
                      </td>
                      <td width="50%" valign="top">
                          <table width="100%" class="tablefont">
                            <tr>
                                <td width="150px">Umur waktu kawin pertama</td>
                                <td width="5px">:</td>
                                <td><?php echo $model->obgyn_umurkawinpertama; ?> Tahun</td>
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
            </div>
        </div>

      </div>
  </div>
</div>

<div class="pageDetail" id="pageDetail_2">
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>RIWAYAT KEHAMILAN</strong></div>
     </div>
      <div class="panel-body">
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title">Riwayat Kehamilan</div>
           </div>
            <div class="panel-body">
              <table class="items table table-bordered">
                <thead>
                  <tr>
                    <th class="textcenter" rowspan="2" width="80px">Hamil Ke-</th>
                    <th class="textcenter" rowspan="2">Umur Kehamilan<br/>(Minggu)</th>
                    <th class="textcenter" colspan="2">Sex</th>
                    <th class="textcenter" rowspan="2" width="100px">Cara Persalinan</th>
                    <th class="textcenter" rowspan="2" width="100px">Penolong Persalinan</th>
                    <th class="textcenter" rowspan="2">Tempat Persalinan</th>
                    <th class="textcenter" colspan="2">Abortus</th>
                    <th class="textcenter" rowspan="2">Komplikasi/ Keterangan</th>
                  </tr>
                  <tr>
                    <th class="textcenter" width="50px">L</th>
                    <th class="textcenter" width="50px">P</th>
                    <th class="textcenter" width="50px">Ya</th>
                    <th class="textcenter" width="50px">Tidak</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      $riwayatKehamilan = RiwayatobstetrikpasienT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id),array('order'=>'kehamilan_hamilke ASC'));

                      if(count($riwayatKehamilan) >0){
                        foreach ($riwayatKehamilan as $rwy) {
                        ?>
                        <tr>
                          <td><?php echo $rwy->kehamilan_hamilke; ?></td>
                          <td><?php echo $rwy->kehamilan_umur; ?></td>
                          <td class="textcenter"><span class="<?php echo ((!empty($rwy->anak_jeniskelamin) && ($rwy->anak_jeniskelamin=='Laki-laki'))?"fa fa-check":""); ?>"></span></td>
                          <td class="textcenter"><span class="<?php echo ((!empty($rwy->anak_jeniskelamin) && ($rwy->anak_jeniskelamin=='Perempuan'))?"fa fa-check":""); ?>"></span></td>
                          <td><?php echo $rwy->persalinan_cara; ?></td>
                          <td><?php echo $rwy->persalinan_penolong; ?></td>
                          <td><?php echo $rwy->persalinan_tempat; ?></td>
                          <td class="textcenter"><span class="<?php echo (($rwy->isabortur==true)?"fa fa-check":""); ?>"></span></td>
                          <td class="textcenter"><span class="<?php echo (($rwy->isabortur==false)?"fa fa-check":""); ?>"></span></td>
                          <td><?php echo $rwy->persalinan_komplikasiket; ?></td>
                        </tr>
                        <?php
                        }
                      }else{
                        ?>
                        <tr>
                          <td colspan="11">Data Tidak Ditemukan</td>
                        </tr>
                        <?php
                      }
                   ?>
                </tbody>
              </table>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title">Riwayat Hamil Ini</div>
           </div>
            <div class="panel-body">
              <table width="100%">
                  <tr>
                      <td width="50%">
                          <table width="100%" class="tablefont">
                              <tr>
                                  <td width="150px" valign="top">Ante Natal Care</td>
                                  <td width="5px" valign="top">:</td>
                                  <td>
                                    <span class="<?php echo ((!empty($model->obgyn_antenatalcare_status) && ($model->obgyn_antenatalcare_status =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                                    <br/>
                                    <span class="<?php echo ((!empty($model->obgyn_antenatalcare_status) && ($model->obgyn_antenatalcare_status =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                                  </td>
                              </tr>
                              <tr>
                                  <td></td>
                                  <td></td>
                                  <td>
                                    Di :
                                    <span style="padding-left: 4px" class="<?php echo ((!empty($model->obgyn_antenatalcare_tempat) && ($model->obgyn_antenatalcare_tempat =='Dokter Kandungan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Dokter Kandungan
                                    <br/>
                                    <span style="padding-left: 25px" class="<?php echo ((!empty($model->obgyn_antenatalcare_tempat) && ($model->obgyn_antenatalcare_tempat =='Dokter Umum'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Dokter Umum
                                    <br/>
                                    <span style="padding-left: 25px" class="<?php echo ((!empty($model->obgyn_antenatalcare_tempat) && ($model->obgyn_antenatalcare_tempat =='Dokter Bidan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Dokter Bidan
                                    <br/>
                                    <span style="padding-left: 25px" class="<?php echo ((!empty($model->obgyn_antenatalcare_tempat) && ($model->obgyn_antenatalcare_tempat =='Lainnya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya
                                    , <?php echo $model->obgyn_antenatalcare_tempatlainnya; ?>
                                    <br/>
                                    Frekuensi :
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
                                    <br/>
                                    <span class="<?php echo ((!empty($model->obgyn_imunisasittstatus) && ($model->obgyn_imunisasittstatus =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                                    , Jelaskan <?php echo $model->obgyn_imunisasittket; ?>
                                  </td>
                              </tr>
                          </table>
                      </td>
                      <td width="50%" valign="top">
                          <table width="100%" class="tablefont">
                            <tr>
                                <td width="150px" valign="top">Keluhan saat Hamil</td>
                                <td width="5px" valign="top">:</td>
                                <td>
                                  <?php
                                  $keluhanhaminlArr = array('Mual', 'Muntah','Pendarahan','Sakit Kepala','Lainnya');
                                  $htmlKeluhHamil = "";


                                  if(count($keluhanhaminlArr) > 0){
                                    foreach ($keluhanhaminlArr as $i => $hamil) {
                                      $isCheckHamil = false;

                                      if(!empty($modAsesmenawalkeperawatanT->obgyn_keluhansaathamil)){
                                        $arrOriKeluhanHamil = json_decode($modAsesmenawalkeperawatanT->obgyn_keluhansaathamil);

                                        if(count($arrOriKeluhanHamil) >0){
                                          foreach ($arrOriKeluhanHamil as $oriKeluhan) {
                                            if($oriKeluhan==$hamil){
                                              $isCheckHamil = true;
                                            }
                                          }
                                        }
                                      }

                                      if($i > 0){
                                          $htmlKeluhHamil .= "<br/>";
                                      }
                                      $htmlKeluhHamil .= "<span class='".(($isCheckHamil==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$hamil;
                                    }
                                  }
                                  echo $htmlKeluhHamil;
                                  //
                                   ?>
                                   , <?php echo $model->obgyn_keluhansaathamillainnya; ?>
                                   <br/>
                                   Jelaskan : <?php echo $model->obgyn_penjelasankeluhan; ?>
                                </td>
                            </tr>
                          </table>
                      </td>
                  </tr>
              </table>
            </div>
        </div>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>PSIKOLOGIS-SOSIAL-SPIRITUAL</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px">Status Pernikahan</td>
                            <td width="5px">:</td>
                            <td>
                              <?php echo $model->neonatus_kebsosialekonomi_statusperkawinan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Anak</td>
                            <td>:</td>
                            <td>
                              <span class="<?php echo ((!empty($model->isada_anak) && ($model->isada_anak =='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                              <span style="padding-left: 5px" class="<?php echo ((!empty($model->isada_anak) && ($model->isada_anak =='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                              , <?php echo $model->sumberdata_lainnya; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Pendidikan Terakhir</td>
                            <td>:</td>
                            <td><?php echo $model->neonatus_pendidikanortu; ?></td>
                        </tr>
                        <tr>
                            <td>Warga Negara</td>
                            <td>:</td>
                            <td><?php echo $model->neonatus_warganegaraortu; ?></td>
                        </tr>
                        <tr>
                            <td>Tinggal Bersama</td>
                            <td>:</td>
                            <td>
                              <?php echo $model->neonatus_tinggalbersama; ?>
                              <br/>
                              Nama Pihak Lainnya : <?php echo $model->neonatus_tinggalbersamalainnya_nama; ?>
                              <br/>
                              No. Telp Pihak Lainnya : <?php echo $model->neonatus_tinggalbersamalainnya_notlp; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding-left: 5px"><u>Kebiasaan</u></td>
                        </tr>
                        <tr>
                            <td>Status Merokok</td>
                            <td>:</td>
                            <td>
                              <?php echo $model->statusmerokok; ?>
                              <br/>
                              Jumlah Rokok Batangan : <?php echo $model->jmlrokok_btg_hr; ?> Per Hari
                            </td>
                        </tr>
                        <tr>
                            <td>Alkohol</td>
                            <td>:</td>
                            <td><?php echo $model->neonatus_kebiasaanortualkohol_status; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis & Jumlah Alkohol yang dikomsumsi</td>
                            <td>:</td>
                            <td><?php echo $model->neonatus_kebiasaanortualkohol_jenis.' / '.$model->neonatus_kebiasaanortualkohol_jml; ?> Gelas Per Hari</td>
                        </tr>
                        <tr>
                            <td>Kebisaan Lainnya</td>
                            <td>:</td>
                            <td><?php echo $model->neonatus_kebiasaanortulainnya; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="150px">Agama</td>
                          <td width="5px">:</td>
                          <td><?php echo $model->neonatus_agamaortu; ?></td>
                      </tr>
                      <tr>
                          <td>Masalah dalam berbicara</td>
                          <td>:</td>
                          <td>
                            <span class="<?php echo ((!empty($model->masalahdlm_berbicara) && ($model->masalahdlm_berbicara =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                            <br/>
                            <span class="<?php echo ((!empty($model->masalahdlm_berbicara) && ($model->masalahdlm_berbicara =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                            , Jelaskan : <?php echo $model->masalahbicara_ket; ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Bahasa sehari-hari</td>
                          <td>:</td>
                          <td>
                            <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->bahasaseharihari_jenis ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bahasa Indonesia
                            <br/>
                            <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->bahasaseharihari_jenis ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bahasa Daerah
                            <span style="padding-left: 20px"></span>Jenis Bahasa Daerah : <?php echo $modAsesmenkebutuhanEdukasiT->bahasadaerah_nama; ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Perlu Penerjemah</td>
                          <td>:</td>
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
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>EKONOMI</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
          <tr>
              <td width="50%">
                <table width="100%" class="tablefont">
                  <tr>
                      <td width="150px">Pekerjaan</td>
                      <td width="5px">:</td>
                      <td><?php echo $model->neonatus_pekerjaanortu; ?></td>
                  </tr>
                </table>
              </td>
              <td width="50%">
                <table width="100%" class="tablefont">
                  <tr>
                      <td width="150px">Pembiayaan Kesehatan</td>
                      <td width="5px">:</td>
                      <td><?php echo (isset($modPendaftaran->carabayar)? $modPendaftaran->carabayar->carabayar_nama:""); ?></td>
                  </tr>
                </table>
              </td>
            </tr>
        </table>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>KEBUTUHAN EDUKASI</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td width="50%">
                      <table width="100%" class="tablefont">
                        <tr>
                            <td valign="top" width="200px">Bicara</td>
                            <td valign="top" width="5px">:</td>
                            <td>
                              <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bicara_status) && ($modAsesmenkebutuhanEdukasiT->bicara_status=='Normal'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Normal
                              <span style="padding-left: 5px" class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bicara_status) && ($modAsesmenkebutuhanEdukasiT->bicara_status=='Serangan Awal Bicara'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Serangan Awal Bicara
                              <br/>
                              Kapan: <?php echo $modAsesmenkebutuhanEdukasiT->mulaiseranganawal; ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Hambatan Belajar</td>
                            <td valign="top">:</td>
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
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                        <tr>
                            <td valign="top" width="200px">Kajian budaya, nilai-nilai budaya atau kepercayaan khusus</td>
                            <td valign="top" width="5px">:</td>
                            <td>
                              <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->nilaikepercayaankhusus) && ($modAsesmenkebutuhanEdukasiT->nilaikepercayaankhusus=='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                              <br/>
                              <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->nilaikepercayaankhusus) && ($modAsesmenkebutuhanEdukasiT->nilaikepercayaankhusus=='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                              <br/>
                              <span style="padding-left: 20px"></span>Jelaskan : <?php echo $modAsesmenkebutuhanEdukasiT->nilaikepercayaankhususket; ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="200px">Pasien dan/ keluarga pasien bersediaan diberikan edukasi</td>
                            <td valign="top" width="5px">:</td>
                            <td>
                              <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->kesediaanmenerimaedukasi_status==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                              <br/>
                              <span style="padding-left: 20px"></span>Alasan tidak bersedia : <?php echo $modAsesmenkebutuhanEdukasiT->kesediaanmenerimaedukasi_alasantidak; ?>
                              <br/>
                              <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->kesediaanmenerimaedukasi_status==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                              <br/>
                              <span style="padding-left: 20px"></span>Pihak Pasien Edukasi
                              <br/>
                              <span style="padding-left: 20px" class="<?php echo (($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_pasien==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pasien
                              <br/>
                              <span style="padding-left: 20px" class="<?php echo (($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_keluargapasien==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga Pasien, <?php echo $modAsesmenkebutuhanEdukasiT->penerimaedukasi_namakeluargapasien; ?>
                              <br/>
                              <span style="padding-left: 20px" class="<?php echo (($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_lainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modAsesmenkebutuhanEdukasiT->penerimaedukasi_lainnyanama; ?>
                            </td>
                        </tr>

                        <tr>
                            <td valign="top" width="200px">Kebutuhan Edukasi</td>
                            <td valign="top" width="10px">:</td>
                            <td>
                                <table width="100%" class="tablefont">
                                    <?php
                                        $modLookupData = LookupM::model()->findAll("lookup_type = 'edukasipasien'");

                                        if(count($modLookupData)>0){

                                            foreach ($modLookupData as $i => $dataLook){
                                                    $html = "";
                                                    $ModAsseEdu = new AsesmenkebutuhanEdukasidetT();
                                                    if(is_array($modAsesmenkebutuhanEdukasidetT) && count($modAsesmenkebutuhanEdukasidetT)>0){
                            //                                $ModAsseEdu = new RDAsesmenkebutuhanEdukasidetT();
                                                        foreach ($modAsesmenkebutuhanEdukasidetT as $dataKebEduDet){
                                                            if($dataKebEduDet->edukasipasien == $dataLook->lookup_value){
                                                                $ModAsseEdu->isedukasipasien = true;
                                                                $ModAsseEdu->edukasipasien_lainnya = $dataKebEduDet->edukasipasien_lainnya;
                                                            }


                                                        }

                                                    }else{

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
              </tr>
          </table>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>SKRINING GIZI</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td width="50%" valign="top">
                    <table class="items table table-bordered" id="tblInputFungsional">
                        <thead>
                            <tr>
                                <th colspan="4" style="text-align: center">Skrining Gizi pada Dewasa <br /> Berdasarkan Metode Strong MST (usia > 18 th)</th>
                            </tr>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Parameter</th>
                                <th style="width: 100px">Nilai</th>
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
                            <td style="border-bottom: none; border-top: none;">
                                 <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 0
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none; border-top: none;"></td>
                            <td style="border-bottom: none; border-top: none;">Tidak tahu berapa kg penurunan</td>
                            <td style="border-bottom: none; border-top: none;">
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
                            <td style="border-bottom: none; border-top: none;">
                                <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Ada penurunan BB sebanyak 1-5 kg'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 1
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none; border-top: none;"></td>
                            <td style="border-bottom: none; border-top: none; padding-left: 10px"> Ada penurunan BB sebanyak 6 - 10 Kg</td>
                            <td style="border-bottom: none; border-top: none;">
                                <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Ada penurunan BB sebanyak 6-10 kg'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 2
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none; border-top: none;"></td>
                            <td style="border-bottom: none; border-top: none; padding-left: 10px">Ada penurunan BB sebanyak 11 - 15 Kg</td>
                            <td style="border-bottom: none; border-top: none;">
                                <span class="<?php echo ((!empty($model->skrinninggizi_jwb_penurunanbb_dewasa) && ($model->skrinninggizi_jwb_penurunanbb_dewasa=='Ada penurunan BB sebanyak 11-15 kg'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 3
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none; border-top: none;"></td>
                            <td style="border-bottom: none; border-top: none; padding-left: 10px">Ada penurunan BB sebanyak > 15 Kg</td>
                            <td style="border-bottom: none; border-top: none;">
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
                            <td style="border-bottom: none; border-top: none;">
                                <span class="<?php echo ((!empty($model->skrinninggizi_jwb_asupanmakanan_dewasa) && ($model->skrinninggizi_jwb_asupanmakanan_dewasa=='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 1
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none; border-top: none;"></td>
                            <td style="border-bottom: none; border-top: none;">Tidak</td>
                            <td style="border-bottom: none; border-top: none;">
                                <span class="<?php echo ((!empty($model->skrinninggizi_jwb_asupanmakanan_dewasa) && ($model->skrinninggizi_jwb_asupanmakanan_dewasa=='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> 0
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">Total Skor</td>
                            <td> <?php echo $model->skrinninggizi_skor_totaldewasa; ?> </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center;">Catatan:Skor 4-5 dilakukan pengkajian lanjut oleh ahli gizi</td>
                        </tr>
                    </table>
                  </td>
                  <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="200px" style="padding-left: 50px">Diet Saat ini</td>
                            <td width="5px">:</td>
                            <td>
                              <?php echo $model->nutrisi_dietsaatini; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="200px" style="padding-left: 50px">Penurunan/kenaikan berat badan selama 6 bulan terakhir</td>
                            <td width="5px">:</td>
                            <td>
                              <span class="<?php echo ((!empty($model->nutrisi_perubahanbb6blnterakhir) && ($model->nutrisi_perubahanbb6blnterakhir=='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                              <br/>
                              <span class="<?php echo ((!empty($model->nutrisi_perubahanbb6blnterakhir) && ($model->nutrisi_perubahanbb6blnterakhir=='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                              <br/>
                              <span style="padding-left: 5px"></span>Jelaskan : <?php echo $model->nutrisi_perubahanbb6blnterakhirket; ?>
                            </td>
                        </tr>
                    </table>
                  </td>
              </tr>
          </table>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>SKRINING STATUS FUNGSIONAL</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td width="60%">
                      <table class="items table table-bordered table-striped table-condensed" id="tblInputFungsional">
                          <thead>
                              <tr>
                                  <th style="width: 10px">No</th>
                                  <th style="width: 300px">Kriteria Barthel Index</th>
                                  <th style="width: 50px">Skor</th>
                                  <th style="width: 100px">Keterangan</th>
                              </tr>
	                       </thead>
                          <tr>
                              <td>1</td>
                              <td>Makan</td>
                              <td><?php echo $model->skrinningfungsional_skor_makan; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_makan==5)? "Dengan Bantuan":(($model->skrinningfungsional_skor_makan==10)? "Mandiri" : "")); ?></td>
                          </tr>
                           <tr>
                              <td>2</td>
                              <td>Aktifitas di Toilet</td>
                              <td><?php echo $model->skrinningfungsional_skor_aktifitastoilet; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_aktifitastoilet==5)? "Dengan Bantuan":(($model->skrinningfungsional_skor_aktifitastoilet==10)? "Mandiri" : "")); ?></td>

                           </tr>
                           <tr>
                              <td>3</td>
                              <td>Berpindah dari roda ke tempat tidur/ sebaliknya, termasuk duduk di tempat tidur</td>
                              <td><?php echo $model->skrinningfungsional_skor_berpindahkursi; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_berpindahkursi >=5 && $model->skrinningfungsional_skor_berpindahkursi <= 10 )? "Dengan Bantuan":(($model->skrinningfungsional_skor_berpindahkursi==15)? "Mandiri" : "")); ?></td>
                           </tr>
                           <tr>
                              <td>4</td>
                              <td>Kebersihan diri, mencuci muka, menyisir rambut, menggosok gigi</td>
                              <td><?php echo $model->skrinningfungsional_skor_kebersihanmandiri; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_kebersihanmandiri==0)? "Dengan Bantuan":(($model->skrinningfungsional_skor_kebersihanmandiri==5)? "Mandiri" : "")); ?></td>

                           </tr>
                           <tr>
                              <td>5</td>
                              <td>Mandi</td>
                              <td><?php echo $model->skrinningfungsional_skor_mandi; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_mandi==0)? "Dengan Bantuan":(($model->skrinningfungsional_skor_mandi==5)? "Mandiri" : "")); ?></td>

                           </tr>
                           <tr>
                              <td>6</td>
                              <td>Berjalan di permukaan dasar</td>
                              <td><?php echo $model->skrinningfungsional_skor_berjalanpermukaankasar; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_berjalanpermukaankasar==10)? "Dengan Bantuan":(($model->skrinningfungsional_skor_berjalanpermukaankasar==15)? "Mandiri" : "")); ?></td>

                           </tr>
                           <tr>
                              <td>7</td>
                              <td>Naik turun tangga</td>
                              <td><?php echo $model->skrinningfungsional_skor_naikturuntangga; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_naikturuntangga==5)? "Dengan Bantuan":(($model->skrinningfungsional_skor_naikturuntangga==10)? "Mandiri" : "")); ?></td>

                           </tr>
                           <tr>
                              <td>8</td>
                              <td>Berpakaian</td>
                              <td><?php echo $model->skrinningfungsional_skor_berpakaian; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_berpakaian==5)? "Dengan Bantuan":(($model->skrinningfungsional_skor_berpakaian==10)? "Mandiri" : "")); ?></td>

                           </tr>
                           <tr>
                              <td>9</td>
                              <td>Mengontrol defekasi</td>
                              <td><?php echo $model->skrinningfungsional_skor_mengontroldefekasi; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_mengontroldefekasi==5)? "Dengan Bantuan":(($model->skrinningfungsional_skor_mengontroldefekasi==10)? "Mandiri" : "")); ?></td>

                           </tr>
                          <tr>
                              <td>10</td>
                              <td>Mengontrol Berkemih</td>
                              <td><?php echo $model->skrinningfungsional_skor_mengontrolberkemih; ?></td>
                              <td><?php echo (($model->skrinningfungsional_skor_mengontrolberkemih==5)? "Dengan Bantuan":(($model->skrinningfungsional_skor_mengontrolberkemih==10)? "Mandiri" : "")); ?></td>

                          </tr>
                          <tr>
                              <td colspan="2">TOTAL</td>
                              <td colspan="2"><?php echo $model->skrinningfungsional_jumlah_skor; ?></td>
	                       </tr>
                          <tr>
                              <td colspan="2">Kategori</td>
                              <td colspan="2"><?php echo $model->skrinningfungsional_kategori .' '.$model->skrinningfungsional_keterangan; ?></td>
	                       </tr>
                      </table>
                  </td>
                  <td width="5%" valign="top"></td>
                  <td width="25%" valign="top">
                      <table class="items table table-bordered table-striped table-condensed">
                          <thead>
                              <tr>
                                  <th colspan="3" style="text-align: center !important;">Kategori</th>
                                  <th style="width: 10px">No</th>
                              </tr>
                         </thead>
                          <tr>
                              <td>I</td>
                              <td>100</td>
                              <td>Mandiri</td>
                              <td>1</td>
                          </tr>
                           <tr>
                              <td>II</td>
                              <td>91 - 92</td>
                              <td>Ketergantungan ringan</td>
                              <td>2</td>
                          </tr>
                          <tr>
                              <td>III</td>
                              <td>62 - 90</td>
                              <td>Sedang</td>
                              <td>3</td>
                          </tr>
                          <tr>
                              <td>IV</td>
                              <td>21 - 61</td>
                              <td>Ketergantingan berat</td>
                              <td>4</td>
                          </tr>
                          <tr>
                              <td>V</td>
                              <td>0 - 20</td>
                              <td>Ketergantungan Total</td>
                              <td>5</td>
                          </tr>
                      </table>
                  </td>
                  <td width="10%" valign="top"></td>
              </tr>
          </table>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>ASUHAN KEPERAWATAN</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
          <tr>
              <td width="35%">
                <table width="100%" class="tablefont">
                  <tr>
                    <td>
                      Masalah Keperawatan
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo $masalahKeperawatan; ?>
                    </td>
                  </tr>
                  </table>
              </td>
              <td width="30%">
                <table width="100%" class="tablefont">
                  <tr>
                    <td>
                      Rencana Keperawatan
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo $rencanaKeperawatan; ?>
                    </td>
                  </tr>
                  </table>
              </td>
              <td width="35%">
                <table width="100%" class="tablefont">
                  <tr>
                    <td>
                      Tindakan Keperawatan
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo $tindakanKeperawatan; ?>
                    </td>
                  </tr>
                  </table>
              </td>
            </tr>
        </table>
      </div>
  </div>


</div>

<br/><br/>
<input type="hidden" id="pagerdata">
<ul class="pager wizard">
  <li class="previous" style="background-color: green">
  <a href="javascript::void(0)" style="background-color: #00a651; color: white;" onclick="prevPager(this)"><i class="entypo-left-open"></i> Sebelumnya</a>
  </li>

  <li class="next" style="background-color: green">
      <a href="javascript:void(0)" style="background-color: #00a651; color: white" onclick="nextPager(this)">Berikutnya <i class="entypo-right-open"></i></a>
  </li>
</ul>

<script type="text/javascript">
  function prevPager(obj){
    var index = parseInt($('#pagerdata').val());
    if(index == 1){

    }else{
      if(index > 0){
          index -= 1;
      }else{
        index = 1;
      }
    }
    tabPager(index);
  }
  function nextPager(obj){
    var index = parseInt($('#pagerdata').val());
    if(index > 2){

    }else{
      index += 1;
    }
    tabPager(index);
  }

  function tabPager(index){
    $('#pagerdata').val(index);
    $('.previous').show();
    $('.next').show();
    $('.pageDetail').hide();
    $('#pageDetail_'+index).show();
    scrollTo(0,0);
    if(index==1){
      $('.previous').hide();
    }else if(index==2){
      $('.next').hide();
    }
  }

$(document).ready(function(){
  tabPager(1);
});

</script>
