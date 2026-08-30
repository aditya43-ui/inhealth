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
<div style="text-align: right; font-weight: bold; color: black">
  FRM/1/RSSACPT
</div>
<br/>
<div class="pageDetail" id="pageDetail_1">

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
                    <tr>
                        <td valign="top">Tiba di ruangan dengan cara</td>
                        <td valign="top">:</td>
                        <td>
                          <?php
                            $look_catatandiruangan = LookupM::model()->findAllByAttributes(array('lookup_type'=>'caratibadiruangan'),array('order'=>'lookup_urutan ASC'));

                            if(count($look_catatandiruangan) > 0){
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
                            }
                        echo !empty($html_catatandiruangan) ? $html_catatandiruangan : "" ; ?></td>
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
                    <tr>
                        <td>Nama Orang Terdekat</td>
                        <td>:</td>
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
         <div class="panel-title"><strong>RIWAYAT OPERASI, RIWAYAT TRANSFUSI, RIWAYAT PENYAKIT DALAM KELUARGA DAN RIWAYAT PENYAKIT TERDAHULU</strong></div>
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
                        <tr>
                            <td width="150px" valign="top">Riwayat Penyakit terdahulu</td>
                            <td width="5px" valign="top">:</td>
                            <td><?php echo trim($model->riwayatpenyakitterdahulu); ?></td>
                        </tr>
                      </table>
                  </td>
              </tr>
          </table>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>KEADAAN UMUM & TANDA VITAL</strong></div>
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
                              <td>Keadaan Umum</td>
                              <td>:</td>
                              <td><?php echo $model->kondisiumum; ?></td>
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

</div>

