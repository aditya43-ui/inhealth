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
    .textcenter{
      text-align: center;
    }
    .textbold{
      font-weight: bold;
    }

    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .tablecustom th, .tablecustom td{
        color: black;
        padding: 10px;
        border: 1px solid black;
    }
</style>

<div class="pageDetail" id="pageDetail_1">
    <h3>SKALA RESIKO JATUH MORSE FALL SCALE UNTUK PASIEN DEWASA (&ge; 13 TAHUN)</h3>

  <div class="panel panel-success">
     <div class="panel-heading">
         <div class="panel-title">Pengkajian Skor Resiko Jatuh</div>
     </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="150px">Tanggal Pendaftaran/<br/> No. Pendaftaran</td>
                        <td width="5px">:</td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)."/ <br/>".$modPendaftaran->no_pendaftaran; ?></td>
                    </tr>
                    <tr>
                        <td>Instalasi/ Ruangan</td>
                        <td>:</td>
                        <td><?php echo (!empty($model->ruangan)? (!empty($model->ruangan->instalasi) ? $model->ruangan->instalasi->instalasi_nama : "") :"")."/ <br/>". (!empty($model->ruangan)?  $model->ruangan->ruangan_nama : ""); ?></td>
                    </tr>
                    <tr>
                        <td>Tgl/ Jam<br/> Pengkajian Resiko</td>
                        <td>:</td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($model->tanggal_pengkajian) ."/ <br/>". $model->jam_pengkajian; ?></td>
                    </tr>
                  </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                  <tr>
                        <td width="150px">Petugas Pengisi</td>
                        <td width="5px">:</td>
                        <td><?php echo $model->petugas->namaLengkap; ?></td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td><?php echo $model->waktupengkajian_resikojatuh; ?></td>
                    </tr>
                  </table>
                </td>
            </tr>
        </table>
        <br/>
        <table class="tablecustom" width="100%">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th width="100px">Risiko</th>
                    <th>Penilaian</th>
                    <th width="50px">Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                  $hasilPenc = array();

                  if(!empty($modHasil)){
                    foreach($modHasil as $dataHasil){
                      if($dataHasil->parameter == 'Usia'){
                        $hasilPenc[0]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[0]['skor'] = $dataHasil->skor;
                      }else if($dataHasil->parameter == 'Defisit Sensoris'){
                        $hasilPenc[1]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[1]['skor'] = $dataHasil->skor;
                      }else if($dataHasil->parameter == 'Aktivitas'){
                        $hasilPenc[2]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[2]['skor'] = $dataHasil->skor;
                      }else if($dataHasil->parameter == 'Riwayat Jatuh'){
                        $hasilPenc[3]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[3]['skor'] = $dataHasil->skor;
                      }else if($dataHasil->parameter == 'Kognisi'){
                        $hasilPenc[4]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[4]['skor'] = $dataHasil->skor;
                      }else if($dataHasil->parameter == 'Pengobatan'){
                        $hasilPenc[5]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[5]['skor'] = $dataHasil->skor;
                      }else if($dataHasil->parameter == 'Mobilitas'){
                        $hasilPenc[6]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[6]['skor'] = $dataHasil->skor;
                      }else if($dataHasil->parameter == 'Pola BAB/BAK'){
                        $hasilPenc[7]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[7]['skor'] = $dataHasil->skor;
                      }else if($dataHasil->parameter == 'Komorbiditas'){
                        $hasilPenc[8]['penilaian'] = $dataHasil->penilaian;
                        $hasilPenc[8]['skor'] = $dataHasil->skor;
                      }
                    }
                  }
                ?>
                <tr>
                    <td>1</td>
                    <td>Usia</td>
                    <td>
                      <?php echo (!empty($hasilPenc[0]['penilaian']) ? $hasilPenc[0]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[0]['skor']) ? $hasilPenc[0]['skor']: 0); ?>
                    </td>
                </tr>
                <tr>
                  <td>2</td>
                    <td>Defisit Sensoris</td>
                    <td>
                      <?php echo (!empty($hasilPenc[1]['penilaian']) ? $hasilPenc[1]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[1]['skor']) ? $hasilPenc[1]['skor']: 0); ?>
                    </td>
                </tr>
                <tr>
                  <td>3</td>
                    <td>Aktivitas</td>
                    <td>
                      <?php echo (!empty($hasilPenc[2]['penilaian']) ? $hasilPenc[2]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[2]['skor']) ? $hasilPenc[2]['skor']: 0); ?>
                    </td>
                </tr>
                <tr>
                <td>4</td>
                    <td>Riwayat Jatuh</td>
                    <td>
                      <?php echo (!empty($hasilPenc[3]['penilaian']) ? $hasilPenc[3]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[3]['skor']) ? $hasilPenc[3]['skor']: 0); ?>
                    </td>
                </tr>
                <tr>
                <td>5</td>
                    <td>Kognisi</td>
                    <td>
                      <?php echo (!empty($hasilPenc[4]['penilaian']) ? $hasilPenc[4]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[4]['skor']) ? $hasilPenc[4]['skor']: 0); ?>
                    </td>
                </tr>
                <tr>
                <td>6</td>
                    <td>Pengobatan</td>
                    <td>
                      <?php echo (!empty($hasilPenc[5]['penilaian']) ? $hasilPenc[5]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[5]['skor']) ? $hasilPenc[5]['skor']: 0); ?>
                    </td>
                </tr>
                <tr>
                <td>7</td>
                    <td>Mobilitas</td>
                    <td>
                      <?php echo (!empty($hasilPenc[6]['penilaian']) ? $hasilPenc[6]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[6]['skor']) ? $hasilPenc[6]['skor']: 0); ?>
                    </td>
                </tr>
                <tr>
                <td>8</td>
                    <td>Pola BAB/BAK</td>
                    <td>
                      <?php echo (!empty($hasilPenc[7]['penilaian']) ? $hasilPenc[7]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[7]['skor']) ? $hasilPenc[7]['skor']: 0); ?>
                    </td>
                </tr>
                <tr>
                <td>9</td>
                    <td>Komorbiditas</td>
                    <td>
                      <?php echo (!empty($hasilPenc[8]['penilaian']) ? $hasilPenc[8]['penilaian']: ""); ?>
                    </td>
                    <td>
                      <?php echo (!empty($hasilPenc[8]['skor']) ? $hasilPenc[8]['skor']: 0); ?>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="3">Jumlah Skor</td>
                    <td><?php echo $model->totalskor; ?></td>
                </tr>
                <tr>
                    <td colspan="2">Pasien termasuk kategori risiko jatuh :</td>
                    <td colspan="2"><?php echo $model->keteranganskor_resikojatuh; ?></td>
                </tr>
            </tbody>
        </table>
      </div>
  </div>
