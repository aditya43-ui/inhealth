<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
  .tablefont td{
        color: black;
        padding: 10px;
    }
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

    .textcenter{
      text-align: center;
    }
    .textbold{
      font-weight: bold;
    }
    .padding5{
      padding: 5px;
    }

    .table-custom th, .table-custom td{
      border: 1px solid black;
      padding: 5px;
    }
</style>
<?php
  $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
 ?>
<div style="font-weight: bold" class="borderbottomclass padding5">RM 01</div>
<table width="100%">
  <tr>
    <td width="30%" class="padding5">
      <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="height: 80px;"/>
    </td>
    <td width="70%"></td>
  </tr>
  <tr>
    <td width="100%" class="padding5" style="padding-left: 50px">
      <font style="font-size:12px;"><?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit) . ' ' . ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' ' . ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?></font>
      <font style="font-size:12px;"> Telp : <?php echo $modProfilRs->no_telp_profilrs; ?></font>
    </td>
  </tr>
  <tr>
    <td width="100%">
      <center>
        <div style="width: 90%;" class="borderbottomclass"></div>
        <div style="width: 90%; padding-top: 5px" class="borderbottomclass"></div>
      </center>
    </td>
  </tr>
</table>
<br/>
<center>
  <div style="font-weight: bold; font-size: 16pt; text-decoration: underline;">
    RINGKASAN MASUK & KELUAR
  </div>
</center>
<br/>
<table width="100%">
  <tr>
    <td width="50%" class="padding5" valign="top">
      <table class="tablefont" width="100%">
        <tr>
          <td width="250px">
            Nama Pasien
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $modPasien->nama_pasien; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Nomor Rekam Medik
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $modPasien->no_rekam_medik; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Tanggal Lahir
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $modPasien->tanggal_lahir; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Pendidikan
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $model->pendidikan_nama; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Pekerjaan
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $model->pekerjaan_nama; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Alamat Lengkap
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $modPasien->alamat_pasien; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            No. Telepon
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $modPasien->no_mobile_pasien; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Status Perkawinan
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $modPasien->statusperkawinan; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Nama Penanggung Jawab Pembayar
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $model->nama_pj; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Nama Keluarga Terdekat
          </td>
          <td>
            <div style="width: 90%" class="borderbottomclass">: <?php echo $model->hubungankeluarga; ?></div>
          </td>
        </tr>
      </table>
    </td>
    <td width="50%" class="padding5" valign="top">
      <table class="tablefont" width="100%">
        <tr>
          <td width="200px">
            Alamat Keluarga Terdekat
          </td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $model->alamat_pj; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Agama
          </td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $modPasien->agama; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Jenis Pasien
          </td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $modPendaftaran->carabayar_nama; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Ruangan rawat
          </td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $modPendaftaran->ruangan_nama; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Kelas
          </td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $modPendaftaran->kelaspelayanan_nama; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Tanggal Masuk
          </td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $modPendaftaran->tgl_pendaftaran; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Tanggal Keluar
          </td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $modPasienPulang->tglpasienpulang; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            Lama dirawat
          </td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $model->lamarawat; ?></div>
          </td>
        </tr>
        <tr>
          <td valign="top">
            Diagnosa Masuk
          </td>
          <td>
            : <?php echo nl2br($model->diagnosa_masuk); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br/>
