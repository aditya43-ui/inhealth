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
<?php echo '<p style="text-align:center;"><b>PENGKAJIAN AWAL KEPERAWATAN</b></p>'; ?>
<?php echo '<p style="text-align:center;">(Dilengkapi dalam waktu 24 jam pertama pasien masuk rawat inap)</p>'; ?>
<table width="100%">
  <tr>
      <td width="50%" class="textbold padding5 bordertopclass borderleftclass borderrightclass">
          DATA AWAL (diisi oleh Perawat)
      </td>
      <td width="50%" class="textright bordertopclass borderleftclass borderrightclass">
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
                        <td width="200px" valign="top">Sumber Data</td>
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
          DATA UMUM
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="150px" valign="top">Tiba di ruangan dengan cara</td>
                        <td width="5px" valign="top">:</td>
                        <td>
                          <?php
                            $look_catatandiruangan = LookupM::model()->findAllByAttributes(array('lookup_type'=>'caratibadiruangan'),array('order'=>'lookup_urutan ASC'));

                            if(count((array)$look_catatandiruangan) > 0){
                              $html_catatandiruangan = "";

                              foreach ($look_catatandiruangan as $i => $look) {
                                $isCheck = false;
                                if($i > 0){
                                  $html_catatandiruangan .= "<br/>";
                                }
                                if($look->lookup_value == $model->caratibadiruangan){
                                  $isCheck = true;
                                }
                                $html_catatandiruangan .= "<span class='".(($isCheck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                              }
                              echo $html_catatandiruangan; 
                            }
                        ?></td>
                    </tr>
                    <tr>
                        <td>Rujukan</td>
                        <td>:</td>
                        <td><?php echo $rujukan; ?></td>
                    </tr>
                    <tr>
                        <td>Dx Rujukan</td>
                        <td>:</td>
                        <td><?php echo $diagnosarujukan; ?></td>
                    </tr>
                    <tr>
                        <td>Pembiayaan Kesehatan</td>
                        <td>:</td>
                        <td><?php echo (isset($modPendaftaran->carabayar)? $modPendaftaran->carabayar->carabayar_nama:""); ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td><?php echo $model->neonatus_pekerjaanortu; ?></td>
                    </tr>
                    <tr>
                        <td>Kegiatan Sekarang</td>
                        <td>:</td>
                        <td><?php echo $modPasienAdmisi->kamarruangan->kamarruangan_nokamar.'/ '.$modPasienAdmisi->kamarruangan->kamarruangan_nobed; ?></td>
                    </tr>
                  </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="150px">Nama Orang Terdekat</td>
                        <td width="5px">:</td>
                        <td><?php echo $modAskepgeriatriT->orangterdekat_nama; ?></td>
                    </tr>
                    <tr>
                        <td>Orang yang tinggal serumah</td>
                        <td>:</td>
                        <td><?php echo $modAskepgeriatriT->orangygtinggal_serumah; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Jumlah Anak</td>
                        <td valign="top">:</td>
                        <td>
                          <?php echo $modAskepgeriatriT->jmlanak_seluruh; ?> Orang<br/>
                          Laki-laki : <?php echo $modAskepgeriatriT->jmlanak_lakilaki; ?> Orang<br/>
                          Perempuan : <?php echo $modAskepgeriatriT->jmlanak_perempuan; ?> Orang
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Jumlah Cucu</td>
                        <td valign="top">:</td>
                        <td>
                          <?php echo $modAskepgeriatriT->jmlcucu_seluruh; ?> Orang<br/>
                          Laki-laki : <?php echo $modAskepgeriatriT->jmlcucu_lakilaki; ?> Orang<br/>
                          Perempuan : <?php echo $modAskepgeriatriT->jmlcucu_perempuan; ?> Orang
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Jumlah Cicit</td>
                        <td valign="top">:</td>
                        <td>
                          <?php echo $modAskepgeriatriT->jmlcicit_seluruh; ?> Orang<br/>
                          Laki-laki : <?php echo $modAskepgeriatriT->jmlcicit_lakilaki; ?> Orang<br/>
                          Perempuan : <?php echo $modAskepgeriatriT->jmlcicit_perempuan; ?> Orang
                        </td>
                    </tr>
                  </table>
                </td>
            </tr>
        </table>

      </td>
    </tr>
</table>
