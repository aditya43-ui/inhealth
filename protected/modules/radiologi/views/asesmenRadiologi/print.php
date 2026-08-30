<style>
    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, "Noto Sans", sans-serif, Arial, sans-serif !important;
        font-size: 11px !important;
    }
    .content, .content div, .content table, .content tbody, .content tfoot, .content tr, .content td, .content p {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, "Noto Sans", sans-serif, Arial, sans-serif !important;
        font-size: 11px !important;
    }
    #css {
        /* font-family: Times New Roman; */
        font-family: "Open Sans", "Helvetica Neue", Helvetica, "Noto Sans", sans-serif, Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        text-align: center;
        font-size: 11px;
    }

    #css td, #css th {
        border: 1px solid black;
        padding: 8px;
        font-size: 11px;
    }
    #css th, #css td {
        padding-top: 8px;
        padding-bottom: 8px;
        font-size: 11px;
    }

    #css2 {
        /* font-family: Times New Roman; */
        font-family: "Open Sans", "Helvetica Neue", Helvetica, "Noto Sans", sans-serif, Arial, sans-serif;
        text-align: center;
        width: 100%;
        font-size: 11px;
    }
    
    #css2 td, #css2 th, #css2 tr {
        border: none;
        padding: 8px;
        font-size: 11px;
    }
    .nama_top {
        width: 100px;
        text-align: left;
        border: none;
        font-size: 11px;
        font-weight: normal;
    }
    .nama_top2 {
        text-align: left;
        border: none;
        font-size: 11px;
        font-weight: normal;
    }
    h4 {
      text-align: center;
      font-size: 11px !important;
    }
    h3 {
        margin: 0 15px;
        font-weight: bold;
        font-size: 11px !important;
    }
    .content{
      border: solid 1px black;
    }
    .container{
        padding: 0 30px;
    }
</style>

<!-- Logo & Header -->
<div>
  <div style="display: flex; justify-content: center">
    <div style="width: 100%; border: 1px solid black; padding: 8px;">
      <?php 
          echo '<img src="'.Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit.'" style="width: 50%;padding:0px;display: block;">';
          // echo '<br>';
          // echo '<br>';
      ?>
    </div>
    <div style="width: 100%; border: 1px solid black; padding: 8px;">
        <table>
            <tr>
              <th class="nama_top">No. RM </th><th class="nama_top2">: <?php echo $modPendaftaran->pasien->no_rekam_medik ?></th>  
            </tr>
            <tr>
              <th class="nama_top">NAMA (L/P) </th><th class="nama_top2">: <?php echo $modPendaftaran->pasien->nama_pasien ?></th> 
            </tr>
            <tr>
                <th class="nama_top">TGL LAHIR </th><th class="nama_top2">: <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir) ?></th>  
            </tr>
        </table>
    </div>
  </div>
</div>