<table width="100%">
  <tr>
    <td width="50%" class="borderclass padding5">
      Diagnosa Akhir
    </td>
    <td width="50%" class="borderclass padding5">
      Sebab Kekerasan/Kecelakaan/Keracunan
    </td>
  </tr>
  <tr>
    <td width="50%" class="borderclass padding5" valign="top">
      <table class="table-custom" width="100%">
        <thead>
          <tr>
            <th>Kelompok Diagnosa</th>
            <th>Klasifikasi Diagnosa</th>
            <th>Nama Diagnosa</th>
            <th>Kode Diagnosa</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(count($pasienMorbid) > 0){
              foreach($pasienMorbid as $pasMorbid){
                ?>
                <tr>
                  <td><?php echo (isset($pasMorbid->kelompokdiagnosa)?$pasMorbid->kelompokdiagnosa->kelompokdiagnosa_nama:""); ?></td>
                  <td><?php echo (isset($pasMorbid->diagnosa)? (isset($pasMorbid->diagnosa->klasifikasidiagnosa)? $pasMorbid->diagnosa->klasifikasidiagnosa->klasifikasidiagnosa_nama : ""):""); ?></td>
                  <td><?php echo (isset($pasMorbid->diagnosa)?$pasMorbid->diagnosa->diagnosa_nama:""); ?></td>
                  <td><?php echo (isset($pasMorbid->diagnosa)?$pasMorbid->diagnosa->diagnosa_kode:""); ?></td>
                </tr>
                <?php
              }
            }else{
              echo '<tr><td colspan="4">Data Tidak Ditemukan</td></tr>';
            }
           ?>
        </tbody>
      </table>
    </td>
    <td width="50%" class="borderclass padding5" valign="top">
      <table class="tablefont" width="100%">
        <tr>
          <td width="150px">Komplikasi</td>
          <td>: <?php echo $model->komplikasi; ?></td>
        </tr>
        <tr>
          <td>Patologi</td>
          <td>: <?php echo $model->patologi; ?></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="50%" class="borderclass padding5">
      Data Operasi
    </td>
    <td width="50%" class="borderclass padding5">
      Data Tindakan
    </td>
  </tr>
  <tr>
    <td width="50%" class="borderclass padding5" valign="top">
      <table class="table-custom" width="100%">
        <thead>
          <tr>
            <th>Tanggal Operasi</th>
            <th>Nama Operasi</th>
            <th>Golongan Operasi</th>
            <th>Jenis Anastesi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(count($modRencanaOperasi) > 0){
              foreach($modRencanaOperasi as $rencanaOp){
                ?>
                <tr>
                  <td><?php echo MyFormatter::formatDateTimeForUser($rencanaOp->tglrencanaoperasi); ?></td>
                  <td><?php echo (isset($rencanaOp->operasi)? $rencanaOp->operasi->operasi_nama:""); ?></td>
                  <td><?php echo (isset($rencanaOp->golonganoperasi)?$rencanaOp->golonganoperasi->golonganoperasi_nama:""); ?></td>
                  <td><?php echo (isset($rencanaOp->pasienanastesi)? (isset($rencanaOp->pasienanastesi->jenisanastesi)?$rencanaOp->pasienanastesi->jenisanastesi->jenisanastesi_nama : ""):""); ?></td>
                </tr>
                <?php
              }
            }else{
              echo '<tr><td colspan="4"></td></tr>';
            }
           ?>
        </tbody>
      </table>
    </td>
    <td width="50%" class="borderclass padding5" valign="top">
      <table class="table-custom" width="100%">
        <thead>
          <tr>
            <th>Tanggal Tindakan</th>
            <th>Pemeriksaan</th>
            <th>Pemeriksa</th>
          </tr>
        </thead>
        <tbody>
          <?php
          
            
            $res = array();
            
            if (!empty($model->tindakanyangdipilih) && is_array($model->tindakanyangdipilih)) {
                foreach ($model->tindakanyangdipilih as $id => $item) {
                    if ($item == 1) {
                        $res[] = $id;
                    }
                }
            }
            
            $modTindakanPelayanan = TindakanpelayananT::model()->findAllByAttributes(array(
                'tindakanpelayanan_id'=>$res,
            ));
          
            if(count($modTindakanPelayanan) > 0){
                foreach($modTindakanPelayanan as $tindakan){
                  ?>
                    <tr>
                        <td><?php echo MyFormatter::formatDateTimeForUser($tindakan->tgl_tindakan); ?></td>
                        <td><?php echo (isset($tindakan->daftartindakan)? $tindakan->daftartindakan->daftartindakan_nama:""); ?></td>
                        <td><?php echo empty($tindakan->dokter1) ? "-" : $tindakan->dokter1->namaLengkap; ?></td>
                    </tr>
                  <?php
                }
            }else{
                echo '<tr><td colspan="4"></td></tr>';
            }
           ?>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td width="50%" class="padding5" valign="top">
      <table class="tablefont" width="100%">
        <tr>
          <td width="150px">Infeksi Nosokomial</td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $model->lamarawat; ?></div>
          </td>
        </tr>
        <tr>
          <td colspan="2">Imunisasi yang pernah didapat :</td>
        </tr>
        <tr>
          <td colspan="2" style="padding: 0px 10px 0px 10px;">
            <table width="100%">
              <?php
                $lookupImunisasi =  LookupM::model()->findAll("lookup_type = 'imunisasididapat' order by lookup_urutan ASC");

                if(count($lookupImunisasi) > 0){
                  $indexTr = 0;
                  $htmlImunisasi = "";

                  foreach($lookupImunisasi as $look){
                    $indexTr += 1;

                    if($indexTr == 1){
                      $htmlImunisasi .= "<tr>";
                    }
                    $htmlImunisasi .= "<td>";
                    $htmlImunisasi .= "<span class='".((!empty($model->imunisasididapat) && is_array($model->imunisasididapat) && (in_array($look->lookup_value, $model->imunisasididapat)))?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                    $htmlImunisasi .= "</td>";
                    if($indexTr == 3){
                      $htmlImunisasi .= "</tr>";
                      $indexTr = 0;
                    }
                  }
                  echo $htmlImunisasi;
                }
               ?>
             </table>
          </td>
        </tr>
        <tr>
          <td colspan="2">Pengobatan radio terapi / Kedokteran nuklir :</td>
        </tr>
        <tr>
          <td colspan="2">
            <?php echo $model->pengobatanradioterapi; ?>
          </td>
        </tr>
        <tr>
          <td>Keadaan Keluar</td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php
            $carakeluar = CarakeluarM::model()->findByPk($model->carakeluar_id);
             echo (isset($carakeluar)?$carakeluar->carakeluar_nama:""); ?></div>
          </td>
        </tr>
        <tr>
          <td colspan="2">Alergi :</td>
        </tr>
        <tr>
          <td colspan="2">
            <?php echo $model->alergipasien; ?>
          </td>
        </tr>
      </table>
    </td>
    <td width="50%" class="padding5" valign="top">
      <table class="tablefont" width="100%">
        <tr>
          <td width="150px">Penyebab Infeksi</td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $model->penyebabinfeksi; ?></div>
          </td>
        </tr>
        <tr>
          <td colspan="2">Imunisasi yang diperoleh selama dirawat :</td>
        </tr>
        <tr>
          <td colspan="2">
            <?php echo $model->imunisasidirawatinap; ?>
          </td>
        </tr>
        <tr>
          <td>Transfusi Darah</td>
          <td>
            <div style="width: 80%; display: inline-block;" class="borderbottomclass">: <?php echo $model->transfusidarah; ?></div> cc
          </td>
        </tr>
        <tr>
          <td>Golongan Darah</td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $model->golongandarah; ?></div>
          </td>
        </tr>
        <tr>
          <td>Catatan Keluar</td>
          <td>
            <div style="width: 80%" class="borderbottomclass">: <?php echo $model->catatankeluar; ?></div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br/><br/>
<table width="100%">
  <tr>
    <td width="60%" valign="top"></td>
    <td width="40%" valign="top">
      <center>
        Dokter Yang Merawat,
        <br/><br/><br/><br/><br/><br/>
        (<?php echo $model->dokteryangmerawat->namaLengkap; ?>)<br/>
        <span style="font-style: italic;">Nama dokter yang merawat</span>
      </center>
    </td>
  </tr>
</table>
