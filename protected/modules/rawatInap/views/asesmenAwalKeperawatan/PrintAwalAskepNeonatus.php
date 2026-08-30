<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    @page {
        /*   size: 7in 9.25in;*/




    }
    @media print {
        html, body {


        }
        .headerclass{
            right: 0; top: 10; position: fixed; font-weight: bold;
        }
        /* ... the rest of the rules ... */
    }
    .headerclass{
        right: 0; top: 0; float: right; font-weight: bold;
    }
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }

    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    p {
        text-align: justify;
    }


    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .padding5{
        padding: 5px;
    }


    .wrapper {
        height: 100vh;
        display: flex;

        flex-direction: column;
    }

    header, footer {
        height: 30px;
    }

    main {
        flex: 1;
    }

    body {
        margin: 0;
    }

    .tablefont td{
        color: black;
        padding: 5px;
    }

    .classbraketr{
        page-break-after: always;
    }

    .fa{
        font-size: 12pt;
    }
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }

    .textbold {
        font-weight: bold;
    }
    .textcenter {
        text-align: center;
    }

    .tableBorder th, .tableBorder td {
        border:1px solid #000;
        padding: 5px;
    }

    .tab_page{

    }

    .textstrikethrough{
      text-decoration: line-through;
    }

    /* content table { page-break-inside:auto }
   content table tr    { page-break-inside:avoid; page-break-after:auto } */
</style>


<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

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

