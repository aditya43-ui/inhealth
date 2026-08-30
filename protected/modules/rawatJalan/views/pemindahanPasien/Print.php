<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    .fa{
        font-size: 11pt;
    }

    body{
        color: black !important;
    }

    h5{
        color: black !important;
    }

    label{
        color: black !important;
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

    .textbold{
      font-weight: bold;
    }
    .text-center{
        text-align: center !important;
    }

    .table-border tbody td, .table-border thead th{
        border: 1px solid black !important;
        padding: 5px;
    }
    .padding5{
      padding: 5px;
    }
    .bordernonetop{
      border-top: none !important;
    }

    .tablefont td{
            color: black;
            padding: 5px;
        }
</style>
<div class="textbold">FRM/02.1/RSBM</div>
<?php echo $this->renderPartial($this->path_view.'_headerSurat',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
<table width="100%">
  <tr>
    <td class="borderclass padding5 bordernonetop">
      Situation
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <table width="100%">
        <tr>
          <td width="50%" valign="top">
            <table class="tablefont" width="100%">
              <tr>
                <td width="150px">Ruangan Asal</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->ruanganasal->ruangan_nama; ?>
                </td>
              </tr>
              <tr>
                <td>Jenis Pemindahan</td>
                <td>:</td>
                <td>
                  <?php echo $model->jenispemindahan; ?>
                </td>
              </tr>
              <tr>
                <td>Instalasi Tujuan</td>
                <td>:</td>
                <td>
                  <?php echo $model->instalasitujuan->instalasi_nama; ?>
                </td>
              </tr>
              <tr>
                <td>Ruangan Tujuan</td>
                <td>:</td>
                <td>
                  <?php echo $model->ruangantujuan->ruangan_nama; ?>
                </td>
              </tr>
              <tr>
                <td>Tanggal Pemindahan</td>
                <td>:</td>
                <td>
                  <?php echo MyFormatter::formatDateTimeForUser($model->tanggal_pemindahan); ?>
                </td>
              </tr>
              <tr>
                <td>Jam Pemindahan</td>
                <td>:</td>
                <td>
                  <?php echo $model->jam_pemindahan; ?>
                </td>
              </tr>
              <tr>
                <td>Dokter yang merawat</td>
                <td>:</td>
                <td>
                  <?php echo $model->dokterperegawat->namaLengkap; ?>
                </td>
              </tr>
            </table>
          </td>
          <td width="50%" valign="top">
            <table class="tablefont" width="100%">
              <tr>
                <td width="150px" valign="top">Diagnosa Medis</td>
                <td width="5px" valign="top">:</td>
                <td>
                  <?php echo nl2br($model->diagnosa); ?>
                </td>
              </tr>
              <tr>
                <td valign="top">Pasien/Keluarga Sudah di jelaskan mengenai diagnosa</td>
                <td valign="top">:</td>
                <td valign="top">
                  <span class="<?php echo (($model->ispemberitahudiagnosa==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Ya
                  <span style="padding-left: 10px" class="<?php echo (($model->ispemberitahudiagnosa==false)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Tidak
                </td>
              </tr>
              <tr>
                <td>Prosedur Invasif/Pembedahan</td>
                <td>:</td>
                <td>
                  <?php echo $model->prosedurinvasif; ?>
                </td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>
                  <?php echo (!empty($model->tanggal_prosedur)?MyFormatter::formatDateTimeForUser($model->tanggal_prosedur):""); ?>
                </td>
              </tr>
              <tr>
                <td>Masalah Keperawatan</td>
                <td>:</td>
                <td>
                  <?php echo $model->masalahkeperawatan; ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5 bordernonetop">
      Background
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <table width="100%">
        <tr>
          <td width="50%" valign="top">
            <table class="tablefont" width="100%">
              <tr>
                <td width="150px" valign="top">Riwayat Alergi / Reaksi Obat</td>
                <td width="5px" valign="top">:</td>
                <td>
                  <span class="<?php echo (($model->isriwayatalergi==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Ya
                  <span style="padding-left: 10px" class="<?php echo (($model->isriwayatalergi==false)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Tidak
                    <br/> <?php echo $model->riwayat_ket; ?>
                </td>
              </tr>
              <tr>
                <td>Riwayat Reaksi</td>
                <td>:</td>
                <td>
                  <?php echo $model->riwayatreaksi; ?>
                </td>
              </tr>
              <tr>
                <td>Intervensi Medik</td>
                <td>:</td>
                <td>
                  <?php echo $model->intervensimedik; ?>
                </td>
              </tr>
            </table>
          </td>
          <td width="50%" valign="top">
            <table class="tablefont" width="100%">
              <tr>
                <td width="150px" valign="top">Hasil Investigasi Abnormal</td>
                <td width="5px" valign="top">:</td>
                <td>
                  <?php echo $model->investigasiabnormal; ?>
                </td>
              </tr>
              <tr>
                <td valign="top">Kewaspadaan</td>
                <td valign="top">:</td>
                <td valign="top">
                  <?php echo $model->kewaspadaan; ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5 bordernonetop">
      Assesment
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <table width="100%">
        <tr>
          <td width="50%" valign="top">
            <table class="tablefont" width="100%">
              <tr>
                <td width="150px" valign="top">Observasi Terakhir Pukul</td>
                <td width="5px" valign="top">:</td>
                <td>
                    <?php echo (!empty($model->observasiterakhir) ? MyFormatter::formatDateTimeForUser($model->observasiterakhir) : ""); ?>
                </td>
              </tr>
              <tr>
                <td>GCS Eye</td>
                <td>:</td>
                <td>
                  <?php echo $model->gcs_eye; ?>
                </td>
              </tr>
              <tr>
                <td>GCS Verbal</td>
                <td>:</td>
                <td>
                  <?php echo $model->gcs_verbal; ?>
                </td>
              </tr>
              <tr>
                <td>GCS Motorik</td>
                <td>:</td>
                <td>
                  <?php echo $model->gcs_motorik; ?>
                </td>
              </tr>
              <tr>
                <td>Nilai GCS</td>
                <td>:</td>
                <td>
                  <?php echo ($model->gcs_eye+$model->gcs_verbal + $model->gcs_motorik); ?>
                </td>
              </tr>
              <tr>
                <td colspan="3">Reflek Pupil</td>
              </tr>
              <tr>
                <td style="padding-left: 10px">Kanan</td>
                <td>:</td>
                <td>
                  <?php echo $model->reflekpupilkanan; ?>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 10px">Kiri</td>
                <td>:</td>
                <td>
                  <?php echo $model->reflekpupilkiri; ?>
                </td>
              </tr>
              <tr>
                <td>Tekanan Darah</td>
                <td>:</td>
                <td>
                  <?php echo $model->td_systolic.'/'.$model->td_diastolic; ?> MmHg
                </td>
              </tr>
              <tr>
                <td>Nadi</td>
                <td>:</td>
                <td>
                  <?php echo $model->nadi; ?> /Menit
                </td>
              </tr>
              <tr>
                <td>Pernapasan</td>
                <td>:</td>
                <td>
                  <?php echo $model->pernapasan; ?> / Menit
                </td>
              </tr>
              <tr>
                <td>SpO2</td>
                <td>:</td>
                <td>
                  <?php echo $model->tandavital_spo2; ?> %
                </td>
              </tr>
              <tr>
                <td>Suhu</td>
                <td>:</td>
                <td>
                  <?php echo $model->suhutubuh; ?> &#176; C
                </td>
              </tr>
              <tr>
                <td>BAB</td>
                <td>:</td>
                <td>
                  <?php echo $model->pemindahan_bab; ?>
                </td>
              </tr>
              <tr>
                <td>BAK</td>
                <td>:</td>
                <td>
                  <span class="<?php echo (($model->isbak==false)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Normal
                  <span style="padding-left: 10px" class="<?php echo (($model->isbak==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Kateter
                </td>
              </tr>
              <tr>
                <td>Jenis Kateter</td>
                <td>:</td>
                <td>
                  <?php echo $model->jeniskateter; ?>
                </td>
              </tr>
              <tr>
                <td>No Kateter</td>
                <td>:</td>
                <td>
                  <?php echo $model->no_kateter; ?>
                </td>
              </tr>
              <tr>
                <td>Tanggal Pemasangan</td>
                <td>:</td>
                <td>
                  <?php echo (!empty($model->tglpemasangan_kateter)? MyFormatter::formatDateTimeForUser($model->tglpemasangan_kateter) : ""); ?>
                </td>
              </tr>
              <tr>
                <td>Mobilisasi</td>
                <td>:</td>
                <td>
                  <?php echo $model->mobilisasi; ?>
                </td>
              </tr>
              <tr>
                <td>Transfer / Mobilisasi</td>
                <td>:</td>
                <td>
                  <?php echo $model->transfermobilisasi; ?>
                </td>
              </tr>
              <tr>
                <td>Gangguan Indra</td>
                <td>:</td>
                <td>
                  <?php echo $model->gangguanindra; ?>
                </td>
              </tr>
              <tr>
                <td>Alat Bantu yang dipakai</td>
                <td>:</td>
                <td>
                  <?php echo $model->alatabantudiapakai; ?>
                </td>
              </tr>
            </table>
          </td>
          <td width="50%" valign="top">
            <table class="tablefont" width="100%">
              <tr>
                <td colspan="3">Luka / Perawatn Decubitus</td>
              </tr>
              <tr>
                <td colspan="3" style="padding-left: 10px">
                  <span class="<?php echo (($model->islukaperawatan==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Ya
                  <span style="padding-left: 10px" class="<?php echo (($model->islukaperawatan==false)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Tidak
                </td>
              </tr>
              <tr>
                <td width="200px">Kondisi</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->kondisiperawatan; ?>
                </td>
              </tr>
              <tr>
                <td width="200px">Lokasi</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->lokasiperawatan; ?>
                </td>
              </tr>
              <tr>
                <td width="200px">Ukuran</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->ukuranperawatan; ?>
                </td>
              </tr>
              <tr>
                <td width="200px"><span class="<?php echo (($model->isinfus==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Invus / CVC</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->infuscvc; ?>
                </td>
              </tr>
              <tr>
                <td width="200px"><span class="<?php echo (($model->isvasscore==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> VAS Score</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->vasscore; ?>
                </td>
              </tr>
              <tr>
                <td width="200px">Tanggal Pemasangan</td>
                <td width="5px">:</td>
                <td>
                  <?php echo (!empty($model->tglpemasangan_perawatan)? MyFormatter::formatDateTimeForUser($model->tglpemasangan_perawatan) : ""); ?>
                </td>
              </tr>
              <tr>
                <td width="200px">Tindakan Kebutuhan Khusus</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->tindakankebutuhan_khusus; ?>
                </td>
              </tr>
              <?php
                if(!empty($model->peralatanyangdigunakan)){
                  $arrPeralatan = explode('|',$model->peralatanyangdigunakan);

                  if(count($arrPeralatan) > 0){
                    $model->alat1_ket = (isset($arrPeralatan[0])?$arrPeralatan[0]:"");
                    $model->isalat1 = (!empty($model->alat1_ket)?true:false);
                    $model->alat2_ket = (isset($arrPeralatan[1])?$arrPeralatan[1]:"");
                    $model->isalat2 = (!empty($model->alat2_ket)?true:false);
                    $model->alat3_ket = (isset($arrPeralatan[2])?$arrPeralatan[2]:"");
                    $model->isalat3 = (!empty($model->alat3_ket)?true:false);
                  }
                }
               ?>
              <tr>
                <td colspan="3">Peralatan Khusus yang diperlukan</td>
              </tr>
              <tr>
                <td width="200px"><span class="<?php echo (($model->isalat1==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Alat 1</td>
                <td width="5px"></td>
                <td>
                  <?php echo $model->alat1_ket; ?>
                </td>
              </tr>
              <tr>
                <td width="200px"><span class="<?php echo (($model->isalat2==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Alat 2</td>
                <td width="5px"></td>
                <td>
                  <?php echo $model->alat2_ket; ?>
                </td>
              </tr>
              <tr>
                <td width="200px"><span class="<?php echo (($model->isalat3==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Alat 3</td>
                <td width="5px"></td>
                <td>
                  <?php echo $model->alat3_ket; ?>
                </td>
              </tr>
              <tr>
                <td colspan="3">Hal - hal istimewa yang berhubungan dengan kondisi pasien :</td>
              </tr>
              <tr>
                <td colspan="3"><?php echo $model->investigasiabnormal; ?></td>
              </tr>
            </table>

          </td>
        </tr>
      </table>
      <br/>
      <table width="100%" class="table-border">
        <thead>
          <tr>
            <th width="50px">No</th>
            <th>Diagnosa Keperawatan</th>
            <th width="100px">Sudah Teratasi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $diagnosaKep = DiagnosakeperawatanT::model()->findAllByAttributes(array('pemindahanpasien_id'=>$model->pemindahanpasien_id));
            if(count($diagnosaKep) >0){
                $no = 0;
                foreach($diagnosaKep as $diagnosaKep){
                  $no++;

                  ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $diagnosaKep->nama_diagnosa; ?></td>
                    <td><?php echo $diagnosaKep->statusdiagnosa; ?></td>
                  </tr>
                  <?php
                }
            }
           ?>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5 bordernonetop">
      Kondisi Pasien
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <table width="100%">
        <tr>
          <td width="50%" valign="top">
            <table class="tablefont" width="100%">
              <tr>
                <td width="150px">Waktu Keadaan</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->waktukeadaan; ?>
                </td>
              </tr>
              <tr>
                <td>Keadaan Umum</td>
                <td>:</td>
                <td>
                  <?php echo $model->keadaanumum; ?>
                </td>
              </tr>
              <tr>
                <td>Kesadaran</td>
                <td>:</td>
                <td>
                  <?php echo $model->kesadaran; ?>
                </td>
              </tr>
            </table>
          </td>
          <td width="50%" valign="top">
            <table class="tablefont" width="100%">
              <tr>
                <td width="150px">Catatan Penting</td>
                <td width="5px">:</td>
                <td>
                  <?php echo $model->catatan_penting; ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br/>
      <table width="100%">
        <tr>
          <td class="borderclass padding5">Kelengkapan Dokumen</td>
        </tr>
        <tr>
          <td class="borderclass" style="padding: 10px 20px">
            <table class="table-border" width="100%">
              <thead>
                <tr>
                  <th width="80px">Check</th>
                  <th>Data Kelengkapan</th>
                  <th>Keterangan Kelengkapan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $arrMateri = array();
                  if(!empty($model->kelengkapan_dokumen)){
                    $oriMateri = json_decode($model->kelengkapan_dokumen);

                    if(count($oriMateri) >0){
                      foreach($oriMateri as $dataMateri){
                        if($dataMateri->nama == 'Obat - Obatan'){
                          $arrMateri[0] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'Hasil Laboratorium'){
                          $arrMateri[1] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'X - Ray Regio'){
                          $arrMateri[2] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'CT Scan Regio'){
                          $arrMateri[3] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'USG Regio'){
                          $arrMateri[4] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'Penunjang Radiologi lain (MRI / MRA / Lainnya)'){
                          $arrMateri[5] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'Echocardiografi'){
                          $arrMateri[6] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'Gigi Palsu'){
                          $arrMateri[7] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'Kaca Mata'){
                          $arrMateri[8] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }
                        else if($dataMateri->nama == 'Alat Bantu Dengan'){
                          $arrMateri[9] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                        }

                      }
                    }
                  }
                 ?>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[0]['iskelengkapan']) && $arrMateri[0]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    Obat - Obatan
                  </td>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[0]['keterangan']) && $arrMateri[0]['keterangan']=="Lengkap")?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Lengkap
                    <span style="padding-left: 10px" class="<?php echo ((isset($arrMateri[0]['keterangan']) && $arrMateri[0]['keterangan']=="Tidak Lengkap")?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"> Tidak Lengkap
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[1]['iskelengkapan']) && $arrMateri[1]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    Hasil Laboratorium
                  </td>
                  <td>
                    <label>Jumlah : </label>&nbsp;&nbsp;
                    <?php echo (isset($arrMateri[1]['keterangan']) ?$arrMateri[1]['keterangan'] : '' ); ?>
                    &nbsp;&nbsp;<label>Lembar</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[2]['iskelengkapan']) && $arrMateri[2]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    X - Ray Regio
                  </td>
                  <td>
                    <label>Jumlah : </label>&nbsp;&nbsp;
                    <?php echo (isset($arrMateri[2]['keterangan']) ?$arrMateri[2]['keterangan'] : '' ); ?>
                    &nbsp;&nbsp;<label>Lembar</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[3]['iskelengkapan']) && $arrMateri[3]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    CT Scan Regio
                  </td>
                  <td>
                    <label>Jumlah : </label>&nbsp;&nbsp;
                    <?php echo (isset($arrMateri[3]['keterangan']) ?$arrMateri[3]['keterangan'] : '' ); ?>
                    &nbsp;&nbsp;<label>Lembar</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[4]['iskelengkapan']) && $arrMateri[4]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    USG Regio
                  </td>
                  <td>
                    <label>Jumlah : </label>&nbsp;&nbsp;
                    <?php echo (isset($arrMateri[4]['keterangan']) ?$arrMateri[4]['keterangan'] : '' ); ?>
                    &nbsp;&nbsp;<label>Lembar</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[5]['iskelengkapan']) && $arrMateri[5]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    Penunjang Radiologi lain (MRI / MRA / Lainnya)
                  </td>
                  <td>
                    <label>Jumlah : </label>&nbsp;&nbsp;
                    <?php echo (isset($arrMateri[5]['keterangan']) ?$arrMateri[5]['keterangan'] : '' ); ?>
                    &nbsp;&nbsp;<label>Lembar</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[6]['iskelengkapan']) && $arrMateri[6]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    Echocardiografi
                  </td>
                  <td>
                    <label>Jumlah : </label>&nbsp;&nbsp;
                    <?php echo (isset($arrMateri[6]['keterangan']) ?$arrMateri[6]['keterangan'] : '' ); ?>
                    &nbsp;&nbsp;<label>Lembar</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[7]['iskelengkapan']) && $arrMateri[7]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    Gigi Palsu
                  </td>
                  <td>
                    <label>Jumlah : </label>&nbsp;&nbsp;
                    <?php echo (isset($arrMateri[7]['keterangan']) ?$arrMateri[7]['keterangan'] : '' ); ?>
                    &nbsp;&nbsp;<label>Lembar</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[8]['iskelengkapan']) && $arrMateri[8]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    Kaca Mata
                  </td>
                  <td>
                    <label>Jumlah : </label>&nbsp;&nbsp;
                    <?php echo (isset($arrMateri[8]['keterangan']) ?$arrMateri[8]['keterangan'] : '' ); ?>
                    &nbsp;&nbsp;<label>Lembar</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="<?php echo ((isset($arrMateri[9]['iskelengkapan']) && $arrMateri[9]['iskelengkapan']==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
                  </td>
                  <td>
                    Alat Bantu Dengan
                  </td>
                  <td>
                    <?php echo (isset($arrMateri[9]['keterangan']) ?$arrMateri[9]['keterangan'] : '' ); ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td width="35%" class="borderclass text-center bordernonetop padding5">
      Diketahui
    </td>
    <td width="30%" class="borderclass text-center bordernonetop padding5">
      Diserahkan Oleh
    </td>
    <td width="35%" class="borderclass text-center bordernonetop padding5">
      Diterima
    </td>
  </tr>
  <tr>
    <td width="35%" class="borderclass text-center padding5" valign="middle">
      <br/><br/>
      <?php echo (isset($model->pegawaimengetahui)?$model->pegawaimengetahui->namaLengkap:"").'<br/>'. MyFormatter::formatDateTimeForUser($model->tanggal_pemindahan); ?>
      <br/><br/>
    </td>
    <td width="30%" class="borderclass text-center padding5" valign="middle">
      <br/><br/>
      <?php echo (isset($model->perawatpengirim)?$model->perawatpengirim->namaLengkap:"").'<br/>'. MyFormatter::formatDateTimeForUser($model->tanggal_pemindahan); ?>
      <br/><br/>
    </td>
    <td width="35%" class="borderclass text-center padding5" valign="middle">
      <br/><br/>
      <?php echo ((!empty($model->ispasienditerima) && $model->ispasienditerima==true) ? (isset($model->perawatpenerima)?$model->perawatpenerima->namaLengkap:"").'<br/>'. MyFormatter::formatDateTimeForUser($model->tanggal_penerimaan) : "data belum diterima oleh pegawai ruangan"); ?>
      <br/><br/>
    </td>
  </tr>
  <tr>
    <td width="35%" class="borderclass text-center padding5">
      Dokter
    </td>
    <td width="30%" class="borderclass text-center padding5">
      <?php echo $model->tipediserahkan; ?>
    </td>
    <td width="35%" class="borderclass text-center padding5">
      <?php echo ((!empty($model->ispasienditerima) && $model->ispasienditerima==true) ? $model->tipepenerima : ""); ?>
    </td>
  </tr>
</table>
