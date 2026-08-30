<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style type="text/css">
body{
    color: black;
  }
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
      text-align: center;
    }
    .textbold{
      font-weight: bold;
    }

    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }
</style>
<?php
  $hidden = false;

  if($model->jenisasesmen == 'asesmenri_dewasa'){
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
<div class="pageDetail" id="pageDetail_1">
  <div style="text-align: right; font-weight: bold; color: black">
    FRM/73D Rev 01/RSBM
  </div>
  <br/>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Data Awal</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="200px">Ruangan</td>
                        <td width="10px">:</td>
                        <td><?php echo $modPasienAdmisi->ruangan->ruangan_nama; ?></td>
                    </tr>
                    <tr>
                        <td width="200px">Kamar/ Bed</td>
                        <td width="10px">:</td>
                        <td><?php echo $modPasienAdmisi->kamarruangan->kamarruangan_nokamar.'/ '.$modPasienAdmisi->kamarruangan->kamarruangan_nobed; ?></td>
                    </tr>
                    <tr>
                        <td width="200px" valign="top">Pasien pindahan dari</td>
                        <td width="10px" valign="top">:</td>
                        <td>
                          <?php
                          $ruanganDaftar = $modPendaftaran->ruangan->ruangan_nama;
                          $checklistRuangan = "";
                          $checkPindahKamar = PindahkamarT::model()->findByAttributes(array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id));
                          $pasienPindahKamar = PasienridariruanganlainV::model()->findByAttributes(array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,'ruangan_id'=>$modPasienAdmisi->ruangan_id));

                          if($modPasienAdmisi->caramasuk_id==2 && empty($checkPindahKamar)){
                            if($modPendaftaran->ruangan_id == 7){
                              $checklistRuangan = "IGD";
                            }else{
                              $checklistRuangan = "LAIN";
                            }
                          }else if($modPasienAdmisi->caramasuk_id==3 && empty($checkPindahKamar)){
                            $checklistRuangan = "LAIN";
                          }else if(!empty($checkPindahKamar)){
                            $checklistRuangan = "LAIN";
                            $ruanganDaftar = ((isset($pasienPindahKamar) && !empty($pasienPindahKamar))?$pasienPindahKamar->ruangan_nama:"");
                          }

                          ?>
                          <span class="<?php echo ((!empty($checklistRuangan) && ($checklistRuangan=='IGD'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> IGD
                          <br/>
                          <span class="<?php echo ((!empty($checklistRuangan) && ($checklistRuangan=='LAIN'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ruangan: <?php echo ((!empty($checklistRuangan) && ($checklistRuangan=='LAIN'))? $ruanganDaftar :""); ?>
                        </td>
                    </tr>
                  </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="200px" valign="top">Sumber Dana</td>
                        <td width="10px" valign="top">:</td>
                        <td>
                          <span class="<?php echo ((!empty($model->sumberdata) && ($model->sumberdata=='Pasien'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pasien
                          <br/>
                          <span class="<?php echo ((!empty($model->sumberdata) && ($model->sumberdata=='Keluarga'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga
                          <br/>
                          <span class="<?php echo ((!empty($model->sumberdata) && ($model->sumberdata=='Lainnya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $model->sumberdata_lainnya; ?>
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
                          <td><?php echo date('d', strtotime($model->tgl_assesmen_awal)).' '.MyFormatter::getMonthId(date('m', strtotime($model->tgl_assesmen_awal))).' '.date('Y', strtotime($model->tgl_assesmen_awal)).' '.date('H:i:s', strtotime($model->tgl_assesmen_awal)); ?>WITA</td>
                      </tr>
                      <tr>
                          <td width="200px">Jam Masuk Ruangan</td>
                          <td width="10px">:</td>
                          <td><?php echo $model->jam_masukruangan; ?> WITA</td>
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
         <div class="panel-title"><strong>PSIKOLOGI-SOSIAL-SPIRITUAL</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="150px" valign="top">Tinggal Bersama</td>
                          <td width="5px" valign="top">:</td>
                          <td>
                            <?php echo $model->neonatus_tinggalbersama; ?>
                            <br/>
                            Nama Pihak Lainnya : <?php echo $model->neonatus_tinggalbersamalainnya_nama; ?>
                            <br/>
                            No. Telp Pihak Lainnya : <?php echo $model->neonatus_tinggalbersamalainnya_notlp; ?>
                          </td>
                      </tr>
                        <tr>
                            <td colspan="3" style="padding-left: 5px"><u>Kebiasaan Ibu</u></td>
                        </tr>
                        <tr>
                            <td valign="top">Status Merokok</td>
                            <td valign="top">:</td>
                            <td>
                              <?php echo ($model->statusmerokok==1)?"Ya":"Tidak"; ?>
                              <br/>
                              Jumlah Rokok Batangan : <?php echo $model->jmlrokok_btg_hr; ?> Per Hari
                            </td>
                        </tr>
                        <tr>
                            <td>Alkohol</td>
                            <td>:</td>
                            <td><?php echo ($model->neonatus_kebiasaanortualkohol_status==true)?"Ya":"Tidak"; ?></td>
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
                          <td colspan="3" style="padding-left: 5px"><u>EKONOMI</u></td>
                      </tr>
                      <tr>
                          <td>Pembiayaan Kesehatan</td>
                          <td>:</td>
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
         <div class="panel-title"><strong>RIWAYAT ALERGI</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="150px" valign="top">Alergi</td>
                              <td width="5px" valign="top">:</td>
                              <td>
                                <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                                <br/>
                                <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                                <br/>
                                <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Tidak Tahu'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Tahu</td>
                              </td>
                          </tr>
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                        <table width="100%" class="tablefont">
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
                      </table>
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
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="150px">Keluhan Utama</td>
                              <td width="5px">:</td>
                              <td><?php echo trim($model->keluhanutama); ?></td>
                          </tr>
                          <tr>
                              <td width="150px">Keluhan Tambahan</td>
                              <td width="5px">:</td>
                              <td><?php echo trim($model->keluhantambahan); ?></td>
                          </tr>
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px" valign="top">Diagnosa Medis saat ini</td>
                            <td width="5px" valign="top">:</td>
                            <td><?php echo trim($model->diagnosa_utama); ?></td>
                        </tr>
                        <tr>
                            <td width="150px">Riwayat Keluhan Penyakit saat ini</td>
                            <td width="5px">:</td>
                            <td><?php echo trim($model->riwayatperjalanan_penyakitpasien); ?></td>
                        </tr>
                      </table>
                  </td>
              </tr>
          </table>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Riwayat Kesehatan</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td colspan="2" style="color: black"><strong>A. Riwayat Prenatal</strong></td>
              </tr>
              <tr>
                  <td width="50%">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="200px" valign="top">Riwayat Penyakit Selama Hamil</td>
                              <td width="5px" valign="top">:</td>
                              <td>
                                  <table>
                                    <tr>
                                      <td width="200px">
                                          <span class="<?php echo (($model->neonatus_ispenyakitibudm==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> DM
                                      </td>
                                      <td></td>
                                      <td  width="200px">
                                        <span class="<?php echo (($model->neonatus_ispenyakitibuhepatitisb==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hepatitis B
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <span class="<?php echo (($model->neonatus_ispenyakitibuhipertensi==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hipertensi
                                      </td>
                                      <td></td>
                                      <td>
                                        <span class="<?php echo (($model->neonatus_ispenyakitibuasma==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Asma
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <span class="<?php echo (($model->neonatus_ispenyakitibujantung==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Jantung
                                      </td>
                                      <td></td>
                                      <td>
                                        <span class="<?php echo (($model->neonatus_ispenyakitibupms==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> PMS
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <span class="<?php echo (($model->neonatus_ispenyakitibutbc==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> TBC
                                      </td>
                                      <td></td>
                                      <td>
                                        <span class="<?php echo (($model->neonatus_ispenyakitibulainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya
                                        , <?php echo $model->neonatus_penyakitibu_lainnyaket; ?>
                                      </td>
                                    </tr>
                                  </table>
                              </td>
                          </tr>
                          <tr>
                              <td width="200px" valign="top">Komplikasi Kehamilan</td>
                              <td width="5px" valign="top">:</td>
                              <td>
                                <?php
                                     $lookupKomplikasi = LookupM::model()->findAll("lookup_type = 'komplikasikehamilan_asesmen' order by lookup_urutan ASC");

                                     if(count((array)$lookupKomplikasi) > 0){
                                       $htmlKomplikasi = "";
                                       foreach($lookupKomplikasi as $i => $look_komplikasi){
                                         $isKomplikasi = false;

                                         if($i > 0){
                                           $htmlKomplikasi .= "<br/>";
                                         }

                                         if(!empty($model->neonatus_kompilkasikehamilan)){
                                           $arrOriKomplikasi = json_decode($model->neonatus_kompilkasikehamilan);
                                           foreach ($arrOriKomplikasi as $oriKomplikasi) {
                                             if($oriKomplikasi == $look_komplikasi->lookup_value){
                                               $isKomplikasi = true;
                                             }
                                           }
                                         }

                                         if($look_komplikasi->lookup_value == 'Lain-lain'){
                                           $htmlKomplikasi .= "<span class='".(($isKomplikasi==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_komplikasi->lookup_name;
                                           $htmlKomplikasi .= ", ".$model->neonatus_kompilkasikehamilanlainnya;
                                         }else{
                                           $htmlKomplikasi .= "<span class='".(($isKomplikasi==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_komplikasi->lookup_name;
                                         }
                                       }
                                       echo $htmlKomplikasi;
                                     }
                                 ?>
                              </td>
                          </tr>
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="150px">Riwayat Pengobatan Ibu</td>
                              <td width="5px">:</td>
                              <td><?php echo $model->neonatus_riwayatpengobatanibu; ?></td>
                          </tr>
                          <tr>
                              <td>Kebiasaan Saat Hamil</td>
                              <td>:</td>
                              <td>
                                <?php
                                     $lookupKebiasaan = array(0=>'Rokok',1=>'Jamu', 2=>'Lainnya');

                                     if(count((array)$lookupKebiasaan) > 0){
                                       $htmlKebiasaan = "";
                                       foreach($lookupKebiasaan as $i => $look_kebiasaan){
                                         $isKebiasaan = false;

                                         if($i >0){
                                           $htmlKebiasaan .= "<br/>";
                                         }
                                         if(!empty($model->neonatus_kebiasaansaathamil)){
                                           $arrOriKebiasaan = json_decode($model->neonatus_kebiasaansaathamil);
                                           foreach ($arrOriKebiasaan as $oriKebiasaan) {
                                             if($oriKebiasaan == $look_kebiasaan){
                                               $isKebiasaan = true;
                                             }
                                           }
                                         }

                                         if($look_kebiasaan == 'Lainnya'){
                                           $htmlKebiasaan .= "<span class='".(($isKebiasaan==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_kebiasaan;
                                           $htmlKebiasaan .= ", ".$model->neonatus_kebiasaansaathamillainnya;
                                         }else{
                                           $htmlKebiasaan .= "<span class='".(($isKebiasaan==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_kebiasaan;
                                         }
                                       }
                                       echo $htmlKebiasaan;
                                     }
                                 ?>
                              </td>
                          </tr>
                      </table>
                  </td>
              </tr>
              <tr>
                  <td colspan="2" style="color: black"><strong>B. Riwayat Intranatal</strong></td>
              </tr>
              <tr>
                  <td width="50%">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="200px">Diagnosa Ibu</td>
                              <td width="5px">:</td>
                              <td>
                                <?php echo "G : ".$model->khususanak_gravida_g." P : ".$model->khususanak_gravida_p." A : ".$model->khususanak_gravida_a; ?>
                              </td>
                          </tr>
                          <tr>
                              <td>Umur Kehamilan</td>
                              <td>:</td>
                              <td><?php echo $model->neonatus_umurkehamilan; ?> Minggu</td>
                          </tr>
                          <tr>
                              <td valign="top">Tanggal Persalinan</td>
                              <td valign="top">:</td>
                                <td><?php echo (!empty($model->neonatus_tglpersalinan)?MyFormatter::formatDateTimeForUser($model->neonatus_tglpersalinan):""); ?></td>
                          </tr>
                          <tr>
                              <td valign="top">Pukul</td>
                              <td valign="top">:</td>
                                <td><?php echo $model->neonatus_jampersalinan; ?></td>
                          </tr>
                          <tr>
                              <td valign="top">Cara Persalinan</td>
                              <td valign="top">:</td>
                                <td><?php echo $model->neonatus_carapersalinan; ?></td>
                          </tr>
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td valign="top" width="150px">Ketuban Pecah</td>
                              <td valign="top" width="5px">:</td>
                              <td>
                                <span class="<?php echo (($model->neonatus_isketubanpecah==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                                <br/>
                                <span class="<?php echo (($model->neonatus_isketubanpecah==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                                <span style="padding-left: 20px">Warna Ketuban : </span>
                                <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_warnaketuban) && ($model->neonatus_warnaketuban=='Jernih'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Jernih
                                <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_warnaketuban) && ($model->neonatus_warnaketuban=='Merah'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Merah
                                <br/>
                                <span style="padding-left: 153px" class="<?php echo ((!empty($model->neonatus_warnaketuban) && ($model->neonatus_warnaketuban=='Hijau'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hijau
                                <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_warnaketuban) && ($model->neonatus_warnaketuban=='Keruh'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keruh
                              </td>
                          </tr>
                          <tr>
                              <td>Tali Pusat</td>
                              <td>:</td>
                              <td>
                                <span class="<?php echo ((!empty($model->neonatus_talipusat) && ($model->neonatus_talipusat=='Segar'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Segar
                                <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_talipusat) && ($model->neonatus_talipusat=='Layu'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Layu
                                <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_talipusat) && ($model->neonatus_talipusat=='Simpul'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Simpul
                              </td>
                          </tr>
                          <tr>
                              <td>Placenta</td>
                              <td>:</td>
                              <td>
                                <span class="<?php echo ((!empty($model->neonatus_placenta) && ($model->neonatus_placenta=='Komplit'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Komplit
                                <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_placenta) && ($model->neonatus_placenta=='Klasifikasi'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Klasifikasi
                                <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_placenta) && ($model->neonatus_placenta=='Kelainan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kelainan
                              </td>
                          </tr>
                      </table>
                  </td>
              </tr>
              <tr>
                  <td colspan="2" style="color: black"><strong>C. Fakor Risiko Infeksi</strong></td>
              </tr>
              <tr>
                  <td colspan="2">
                    <table width="100%" class="tablefont">
                      <tr>
                        <td width="120px">Mayor</td>
                        <td width="5px">:</td>
                        <td>
                          <span class="<?php echo (($model->neonatus_faktorinfeksimayor_ibudemam==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ibu Demam ≥ 38 &#176;C &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksimayor_kpdlebihdr24jam==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> KPD > 24 JAM &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksimayor_ketubanhijau==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ketuban Hijau &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksimayor_korioamnionitis==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Korioamnionitis &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksimayor_fetaldistress==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Fetal Distress
                        </td>
                      </tr>
                      <tr>
                        <td width="120px">Minor</td>
                        <td width="5px">:</td>
                        <td>
                          <span class="<?php echo (($model->neonatus_faktorinfeksiminor_kpdkurangdr12jam==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> KPD < 12 Jam &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksiminor_asfiksia==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Asfiksia &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksiminor_bblr==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> BBLR &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksiminor_isk==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> ISK &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksiminor_ukkurangdr37minggu==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> UK < 37 Minggu &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksiminor_gemeli==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Gemeli &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksiminor_keputihan==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keputihan &nbsp;&nbsp;
                          <span class="<?php echo (($model->neonatus_faktorinfeksiminor_ibutemplebihdr37==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ibu Temp > 37 &#176C;
                        </td>
                      </tr>
                    </table>
                  </td>
                </td>
              </tr>
              <tr>
                  <td colspan="2" style="color: black"><strong>D. Keadaan Bayi saat Lahir</strong></td>
              </tr>
              <tr>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                      <td width="120px">Tanggal Lahir</td>
                      <td width="5px">:</td>
                      <td>
                        <?php echo (!empty($model->neonatus_tglpersalinan)?MyFormatter::formatDateTimeForUser($model->neonatus_tglpersalinan):""); ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Jam Lahir</td>
                      <td>:</td>
                      <td>
                      <?php echo $model->neonatus_jampersalinan; ?>
                      </td>
                    </tr>
                    <tr>
                        <td valign="top">Jenis Kelamin</td>
                        <td valign="top">:</td>
                        <td>
                          <span class="<?php echo ((!empty($model->neonatus_jeniskelamin) && ($model->neonatus_jeniskelamin=='LAKI-LAKI'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> LAKI-LAKI
                          <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_jeniskelamin) && ($model->neonatus_jeniskelamin=='PEREMPUAN'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> PEREMPUAN
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Jenis Kelahiran</td>
                        <td valign="top">:</td>
                        <td>
                          <span class="<?php echo ((!empty($model->neonatus_jeniskelahiran) && ($model->neonatus_jeniskelahiran=='Kelahiran Tunggal'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kelahiran Tunggal
                          <br/>
                          <span class="<?php echo ((!empty($model->neonatus_jeniskelahiran) && ($model->neonatus_jeniskelahiran=='Kelahiran Kembar/ Multiple'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kelahiran Kembar/ Multiple
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Kondisi saat lahir</td>
                        <td valign="top">:</td>
                        <td>
                          <span class="<?php echo ((!empty($model->neonatus_kondisisaatlahir) && ($model->neonatus_kondisisaatlahir=='Hidup'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hidup
                          <br/>
                          <span class="<?php echo ((!empty($model->neonatus_kondisisaatlahir) && ($model->neonatus_kondisisaatlahir=='Mati'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Mati
                          <br/>
                          <span style="padding-left: 15px" class="<?php echo ((!empty($model->neonatus_statuskelahiranmati) && ($model->neonatus_statuskelahiranmati=='Sebelum Persalinan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sebelum Persalinan
                          <br/>
                          <span style="padding-left: 15px" class="<?php echo ((!empty($model->neonatus_statuskelahiranmati) && ($model->neonatus_statuskelahiranmati=='Dalam Persalinan'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Dalam Persalinan
                          <br/><span style="padding-left: 20px">Sebab Kematian : <?php echo $model->neonatus_sebabkematian; ?></span>

                        </td>
                    </tr>
                  </table>
                </td>
                  <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                        <td width="120px">HR</td>
                        <td width="5px">:</td>
                        <td>
                          <?php echo $model->neonatus_saatlahir_hr; ?> x/menit
                        </td>
                      </tr>
                      <tr>
                        <td>Suhu Tubuh</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->neonatus_saatlahir_suhutubuh; ?> &#176;C
                         </td>
                      </tr>
                      <tr>
                        <td>RR</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->neonatus_saatlahir_rr; ?> x/menit
                         </td>
                      </tr>
                      <tr>
                        <td>SpO2</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->neonatus_saatlahir_spo2; ?> %
                         </td>
                      </tr>
                      <tr>
                        <td>Berat Badan Lahir</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->khususanak_beratbadanlahir; ?> gram
                         </td>
                      </tr>
                      <tr>
                        <td>Panjang Badan (PB)</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->khususanak_tinggibadan; ?> cm
                         </td>
                      </tr>
                      <tr>
                        <td>Lingkar Kepala (LK)</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->neonatus_saatlahir_lingkarkepala; ?> cm
                         </td>
                      </tr>
                      <tr>
                        <td>Lingkar Dada (LD)</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->neonatus_saatlahir_lingkardada; ?> cm
                         </td>
                      </tr>
                      <tr>
                        <td>Anus</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->neonatus_saatlahir_anus; ?>
                         </td>
                      </tr>
                      <tr>
                        <td>Kelahiran</td>
                        <td>:</td>
                        <td>
                          <?php echo $model->neonatus_saatlahir_kelahiran; ?>
                         </td>
                      </tr>
                    </table>
                  </td>
                </td>
              </tr>
          </table>
      </div>
  </div>
</div>

<div class="pageDetail" id="pageDetail_2">
  <div style="text-align: right; font-weight: bold; color: black">
  FRM/73D Rev 01/RSBM
  </div>
  <br/>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Pemeriksaan Fisik Neonatus</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%" class="tablefont">
            <tr>
                <td width="150px" valign="top">Kepala</td>
                <td width="5px" valign="top">:</td>
                <td>
                  <span class="<?php echo ((!empty($modPeriksaFisikNeonatus->kepala_kesimetrisan) && ($modPeriksaFisikNeonatus->kepala_kesimetrisan=='Simestri'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Simestri
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->kepala_kesimetrisan) && ($modPeriksaFisikNeonatus->kepala_kesimetrisan=='Asimestri'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Asimestri
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->kepala_iscephalhematoma==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Cephal Hematoma
                  <span style="padding-left: 50px" class="<?php echo (($modPeriksaFisikNeonatus->kepala_ismicrocephali==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Microcephali
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->kepala_iscaputsuccedanium==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Caput Succedanium
                  <span style="padding-left: 44px" class="<?php echo (($modPeriksaFisikNeonatus->kepala_ishydrocephali==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hydricephalus
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->kepala_isanencephali==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Anencephali
                  <span style="padding-left: 88px" class="<?php echo (($modPeriksaFisikNeonatus->kepala_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->kepala_lainnyaket; ?>
                </td>
            </tr>
            <tr>
                <td>UUB</td>
                <td>:</td>
                <td>
                  <span class="<?php echo ((!empty($modPeriksaFisikNeonatus->ubunubunbesar_status) && ($modPeriksaFisikNeonatus->ubunubunbesar_status=='Datar'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Datar
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->ubunubunbesar_status) && ($modPeriksaFisikNeonatus->ubunubunbesar_status=='Cembung'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Cembung
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->ubunubunbesar_status) && ($modPeriksaFisikNeonatus->ubunubunbesar_status=='Cekung'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Cekung
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->ubunubunbesar_status) && ($modPeriksaFisikNeonatus->ubunubunbesar_status=='Lainnya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->ubunubunbesar_ket; ?>
                </td>
            </tr>
            <tr>
                <td>Mata</td>
                <td>:</td>
                <td>
                  <span class="<?php echo ((!empty($modPeriksaFisikNeonatus->mata_status) && ($modPeriksaFisikNeonatus->mata_status=='Normal'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Normal
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->mata_status) && ($modPeriksaFisikNeonatus->mata_status=='Anemia'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Anemia
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->mata_status) && ($modPeriksaFisikNeonatus->mata_status=='Ikterus'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ikterus
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->mata_status) && ($modPeriksaFisikNeonatus->mata_status=='Sekret'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sekret
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->mata_status) && ($modPeriksaFisikNeonatus->mata_status=='Lainnya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->mata_ket; ?>
                </td>
            </tr>
            <tr>
                <td>THT</td>
                <td>:</td>
                <td>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->tht_isnormal==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Normal
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->tht_isnch==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Nafas Cuping Hidung (NCH)
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->tht_iscianosis==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Cianosis
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->tht_issekret==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sekret
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->tht_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->tht_lainnyaket; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">Mulut</td>
                <td valign="top">:</td>
                <td>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->mulut_isnormal==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Normal
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->mulut_islabioschzis==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Labioschzis
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->mulut_islabiognatopalatoschizis==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Labiognatopalatoschizis
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->mulut_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->mulut_lainnyaket; ?>
                  <br/>
                  Mukosa, Warna : <?php echo $modPeriksaFisikNeonatus->mulut_mukosa; ?>
                  <span style="padding-left: 10px">Lainnya</span> <?php echo $modPeriksaFisikNeonatus->mulut_mukosalainnya; ?>
                </td>
            </tr>
            <tr>
                <td>Thorax</td>
                <td>:</td>
                <td>
                  <span class="<?php echo ((!empty($modPeriksaFisikNeonatus->thorax_status) && ($modPeriksaFisikNeonatus->thorax_status=='Normal'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Normal
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->thorax_status) && ($modPeriksaFisikNeonatus->thorax_status=='Retraksi'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Retraksi
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->thorax_status) && ($modPeriksaFisikNeonatus->thorax_status=='Lainnya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->thorax_lainnya; ?>
                </td>
            </tr>
            <tr>
                <td>Abdomen</td>
                <td>:</td>
                <td>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->abdomen_isnormal==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Normal
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->abdomen_isdistensi==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Distensi
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->abdomen_isomphalocele==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Omphalocele
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->abdomen_isbisingusus==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bising Usus
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->abdomen_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->abdomen_lainnyaket; ?>
                </td>
            </tr>
            <tr>
                <td>Punggung</td>
                <td>:</td>
                <td>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->punggung_isnormal==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Normal
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->punggung_isspina_bifida==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Spina Bifida
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->punggung_isgibus==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Gibus
                  <span style="padding-left: 5px" class="<?php echo (($modPeriksaFisikNeonatus->punggung_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->punggung_lainnyaket; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">Genitalia</td>
                <td valign="top">:</td>
                <td>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->genitalia_iskelainan==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> LAKI-LAKI, <?php echo $modPeriksaFisikNeonatus->genitalia_kelainanket; ?>
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->genitalia_ishermaprodit==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hemoprodit
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->genitalia_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->genitalia_lainnyaket; ?>
                </td>
            </tr>
            <tr>
                <td>Anus</td>
                <td>:</td>
                <td>
                  <span class="<?php echo ((!empty($modPeriksaFisikNeonatus->anus_isada) && ($modPeriksaFisikNeonatus->anus_isada=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->anus_isada) && ($modPeriksaFisikNeonatus->anus_isada=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                </td>
            </tr>
            <tr>
                <td>Ekstremitas</td>
                <td>:</td>
                <td>
                  <span class="<?php echo ((!empty($modPeriksaFisikNeonatus->ekstremitas_simetris) && ($modPeriksaFisikNeonatus->ekstremitas_simetris=='Simestri'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Simestri
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modPeriksaFisikNeonatus->ekstremitas_simetris) && ($modPeriksaFisikNeonatus->ekstremitas_simetris=='Asimestri'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Asimestri
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->ekstremitas_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->ekstremitas_islainnyaket; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">Kulit</td>
                <td valign="top">:</td>
                <td>
                  Tugor : <?php echo $modPeriksaFisikNeonatus->kulit_turgor; ?>
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->kulit_ismarmorata==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kurtis Marmorata
                  <span style="padding-left: 47px" class="<?php echo (($modPeriksaFisikNeonatus->kulit_ishematoma==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hematoma
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->kulit_issianosis==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sianosis
                  <span style="padding-left: 100px" class="<?php echo (($modPeriksaFisikNeonatus->kulit_issklerema==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sklerema
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->kulit_ispendarahan==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pendarahan
                  <span style="padding-left: 80px" class="<?php echo (($modPeriksaFisikNeonatus->kulit_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->kulit_lainnyaket; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">Reflek</td>
                <td valign="top">:</td>
                <td>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->reflek_ismoro==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Moro, <?php echo $modPeriksaFisikNeonatus->reflek_moroket; ?>
                  <span style="padding-left: 100px" class="<?php echo (($modPeriksaFisikNeonatus->reflek_isbabinski==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Babinski, <?php echo $modPeriksaFisikNeonatus->reflek_babinskiket; ?>
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->reflek_israsping==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Rasping/Genggam, <?php echo $modPeriksaFisikNeonatus->reflek_raspingket; ?>
                  <span style="padding-left: 52px" class="<?php echo (($modPeriksaFisikNeonatus->reflek_isglabela==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Glabela, <?php echo $modPeriksaFisikNeonatus->reflek_glabelaket; ?>
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->reflek_issucking==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sucking/ Isap, <?php echo $modPeriksaFisikNeonatus->reflek_suckingket; ?>
                  <span style="padding-left: 55px" class="<?php echo (($modPeriksaFisikNeonatus->reflek_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $modPeriksaFisikNeonatus->reflek_lainnyaket; ?>
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->reflek_isrooting==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Rooting, <?php echo $modPeriksaFisikNeonatus->reflek_rootingket; ?>
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->reflek_isswallowing==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Swallowing/ Menelan, <?php echo $modPeriksaFisikNeonatus->reflek_swallowingket; ?>
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->reflek_istonickneck==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tonick Neck, <?php echo $modPeriksaFisikNeonatus->reflek_tonickneckket; ?>
                  <br/>
                  <span class="<?php echo (($modPeriksaFisikNeonatus->reflek_isstepping==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Stepping, <?php echo $modPeriksaFisikNeonatus->reflek_steppingket; ?>
                </td>
            </tr>
          </table>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>PENILAIAN RESIKO JATUH</strong></div>
     </div>
      <div class="panel-body">
        <div class="panel panel-default panel-shadow">
           <div class="panel-heading">
               <div class="panel-title"><strong>Skrinning Resiko Jatuh Anak (Humpty Dumpty)</strong></div>
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
                          <td>Usia</td>
                          <td>
                              <?php echo  $model->usia_anak; ?>
                          </td>
                          <td><?php echo $model->skor_usia_anak; ?></td>
                      </tr>
                       <tr>
                          <td>2</td>
                          <td>Jenis Kelamin</td>
                          <td>
                              <?php echo  $model->jeniskelamin_anak; ?>
                          </td>
                          <td><?php echo $model->skor_jeniskelamin_anak; ?></td>
                      </tr>
                       <tr>
                          <td>3</td>
                          <td>Diagnose</td>
                          <td>
                              <?php echo  $model->diagnosa_asessment_anak; ?>
                          </td>
                          <td><?php echo $model->skor_diagnosa_anak; ?></td>
                      </tr>
                       <tr>
                          <td>4</td>
                          <td>Gangguan Kognitif</td>
                          <td>
                              <?php echo  $model->gangguan_kognitif_anak; ?>
                          </td>
                          <td><?php echo $model->skor_gangguan_kognitif_anak; ?></td>
                      </tr>
                       <tr>
                          <td>5</td>
                          <td>Faktor Lingkungan</td>
                          <td>
                              <?php echo  $model->faktor_lingkungan_anak; ?>
                          </td>
                          <td><?php echo $model->skor_faktor_lingkungan_anak; ?></td>
                      </tr>
                       <tr>
                          <td>6</td>
                          <td>Respon Terhadap: Pembedahan, sedasi, anestesi</td>
                          <td>
                              <?php echo  $model->responterhadap_pembedahan_anak; ?>
                          </td>
                          <td><?php echo $model->skor_responterhadap_pembedahan_anak; ?></td>
                      </tr>
                       <tr>
                          <td>6</td>
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
          </div>
      </div>
    </div>
  </div>

</div>
<div class="pageDetail" id="pageDetail_3">
  <div style="text-align: right; font-weight: bold; color: black">
    FRM/73D Rev 01/RSBM
  </div>
  <br/>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>SKRINING STATUS FUNGSIONAL</strong></div>
     </div>
      <div class="panel-body">
        <?php if($model->jenis_statusfungsional == 'jenis_fungsionaladl'){ ?>
          <table width="100%">
              <tr>
                  <td>
                      <table class="items table table-bordered table-striped table-condensed" style="width: 80%;">
                          <thead>
                              <tr>
                                  <th style="width: 10px; text-align: center;">NO</th>
                                  <th style="width: 200px; text-align: center;">FUNGSI</th>
                                  <th style="width: 200px; text-align: center;">URAIAN</th>
                                  <th style="width: 50px; text-align: center;">SKOR</th>
                                  <th style="width: 80px; text-align: center;">NILAI SKOR</th>
                              </tr>
	                       </thead>
                         <tr>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;">1</td>
                             <td rowspan="4" style="vertical-align: middle;">Mengendalikan Rangsang deteksi (BAB)</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_bab; ?> </td>
                         </tr>
                         <tr>
                           <td>Tak Terkendali/ Tak Teratur (Perlu Pencahar)</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Kadang - kadang tak terkendali</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">2</td>
                         </tr>
                         <tr>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;">2</td>
                             <td rowspan="4" style="vertical-align: middle;">Mengendalikan Rangsang Berkemih (BAK)</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_bak; ?> </td>
                         </tr>
                         <tr>
                           <td>Tak Terkendali/ Tak Teratur (Perlu Pencahar)</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Kadang - kadang tak terkendali (1 x 24 jam)</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">2</td>
                         </tr>
                         <tr>
                             <td rowspan="3" style="vertical-align: middle; text-align: center;">3</td>
                             <td rowspan="3" style="vertical-align: middle;">Membersihkan diri (Cuci Muka, Sisir Rambut, Sikat Gigi)</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="3" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_kebersihanmandiri;; ?> </td>
                         </tr>
                         <tr>
                           <td>Butuh Pertolongan Orang Lain</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;">4</td>
                             <td rowspan="4" style="vertical-align: middle;">Penggunaan Jamban, Masuk dan Keluar (Melepaskan, memakai celana, membersihkan, menyiram)</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_pengunaanjamban; ?> </td>
                         </tr>
                         <tr>
                           <td>Tergantung Pertolongan Orang Lain</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Perlu Pertolongan pada beberapa kegiatan, tetapi dapat mengerjakan sendiri kegiatan yang lain</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">2</td>
                         </tr>
                         <tr>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;">5</td>
                             <td rowspan="4" style="vertical-align: middle;">Makan</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_makan; ?> </td>
                         </tr>
                         <tr>
                           <td>Tidak Mampu</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Perlu ditolong memotong makanan</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">2</td>
                         </tr>
                         <tr>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;">6</td>
                             <td rowspan="4" style="vertical-align: middle;">Berubah sikap dari berbaring ke duduk</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_sikap; ?> </td>
                         </tr>
                         <tr>
                           <td>Perlu banyak bantuan untuk bisa duduk (2 orang)</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Bantung (2 Orang)</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">2</td>
                         </tr>
                         <tr>
                             <td rowspan="5" style="vertical-align: middle; text-align: center;">7</td>
                             <td rowspan="5" style="vertical-align: middle;">Berpindah / Berjalan</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="5" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_berpindah; ?> </td>
                         </tr>
                         <tr>
                           <td>Tidak Mampu</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Bisa (Pindah) dengan kursi roda</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                           <td>Berjalan dengan bantuan 1 orang</td>
                           <td style="text-align: center;">2</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">3</td>
                         </tr>
                         <tr>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;">8</td>
                             <td rowspan="4" style="vertical-align: middle;">Memakai Baju</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_baju; ?> </td>
                         </tr>
                         <tr>
                           <td>Tergantung Orang Lain</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Sebagian dibantu (Misalnya: mengancing baju)</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">2</td>
                         </tr>
                         <tr>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;">9</td>
                             <td rowspan="4" style="vertical-align: middle;">Naik Turun Tangga</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_naikturuntangga; ?> </td>
                         </tr>
                         <tr>
                           <td>Tidak Mampu</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Butuh Pertolongan</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">2</td>
                         </tr>
                         <tr>
                             <td rowspan="3" style="vertical-align: middle; text-align: center;">10</td>
                             <td rowspan="3" style="vertical-align: middle;">Mandi</td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td style="border-width: 0px; padding: 0px;"></td>
                             <td rowspan="3" style="vertical-align: middle; text-align: center;"><?php echo $modBarthelindexadlT->skor_mandi; ?> </td>
                         </tr>
                         <tr>
                           <td>Tergantung Orang Lain</td>
                           <td style="text-align: center;">0</td>
                         </tr>
                         <tr>
                           <td>Mandiri</td>
                           <td style="text-align: center;">1</td>
                         </tr>
                         <tr>
                             <td colspan="3" style="text-align: center;">TOTAL SKOR</td>
                             <td colspan="2" style="text-align: center;"> <?php echo $model->skrinningfungsional_jumlah_skor; ?> </td>
                         </tr>
                         <tr>
                             <td style="text-align: center;" colspan="3">KETERANGAN SKOR</td>
                             <td colspan="2" style="text-align: center;"> <?php echo $model->skrinningfungsional_keterangan; ?> </td>
                         </tr>
                         <tr>
                             <td style="text-align: center;" colspan="3">Petugas Pengisi</td>
                             <td colspan="2" style="text-align: center;"> <?php echo (isset($modBarthelindexadlT->perawat)?$modBarthelindexadlT->perawat->namaLengkap:"-") ?> </td>
                         </tr>
                         <tr>
                             <td colspan="5">
                               <b>Keterangan Score Penilaian Status Fungsional</b>
                               <br/>
                               Mandiri : 20<br/>
                               Tergantungan Ringan : 12-15<br/>
                               Tergantungan Sedang : 9-11<br/>
                               Tergantungan Berat : 5-8<br/>
                               Tergantungan Total : 0-4
                             </td>
                         </tr>
                      </table>
                  </td>
              </tr>
          </table>
        <?php }else{ ?>
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
          <?php } ?>
      </div>
  </div>
</div>

<div class="pageDetail" id="pageDetail_4">
  <div style="text-align: right; font-weight: bold; color: black">
    FRM/73D Rev 01/RSBM
  </div>
  <br/>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>PENILAIAN NYERI</strong></div>
     </div>
      <div class="panel-body">
        <?php
          if(!empty($model->kesadaranpasien_pengkajiannyeri) && $model->kesadaranpasien_pengkajiannyeri=="Tidak Sadar"){
            $model->isadakeluhannyeri = null;
            $model->jenisnyeri = null;
            $model->deskripsinyeri_lokasiskalanyeri = null;
            $model->deskripsinyeri_onset = null;
            $model->deskripsinyeri_onsetsatuan = null;
            $model->deskripsinyeri_penyebabtimbul = null;
            $model->kualitasnyeri = null;
            $model->deskripsinyeri_ismenjalar = null;
            $model->deskripsinyeri_lokasipenjalaran = null;
            $model->tingkatannyeri = null;
            $model->deskripsinyeri_frekuensinyeri = null;
            $model->deskripsinyeri_frekuensinyerilainnya = null;
            $model->kualitasnyeri_lainnya = null;
            $model->score_skalanyeri = null;
            $model->keteranganskala_nyeri = null;
          }
         ?>
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
                           <span style="padding-left: 20px" class="<?php echo ((!empty($model->jenisnyeri) && ($model->jenisnyeri=='Akut'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Akut
                          <br/>
                          <span style="padding-left: 20px" class="<?php echo ((!empty($model->jenisnyeri) && ($model->jenisnyeri=='Kronis'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kronis
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
                        <span class="<?php echo (($model->deskripsinyeri_ismenjalar != null && $model->deskripsinyeri_ismenjalar ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                        <br />
                        <span class="<?php echo (($model->deskripsinyeri_ismenjalar != null && $model->deskripsinyeri_ismenjalar ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
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
              <?php if($model->is_keluhannyeri_dewasa==true){ ?>
                <h2 style="text-align:center;">Intensitas "WONG BAKER FACE SCALE"</h2>
                <br/>
                <?php
                echo $this->renderPartial($this->path_view.'_formAsesmenDewasaDetail', array(
                    'model' => $model
                        ), true);
                ?>
              <?php }else if($model->is_keluhannyeri_dewasa==true){ ?>
                <?php

                echo $this->renderPartial($this->path_view.'_formAsesmenAnakDetail', array(
                    'model' => $model,
                    'dataFlaCcs' => $dataFlaCcs,
                    'getFlaCcs' => $getFlaCcs,
                    'modNyeriAnakDet'=>$modSkrinningnyerianakdetT
                        ), true);
                ?>
            <?php }else if($model->is_keluhannyeri_dewasa==null){ ?>
              <center><b>METODE CRIES</b></center><br/>
              <table class="items table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px;  text-align: center">No</th>
                        <th>Penilaian</th>
                        <th style="width: 250px; text-align: center">Nilai 0</th>
                        <th style="width: 250px; text-align: center">Nilai 1</th>
                        <th style="width: 250px; text-align: center">Nilai 2</th>
                        <th style="width: 50px; text-align: center">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><label>1</label></td>
                    <td style="font-style: italic;"><label>Crying</label></td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_cryingket)) && ($model->neonatus_cries_cryingnilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Tidak ada tangisan/ tangisan tidak melengking</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_cryingket)) && ($model->neonatus_cries_cryingnilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Tangisan melengking tetapi bayi mudah dihibur</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_cryingket)) && ($model->neonatus_cries_cryingnilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Tangisan melengking tetapi bayi tidak mudah dihibur</label>
                    </td>
                    <td style="text-align: center">
                      <label><?php echo $model->neonatus_cries_cryingnilai; ?></label>
                    </td>
                  </tr>
                  <tr>
                    <td><label>2</label></td>
                    <td style="font-style: italic;"><label>Requires</label></td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_requiresket)) && ($model->neonatus_cries_requiresnilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Tidak perlu oksigen</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_requiresket)) && ($model->neonatus_cries_requiresnilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      perlu oksigen ≤ 30%</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_requiresket)) && ($model->neonatus_cries_requiresnilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      perlu oksigen ≥ 30%</label>
                    </td>
                    <td style="text-align: center">
                      <label><?php echo $model->neonatus_cries_requiresnilai; ?></label>
                    </td>
                  </tr>
                  <tr>
                    <td><label>3</label></td>
                    <td style="font-style: italic;"><label>Increased</label></td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_increasedket)) && ($model->neonatus_cries_increasednilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Detak jantung dan tekanan darah tidak berubah atau kurang dari nilai base line</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_increasedket)) && ($model->neonatus_cries_increasednilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Detak jantung atau tekanan darah meningkat, tetapi peningkatan ≤ 20%</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_increasedket)) && ($model->neonatus_cries_increasednilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Detak jantung atau tekanan darah meningkat ≥ 20% dari nilai base line</label>
                    </td>
                    <td style="text-align: center">
                      <label><?php echo $model->neonatus_cries_increasednilai; ?></label>
                    </td>
                  </tr>
                  <tr>
                    <td><label>4</label></td>
                    <td style="font-style: italic;"><label>Expression</label></td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_expressionket)) && ($model->neonatus_cries_expressionnilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                        Tidak ada seringai</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_expressionket)) && ($model->neonatus_cries_expressionnilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Seringai ada</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_expressionket)) && ($model->neonatus_cries_expressionnilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Seringai ada dan tidak ada suara tangisan dengkur</label>
                    </td>
                    <td style="text-align: center">
                      <label><?php echo $model->neonatus_cries_expressionnilai; ?></label>
                    </td>
                  </tr>
                  <tr>
                    <td><label>5</label></td>
                    <td style="font-style: italic;"><label>Sleepless</label></td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_sleeplessket)) && ($model->neonatus_cries_sleeplessnilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Bayi terus menerus tidur</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_sleeplessket)) && ($model->neonatus_cries_sleeplessnilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Bayi terbangung pada interval berulang</label>
                    </td>
                    <td>
                      <label><span class="<?php echo (((!empty($model->neonatus_cries_sleeplessket)) && ($model->neonatus_cries_sleeplessnilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                      Bayi terjaga, terbangun secara terus menerus</label>
                    </td>
                    <td style="text-align: center">
                      <label><?php echo $model->neonatus_cries_sleeplessnilai; ?></label>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5" style="color: black">Total Nilai</td>
                    <td style="text-align: center">  <label><?php echo $model->neonatus_cries_totalnilai; ?></label></td>
                  </tr>
                </tfoot>
              </table>
            <?php } ?>
            </td>
          </tr>
        </table>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>STATUS NUTRISI</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%" class="tablefont">
          <tr>
              <td>Berat Badan (BB) biasanya : <?php echo $model->beratbadan_biasanya ?> Kg</td>
              <td>Berat Badan (BB) sekarang : <?php echo $model->beratbadan_kg ?> Kg</td>
              <td>Tinggi Badan/ Panjang Badan : <?php echo $model->tinggibadan_cm ?> cm</td>
              <td>BMI : <?php echo $model->bb_ideal ?> Kg/m<sup>2</sup></td>
          </tr>
        </table>
        <br/>
        <?php if($model->isskrinninggizidewasa==true){ ?>
          <table width="100%" class="items table table-bordered" id="tblInputFungsional">
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
                  <td colspan="2">Total Skor</td>
                  <td> <?php echo $model->skrinninggizi_skor_totaldewasa; ?> </td>
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
        <?php }else{ ?>
          <table class="items table table-bordered" id="tblInputFungsional">
              <thead>
                  <tr>
                      <th colspan="4" style="text-align: center">Skrinning Gizi (Metode Strong Kids)</th>
                  </tr>
                  <tr>
                      <th style="width: 10px">No</th>
                      <th>Parameter</th>
                      <th style="width: 80px">Jawaban</th>
                      <th style="width: 50px">Nilai</th>
                  </tr>
             </thead>
              <tr>
                  <td>1</td>
                  <td>Apakah pasien tampak kurus?</td>
                  <td>
                      <?php echo $model->skrinninggizi_jwb_tampakkurus; ?>
                  </td>
                  <td>
                      <?php echo $model->skrinninggizi_skor_tampakkurus; ?>
                  </td>
              </tr>
              <tr>
                  <td>2</td>
                  <td>Apakah terdapat penurunan BB selama 1 bulan terakhir? <br/>(Berdasarkan penilaian objektif)</td>
                  <td>
                      <?php echo $model->skrinninggizi_jwb_penurunanbb; ?>
                  </td>
                  <td>
                      <?php echo $model->skrinninggizi_skor_penurunanbb; ?>
                  </td>
              </tr>
              <tr>
                  <td>3</td>
                  <td>Apakah terdapat salah satu kodisi tersebut?<br/>
                      a. Diare ≥ 5 kali/hari dan atau muntah > 3 kali/hari dalam seminggu terakhir <br />
                      b. Asupan Makanan kurang selama 1 minggu terakhir
                  </td>
                  <td>
                      <?php echo $model->skrinninggizi_jwb_kondisi; ?>
                  </td>
                  <td>
                      <?php echo $model->skrinninggizi_skor_kondisi; ?>
                  </td>
              </tr>
              <tr>
                  <td>4</td>
                  <td>Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien beresiko malnutrisi dan sudah malnutrisi? (Gizi Buruk)</td>
                  <td>
                      <?php echo $model->skrinninggizi_jwb_penyakit; ?>
                  </td>
                  <td>
                      <?php echo $model->skrinninggizi_skor_penyakit; ?>
                  </td>
              </tr>
              <tr>
                  <td colspan="3" style="text-align: center;">Total Skor</td>
                  <td> <?php echo $model->skrinninggizi_skor_totalanak; ?> </td>
              </tr>
          </table>
        <?php } ?>
      </div>
  </div>

