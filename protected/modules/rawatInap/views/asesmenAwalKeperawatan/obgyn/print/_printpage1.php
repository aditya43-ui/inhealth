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
          DATA AWAL (diisi oleh Perawat)
      </td>
      <td width="50%" class="textright borderleftclass borderrightclass">
          Tgl : <?php echo date('d',strtotime($model->tgl_assesmen_awal)).' '.MyFormatter::getMonthId(date('m',strtotime($model->tgl_assesmen_awal))).' '.date('Y',strtotime($model->tgl_assesmen_awal)); ?>
          Jam : <?php echo date('H:i:s',strtotime($model->tgl_assesmen_awal)); ?> WIB
       </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
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
                    <tr>
                        <td>Jam Masuk Ruangan</td>
                        <td>:</td>
                        <td><?php echo $model->jam_masukruangan; ?> WIB</td>
                    </tr>
                    <tr>
                        <td>Dokter Pemeriksaan</td>
                        <td>:</td>
                        <td><?php echo $model->dokterpemeriksa->namaLengkap; ?></td>
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
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
          PSIKOLOGIS-SOSIAL-SPRITUAL
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
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
                <td valign="top">Tinggal Bersama</td>
                <td valign="top">:</td>
                <td>
                  <?php echo $model->neonatus_tinggalbersama; ?>
                  <br/>
                  Nama Pihak Lainnya : <?php echo $model->neonatus_tinggalbersamalainnya_nama; ?>
                  <br/>
                  No. Telp Pihak Lainnya : <?php echo $model->neonatus_tinggalbersamalainnya_notlp; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">Kebiasaan</td>
                <td valign="top">:</td>
                <td>
                  <table>
                    <tr>
                      <td width="150px">Status Merokok :</td>
                      <td>
                        <?php echo ($model->statusmerokok==1)?"Ya":"Tidak"; ?>
                      </td>
                      <td width="150px">Alkohol</td>
                      <td>
                        : <?php echo ($model->neonatus_kebiasaanortualkohol_status==true)?"Ya":"Tidak"; ?>
                      </td>
                      <td width="150px">Kebisaan Lainnya</td>
                      <td>
                        : <?php echo $model->neonatus_kebiasaanortulainnya; ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">Jumlah Rokok Batangan : <?php echo $model->jmlrokok_btg_hr; ?> Per Hari</td>
                      <td width="150px">Jenis & Jumlah Alkohol yang dikomsumsi</td>
                      <td>
                        : <?php echo $model->neonatus_kebiasaanortualkohol_jenis.' / '.$model->neonatus_kebiasaanortualkohol_jml; ?> Gelas Per Hari
                      </td>
                    </tr>
                  </table>

                  <br/>

                </td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?php echo $model->neonatus_agamaortu; ?></td>
            </tr>
            <tr>
                <td>Masalah dalam berbicara</td>
                <td>:</td>
                <td>
                  <span class="<?php echo ((!empty($model->masalahdlm_berbicara) && ($model->masalahdlm_berbicara =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                  <span style="padding-left: 5px" class="<?php echo ((!empty($model->masalahdlm_berbicara) && ($model->masalahdlm_berbicara =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                  , Jelaskan : <?php echo $model->masalahbicara_ket; ?>
                </td>
            </tr>
            <tr>
                <td>Bahasa sehari-hari</td>
                <td>:</td>
                <td>
                  <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->bahasaseharihari_jenis =="Indonesia")?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bahasa Indonesia
                  <span style="padding-left: 5px" class="<?php echo (($modAsesmenkebutuhanEdukasiT->bahasaseharihari_jenis =="Daerah")?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bahasa Daerah
                  <br/>
                  <span style="padding-left: 150px"></span>Jenis Bahasa Daerah : <?php echo $modAsesmenkebutuhanEdukasiT->bahasadaerah_nama; ?>
                </td>
            </tr>
            <tr>
                <td>Perlu Penerjemah</td>
                <td>:</td>
                <td>
                  <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status) && ($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                  <span style="padding-left: 5px" class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status) && ($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                  , <?php echo $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa; ?>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        EKONIMI
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
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
                      <td width="180px">Pembiayaan Kesehatan</td>
                      <td width="5px">:</td>
                      <td><?php echo (isset($modPendaftaran->carabayar)? $modPendaftaran->carabayar->carabayar_nama:""); ?></td>
                  </tr>
                </table>
              </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        KEBUTUHAN KOMUNIKASI/ PENDIDIKAN DAN PENGAJARAN
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
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
                      <!-- <tr>
                          <td width="220px" valign="top">Diagnosa Medis saat ini</td>
                          <td width="5px" valign="top">:</td>
                          <td><?php //echo trim($model->diagnosa_utama); ?></td>
                      </tr> -->
                      <tr>
                          <td>Riwayat Keluhan Penyakit saat ini</td>
                          <td>:</td>
                          <td><?php echo trim($model->riwayatperjalanan_penyakitpasien); ?></td>
                      </tr>
                    </table>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        RIWAYAT ALERGI
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
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
                        <tr>
                            <td colspan="2">Bila Ada: </td>
                        </tr>
                        <tr>
                            <td width="180px">Riwayat Alergi Obat</td>
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
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        RIWAYAT OPERASI, RIWAYAT TRANSFUSI DAN RIWAYAT PENYAKIT DALAM KELUARGA
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
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
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td valign="top" width="150px">Kesadaran</td>
                            <td valign="top" width="5px">:</td>
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
                            <td><?php echo $model->detaknadi; ?> X/Menit</td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px">Suhu</td>
                          <td width="5px">:</td>
                          <td><?php echo (!empty($model->suhutubuh)?number_format($model->suhutubuh,2):"-"); ?> &#176; Celcius</td>
                      </tr>
                      <tr>
                          <td>Pernapasan</td>
                          <td>:</td>
                          <td>
                              <?php echo (!empty($model->pernapasan)?number_format($model->pernapasan,2):"-"); ?> X/Menit
                          </td>
                      </tr>
                      <tr>
                          <td>Detak Jantung</td>
                          <td>:</td>
                          <td><?php echo $model->denyutjantung; ?></td>
                      </tr>
                        <tr>
                            <td>Kelainan pada Bag. Tubuh</td>
                            <td>:</td>
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
      </td>
    </tr>
    <!-- <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        Kontrol Risiko Infeksi
      </td>
    </tr> -->
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%" class="tablefont">
            <!-- <tr>
                <td width="100px">Status</td>
                <td width="5px">:</td>
                <td>
                  <span class="<?php //echo ((!empty($model->kontrolrisikoinfeksi_status ) && ($model->kontrolrisikoinfeksi_status =='Tidak Diketahui'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Diketahui
                  <span style="padding-left: 5px" class="<?php //echo ((!empty($model->kontrolrisikoinfeksi_status ) && ($model->kontrolrisikoinfeksi_status =='Suspect'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Suspect
                  <span style="padding-left: 5px" class="<?php //echo ((!empty($model->kontrolrisikoinfeksi_status ) && ($model->kontrolrisikoinfeksi_status =='Diketahui'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Diketahui :
                  <?php
                      //  $lookupJenisRisiko = LookupM::model()->findAll("lookup_type = 'jenisrisikoinfeksi'");

                      //  if(count((array)$lookupJenisRisiko) >0 ){
                      //    $htmlRisiko = "";

                      //    foreach($lookupJenisRisiko as $i => $look_risiko){
                      //      $styleRisiko = "";
                      //      $isRisiko = false;

                      //      if($i > 0){
                      //        $styleRisiko = "style='padding-left: 5px'";
                      //      }

                      //      if(!empty($model->jenisrisikoinfeksi)){
                      //        $oriRisiko = json_decode($model->jenisrisikoinfeksi);

                      //        if(isset($oriRisiko) && count((array)$oriRisiko) > 0){
                      //          foreach ($oriRisiko as $propRisiko) {
                      //            if($propRisiko == $look_risiko->lookup_value){
                      //              $isRisiko = true;
                      //            }
                      //          }
                      //        }
                      //      }

                      //      if($look_risiko->lookup_value == 'Lainnya'){
                      //        $htmlRisiko .= "<span ".$styleRisiko." class='".(($isRisiko==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                      //        $htmlRisiko .= ", ".$model->jenisrisikoinfeksi_lainnya;
                      //      }else{
                      //        $htmlRisiko .= "<span ".$styleRisiko." class='".(($isRisiko==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                      //      }
                      //    }
                      //    echo $htmlRisiko;
                      //  }
                   ?>
                </td>
            </tr> -->
          </table>
          <table width="100%" class="tablefont">
            <tr>
                <td width="300px">Addtional Precaution yang harus dilakukan</td>
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
      </td>
    </tr>
</table>