<table width="100%"class="tab_page" >
    <thead>
        <tr>
            <td >
                <div class="header"><div style="text-align:right;font-weight: bold" class="">RM RI 07.a</div></div>

            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content" >
                    <table width="100%">
                        <tr>
                            <td style="width: 40%" valign="top">
                                <table>
                                    <tr>
                                        <td width="30%" align="center" class="bordertopclass borderbottomclass borderleftclass">
                                            <div style="padding:5px"><img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 100px"/></div>
                                        </td>
                                        <td width="1%" class="bordertopclass borderbottomclass">
                                        </td>
                                        <td  class="bordertopclass borderrightclass borderbottomclass">
                                            <font style="font-size:12px;"><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></font><br><br>
                                            <font style="font-size:12px;"><?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit) . ' ' . ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' ' . ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?></font><br>
                                            <font style="font-size:12px;">Phone. <?php echo $modProfilRs->no_telp_profilrs; ?></font> <br>
                                            <font style="font-size:12px;">FAX : <?php echo $modProfilRs->no_faksimili; ?></font>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 25%" valign="bottom">
                            </td>
                            <td style="width: 35%;">
                                <table class="borderclass" style="float:right; width: 100%">
                                    <tr>
                                        <td style="" width="120px">Nama Pasien</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->nama_pasien; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Tanggal Lahir</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Jenis Kelamin</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->jeniskelamin; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">No. RM</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->no_rekam_medik; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Dokter DPJP</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php
                                            $dokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                                            $nama = "";

                                            if (isset($dokter)) {
                                                $nama = $dokter->namaLengkap;
                                            }
                                            echo $nama;
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <center>
                        <p class="textcenter">
                            <span  style="font-weight: bold; font-size: 14pt">
                                ASSESMEN AWAL KEPERAWATAN <?php if (Params::MODUL_ID_RD == Yii::app()->user->getState("modul_id")){
                                    echo "RAWAT DARURAT";
                                } else {
                                    echo "RAWAT INAP";
                                }?>
                                <br />
                                NEONATUS (< 30 HARI)
                            </span><br />
                            (Asesmen ini dilengkapi dalam waktu 1 x 24 jam saat pasien masuk)<br />
                            <b>(Data awal diisi oleh perawat)</b>
                        </p>
                    </center>
                    <br/>
                    <table width="100%" class="borderclass">
                        <tr>
                            <td colspan="2" style="padding:10px">
                                <table width="100%" class="tablefont">
                                    <!-- <tr>
                                        <td>Sumber Data</td>
                                        <td>:</td>
                                        <td><?php //echo $model->jam_masukruangan; ?> WIB</td>
                                    </tr> -->
                                    <tr>
                                        <td width="200px">Rujukan</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $rujukan; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dx Rujukan</td>
                                        <td>:</td>
                                        <td><?php echo $diagnosarujukan; ?></td>
                                    </tr>
                                </table>
                                <table width="100%" class="tablefont">
                                    <tr>
                                        <td width="300px">Nama Keluarga yang Bisa Dihubungi</td>
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
                            </td>
                        </tr>

                        <tr class="bordertopclass borderleftclass borderrightclass">
                            <td style="padding:5px" class="textbold">RIWAYAT KESEHATAN</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:10px">
                                <table width="100%" class="tablefont">
                                  <tr>
                                      <td colspan="2" style="color: black"><strong>A. Riwayat Prenatal</strong></td>
                                  </tr>
                                  <tr>
                                    <td width="50%" style="padding-left: 20px">
                                      <table width="100%" class="tablefont">
                                          <tr>
                                              <td width="180px">Anak ke-</td>
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
                                                <td width="200px">Umur Kehamilan</td>
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
                                      <td width="50%" style="padding-left: 20px">
                                          <table width="100%" class="tablefont">
                                              <tr>
                                                  <td width="180px">Diagnosa Ibu</td>
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
                                      <td colspan="2" style="padding-left: 20px">
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="180px">Mayor</td>
                                            <td width="5px">:</td>
                                            <td>
                                              <span class="<?php echo (($model->neonatus_faktorinfeksimayor_ibudemam==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ibu Demam ≥ 38 &#176C &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksimayor_kpdlebihdr24jam==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> KPD > 24 JAM &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksimayor_ketubanhijau==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ketuban Hijau &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksimayor_korioamnionitis==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Korioamnionitis &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksimayor_fetaldistress==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Fetal Distress
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Minor</td>
                                            <td>:</td>
                                            <td>
                                              <span class="<?php echo (($model->neonatus_faktorinfeksiminor_kpdkurangdr12jam==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> KPD < 12 Jam &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksiminor_asfiksia==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Asfiksia &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksiminor_bblr==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> BBLR &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksiminor_isk==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> ISK &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksiminor_ukkurangdr37minggu==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> UK < 37 Minggu &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksiminor_gemeli==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Gemeli &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksiminor_keputihan==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keputihan &nbsp;
                                              <span class="<?php echo (($model->neonatus_faktorinfeksiminor_ibutemplebihdr37==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ibu Temp > 37 &#176C &nbsp;
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
                                      <td colspan="2" style="padding-left: 20px">
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="180px">Nutrisi</td>
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
                                    <td colspan="2" style="padding-left: 20px">
                                      <table width="100%" class="tablefont">
                                        <tr>
                                            <td width="180px" valign="top">Alergi</td>
                                            <td width="5px" valign="top">:</td>
                                            <td>
                                                <table width="100%" class="tablefont">
                                                    <tr>
                                                        <td>
                                                          <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                          <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Tidak Tahu'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Tahu
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                          <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="padding-left: 20px">
                                                          <table width="100%" class="tablefont">
                                                            <tr>
                                                                <td width="220px">Riwayat Alergi Obat : </td>
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
                                                    <tr>
                                                        <td>
                                                          <span class="<?php echo (($model->ispasangtandaalergi==true) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Gelang Tanda Alergi Dipasang (Warna Merah)
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
                        <tr class="bordertopclass borderleftclass borderrightclass">
                            <td style="padding:5px" class="textbold">Kebutuhan Psikologi (Untuk Orang Tua : <?php echo $model->neonatus_kebpsikologidikasikpd; ?>)</td>
                        </tr>
                        <tr>
                          <td colspan="2" style="padding:10px">
                              <table width="100%" class="tablefont">
                                <tr>
                                    <td width="230px">Masalah Perkawinan</td>
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
                                      <span style="padding-left: 10px" class="<?php echo (($model->neonatus_kekerasanfisikortu_isorglain==true) ?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Orang Lain
                                    </td>
                                </tr>
                                <tr>
                                    <td>Trauma Dalam Kehidupan</td>
                                    <td>:</td>
                                    <td>
                                      <span class="<?php echo ((!empty($model->neonatus_traumadlmhiduportu) && ($model->neonatus_traumadlmhiduportu=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                                      <span style="padding-left: 10px" class="<?php echo ((!empty($model->neonatus_traumadlmhiduportu) && ($model->neonatus_traumadlmhiduportu=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada, <?php echo $model->neonatus_traumadlmhiduportuket; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gangguan Tidur</td>
                                    <td>:</td>
                                    <td>
                                      <span class="<?php echo ((!empty($model->gangguantidur_status) && ($model->gangguantidur_status=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                                      <span style="padding-left: 10px" class="<?php echo ((!empty($model->gangguantidur_status) && ($model->gangguantidur_status=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada, <?php echo $model->gangguantidur_keterangan; ?>
                                    </td>
                                </tr>
                              </table>
                              <table width="100%" class="tablefont">
                                <tr>
                                    <td width="350px">Konsultasi dengan Psikologi/ Psikiater</td>
                                    <td width="5px">:</td>
                                    <td>
                                      <span class="<?php echo ((!empty($model->neonatus_konsulpsikologortu) && ($model->neonatus_konsulpsikologortu=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                                      <span style="padding-left: 10px"  class="<?php echo ((!empty($model->neonatus_konsulpsikologortu) && ($model->neonatus_konsulpsikologortu=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                                    </td>
                                </tr>
                                <tr>
                                    <td>Penerimaan Terhadap Kondisi Bayi saat ini</td>
                                    <td>:</td>
                                    <td>
                                      <span class="<?php echo ((!empty($model->neonatus_penerimaankondisibayi) && ($model->neonatus_penerimaankondisibayi=='Menerima'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Menerima
                                      <span style="padding-left: 10px" class="<?php echo ((!empty($model->neonatus_penerimaankondisibayi) && ($model->neonatus_penerimaankondisibayi=='Tidak Menerima'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Menerima
                                    </td>
                                </tr>
                              </table>
                              <table width="100%" class="tablefont">
                                <tr>
                                    <td width="230px">Dukungan Sosial Dari</td>
                                    <td width="5px">:</td>
                                    <td>
                                      <span class="<?php echo (($model->neonatus_dukungansosialdr_issuami==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Suami
                                      <span style="padding-left: 10px" class="<?php echo (($model->neonatus_dukungansosialdr_isistri==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Istri
                                      <span style="padding-left: 10px" class="<?php echo (($model->neonatus_dukungansosialdr_isortu==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Orang Tua
                                      <span style="padding-left: 10px" class="<?php echo (($model->neonatus_dukungansosialdr_iskeluarga==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga
                                      <span style="padding-left: 10px"  class="<?php echo (($model->neonatus_dukungansosialdr_islainnya==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lainnya,  <?php echo $model->neonatus_dukungansosialdr_lainnyaket; ?>
                                    </td>
                                </tr>
                              </table>
                            </td>
                        </tr>
                        <tr class="bordertopclass borderleftclass borderrightclass">
                            <td style="padding:5px" class="textbold">Kebutuhan Sosial Ekonomi (Untuk Orang Tua : <?php echo (($model->neonatus_kebsosialekonomi_pihakygdikaji=='Lainnya')? $model->neonatus_kebsosialekonomi_pihakygdikajilainnya: $model->neonatus_kebsosialekonomi_pihakygdikaji) ?>)</td>
                        </tr>
                        <tr>
                            <td width="50%" style="padding:10px">
                                <table width="100%" class="tablefont">
                                  <tr>
                                      <td width="200px">Status Pernikahan</td>
                                      <td width="5px">:</td>
                                      <td><?php echo $model->neonatus_kebsosialekonomi_statusperkawinan; ?></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
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
                                      <td></td>
                                      <td>Nama Pihak Lainnya :<?php echo $model->neonatus_tinggalbersamalainnya_nama; ?></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                      <td>No. Telp Pihak Lainnya :<?php echo $model->neonatus_tinggalbersamalainnya_notlp; ?></td>
                                  </tr>
                                  <tr>
                                      <td>Agama</td>
                                      <td>:</td>
                                      <td><?php echo $model->neonatus_agamaortu; ?></td>
                                  </tr>
                                </table>
                            </td>
                            <td width="50%" style="padding:10px" valign="top">
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
                                    <td></td>
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
                        <tr class="bordertopclass borderleftclass borderrightclass">
                            <td style="padding:5px" class="textbold">Kebutuhan Komunikasi & Edukasi (Untuk Orang Tua : <?php echo $modAsesmenkebutuhanEdukasiT->neonatus_edukasidiberikankpd; ?>)</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:10px">
                                <table width="100%" class="tablefont">
                                  <tr>
                                      <td width="250px">Edukasi Diberikan Kepada</td>
                                      <td width="5px">:</td>
                                      <td><span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_edukasidiberikankpd) && ($modAsesmenkebutuhanEdukasiT->neonatus_edukasidiberikankpd=="Orang Tua"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Orang Tua</td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
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
                                      <td></td>
                                      <td>
                                        <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->bicara_status) && ($modAsesmenkebutuhanEdukasiT->bicara_status=="Serangan awal gangguan bicara"))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Serangan awal gangguan bicara
                                        , Kapan <?php echo $modAsesmenkebutuhanEdukasiT->mulaiseranganawal; ?>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>Bahasa Sehari-hari</td>
                                      <td>:</td>
                                      <td>
                                        <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indo==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Indonesia
                                        <span style="padding-left: 10px"> <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indostatus) && ($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indostatus=="Aktif"))?"textstrikethrough":""); ?>">Aktif</span> /<span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indostatus) && ($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_indostatus=="Pasif"))?"textstrikethrough":""); ?>"> Pasif</span></span>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                      <td>
                                        <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggris==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Inggris
                                        <span style="padding-left: 10px"> <span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggrisstatus) && ($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggrisstatus=="Aktif"))?"textstrikethrough":""); ?>">Aktif</span> /<span class="<?php echo ((!empty($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggrisstatus) && ($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_inggrisstatus=="Pasif"))?"textstrikethrough":""); ?>"> Pasif</span></span>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                      <td>
                                        <span class="<?php echo (($modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_daerah==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Daerah
                                        , Jelaskan <?php echo $modAsesmenkebutuhanEdukasiT->neonatus_bahasaseharihari_daerahket; ?>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
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
                                      <td></td>
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
                        <tr class="borderclass">
                            <td style="padding:5px" class="textbold">DATA PSIKOLOGIS, SOSIAL, EKONOMI DAN SPIRITUAL</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:10px">
                                <table width="100%" class="tablefont">
                                    <tr>
                                        <td width="200px">Psikologi</td>
                                        <td width="10px">:</td>
                                        <td>
                                            <span class="<?php echo (($model->statuspsikologis_isstabil == true) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Stabil/ Tenang
                                            <span class="<?php echo (($model->statuspsikologis_iscemas == true) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Cemas/ Takut
                                            <span class="<?php echo (($model->statuspsikologis_ismarah == true) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Marah
                                            <span class="<?php echo (($model->statuspsikologis_issedih == true) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Sedih
                                            <span class="<?php echo (($model->statuspsikologis_islainnya == true) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Lainnya
                                            ,<?php echo $model->statuspsikologis_lainnya; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hambatan Sosial</td>
                                        <td>:</td>
                                        <td>
                                            <span class="<?php echo ((!empty($model->hambatansosial_status) && ($model->hambatansosial_status == 'Tidak Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Tidak Ada
                                            <span class="<?php echo ((!empty($model->hambatansosial_status) && ($model->hambatansosial_status == 'Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Ada ,
                                            <?php echo $model->hambatansosial_keteranganada; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hambatan Ekonomi</td>
                                        <td>:</td>
                                        <td>
                                            <span class="<?php echo ((!empty($model->hambatanekonomi_status) && ($model->hambatanekonomi_status == 'Tidak Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Tidak Ada
                                            <span class="<?php echo ((!empty($model->hambatanekonomi_status) && ($model->hambatanekonomi_status == 'Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Ada ,
                                            <?php echo $model->hambatanekonomi_keteranganada; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hambatan Spiritual</td>
                                        <td>:</td>
                                        <td>
                                            <span class="<?php echo ((!empty($model->hambatanspiritual_status) && ($model->hambatanspiritual_status == 'Tidak Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Tidak Ada
                                            <span class="<?php echo ((!empty($model->hambatanspiritual_status) && ($model->hambatanspiritual_status == 'Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Ada ,
                                            <?php echo $model->hambatanspiritual_keteranganada; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai Kepercayaan</td>
                                        <td>:</td>
                                        <td>
                                            <span class="<?php echo ((!empty($model->nilaikepercayaan_status) && ($model->nilaikepercayaan_status == 'Tidak Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Tidak Ada
                                            <span class="<?php echo ((!empty($model->nilaikepercayaan_status) && ($model->nilaikepercayaan_status == 'Ada')) ? 'fa fa-check-square-o' : 'fa fa-square-o'); ?>"></span> Ada ,
                                            <?php echo $model->nilaikepercayaan_keteranganada; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="bordertopclass borderleftclass borderrightclass">
                            <td width="50%" style="padding:10px">
                              <table width="100%" class="tablefont">
                                  <tr>
                                      <td valign="top">Hambatan Edukasi</td>
                                      <td valign="top">:</td>
                                      <td valign="top">
                                          <table width="100%" class="tablefont">
                                              <tr>
                                                  <td width="50%" style="padding-top: 0 !important;">
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
                                                  <td width="50%" valign="top" style="padding-top: 0 !important;">
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

                                                  if(count((array)$modLookupData)>0){

                                                      foreach ($modLookupData as $i => $dataLook){
                                                              $html = "";
                                                              $ModAsseEdu = new AsesmenkebutuhanEdukasidetT();
                                                              if(is_array($modAsesmenkebutuhanEdukasidetT) && count((array)$modAsesmenkebutuhanEdukasidetT)>0){
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
                            <td width="50%" style="padding:10px" valign="top">
                              <table width="100%" class="tablefont">
                                <tr>
                                    <td valign="top" width="180px">Cara Edukasi yang disukai</td>
                                    <td valign="top"  width="5px">:</td>
                                    <td>
                                      <table width="100%" class="tablefont">
                                          <tr>
                                              <td width="50%" style="padding-top: 0 !important;">
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
                                              <td width="50%" style="padding-top: 0 !important;" valign="top">
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
                        <tr class="bordertopclass borderleftclass borderrightclass">
                            <td colspan="2" style="padding:10px">
                              <table class="tableBorder" width="100%">
                                  <thead>
                                      <tr>
                                          <th style="width: 10px">No</th>
                                          <th>Penilaian</th>
                                          <th style="width: 300px">Nilai 0</th>
                                          <th style="width: 300px">Nilai 1</th>
                                          <th style="width: 300px">Nilai 2</th>
                                          <th style="width: 50px">Nilai</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>1</td>
                                      <td style="font-style: italic;">Crying</td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_cryingket)) && ($model->neonatus_cries_cryingnilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Tidak ada tangisan/ tangisan tidak melengking
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_cryingket)) && ($model->neonatus_cries_cryingnilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Tangisan melengking tetapi bayi mudah dihibur
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_cryingket)) && ($model->neonatus_cries_cryingnilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Tangisan melengking tetapi bayi tidak mudah dihibur
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td style="text-align: center">
                                        <?php echo $model->neonatus_cries_cryingnilai; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>2</td>
                                      <td style="font-style: italic;">Requires</td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_requiresket)) && ($model->neonatus_cries_requiresnilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Tidak perlu oksigen
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_requiresket)) && ($model->neonatus_cries_requiresnilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              perlu oksigen ≤ 30%
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_requiresket)) && ($model->neonatus_cries_requiresnilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              perlu oksigen ≥ 30%
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td style="text-align: center">
                                        <?php echo $model->neonatus_cries_requiresnilai; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>3</td>
                                      <td style="font-style: italic;">Increased</td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_increasedket)) && ($model->neonatus_cries_increasednilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Detak jantung dan tekanan darah tidak berubah atau kurang dari nilai base line
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_increasedket)) && ($model->neonatus_cries_increasednilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Detak jantung atau tekanan darah meningkat, tetapi peningkatan ≤ 20%
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_increasedket)) && ($model->neonatus_cries_increasednilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Detak jantung atau tekanan darah meningkat ≥ 20% dari nilai base line
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td style="text-align: center">
                                        <?php echo $model->neonatus_cries_increasednilai; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>4</td>
                                      <td style="font-style: italic;">Expression</td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_expressionket)) && ($model->neonatus_cries_expressionnilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Tidak ada seringai
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_expressionket)) && ($model->neonatus_cries_expressionnilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Seringai ada
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_expressionket)) && ($model->neonatus_cries_expressionnilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Seringai ada dan tidak ada suara tangisan dengkur
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td style="text-align: center">
                                        <?php echo $model->neonatus_cries_expressionnilai; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>5</td>
                                      <td style="font-style: italic;">Sleepless</td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_sleeplessket)) && ($model->neonatus_cries_sleeplessnilai==0))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Bayi terus menerus tidur
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_sleeplessket)) && ($model->neonatus_cries_sleeplessnilai==1))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Bayi terbangung pada interval berulang
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table width="100%" class="tablefont">
                                          <tr>
                                            <td width="10px" valign="top" style="border: none;">
                                              <span class="<?php echo (((!empty($model->neonatus_cries_sleeplessket)) && ($model->neonatus_cries_sleeplessnilai==2))?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span>
                                            </td>
                                            <td style="border: none;">
                                              Bayi terjaga, terbangun secara terus menerus
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td style="text-align: center">
                                        <?php echo $model->neonatus_cries_sleeplessnilai; ?>
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
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <table width="100%">
                      <tr class="borderclass">
                        <td class="borderclass padding5" width="50%">Masalah Keperawatan</td>
                        <td class="borderclass padding5" width="50%">Tujuan Terukur</td>
                      </tr>
                      <tr>
                        <td class="borderclass padding5" width="50%">
                          <table width="100%">
                              <tr>
                                  <td>
                                    <?php echo $masalahKeperawatanNeonatus; ?>
                                  </td>
                                </tr>
                          </table>
                        </td>
                        <td class="borderclass padding5" width="50%">

                        </td>
                      </tr>
                    </table>
                    <br/>
                    <table width="100%">
                      <tr class="borderclass">
                        <td class="borderclass padding5" width="50%">Rencana Keperawatan Keperawatan</td>
                        <td class="borderclass padding5" width="50%"></td>
                      </tr>
                      <tr>
                        <td class="borderclass padding5" width="50%">
                          <table width="100%">
                              <tr>
                                  <td>
                                    <?php echo $rencanaKeperawatan; ?>
                                  </td>
                                </tr>
                          </table>
                        </td>
                        <td class="borderclass padding5" width="50%">

                        </td>
                      </tr>
                    </table>
                    <br/>
                    <table width="100%">
                      <tr class="borderclass">
                        <td class="borderclass padding5" width="50%">Tindakan Keperawatan</td>
                        <td class="borderclass padding5" width="50%"></td>
                      </tr>
                      <tr>
                        <td class="borderclass padding5" width="50%">
                          <table width="100%">
                              <tr>
                                  <td>
                                    <?php echo $tindakanKeperawatan; ?>
                                  </td>
                                </tr>
                          </table>
                        </td>
                        <td class="borderclass padding5" width="50%">

                        </td>
                      </tr>
                    </table>
                    <br/><br/><br/>
                    <table width="100%">
                        <tr>
                            <td style="width:30%; text-align: left; padding-left: 50px;" colspan="2">
                        <center>
                          <div style="text-align: left"><?php echo $modProfilRs->kabupaten->kabupaten_nama ?>, <br/>
                          Jam : <?php echo date('H:i:s', strtotime($model->tgl_assesmen_awal)) . " WIB"; ?><br/></div>
                          Pasien/ Keluarga
                            <br><br><br><br><br><br>
                            <?php
                            $dokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                            $namaDpjp = "";

                            if (isset($dokter)) {
                                $namaDpjp = $dokter->namaLengkap;
                            }

                            echo $namaDpjp;
                            ?><br />
                        </center>
                        </td>
                        <td style="width:30%; text-align: left;" colspan="2" >
                        </td>
                        <td style="width:40%; text-align: left;" colspan="2" >
                          <div style="padding-left: 50px;text-align: left"><?php echo $modProfilRs->kabupaten->kabupaten_nama ?>, <?php echo date('d', strtotime($model->tgl_assesmen_awal)) . ' ' . MyFormatter::getMonthId(date('m', strtotime($model->tgl_assesmen_awal))) . ' ' . date('Y', strtotime($model->tgl_assesmen_awal));?><br/>
                          Jam : <?php echo date('H:i:s', strtotime($model->tgl_assesmen_awal)) . " WIB"; ?><br/>
                          </div>
                        <center>
                            Perawat yang Melakukan pengkajian
                            <br><br><br><br><br><br>
                              <?php echo $model->paramedis_nama; ?><br />
                        </center>
                        </td>
                        </tr>
                    </table>
            </td>
        </tr>
        </div>
        </td>
        </tr>

    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space" style="text-align: right">2019-2022</div>
            </td>
        </tr>
    </tfoot>
</table>