</div>

<div class="pageDetail" id="pageDetail_5">
  <div style="text-align: right; font-weight: bold; color: black">
    FRM/73D Rev 01/RSBM
  </div>
  <br/>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Pemeriksaan Fisik (Body System)</strong></div>
     </div>
      <div class="panel-body">

        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title"><strong>B1 (Breathing)/ Pernapasan</strong></div>
           </div>
            <div class="panel-body">
              <table width="100%" class="tablefont">
                  <tr>
                      <td width="200px">RR</td>
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
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title"><strong>B2 (Blood) Cardiovasculer</strong></div>
           </div>
            <div class="panel-body">
              <table width="100%" class="tablefont">
                  <tr>
                      <td width="200px">Tensi</td>
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
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title"><strong>B3 (Brain) Persarafan</strong></div>
           </div>
            <div class="panel-body">
              <table width="100%" class="tablefont">
                  <tr>
                      <td width="200px">Kesadaran</td>
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
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title"><strong>B4 (Bleader) Perkemihan/ Eliminasi Urin</strong></div>
           </div>
            <div class="panel-body">
              <table width="100%" class="tablefont">
                  <tr>
                      <td width="200px">BAK</td>
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
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title"><strong>B5 (Bowel) Pencernaan/ Eliminasi Alvi</strong></div>
           </div>
            <div class="panel-body">
              <table width="100%" class="tablefont">
                  <tr>
                      <td width="200px">Nafsu Makan</td>
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
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title"><strong>B6 (Bonel) Tulang, Otot dan Integumen</strong></div>
           </div>
            <div class="panel-body">
              <table width="100%" class="tablefont">
                  <tr>
                      <td width="200px">Suhu Tubuh</td>
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
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
           <div class="panel-heading">
               <div class="panel-title"><strong>Psikososial Spiritual</strong></div>
           </div>
            <div class="panel-body">
              <table width="100%" class="tablefont">
                  <tr>
                      <td width="200px">Taat Beribadah</td>
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
                  <tr>
                      <td valign="top">Gangguan Orientasi terhadap</td>
                      <td valign="top">:</td>
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
            </div>
        </div>
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
    if(index > 5){

    }else{
      index += 1;
    }
    tabPager(index);
  }

  function tabPager(index){
    window.scrollTo(0, 0);
    $('#pagerdata').val(index);
    $('.previous').show();
    $('.next').show();
    $('.pageDetail').hide();
    $('#pageDetail_'+index).show();

    if(index==1){
      $('.previous').hide();
    }else if(index==5){
      $('.next').hide();
    }
  }

$(document).ready(function(){
  tabPager(1);
});

</script>