<div class="content">
    <center><h4>ASESMEN AWAL DAN EDUKASI <br> DOSIS RADIASI PEMERIKSAAN R.I.R</h4></center>

    <h3> <b>1. Asesmen Awal</b> </h3>
    <div class="container">
        <div>Keluhan : <?php echo empty($modRadiologi->keluhan) ? '-' : $modRadiologi->keluhan ?></div>
        <div>Riwayat Penyakit : <?php echo empty($modRadiologi->riwayatpenyakit) ? '-' : $modRadiologi->riwayatpenyakit ?></div>
        <div>
            Riwayat Alergi :
            <?php
                $data = json_decode($modRadiologi->riwayatalergi, true);
                foreach($data as $key => $value) {
                    foreach($value as $key2 => $value2) {
                        if($value2 === '0'){
                            $value2 = '- ';
                        } else {
                            $value2 = '&#10004; ';
                        }
                        echo $value2 . " " . $key . "<span style='margin: 0 15px;'> | </span>";
                    }
                }
            ?>
            Lainnya : <?php echo empty($modRadiologi->riwayatalergi_lainnya) ? '-' : $modRadiologi->riwayatalergi_lainnya ?>
        </div>
        <div>
            Riwayat Kebiasaan :
            <?php
                $data = json_decode($modRadiologi->riwayatkebiasaan, true);
                foreach($data as $key => $value) {
                    foreach($value as $key2 => $value2) {
                        if($value2 === '0'){
                            $value2 = '- ';
                        } else {
                            $value2 = '&#10004; ';
                        }
                        echo $value2 . " " . $key . "<span style='margin: 0 15px;'> | </span>";
                    }
                }
            ?>
            Lainnya : <?php echo empty($modRadiologi->riwayatkebiasaan_lainnya) ? '-' : $modRadiologi->riwayatkebiasaan_lainnya ?>
        </div>
        <!-- <div>
            Penilaian Nyeri : <?php //echo "&#8226; " .  empty($modRadiologi->penilaian_nyeri) ? '-' : $modRadiologi->penilaian_nyeri ?>
        </div>
        <div> 
            Keterangan Lain : <?php //echo empty($modRadiologi->keterangan_lain) ? '-' : $modRadiologi->keterangan_lain ?>
        </div> -->
        <div>
            Pernah difoto : <?php echo "&#8226; " .  empty($modRadiologi->is_pernahdifoto) ? '-' : $modRadiologi->is_pernahdifoto ?>
            | Foto apa <?php echo empty($modRadiologi->foto_apa) ? '-' : $modRadiologi->foto_apa ?>
            | Berapa kali <?php echo empty($modRadiologi->brp_kali) ? '-' : $modRadiologi->brp_kali ?>
        </div>
        <div>
            Ada keluhan : <?php echo "&#8226; " .  empty($modRadiologi->is_adakeluhan) ? '-' : $modRadiologi->is_adakeluhan ?>
            | Keluhan apa <?php echo empty($modRadiologi->keluhan_apa) ? '-' : $modRadiologi->keluhan_apa ?>
        </div>
        <div>
            Hamil/Program : <?php echo "&#8226; " .  empty($modRadiologi->is_programhamil) ? '-' : $modRadiologi->is_programhamil ?>
            | Bulan ke berapa <?php echo empty($modRadiologi->bulan_ke_brp) ? '-' : $modRadiologi->bulan_ke_brp ?>
        </div>
    </div>

    <h3> <b>2. Penyampaian Informasi, Edukasi Pemeriksaan dan Penerimaan Dosis Radiasi</b> </h3>
    <div class="container">
        a. Pemeriksaan radiologi diagnosis, diagnostik, imaging dan radiologi intercensional <br>
        b. Penerimaan dosis radiologi pada saat pemeriksaan radiologi untuk keperluan medik, diperkenankan bedasarkan pertimbangan bahwa manfaat yang diperoleh jauh lebih besar daripada risiko bahaya radiasi yang ditimbulkan bagi pasien. <br>
        c. Kemungkinan resiko yang dapat terjadi akibat paparan radiasi adalah efek carciogenik bila diberikan paparan radiasi yang berulang-ulang dengan dosis yang cukup bersar. <br>
        d. Paparan medik yang diterima oleh pasien sebagai bagian dari diagnosis atau pengobatan medik bertujuan mengetahui penyakit atau keluhan lain yang dirasa dan dikeluhkan pasien dengan persetujuan DPJP <br>
    </div>

    <h3> <b>3. Nama dan Paraf</b> </h3>
    <div class="container">
        <table id="css">
            <tr>
                <th>Pasien</th>
                <th>Keluarga</th>
                <th>Petugas</th>
            </tr>
            <tr>
                <th style="padding-top: 12%;"><?php echo empty($modPasien->nama_pasien) ? '-' : $modPasien->nama_pasien ?></th>
                <th style="padding-top: 12%;"><?php echo empty($modRadiologi->keluarga_yg_menyatakan) ? '-' : $modRadiologi->keluarga_yg_menyatakan ?></th>
                <th style="padding-top: 12%;"><?php echo empty($modRadiologi->pegawai->nama_pegawai) ? '-' : $modRadiologi->pegawai->nama_pegawai ?></th>
            </tr>
        </table>
    </div>

    <br><div class="col-sm-12" style="border: 1px solid black;"></div><br>

    <h3 style="text-align: center;"> <b> PERSETUJUAN </b> </h3>
    <div class="container">
        Saya mengetahui bahwa saya memiliki kondisi yang membutuhkan perawatan medis, saya mengizinkan dokter dan professional kesehatan lainnya untuk melakukan prosedur diagnosis,
        yang diperlukan dalam penilaian proffesional mereka, meliputi : <br><br>
        1. Pemeriksaan Radiognostik, meliputi <?php echo empty($modRadiologi->pemeriksaan_radiagnostik) ? '-' : $modRadiologi->pemeriksaan_radiagnostik ?><br>
        2. Pemeriksaan Radiologi imaging, meliputi <?php echo empty($modRadiologi->pemeriksaan_radiologiimaging) ? '-' : $modRadiologi->pemeriksaan_radiologiimaging ?><br>
        3. Pemeriksaan Radiologi intervensional, meliputi <?php echo empty($modRadiologi->pemeriksaan_radiologiintervensional) ? '-' : $modRadiologi->pemeriksaan_radiologiintervensional ?><br><br>
        Saya sadar bahwa praktik kedokteran khususnya bidang diagnostik, imaging dan radiologi intervensional menggunakan sumber radiasi yang dipergunakan untuk membantu
        menegakkan diagnasa keluhan/penyakit yang saya alama saat ini. Penerimaan paparan radiasi kepada diri saya dalam nilai btas dosis (NBD) yang aman dan direkomendasikan
        dibidang kesehatan serta diatus dalam peraturan nasional maupun internasional. <br>
        Dengan tanda tangan saya dibawah ini, <br>
        saya menyatakan <b><?php echo empty($modRadiologi->status_persetujuan) ? '-' : $modRadiologi->status_persetujuan ?></b> dilakukan pemeriksaan tersebut, dan saya telah membaca, memahami dan menyetujui seluruh kriteria-kriteria yang terdapat pada tindakan radiologi ini. <br><br>
    
        <table id="css2">
            <tr>
                <th></th>
                <th></th>
                <th>Surabaya, 
                    <?php
                        function tgl_indo($tanggal){
                            $bulan = array (
                                1 =>   'Januari',
                                'Februari',
                                'Maret',
                                'April',
                                'Mei',
                                'Juni',
                                'Juli',
                                'Agustus',
                                'September',
                                'Oktober',
                                'November',
                                'Desember'
                            );
                            $pecahkan = explode('-', $tanggal);
                            
                            // variabel pecahkan 0 = tanggal
                            // variabel pecahkan 1 = bulan
                            // variabel pecahkan 2 = tahun
                            
                            return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
                        }
                            
                        echo tgl_indo(date('Y-m-d'));
                    ?>
                </th>
            </tr>
            <tr>
                <th>Yang Menyatakan</th>
                <th>Saksi I</th>
                <th>Saksi II</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo empty($modRadiologi->yang_menyatakan) ? '-' : $modRadiologi->yang_menyatakan ?></th>
                <th><?php echo empty($modRadiologi->saksi1) ? '-' : $modRadiologi->saksi1 ?></th>
                <th><?php echo empty($modRadiologi->saksi2) ? '-' : $modRadiologi->saksi2 ?></th>
            </tr>
        </table>
    
    </div>



</div>