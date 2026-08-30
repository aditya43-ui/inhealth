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
      text-align: center;
    }
    .textbold{
      font-weight: bold;
    }

    .textstrikethrough{
      text-decoration: line-through;
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
                          <td width="200px">Rujukan</td>
                          <td width="5px">:</td>
                          <td colspan="2"><?php echo $rujukan; ?></td>
                      </tr>
                      <tr>
                          <td width="200px">Dx Rujukan</td>
                          <td width="5px">:</td>
                          <td colspan="2"><?php echo $diagnosarujukan; ?></td>
                      </tr>
                      <tr>
                          <td colspan="2">Nama Keluarga yang Bisa Dihubungi </td>
                          <td width="5px">:</td>
                          <td><?php echo $keluargaNama; ?></td>
                      </tr>
                      <tr>
                          <td width="200px" colspan="2">Alamat</td>
                          <td width="5px">:</td>
                          <td><?php echo $keluargaAlamat; ?></td>
                      </tr>
                      <tr>
                          <td width="200px" colspan="2">No. Telp</td>
                          <td width="5px">:</td>
                          <td><?php echo $keluargaTelp; ?></td>
                      </tr>
                    </table>
                  </td>
                  <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px">Perawat Pengkajian</td>
                          <td width="5px">:</td>
                          <td><?php echo $model->paramedis_nama; ?></td>
                      </tr>
                      <tr>
                          <td>Dokter Pemeriksa</td>
                          <td>:</td>
                          <td> <?php echo $model->dokterpemeriksa->namaLengkap; ?></td>
                      </tr>
                      <tr>
                          <td>Jam Masuk Ruangan</td>
                          <td>:</td>
                          <td><?php echo $model->jam_masukruangan; ?> WIB</td>
                      </tr>
                      <tr>
                          <td>Tanggal & Jam Pengkajian</td>
                          <td>:</td>
                          <td><?php echo date('d', strtotime($model->tgl_assesmen_awal)).' '.MyFormatter::getMonthId(date('m', strtotime($model->tgl_assesmen_awal))).' '.date('Y', strtotime($model->tgl_assesmen_awal)).' '.date('H:i:s', strtotime($model->tgl_assesmen_awal)); ?></td>
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
                              <td width="200px">Anak ke-</td>
                              <td width="5px">:</td>
                              <td><?php echo $model->neonatus_anakke; ?></td>
                          </tr>
                          <tr>
                              <td valign="top">Riwayat Penyakit Ibu</td>
                              <td valign="top">:</td>
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
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="150px">Umur Kehamilan</td>
                              <td width="5px">:</td>
                              <td><?php echo $model->neonatus_umurkehamilan; ?></td>
                          </tr>
                          <tr>
                              <td>Riwayat Pengobatan Ibu</td>
                              <td>:</td>
                              <td> <?php echo $model->neonatus_riwayatpengobatanibu; ?></td>
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
                              <td><?php echo $model->neonatus_diagnosaibu; ?></td>
                          </tr>
                          <tr>
                              <td valign="top">Tanggal Lahir</td>
                              <td valign="top">:</td>
                                <td><?php echo (!empty($model->neonatus_tgllahirbayi)?MyFormatter::formatDateTimeForUser($model->neonatus_tgllahirbayi):""); ?></td>
                          </tr>
                          <tr>
                              <td valign="top">Jam Lahir</td>
                              <td valign="top">:</td>
                                <td><?php echo $model->neonatus_jamlahir; ?></td>
                          </tr>
                          <tr>
                              <td valign="top">Kondisi Saat Lahir</td>
                              <td valign="top">:</td>
                                <td><?php echo $model->neonatus_kondisisaatlahir; ?></td>
                          </tr>
                      </table>
                  </td>
                  <td width="50%" valign="top">
                      <table width="100%" class="tablefont">
                          <tr>
                              <td width="150px">Cara Persalinan</td>
                              <td width="5px">:</td>
                              <td><?php echo $model->neonatus_carapersalinan; ?></td>
                          </tr>
                          <tr>
                              <td>Apgar</td>
                              <td>:</td>
                              <td> <?php echo $model->neonatus_apgarscore; ?></td>
                          </tr>
                          <tr>
                              <td>Letak</td>
                              <td>:</td>
                              <td> <?php echo $model->neonatus_letak; ?></td>
                          </tr>
                          <tr>
                              <td>Tali Pusat</td>
                              <td>:</td>
                              <td> <?php echo $model->neonatus_talipusat; ?></td>
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
                          <span class="<?php echo (($model->neonatus_faktorinfeksimayor_ibudemam==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ibu Demam ≥ 38 &#176C; &nbsp;&nbsp;
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
                  <td colspan="2" style="color: black"><strong>D. Kebutuhan Biologis</strong></td>
              </tr>
              <tr>
                  <td colspan="2">
                    <table width="100%" class="tablefont">
                      <tr>
                        <td width="120px">Nutrisi</td>
                        <td width="5px">:</td>
                        <td>
                          <span class="<?php echo (($model->neonatus_ispenyakitibudm==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> ASI
                          <span style="padding-left: 200px;" class="<?php echo (($model->neonatus_nutrisilainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya, <?php echo $model->neonatus_nutrisilainnyaket; ?>
                        </td>
                      </tr>
                      <tr>
                        <td width="120px"></td>
                        <td width="5px"></td>
                        <td style="padding-left: 20px;">
                          Frekuensi <?php echo $model->neonatus_nutrisiasi_frekuensijml; ?> Cc/
                          <?php echo $model->neonatus_nutrisiasi_frekuensikali; ?> Kali
                        </td>
                      </tr>
                      <tr>
                          <td valign="top">Keluhan BAB</td>
                          <td valign="top">:</td>
                          <td>
                              <table width="100%" class="tablefont">
                                  <tr>
                                      <td><span class="<?php echo (($model->keb_eliminasi_bab_keluhanstatus==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada</td>
                                  </tr>
                                  <tr>
                                      <td><span class="<?php echo (($model->keb_eliminasi_bab_keluhanstatus==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada</td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <span style="padding-left: 10px" class="<?php echo ((!empty($model->keb_eliminasi_bab_ispendarahan) && ($model->keb_eliminasi_bab_ispendarahan==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pendarahan &nbsp;&nbsp;
                                          <span class="<?php echo ((!empty($model->keb_eliminasi_bab_ishemorroid) && ($model->keb_eliminasi_bab_ishemorroid==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Hemorroid &nbsp;&nbsp;
                                          <span class="<?php echo ((!empty($model->keb_eliminasi_bab_iskonstipasi) && ($model->keb_eliminasi_bab_iskonstipasi==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Konstipasi &nbsp;&nbsp;
                                          <span class="<?php echo ((!empty($model->keb_eliminasi_bab_iskeluhanlainnya) && ($model->keb_eliminasi_bab_iskeluhanlainnya==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                                          Lainnya: <?php echo $model->keb_eliminasi_bab_jeniskeluhanlainnya; ?>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                      <tr>
                          <td valign="top">Keluhan BAK</td>
                          <td valign="top">:</td>
                          <td>
                              <table width="100%" class="tablefont">
                                  <tr>
                                      <td><span class="<?php echo (($model->keb_eliminasi_bak_keluhanstatus==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada</td>
                                  </tr>
                                  <tr>
                                      <td><span class="<?php echo (($model->keb_eliminasi_bak_keluhanstatus==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada</td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <span style="padding-left: 10px" class="<?php echo ((!empty($model->keb_eliminasi_bak_isnyeri) && ($model->keb_eliminasi_bak_isnyeri==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Nyeri &nbsp;&nbsp;
                                          <span class="<?php echo ((!empty($model->keb_eliminasi_bak_ispendarahan) && ($model->keb_eliminasi_bak_ispendarahan==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pendarahan &nbsp;&nbsp;
                                          <span class="<?php echo ((!empty($model->keb_eliminasi_bak_iskeluhanlainnya) && ($model->keb_eliminasi_bak_iskeluhanlainnya==true))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                                          Lainnya: <?php echo $model->keb_eliminasi_bak_jeniskeluhanlainnya; ?>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                    </table>
                  </td>
                </td>
              </tr>
              <tr>
                  <td colspan="2" style="color: black"><strong>E. Alergi/ Reaksi (Pada Orang Tua: <?php echo $model->neonatus_alergidikajikpd; ?>)</strong></td>
              </tr>
              <tr>
                <td colspan="2">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="120px" valign="top">Alergi</td>
                        <td width="5px" valign="top">:</td>
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
                                    <td width="150px">Riwayat Alergi Obat : </td>
                                    <td><?php echo $model->riwayatalergiobat; ?></td>
                                </tr>
                                <tr>
                                    <td>Riwayat Alergi Makanan : </td>
                                    <td><?php echo $model->riwayatalergimakanan; ?></td>
                                </tr>
                                <tr>
                                    <td>Riwayat Alergi Lainnya : </td>
                                    <td><?php echo $model->riwayatalergilainnya; ?></td>
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

</div>

<div class="pageDetail" id="pageDetail_2">
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Kebutuhan Psikologi (Untuk Orang Tua : <?php echo $model->neonatus_kebpsikologidikasikpd; ?>)</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="200px">Masalah Perkawinan</td>
                        <td width="5px">:</td>
                        <td><?php echo $model->neonatus_masalahperkawinanortu.', '.$model->neonatus_masalahperkawinanortuket; ?></td>
                    </tr>
                    <tr>
                        <td>Mengalami Kekerasan Fisik</td>
                        <td>:</td>
                        <td><span class="<?php echo ((!empty($model->neonatus_kekerasanfisikortu) && ($model->neonatus_kekerasanfisikortu=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td><span class="<?php echo ((!empty($model->neonatus_kekerasanfisikortu) && ($model->neonatus_kekerasanfisikortu=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td style="padding-left: 20px">
                          <span class="<?php echo (($model->neonatus_kekerasanfisikortu_iscederadiri==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Mencederai Diri
                          <span class="<?php echo (($model->neonatus_kekerasanfisikortu_isorglain==true) ?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Orang Lain
                        </td>
                    </tr>
                    <tr>
                        <td>Trauma Dalam Kehidupan</td>
                        <td>:</td>
                        <td><span class="<?php echo ((!empty($model->neonatus_traumadlmhiduportu) && ($model->neonatus_traumadlmhiduportu=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td><span class="<?php echo ((!empty($model->neonatus_traumadlmhiduportu) && ($model->neonatus_traumadlmhiduportu=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada, <?php echo $model->neonatus_traumadlmhiduportuket; ?></td>
                    </tr>
                    <tr>
                        <td>Gangguan Tidur</td>
                        <td>:</td>
                        <td><span class="<?php echo ((!empty($model->gangguantidur_status) && ($model->gangguantidur_status=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td><span class="<?php echo ((!empty($model->gangguantidur_status) && ($model->gangguantidur_status=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada, <?php echo $model->gangguantidur_keterangan; ?></td>
                    </tr>
                  </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="200px">Konsultasi dengan Psikologi/ Psikiater</td>
                        <td width="5px">:</td>
                        <td>
                          <span class="<?php echo ((!empty($model->neonatus_konsulpsikologortu) && ($model->neonatus_konsulpsikologortu=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada &nbsp;&nbsp;
                          <span class="<?php echo ((!empty($model->neonatus_konsulpsikologortu) && ($model->neonatus_konsulpsikologortu=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                        </td>
                    </tr>
                    <tr>
                        <td>Penerimaan Terhadap Kondisi Bayi saat ini</td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo ((!empty($model->neonatus_penerimaankondisibayi) && ($model->neonatus_penerimaankondisibayi=='Menerima'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Menerima
                          <span style="padding-left: 5px" class="<?php echo ((!empty($model->neonatus_penerimaankondisibayi) && ($model->neonatus_penerimaankondisibayi=='Tidak Menerima'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Menerima
                        </td>
                    </tr>
                    <tr>
                        <td>Dukungan Sosial Dari</td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo (($model->neonatus_dukungansosialdr_iskeluarga==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga &nbsp;&nbsp;
                          <span style="padding-left: 7px"  class="<?php echo (($model->neonatus_dukungansosialdr_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya,  <?php echo $model->neonatus_dukungansosialdr_lainnyaket; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo (($model->neonatus_dukungansosialdr_issuami==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Suami
                          <span style="padding-left: 31px" class="<?php echo (($model->neonatus_dukungansosialdr_isistri==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Istri
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo (($model->neonatus_dukungansosialdr_isortu==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Orang Tua
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
         <div class="panel-title"><strong>Kebutuhan Sosial Ekonomi (Untuk Orang Tua : <?php echo (($model->neonatus_kebsosialekonomi_pihakygdikaji=='Lainnya')? $model->neonatus_kebsosialekonomi_pihakygdikajilainnya: $model->neonatus_kebsosialekonomi_pihakygdikaji) ?>)</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="200px">Status Pernikahan</td>
                        <td width="5px">:</td>
                        <td><?php echo $model->neonatus_kebsosialekonomi_statusperkawinan; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>Jumlah Menikah : <?php echo (!empty($model->neonatus_jmlmenikahortu)?$model->neonatus_jmlmenikahortu:"-"); ?> Kali</td>
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
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td><?php echo $model->neonatus_pekerjaanortu; ?></td>
                    </tr>
                    <tr>
                        <td>Tinggal Bersama</td>
                        <td>:</td>
                        <td><?php echo $model->neonatus_tinggalbersama; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>Nama Pihak Lainnya :<?php echo $model->neonatus_tinggalbersamalainnya_nama; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>No. Telp Pihak Lainnya :<?php echo $model->neonatus_tinggalbersamalainnya_notlp; ?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td><?php echo $model->neonatus_agamaortu; ?></td>
                    </tr>

                  </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                      <td colspan="3"><u>Kebiasaan</u></td>
                    </tr>
                    <tr>
                        <td width="200px">Status Merokok</td>
                        <td width="5px">:</td>
                        <td><?php echo (($model->statusmerokok==true)?"Ya":"Tidak"); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>Jumlah Rokok Batangan <?php echo (!empty($model->jmlrokok_btg_hr)?$model->jmlrokok_btg_hr:"-"); ?> Per Hari</td>
                    </tr>
                    <tr>
                        <td>Alkohol</td>
                        <td>:</td>
                        <td><?php echo (($model->neonatus_kebiasaanortualkohol_status==true)?"Ya":"Tidak"); ?></td>
                    </tr>
                    <tr>
                        <td>Jenis & Jumlah Alkohol yang dikomsumsi</td>
                        <td>:</td>
                        <td><?php echo $model->neonatus_kebiasaanortualkohol_jenis; ?>/ <?php echo $model->neonatus_kebiasaanortualkohol_jml; ?> Per Hari</td>
                    </tr>
                    <tr>
                        <td>Kebiasaan Lainnya</td>
                        <td>:</td>
                        <td><?php echo $model->neonatus_kebiasaanortulainnya; ?></td>
                    </tr>
                  </table>
                </td>
            </tr>
        </table>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Kebutuhan Komunikasi & Edukasi (Untuk Orang Tua : <?php echo $modAsesmenkebutuhanEdukasiT->neonatus_edukasidiberikankpd; ?>)</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="200px">Edukasi Diberikan Kepada</td>
                        <td width="5px">:</td>
                        <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_edukasidiberikankpd) && ($modAsesmenkebutuhanEdukasiT->neonatus_edukasidiberikankpd=="Orang Tua"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Orang Tua</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_edukasidiberikankpd) && ($modAsesmenkebutuhanEdukasiT->neonatus_edukasidiberikankpd=="Keluarga"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga
                          (Hubungan dengan Pasien : <?php echo $modAsesmenkebutuhanEdukasiT->neonatus_hubkeluargapenerimaedukasi; ?>)
                        </td>
                    </tr>
                    <tr>
                        <td>Bicara</td>
                        <td>:</td>
                        <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bicara_status) && ($modAsesmenkebutuhanEdukasiT->bicara_status=="Normal"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Normal</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bicara_status) && ($modAsesmenkebutuhanEdukasiT->bicara_status=="Serangan awal gangguan bicara"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Serangan awal gangguan bicara
                          , Kapan <?php echo $modAsesmenkebutuhanEdukasiT->mulaiseranganawal; ?>
                        </td>
                    </tr>
                  </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="200px">Bahasa Sehari-hari</td>
                        <td width="5px">:</td>
                        <td>
                          <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indo==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Indonesia
                          <span style="padding-left: 10px"> <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indostatus) && ($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indostatus=="Aktif"))?"textstrikethrough":""); ?>">Aktif</span> /<span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indostatus) && ($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indostatus=="Pasif"))?"textstrikethrough":""); ?>"> Pasif</span></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggris==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Inggris
                          <span style="padding-left: 10px"> <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggrisstatus) && ($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggrisstatus=="Aktif"))?"textstrikethrough":""); ?>">Aktif</span> /<span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggrisstatus) && ($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggrisstatus=="Pasif"))?"textstrikethrough":""); ?>"> Pasif</span></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_daerah==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Daerah
                          , Jelaskan <?php echo $modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_daerahket; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_lainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya
                          , Jelaskan <?php echo $modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_lainnyaket; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Perlu Penerjemah</td>
                        <td>:</td>
                        <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status) && ($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status=="Tidak"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status) && ($modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status=="Ya"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                          , <?php echo $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Bahasa Isyarat</td>
                        <td>:</td>
                        <td>
                          <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bahasaisyarat_status) && ($modAsesmenkebutuhanEdukasiT->bahasaisyarat_status=="Tidak"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                          <span style="padding-left: 10px" class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bahasaisyarat_status) && ($modAsesmenkebutuhanEdukasiT->bahasaisyarat_status=="Ya"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
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
         <div class="panel-title"><strong>Edukasi</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td valign="top">Hambatan Edukasi</td>
                        <td valign="top">:</td>
                        <td>
                            <table width="100%" class="tablefont">
                                <tr>
                                    <td width="50%">
                                        <table width="100%" class="tablefont">
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_bahasa==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Bahasa</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_pendengaran==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Pendengaran</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_penglihatan==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Penglihatan</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_motivasi==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Motivasi</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_fisik==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Fisik</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="50%">
                                        <table width="100%" class="tablefont">
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_emosi==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Emosi</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_butahuruf==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Buta Huruf</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_usia==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Usia</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_kognitif==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kognitif</td>
                                            </tr>
                                            <tr>
                                                <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_tidakada==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
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
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td valign="top">Cara Edukasi yang disukai</td>
                        <td valign="top">:</td>
                        <td>
                          <table width="100%" class="tablefont">
                              <tr>
                                  <td width="50%">
                                      <table width="100%" class="tablefont">
                                        <tr>
                                            <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_menulis==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Menulis</td>
                                        </tr>
                                        <tr>
                                            <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_audiovisual==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Audio-Visual/ Gambar</td>
                                        </tr>
                                        <tr>
                                            <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_diskusi==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Diskusi</td>
                                        </tr>
                                      </table>
                                  </td>
                                  <td width="50%">
                                      <table width="100%" class="tablefont">
                                        <tr>
                                            <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_demonstrasi==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Demostrasi</td>
                                        </tr>
                                        <tr>
                                            <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_membaca==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Membaca</td>
                                        </tr>
                                        <tr>
                                            <td><span class="<?php echo (($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_mendengarkan==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Mendengarkan</td>
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
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Skrining Nyeri - Metode CRIES</strong></div>
     </div>
      <div class="panel-body">
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
      </div>
  </div>
</div>
<div class="pageDetail" id="pageDetail_3">
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Masalah Keperawatan</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td>
                  <?php echo $masalahKeperawatan; ?>
                </td>
              </tr>
        </table>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Rencana Keperawatan</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td>
                  <?php echo $rencanaKeperawatan; ?>
                </td>
              </tr>
        </table>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
     <div class="panel-heading">
         <div class="panel-title"><strong>Tindakan Keperawatan</strong></div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td>
                  <?php echo $tindakanKeperawatan; ?>
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
    if(index > 4){

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
