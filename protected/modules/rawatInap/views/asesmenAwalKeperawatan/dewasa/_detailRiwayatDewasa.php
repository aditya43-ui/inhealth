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
    FRM/73A Rev 01/RSBM
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
                              , jumlah anak <?php echo $model->jml_anak; ?>
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
         <div class="panel-title"><strong>KEBUTUHAN KOMUNIKASI/ PENDIDIKAN DAN PENGAJARAN</strong></div>
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
         <div class="panel-title"><strong>RIWAYAT OPERASI, RIWAYAT TRANSFUSI DAN RIWAYAT PENYAKIT DALAM KELUARGA</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="150px" valign="top">Riwayat Operasi</td>
                              <td width="5px" valign="top">:</td>
                              <td>
                                <span class="<?php echo ((!empty($model->riwayatpembedahan_status) && ($model->riwayatpembedahan_status=='Tidak Pernah'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                                <br/>
                                <span class="<?php echo ((!empty($model->riwayatpembedahan_status) && ($model->riwayatpembedahan_status=='Pernah'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                                , jenis dan kapan : <?php echo $model->riwayatpembedahan_keterangan; ?>
                              </td>
                          </tr>
                          <tr>
                              <td width="150px" valign="top">Riwayat Transfusi</td>
                              <td width="5px" valign="top">:</td>
                              <td>
                                <!-- riwayattransfusi_status -->
                                <span class="fa fa-square-o"></span> Tidak
                                <br/>
                                <span class="fa fa-square-o"></span> Ya
                                <br/>
                                Reaksi Transfusi :
                              </td>
                          </tr>
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px" valign="top">Riwayat Penyakit dalam Keluarga</td>
                            <td width="5px" valign="top">:</td>
                            <td><?php echo trim($model->riwayatpenyakitkeluarga); ?></td>
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
                  <td width="50%" valign="top">
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
                      </table>
                  </td>
              </tr>
          </table>
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

                       if(count((array)$lookupJenisRisiko) >0 ){
                         $htmlRisiko = "";

                         foreach($lookupJenisRisiko as $i => $look_risiko){
                           $styleRisiko = "";
                           $isRisiko = false;

                           if($i > 0){
                             $styleRisiko = "style='padding-left: 5px'";
                           }

                           if(!empty($model->jenisrisikoinfeksi)){
                             $oriRisiko = json_decode($model->jenisrisikoinfeksi);

                             if(isset($oriRisiko) && count((array)$oriRisiko) > 0){
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

                    if(count((array)$lookupAddtion) >0 ){
                      $htmlAddtion = "";

                      foreach($lookupAddtion as $i => $look_risiko){
                        $styleRisiko = "";
                        $isaddtional_precaution = false;

                        if($i > 0){
                          $styleRisiko = "style='padding-left: 5px'";
                        }

                        if(!empty($model->addtional_precaution)){
                          $oriAddtional = json_decode($model->addtional_precaution);

                          if(isset($oriAddtional) && count((array)$oriAddtional) > 0){
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
</div>

<div class="pageDetail" id="pageDetail_2">
  <div style="text-align: right; font-weight: bold; color: black">
  FRM/73A Rev 01/RSBM
  </div>
  <br/>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>PENILAIAN RESIKO JATUH</strong></div>
     </div>
      <div class="panel-body">
        <?php if($model->jenisresikojatuh == 'dewasa'){ ?>
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
                                <?php echo  $model->caraberjalan_penilaian; ?>
                            </td>
                            <td><?php echo $model->caraberjalan_skor; ?></td>
                        </tr>
                         <tr>
                            <td>6</td>
                            <td>Status Mental</td>
                            <td>
                                <?php echo  $model->statusmental_penilaian; ?>
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
        <?php } else if($model->jenisresikojatuh == 'lansia'){ ?>
          <div class="panel panel-default panel-shadow">
             <div class="panel-heading">
                 <div class="panel-title"><strong>Skrinning Resiko Lansia (Sidney Scoring)</strong></div>
             </div>
            <div class="panel-body">
              <table class="items table table-bordered">
                  <thead>
                      <tr>
                          <th style="width: 10px">No</th>
                          <th style="width: 200px">Parameter</th>
                          <th>Skrining</th>
                          <th style="width: 80px">Jawaban</th>
                          <th colspan="2" style="width: 50px">Skor</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td rowspan="2">1</td>
                          <td rowspan="2">Riwayat jatuh</td>
                          <td>Apakah pasien datang kerumah sakit karena jatuh?</td>
                          <td>
                              <?php echo (($model->skor_resiko_jatuh_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                          <td rowspan="2"><?php echo $model->skor_resiko_jatuh_lansia; ?></td>
                      </tr>
                      <tr>
                          <td>Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan</td>
                          <td>
                              <?php echo  (($model->skor_resiko_jatuh_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                      </tr>
                       <tr>
                          <td rowspan="3">2</td>
                          <td rowspan="3">Status Mental</td>
                          <td>Apakah pasien delirium? (tidak membuat keputusan, pola piker tidak terorganisir, gangguan daya ingat)</td>
                          <td>
                              <?php echo (($model->skor_status_mental_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                          <td rowspan="3"><?php echo $model->skor_status_mental_lansia; ?></td>
                      </tr>
                       <tr>
                          <td>Apakah pasien disorientasi? (salah menyebut waktu, tempat atau orang)</td>
                          <td>
                              <?php echo (($model->skor_status_mental_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                      </tr>
                       <tr>
                          <td>Apakah pasien mengalami agitasi? (ketakutan, kecemasan, gelisah)</td>
                          <td>
                              <?php echo (($model->skor_status_mental_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                      </tr>
                       <tr>
                          <td rowspan="3">3</td>
                          <td rowspan="3">Penglihatan</td>
                          <td>Apakah pasien memakai kaca mata?</td>
                          <td>
                              <?php echo (($model->skor_penglihatan_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                          <td rowspan="3"><?php echo $model->skor_penglihatan_lansia; ?></td>
                      </tr>
                       <tr>
                          <td>Apakah pasien mengeluhkan penglihatan buram?</td>
                          <td>
                              <?php echo (($model->skor_penglihatan_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Apakah pasien mengalami glaucoma, katarak, degenerasi macula?</td>
                          <td>
                              <?php echo (($model->skor_penglihatan_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                      </tr>
                      <tr>
                          <td>4</td>
                          <td>Kebiasaan berkemih</td>
                          <td>Apakah terdapat perubahan prilaku berkemih? (frekuensi, urgensi, inkotenensia, nokturia)</td>
                          <td>
                            <?php echo (($model->skor_berkemih_lansia > 0)?"Ya":"Tidak"); ?>
                          </td>
                          <td><?php echo $model->skor_berkemih_lansia; ?></td>
                      </tr>
                      <tr>
                          <td>5</td>
                          <td>Transfer (dari tempat tidur ke kursi dan kembali ke tempat tidur)</td>
                          <td colspan="2">
                              <?php echo  $model->transfer_mobilitas_lansia; ?>
                          </td>
                          <td rowspan="2"><?php echo $model->skor_transfer_mobilitas_lansia; ?></td>
                      </tr>
                      <tr>
                          <td>6</td>
                          <td>Mobilitas</td>
                          <td colspan="2">
                              <?php echo  $model->mobilitas_lansia; ?>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="4">Total Skor</td>
                          <td> <?php echo $model->jumlah_skor_lansia; ?> </td>
                      </tr>
                      <tr>
                          <td colspan="2">Pasien termasuk kategori risiko jatuh : </td>
                          <td colspan="2"> <?php echo $model->keterangan_skor_lansia; ?> </td>
                      </tr>
                  </tbody>
              </table>
            </div>
        </div>
        <?php } ?>

      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>SKRINING STATUS FUNGSIONAL</strong></div>
     </div>
      <div class="panel-body">
        <?php if($model->jenis_statusfungsional == 'jenis_fungsionaladl'){ ?>
          <table width="100%">
              <tr>
                <td>
                  <table width="100%" class="tablefont">
                    <tr>
                      <td width="120px">
                        Perawat Pengisi :
                      </td>
                      <td>
                        <?php echo (isset($modBarthelindexadlT->perawat)?$modBarthelindexadlT->perawat->namaLengkap:"-") ?>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
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

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>PENILAIAN NYERI</strong></div>
     </div>
      <div class="panel-body">
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
                      <table class="items table table-bordered table-striped table-condensed">
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
                echo $this->renderPartial($this->path_view.'_formAsesmenDewasaDetail', array(
                    'model' => $model
                        ), true);
                ?>
              </td>
            </tr>
          </table>
        <?php } ?>

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
      </div>
  </div>

</div>
<div class="pageDetail" id="pageDetail_3">
  <div style="text-align: right; font-weight: bold; color: black">
    FRM/73A Rev 01/RSBM
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
    if(index > 3){

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
    }else if(index==3){
      $('.next').hide();
    }
  }

$(document).ready(function(){
  tabPager(1);
});

</script>
