<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style type="text/css">
    body{
    color: black;
  }
  
    .fa{
        font-size: 11pt;
    }
    
   .table-custom td{
       padding: 5px;
   } 
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pemeriksaan</b>
                </div>
            </div>
            <div class="panel-body">
                <table class="table-custom">
                    <tr>
                        <td width="150px">Instalasi/ Ruangan</td>
                        <td width="5px">:</td>
                        <td><?php echo $modPendaftaran->instalasi->instalasi_nama .' / '.$modPendaftaran->ruangan->ruangan_nama; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Periksa</td>
                        <td>:</td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($modPemeriksaanFisik->tglperiksafisik); ?></td>
                    </tr>
                    <tr>
                        <td>Keadaan Umum</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->keadaanumum; ?></td>
                    </tr>
                    <tr>
                        <td>Dokter</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->pegawai->namaLengkap; ?></td>
                    </tr>
                    <tr>
                        <td>Perawat</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->paramedis_nama; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Tanda Vital
                </div>
            </div>
            <div class="panel-body">
                <table class="table-custom">
                    <tr>
                        <td width="200px">Tekanan Darah</td>
                        <td width="5px">:</td>
                        <td><?php echo (isset($modPemeriksaanFisik->tekanandarah) ? $modPemeriksaanFisik->tekanandarah : " - ") . ' /MmHg'; ?></td>
                    </tr>
                    <tr>
                        <td>Mean Arteri Pressure</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->meanarteripressure; ?></td>
                    </tr>
                    <tr>
                        <td>Detak Nadi</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->detaknadi . '/Menit'; ?></td>
                    </tr>
                    <tr>
                        <td>Detak Jantung</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->denyutjantung; ?></td>
                    </tr>
                    <tr>
                        <td>Pernapasan</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->pernapasan . '/Menit'; ?></td>
                    </tr>
                    <tr>
                        <td>Suhu Tubuh</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->suhutubuh ?>&#176 Celcius</td>
                    </tr>
                    <tr>
                        <td>Tinggi Badan/ Berat Badan</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->tinggibadan_cm . ' Cm /' ?><br><?php echo $modPemeriksaanFisik->beratbadan_kg . ' Kg'; ?></td>
                    </tr>
                    <tr>
                        <td>Index Masa Tubuh</td>
                        <td>:</td>
                        <td><?php echo (isset($modPemeriksaanFisik->indexmassatubuh) ? $modPemeriksaanFisik->indexmassatubuh : " - "); ?></td>
                    </tr>
                    <tr>
                        <td>Kelainan Pada Bag. Tubuh</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->kelainanpadabagtubuh; ?></td>
                    </tr>
                    <tr>
                        <td>Reflek Cahaya</td>
                        <td>:</td>
                        <td>
                            <span class="<?php echo (($modPemeriksaanFisik->tandavital_reflekcahaya == true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> <label>Positif</label>
                            <span style="padding-left: 15px" class="<?php echo (($modPemeriksaanFisik->tandavital_reflekcahaya == false)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> <label>Negatif</label>   
                        </td>
                    </tr>
                    <tr>
                        <td>SPO2</td>
                        <td>:</td>
                        <td><?php echo $modPemeriksaanFisik->tandavital_spo2; ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>