</div>

<div class="pageDetail" id="pageDetail_2">
  <h2>SKALA RESIKO JATUH MORSE FALL SCALE UNTUK PASIEN DEWASA (&ge; 13 TAHUN)</h2>

  <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Intervensi Pencegahan Jatuh</div>
    </div>
      <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                  <table width="100%" class="tablefont">
                    <tr>
                        <td width="150px">Tgl. Intervensi Pencegahan Jatuh</td>
                        <td width="5px">:</td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($modIntervensi->tgl_intervensi); ?></td>
                    </tr>
                    <tr>
                        <td>Jam Intervensi Pencegahan Jatuh</td>
                        <td>:</td>
                        <td><?php echo $modIntervensi->jam_intervensi; ?></td>
                    </tr>
                  </table>
                </td>
                <td width="50%">
                  <table width="100%" class="tablefont">
                  <tr>
                        <td width="150px">Petugas Pengisi</td>
                        <td width="5px">:</td>
                        <td><?php echo $modIntervensi->petugas->namaLengkap; ?></td>
                    </tr>
                    <tr>
                        <td>Resiko Jatuh</td>
                        <td>:</td>
                        <td><?php echo $modIntervensi->resikojatuh_tingkat; ?></td>
                    </tr>
                    <tr>
                        <td>Evaluasi</td>
                        <td>:</td>
                        <td><?php echo (($modIntervensi->evaluasi_pencegahanjatuh != null)? (($modIntervensi->evaluasi_pencegahanjatuh==1)?"Ya":"Tidak"):""); ?></td>
                    </tr>
                  </table>
                </td>
            </tr>
        </table>
        <br/>
        <table class="tablecustom" width="100%">
            <thead>
                <tr>
                    <th width="100px" class="textcenter">PROTOKOL</th>
                    <th colspan="2">TINDAKAN PENCEGAHAN</th>
                    <th width="50px" class="textcenter">DILAKUKAN</th>
                </tr>
            </thead>
            <tbody>
              <?php $modMasterIntervensiRendah = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'rendah' and kelompok_pasien = 'dewasa' ORDER BY intervensipencegahanjatuh_urutan ASC"); ?>
                <tr>
                  <td rowspan="<?php echo(count((array)$modMasterIntervensiRendah)+1); ?>">
                    <strong>STANDAR 1 RESIKO RENDAH</strong>
                  </td>
                  <td style="display: none;"></td>
                </tr>
                <?php
                  if(count((array)$modMasterIntervensiRendah)>0){
                      $noRendah = 1;
                      foreach ($modMasterIntervensiRendah as $ir => $dataInvRendah){
                          $oriIntevensi = new IntervensicegahjatuhpasiendetT();

                          if(is_array($modDetail) && count($modDetail)>0){
                              foreach ($modDetail as $dataOriIntervensi){
                                  if($dataOriIntervensi->intervensicegahjatuh_tingkat == $dataInvRendah->intervensipencegahanjatuh_tingkat && $dataOriIntervensi->intervensicegahjatuh_nama == $dataInvRendah->intervensipencegahanjatuh_nama){
                                      $oriIntevensi->isdilakukan_r = $dataOriIntervensi->isdilakukan;
                                  }
                              }
                          }
                          ?>
                            <tr>
                                <td width="50px">
                                  <?php echo $noRendah; ?>
                                </td>
                                <td>
                                  <?php echo $dataInvRendah->intervensipencegahanjatuh_nama; ?>
                                </td>
                                <td>
                                  <?php echo (($oriIntevensi->isdilakukan_r != null) ? (($oriIntevensi->isdilakukan_r==1)?"Ya":"Tidak") : ""); ?>
                                </td>
                            </tr>
                          <?php
                          $noRendah++;
                      }
                  }
              ?>
              <?php $modMasterIntervensiSedang = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'tinggi' and kelompok_pasien = 'dewasa' ORDER BY intervensipencegahanjatuh_urutan ASC"); ?>
                <tr>
                  <td rowspan="<?php echo(count((array)$modMasterIntervensiSedang)+1); ?>">
                    <strong>RESIKO JATUH TINGGI (PROTOKOL 1,2)</strong>
                  </td>
                  <td style="display: none;"></td>
                </tr>
                <?php
                  if(count($modMasterIntervensiSedang)>0){
                    $noSedang = 1;
                    foreach ($modMasterIntervensiSedang as $is => $dataInvSedang){
                        $oriIntevensi = new IntervensicegahjatuhpasiendetT();
    
                        if(is_array($modDetail) && count($modDetail)>0){
                            foreach ($modDetail as $dataOriIntervensi){
                                if($dataOriIntervensi->intervensicegahjatuh_tingkat == $dataInvSedang->intervensipencegahanjatuh_tingkat && $dataOriIntervensi->intervensicegahjatuh_nama == $dataInvSedang->intervensipencegahanjatuh_nama){
                                    $oriIntevensi->isdilakukan_s = $dataOriIntervensi->isdilakukan;
                                }
                            }
                        }
                        ?>
                            <tr>
                                <td width="50px">
                                  <?php echo $noSedang; ?>
                                </td>
                                <td>
                                  <?php echo $dataInvRendah->intervensipencegahanjatuh_nama; ?>
                                </td>
                                <td>
                                  <?php echo (($oriIntevensi->isdilakukan_r != null) ? (($oriIntevensi->isdilakukan_r==1)?"Ya":"Tidak") : ""); ?>
                                </td>
                            </tr>
                        <?php
                        $noSedang++;
                    }
                }
              ?>
              <?php $modMasterIntervensiTinggi = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'sangat_tinggi' and kelompok_pasien = 'dewasa' ORDER BY intervensipencegahanjatuh_urutan ASC"); ?>
                <tr>
                  <td rowspan="<?php echo(count((array)$modMasterIntervensiTinggi)+1); ?>">
                    <strong>RESIKO JATUH SANGGAT TINGGI (PROTOKOL 1,2,3)</strong>
                  </td>
                  <td style="display: none;"></td>
                </tr>
                <?php
                  if(count($modMasterIntervensiTinggi)>0){
                    $noTinggi = 1;
                    foreach ($modMasterIntervensiTinggi as $it => $dataInvTinggi){
                        $oriIntevensi = new IntervensicegahjatuhpasiendetT();
    
                        if(is_array($modDetail) && count($modDetail)>0){
                            foreach ($modDetail as $dataOriIntervensi){
                                if($dataOriIntervensi->intervensicegahjatuh_tingkat == $dataInvTinggi->intervensipencegahanjatuh_tingkat && $dataOriIntervensi->intervensicegahjatuh_nama == $dataInvTinggi->intervensipencegahanjatuh_nama){
                                    $oriIntevensi->isdilakukan_t = $dataOriIntervensi->isdilakukan;
                                }
                            }
                        }
                        ?>
                        <tr>
                                <td width="50px">
                                  <?php echo $noTinggi; ?>
                                </td>
                                <td>
                                  <?php echo $dataInvRendah->intervensipencegahanjatuh_nama; ?>
                                </td>
                                <td>
                                  <?php echo (($oriIntevensi->isdilakukan_r != null) ? (($oriIntevensi->isdilakukan_r==1)?"Ya":"Tidak") : ""); ?>
                                </td>
                            </tr>
                        <?php
                        $noTinggi++;
                    }
                }
              ?>
            </tbody>
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
    window.scrollTo(0, 0);
    $('#pagerdata').val(index);
    $('.previous').show();
    $('.next').show();
    $('.pageDetail').hide();
    $('#pageDetail_'+index).show();

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