<div class="pageDetail" id="pageDetail_2">
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Pemeriksaan Fisik</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%" class="tablefont">
            <tr>
                <td width="200px">Kulit</td>
                <td width="10px">:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_kulit; ?></td>
            </tr>
            <tr>
                <td>Penglihatan</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_penglihatan; ?></td>
            </tr>
            <tr>
                <td>Pendengaran</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_pendengaran; ?></td>
            </tr>
            <tr>
                <td>Mulut, Sendi Rahang  dan Gigi</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_mulutrahang_gigi; ?></td>
            </tr>
            <tr>
                <td>Leher</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_leher; ?></td>
            </tr>
            <tr>
                <td colspan="3"><u>Dada</u></td>
            </tr>
            <tr>
                <td valign="top">Jantung</td>
                <td valign="top">:</td>
                <td>
                  Inspeksi : <?php echo $modAskepgeriatriT->periksafisik_jantung_inspeksi; ?><br/>
                  Palpasi : <?php echo $modAskepgeriatriT->periksafisik_jantung_palpasi; ?><br/>
                  Perkusi : <?php echo $modAskepgeriatriT->periksafisik_jantung_perkusi; ?><br/>
                  Auskultasi : <?php echo $modAskepgeriatriT->periksafisik_jantung_auskultasi; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">Paru</td>
                <td valign="top">:</td>
                <td>
                  Inspeksi : <?php echo $modAskepgeriatriT->periksafisik_paru_inspeksi; ?><br/>
                  Palpasi : <?php echo $modAskepgeriatriT->periksafisik_paru_palpasi; ?><br/>
                  Perkusi : <?php echo $modAskepgeriatriT->periksafisik_paru_perkusi; ?><br/>
                  Auskultasi : <?php echo $modAskepgeriatriT->periksafisik_paru_auskultasi; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><u>Abdomen</u></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top"></td>
                <td>
                  Inspeksi : <?php echo $modAskepgeriatriT->periksafisik_abdomen_inspeksi; ?><br/>
                  Palpasi : <?php echo $modAskepgeriatriT->periksafisik_abdomen_palpasi; ?><br/>
                  Perkusi : <?php echo $modAskepgeriatriT->periksafisik_abdomen_perkusi; ?><br/>
                  Auskultasi : <?php echo $modAskepgeriatriT->periksafisik_abdomen_auskultasi; ?>
                </td>
            </tr>
            <tr>
                <td>Muskuloskeletal</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_muskuloskeletal; ?></td>
            </tr>
        </table>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Pemeriksaan Penunjang</strong></div>
     </div>
      <div class="panel-body">
        <table class="items table table-bordered">
          <thead>
              <tr>
                  <th style="width: 150px">Jenis Penunjang</th>
                  <th>Jenis Pemeriksaan/<br/>Nama Pemeriksaan</th>
                  <th style="width: 150px">Hasil</th>
              </tr>
          </thead>
          <tbody>
              <?php
                $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruanganasal_id'=>$modPendaftaran->ruangan_id),array('condition'=>'ruangan_id in (53,56)'));
                //

                if(count($modPasienMasukPenunjang) > 0){
                  foreach($modPasienMasukPenunjang as $dataPenunjang){
                    $jnspemeriksaanLab = "";
                    $pemeriksaanLab = "";
                    $hslLab = "";

                    if($dataPenunjang->ruangan_id == 53){
                      $criteriaLab = new CDbCriteria();
                      $criteriaLab->select = "jnspmlab.jenispemeriksaanlab_id, jnspmlab.jenispemeriksaanlab_nama, pmlab.pemeriksaanlab_nama, detlab.hasilpemeriksaan, detlab.hasilpemeriksaan_satuan";
                      $criteriaLab->join = "JOIN detailhasilpemeriksaanlab_t detlab on detlab.hasilpemeriksaanlab_id = t.hasilpemeriksaanlab_id
                      JOIN pemeriksaanlab_m pmlab on pmlab.pemeriksaanlab_id = detlab.pemeriksaanlab_id
                      JOIN jenispemeriksaanlab_m jnspmlab on jnspmlab.jenispemeriksaanlab_id = pmlab.jenispemeriksaanlab_id";
                      $criteriaLab->addCondition('t.pasienmasukpenunjang_id = '.$dataPenunjang->pasienmasukpenunjang_id);//.$dataPenunjang->pasienmasukpenunjang_id
                      $modHasilLab = HasilpemeriksaanlabT::model()->findAll($criteriaLab);

                      if(count($modHasilLab)>0){
                        $hasilpemeriksaanLab = array();
                        foreach($modHasilLab as $o=> $detailLab){
                          $hasilpemeriksaanLab[$detailLab->jenispemeriksaanlab_id]=array('jenispemeriksaan_nama'=>$detailLab->jenispemeriksaanlab_nama,'detail'=>array());
                          $hasilpemeriksaanLab[$detailLab->jenispemeriksaanlab_id]['detail'][]=array('pemeriksaan_nama'=>$detailLab->pemeriksaanlab_nama);
                          if($o > 0){
                            $hslLab .= "<br/>";
                          }
                          $hslLab .= $detailLab->hasilpemeriksaan." ".$detailLab->hasilpemeriksaan_satuan;
                        }

                        if(count($hasilpemeriksaanLab) > 0){
                          foreach($hasilpemeriksaanLab as $i => $hsLab){
                            $pemeriksaanLab = "";
                            if($i > 0){
                                $jnspemeriksaanLab .= "<br/>";
                            }
                            $jnspemeriksaanLab .= $hsLab['jenispemeriksaan_nama'];

                            if(count($hsLab['detail'])>0){
                              $nourut = 1;
                              foreach($hsLab['detail'] as $j => $detailLabHs){
                                if($j > 0){
                                    $pemeriksaanLab .= "<br/>";
                                }
                                $pemeriksaanLab .= $nourut.'. '.$detailLabHs['pemeriksaan_nama'];
                                $nourut++;
                              }
                            }
                          }
                        }
                      }
                    }else if($dataPenunjang->ruangan_id == 56){
                      $criteriaLab = new CDbCriteria();
                      $criteriaLab->select = "jnspmlab.jenispemeriksaanrad_id, jnspmlab.jenispemeriksaanrad_nama, pmlab.pemeriksaanrad_nama, t.hasilexpertise, t.kesan_hasilrad, t.kesimpulan_hasilrad";
                      $criteriaLab->join = "JOIN pemeriksaanrad_m pmlab on pmlab.pemeriksaanrad_id = t.pemeriksaanrad_id
                      JOIN jenispemeriksaanrad_m jnspmlab on jnspmlab.jenispemeriksaanrad_id = pmlab.jenispemeriksaanrad_id";
                      $criteriaLab->addCondition('t.pasienmasukpenunjang_id = '.$dataPenunjang->pasienmasukpenunjang_id);
                      $modHasilLab = HasilpemeriksaanradT::model()->findAll($criteriaLab);

                      if(count($modHasilLab)>0){
                        $hasilpemeriksaanLab = array();
                        foreach($modHasilLab as $o=> $detailLab){
                          $hasilpemeriksaanLab[$detailLab->jenispemeriksaanrad_id]=array('jenispemeriksaanrad_nama'=>$detailLab->jenispemeriksaanrad_nama,'detail'=>array());
                          $hasilpemeriksaanLab[$detailLab->jenispemeriksaanrad_id]['detail'][]=array('pemeriksaan_nama'=>$detailLab->pemeriksaanrad_nama);
                          if($o > 0){
                            $hslLab .= "<br/>";
                          }
                          $hslLab .= 'Pemeriksaan dari Hasil Expertise : '.$detailLab->hasilexpertise."<br/> Kesan Hasil Radiologi : ".$detailLab->kesan_hasilrad."<br/> Kesimpulan : ".$detailLab->kesimpulan_hasilrad;
                        }

                        if(count($hasilpemeriksaanLab) > 0){
                          foreach($hasilpemeriksaanLab as $i => $hsLab){
                            $pemeriksaanLab = "";
                            if($i > 0){
                                $jnspemeriksaanLab .= "<br/>";
                            }
                            $jnspemeriksaanLab .= $hsLab['jenispemeriksaanrad_nama'];

                            if(count($hsLab['detail'])>0){
                              $nourut = 1;
                              foreach($hsLab['detail'] as $j => $detailLabHs){
                                if($j > 0){
                                    $pemeriksaanLab .= "<br/>";
                                }
                                $pemeriksaanLab .= $nourut.'. '.$detailLabHs['pemeriksaan_nama'];
                                $nourut++;
                              }
                            }
                          }
                        }
                      }
                    }
                    ?>
                    <tr>
                      <td>
                        <?php
                          $jenispenunjang = "";
                          if($dataPenunjang->ruangan_id == 53){
                            $jenispenunjang = "LABORATORIUM";
                          }else if($dataPenunjang->ruangan_id == 56){
                            $jenispenunjang = "RADIOLOGI";
                          }
                          echo $jenispenunjang;
                         ?>
                      </td>
                      <td>
                        <?php
                          echo $jnspemeriksaanLab.'/<br/>'.$pemeriksaanLab;
                         ?>
                      </td>
                      <td>
                        <?php
                          echo $hslLab;
                         ?>
                      </td>

                    </tr>
                    <?php
                  }
                }
               ?>
          </tbody>
        </table>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Konsep Diri dan Kognitif</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%" class="tablefont">
            <tr>
                <td width="200px">Pengetahuan tentang penyakit saat ini</td>
                <td width="10px">:</td>
                <td>
                  <?php
                    $look_penyakitsekarang = LookupM::model()->findAllByAttributes(array('lookup_type'=>'pengetahuanttg_penyakitsekarang'),array('order'=>'lookup_urutan ASC'));
                    
                    if(count($look_penyakitsekarang) > 0){
                      $html_penyakitsekarang = "";

                      foreach ($look_penyakitsekarang as $i => $look) {
                        $isCheck = false;
                        $style = "";
                        if($i > 0){
                          $style = "style='padding-left: 10px;'";
                        }
                        if($look->lookup_value == $modAskepgeriatriT->pengetahuanttg_penyakitsaatini){
                          $isCheck = true;
                        }
                        $html_penyakitsekarang .= "<span ".$style." class='".(($isCheck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                      }
                    }
                    echo !empty($html_penyakitsekarang) ? $html_penyakitsekarang : ""; ?>
                </td>
            </tr>
            <tr>
                <td>Perawatan/ tindakan yang dilakukan</td>
                <td>:</td>
                <td>
                  <?php
                    $look_perawatan = array(0=>'Mengerti',1=>'Tidak Mengerti');

                    if(count($look_perawatan) > 0){
                      $html_perawatan = "";

                      foreach ($look_perawatan as $i => $look) {
                        $isCheck = false;
                        $style = "";
                        if($i > 0){
                          $style = "style='padding-left: 10px;'";
                        }
                        if($look == $modAskepgeriatriT->pengetahuanttg_perawatan){
                          $isCheck = true;
                        }
                        $html_perawatan .= "<span ".$style." class='".(($isCheck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look;
                      }
                    }
                    echo $html_perawatan; ?>
                </td>
            </tr>
            <tr>
                <td>apakah ada perasaan</td>
                <td>:</td>
                <td>
                  <?php
                    $look_perasaan = LookupM::model()->findAllByAttributes(array('lookup_type'=>'geriatri_memilikiperasaan'),array('order'=>'lookup_urutan ASC'));
                    
                    if(count($look_perasaan) > 0){
                      $html_perasaan = "";

                      foreach ($look_perasaan as $i => $look) {
                        $isCheck = false;
                        $style = "";
                        if($i > 0){
                          $style = "style='padding-left: 10px;'";
                        }
                        if(!empty($modAskepgeriatriT->perasaanyg_dirasakan)){
                          $oriArrPerasaan = json_decode($modAskepgeriatriT->perasaanyg_dirasakan);

                          foreach($oriArrPerasaan as $oriPerasaan){
                            if($look->lookup_value == $oriPerasaan){
                                $isCheck= true;
                            }
                          }
                        }
                        $html_perasaan .= "<span ".$style." class='".(($isCheck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                      }
                    }
                echo !empty($html_perasaan) ? $html_perasaan : ""; ?>
                </td>
            </tr>
        </table>
      </div>
  </div>
</div>

<div class="pageDetail" id="pageDetail_3">
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
                 <div class="panel-title"><strong>Skrinning Resiko Lansia (Ontario Modified-Sidney Scoring)</strong></div>
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
                          <td>Apakah pasien delirium? (tidak dapat membuat keputusan, pola pikir tidak terorganisir, gangguan daya ingat)</td>
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
<div class="pageDetail" id="pageDetail_4">
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Mini Mental State Examination (MMSE)</strong></div>
     </div>
      <div class="panel-body">

        <div class="table-responsive" style="overflow-x:auto;">
          <div class='block-tabel'>
            <?php
            $sumTotalMMSE = 0;
             ?>
             <table class="items table table-bordered">
               <thead>
                   <tr>
                       <th style="text-align: center">Variabel</th>
                       <th style="width: 50px; text-align: center">Nilai Maksimum</th>
                       <th style="width: 200px; text-align: center">Nilai Responden</th>
                       <th style="width: 200px; text-align: center">Keterangan</th>
                   </tr>
               </thead>
               <tbody>
                 <?php
                  $modMinimentalexamMParent = MinimentalexamM::model()->findAllByAttributes(array('isaktif'=>true,'parent_id'=>null),array('order'=>'urutan ASC'));

                  if(count($modMinimentalexamMParent) > 0){
                    $indexNourut = 0;
                    foreach($modMinimentalexamMParent as $dataParent){
                      ?>
                      <tr>
                        <td style="font-weight: bold;">
                          <?php echo $dataParent->variabel; ?>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <?php
                      $modMinimentalexamM = MinimentalexamM::model()->findAllByAttributes(array('isaktif'=>true,'parent_id'=>$dataParent->minimentalexam_id),array('order'=>'urutan ASC'));
                        if(count($modMinimentalexamM) > 0){
                          foreach($modMinimentalexamM as $dataChild){
                            $sumTotalMMSE += $dataChild->nilai_maksimum;
                            $nilairespone = 0;
                            $ket_mmse = "";
                            if(count($modMinimentalexampasienT) > 0){
                              foreach($modMinimentalexampasienT as $dataMiniMentalExP){
                                if($dataMiniMentalExP->minimentalexam_id == $dataChild->minimentalexam_id){
                                  $nilairespone = $dataMiniMentalExP->nilai_responden;
                                  $ket_mmse = $dataMiniMentalExP->keterangan;
                                }
                              }
                            }


                            ?>
                            <tr>
                              <td>
                                <?php
                                    echo $dataChild->variabel;
                                    if($dataChild->isupload_gambar==true && !empty($dataChild->gambar)){
                                      echo '<br/> <img src="'.Params::urlMasterMinimentalexam().$dataChild->gambar.'" />';
                                    }
                                 ?>
                              </td>
                              <td style="text-align: center"><?php echo $dataChild->nilai_maksimum; ?></td>
                              <td style="text-align: center">
                                <?php
                                  if($dataChild->isupload_gambar==true){
                                    echo 'Hasil Gambar : <br/>';
                                    if(count($modMinimentalexampasiendetT)>0){

                                      foreach($modMinimentalexampasiendetT as $k => $dataDetMmseOri){
                                        if($k > 0){
                                          echo '<br/>';
                                        }

                                        if(!empty($dataDetMmseOri->gambar)){
                                            echo '<img src="'.Params::urlMasterMinimentalexam().$dataDetMmseOri->gambar.'" width="60px" height="60px" />';
                                        }
                                      }
                                    }
                                  }else{
                                    echo $nilairespone;
                                  }
                                ?>
                              </td>
                              <td>
                                <?php echo $ket_mmse; ?>
                              </td>
                            </tr>
                            <?php
                            $indexNourut++;
                          }
                        }
                    }
                  }
                  ?>
               </tbody>
               <tfoot>
                 <tr>
                   <td>Total Nilai</td>
                   <td style="text-align: center"><?php echo $sumTotalMMSE; ?></td>
                   <td style="text-align: center"><?php echo $modAskepgeriatriT->minimentalexam_skor; ?></td>
                   <td style="text-align: center"><?php echo $modAskepgeriatriT->minimentalexam_keterangan; ?></td>
                 </tr>
               </tfoot>
             </table>

             <br/>
             <table width="100%">
               <tr>
                 <td>Pedoman Skor Kognitif Global (Secara Umum) : </td>
               </tr>
               <tr>
                 <td>Nilai : 24-30 (Normal)</td>
               </tr>
               <tr>
                 <td>Nilai : 17-23 (Probable Gangguan Kognitif)</td>
               </tr>
               <tr>
                 <td>Nilai : 0-16 (Definite Gangguan Kognitif)</td>
               </tr>
             </table>
           </div>
       </div>

      </div>
  </div>

  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Terapi, Masalah Keperawatan, Rencan Tindak Lanjut</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%" class="tablefont">
          <tr>
              <td colspan="3" style="text-decoration: underline; font-weight: bold;">TERAPI</td>
          </tr>
          <tr>
              <td width="150px" valign="top">Terapi yang diberikan</td>
              <td width="5px" valign="top">:</td>
              <td>
                <?php
                $returTerapi = "-";
                $modObatalkespasienT = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'returresepdet_id'=>null, 'oa'=>'OA'));
                //
                if(count($modObatalkespasienT) > 0){
                  foreach($modObatalkespasienT as $i => $oriObatAlkespasien){
                    if($i > 0){
                      $returTerapi .= '<br/>';
                    }
                    $returTerapi .= '- '.$oriObatAlkespasien->obatalkes->obatalkes_nama.' '.$oriObatAlkespasien->obatalkes->kekuatan.' '.$oriObatAlkespasien->obatalkes->satuankekuatan.', '.$oriObatAlkespasien->qty_oa.' '.$oriObatAlkespasien->obatalkes->satuankecil->satuankecil_id;
                  }
                }

                echo $returTerapi;
                ?>
              </td>
          </tr>
          <tr>
              <td colspan="3" style="text-decoration: underline; font-weight: bold;">Masalah Keperawatan</td>
          </tr>
          <tr>
              <td colspan="3">
                <?php echo (!empty($masalahKeperawatan)?$masalahKeperawatan:"-"); ?>
              </td>
          </tr>
          <tr>
              <td colspan="3" style="text-decoration: underline; font-weight: bold;">Rencana Tindak Lanjut</td>
          </tr>
          <tr>
              <td colspan="3">
                <?php echo $modAskepgeriatriT->rencana_tindaklanjut; ?>
              </td>
          </tr>
        </table>
      </div>
  </div>
</div>

<div class="pageDetail" id="pageDetail_5">
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Kebutuhan Edukasi (<span style="font-style: italic; font-size: 8pt">untuk pasien dan atau keluarga</span>)</strong></div>
     </div>
      <div class="panel-body">
          <table width="100%">
              <tr>
                  <td width="50%">
                      <table width="100%" class="tablefont">
                        <tr>
                            <td valign="top" width="200px">Hambatan Belajar</td>
                            <td valign="top" width="5px">:</td>
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
                        <tr>
                            <td valign="top" width="200px">Potensial kebutuhan pembelajaran</td>
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
                                                        foreach ($modAsesmenkebutuhanEdukasidetT as $dataKebEduDet){
                                                            if($dataKebEduDet->edukasipasien == $dataLook->lookup_value){
                                                                $ModAsseEdu->isedukasipasien = true;
                                                                $ModAsseEdu->edukasipasien_lainnya = $dataKebEduDet->edukasipasien_lainnya;
                                                            }
                                                        }
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
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                        <tr>
                            <td width="200px" valign="top">Perlu Penerjemah</td>
                            <td width="5px" valign="top">:</td>
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
         <div class="panel-title"><strong>Perencanaan Pulang</strong></div>
     </div>
      <div class="panel-body">
        <div class="table-responsive" style="overflow-x:auto;">
            <div class='block-tabel'>
               <table class="items table table-bordered">
                   <thead>
                       <tr>
                           <th style="text-align: center">Komponen Penilaian</th>
                           <th style="text-align: center" width="50px">Ya</th>
                           <th style="text-align: center" width="50px">Tidak</th>
                           <th style="text-align: center" width="300px">Keterangan</th>
                       </tr>
                    </thead>
                    <tbody>
                      <?php
                        $look_rencanapul = LookupM::model()->findAll("lookup_type = 'penilaianrencanpulang' order by lookup_urutan ASC");

                          if(count($look_rencanapul) > 0){
                            foreach ($look_rencanapul as $i => $look) {
                                $penilaian_lainnya = "";
                                $hasil = "";
                                $keterangan = "";
                                $penilaianrencanapulang_id = null;

                                if(count($modPenilaianRenPulang) > 0){
                                  foreach($modPenilaianRenPulang as $oriNilaiRenPulang){
                                    if($look->lookup_name == $oriNilaiRenPulang->penilaian){
                                      $penilaianrencanapulang_id = $oriNilaiRenPulang->penilaianrencanapulang_id;
                                      $penilaian_lainnya = $oriNilaiRenPulang->penilaian_lainnya;
                                      $hasil = $oriNilaiRenPulang->hasil;
                                      $keterangan = $oriNilaiRenPulang->keterangan;
                                    }
                                  }
                                }
                              ?>
                              <tr>
                                <td>
                                  <?php 
                                    echo $look->lookup_name .' : '.(!empty($penilaian_lainnya)? $penilaian_lainnya:"");
                                  ?>

                                </td>
                                <td style="text-align: center">
                                  <span class="<?php echo ((!empty($hasil) && ($hasil =='Ya'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                                </td>
                                <td style="text-align: center">
                                  <span class="<?php echo ((!empty($hasil) && ($hasil =='Tidak'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                                </td>
                                <td>
                                  <?php echo $keterangan; ?>
                                </td>
                              </tr>
                              <?php
                            }
                          }
                       ?>
                    </tbody>
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
