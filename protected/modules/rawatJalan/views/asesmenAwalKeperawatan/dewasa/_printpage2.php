<table width="100%">
  <tr>
    <td class="textbold padding5 borderclass">
        PSIKOLOGI-SOSIAL-SPIRITUAL
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      <table width="100%">
          <tr>
              <td width="50%">
                  <table width="100%" class="tablefont">
                      <tr>
                          <td width="180px">Status Pernikahan</td>
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
                          <td>Status Merokok</td>
                          <td>:</td>
                          <td>
                            <table width="100%">
                              <tr>
                                <td width="30%">
                                  <table width="100%">
                                    <tr>
                                      <td width="100px">Status Merokok</td>
                                      <td>:</td>
                                      <td><?php echo (($model->statusmerokok==true)?"Ya":"Tidak"); ?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3">
                                        Jumlah Rokok Batangan : <?php echo $model->jmlrokok_btg_hr; ?> Per Hari
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td width="35%">
                                  <table width="100%">
                                    <tr>
                                      <td  width="150px">Alkohol</td>
                                      <td>:</td>
                                      <td><?php echo $model->neonatus_kebiasaanortualkohol_status; ?></td>
                                    </tr>
                                    <tr>
                                      <td>Jenis & Jumlah Alkohol yang dikonsumsi</td>
                                      <td>:</td>
                                      <td><?php echo $model->neonatus_kebiasaanortualkohol_jenis.' / '.$model->neonatus_kebiasaanortualkohol_jml; ?> Gelas Per Hari</td>
                                    </tr>
                                  </table>
                                </td>
                                <td width="35%">
                                  <table width="100%">
                                    <tr>
                                      <td width="150px">Kebiasaan Lainnya</td>
                                      <td>:</td>
                                      <td><?php echo $model->neonatus_kebiasaanortulainnya; ?></td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
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
                            <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->bahasaseharihari_jenis ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bahasa Indonesia
                            <span style="padding-left: 5px" class="<?php echo (($modAsesmenkebutuhanEdukasiT->bahasaseharihari_jenis ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bahasa Daerah
                             <br/><span style="padding-left: 160px"></span>Jenis Bahasa Daerah : <?php echo $modAsesmenkebutuhanEdukasiT->bahasadaerah_nama; ?>
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
      </table>
    </td>
  </tr>
  <tr>
    <td class="textbold padding5 borderclass">
        EKONOMI
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      <table width="100%" class="tablefont">
        <tr>
            <td width="200px">Pekerjaan</td>
            <td width="5px">:</td>
            <td><?php echo $model->neonatus_pekerjaanortu; ?></td>
        </tr>
        <tr>
            <td>Pembiayaan Kesehatan</td>
            <td>:</td>
            <td><?php echo (isset($modPendaftaran->carabayar)? $modPendaftaran->carabayar->carabayar_nama:""); ?></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="textbold padding5 borderclass">
        KEBUTUHAN KOMUNIKASI/ PENDIDIKAN DAN PENGAJARAN
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
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
    </td>
  </tr>
  <tr>
    <td style="height:30px;">
        
    </td>
  </tr>
  <tr>
    <td class="textbold padding5 borderclass">
        NUTRISI
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      <table width="100%">
          <tr>
              <td width="50%" valign="top">
                <table class="tableBorder" width="100%">
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
                        <td colspan="3" style="text-align: center;">Catatan : Skor 4-5 dilakukan pengkajian lanjut oleh ahli gizi</td>
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
    </td>
  </tr>
  <tr>
    <td class="textbold padding5 borderclass">
        SKRINING STATUS FUNGSIONAL
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      <table width="100%">
          <tr>
              <td width="60%">
                  <table class="tableBorder" width="100%">
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
                  <table class="tableBorder" width="100%">
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
    </td>
  </tr>
  <tr>
    <td class="textbold padding5 borderclass">
        ASUHAN KEPERAWATAN
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      <table width="100%">
        <tr>
            <td width="35%">
              <table width="100%" class="tablefont">
                <tr>
                  <td>
                    Masalah Keperawatan :
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
                    Rencana Keperawatan :
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
                    Tindakan Keperawatan :
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
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
        Verifikasi Pasien :
    </td>
  </tr>
  <tr>
    <td class="borderclass">
        <table width="100%">
          <tr>
            <td width="50%" class="borderrightclass" valign="top">
              <center>
                Tanda Tangan Pasien/ Keluarga
                <br/><br/><br/><br/><br/>
                <?php echo $model->namapasien_verifikator; ?>
              </center>
            </td>
            <td width="50%"  valign="top">
              <center>
                Tanda Tangan Perawat/ Bidan
                <br/><br/><br/><br/><br/>
                <?php echo $model->paramedis_nama; ?>
              </center>
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
