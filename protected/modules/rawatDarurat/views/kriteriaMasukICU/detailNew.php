<style type="text/css">
  html{
    font-size: 11pt !important;
    color: black;
  }

  body{
      color: black !important;
      margin: 0;
      padding: 0;
  }

  .tableBorder th, .tableBorder td {
      border:1px solid #000;
      padding: 10px;
  }

  .tablePadding th, .tablePadding td {
      padding: 10px;
  }
</style>
<div style="float: right; padding-right: 10px; padding-top: 5px; padding-bottom: 10px; font-weight: bold;">FRM/91A/RSBMB</div>
<table class="tablePadding" width="100%">
  <tr>
    <td width="150px">Tanggal Pemeriksaan</td>
    <td width="5px">:</td>
    <td>
      <?php echo MyFormatter::formatDateTimeForUser($model->tanggal_pemeriksaan); ?>
    </td>
  </tr>
  <tr>
    <td>Petugas Pemeriksa</td>
    <td>:</td>
    <td>
      <?php echo MyFormatter::formatDateTimeForUser($model->petugas_pemeriksa); ?>
    </td>
  </tr>
  <tr>
    <td>Ruangan</td>
    <td>:</td>
    <td>
      <?php $ruangan = RuanganM::model()->findByPk($model->create_ruangan);
          echo (!empty($ruangan)?$ruangan->ruangan_nama:""); ?>
    </td>
  </tr>
</table>

<?php

  $kardio = ['Miokard infark akut dengan komplikasi' => $model->kardiovaskular_ismiokardinfark, 'Shock Kardiogenik' => $model->kardiovaskular_iskardiogenik,
  'Aritmia kompleks yang membutuhkan monitoring ketat dan intervensi invasif' => $model->kardiovaskular_isaritmiakompleks,
  'Congestive heart failure akut disertai gagal nafas yang memerlukan support' => $model->kardiovaskular_ischfakut, 'Hipertensi emergensi' => $model->kardiovaskular_ishipertensi,
  'Angina pektoris tidak stabil, terutama dengan adanya disritmia, instabilitas hemodinamik, atau nyeri dada yang menetap' => $model->kardiovaskular_isanginapektoris,
  'Pasca pemulihan setelah henti jantung' => $model->kardiovaskular_ispemulihan, 'Tamponade jantung atau konstriksi curah jantung disertai instabilitasi haemodinamik' => $model->kardiovaskular_istamponadejantung,
  'Diseksi aneurisma aorta' => $model->kardiovaskular_isdiseksi, 'Blok jantung kompleks (derajat 3)' => $model->kardiovaskular_isblokjantung,
  'Sindrom coroner akut tanpa perbaikan nyeri iskemik paska terapi' => $model->kardiovaskular_issindromcoroner,
  'Pemasangan pompa balon intraaorta atau alat bantu ventrikel mekanik yang lain' => $model->kardiovaskular_isintraaorta,
  'Pemantauan kateter arteri pulmonal atau tekanan vena sentral yang terkait dengan masalah jantung' => $model->kardiovaskular_iskateter,
  'Gagal jantung kronis dekompensata yang membutuhkan' => $model->kardiovaskular_isgagaljantung, 'Laju Jantung < 50x / menit atau > 150x / menit dengan instabilitas hemodinamik' => $model->kardiovaskular_islajujantung];

  $resp = [
    'Gagal pernafasan akut yang membutuhkan bantuan ventilator'=> $model->respirasi_isgagalpernafasan,
    'Emboli paru disertai instabilitas haemodinami'=> $model->respirasi_isemboliparu,
    'Pasien ruang perawatan High Care Unit yang menunjukan perburukan fungsi pernafasan'=> $model->respirasi_isgagalpernafasan,
    'Hemoptisis massif'=> $model->respirasi_ishemoptisis,
    'Gagal nafas yang membutuhkan intubasi dan ventilator'=> $model->respirasi_isgagalnapas,
    'Ventilasi atau oksigenasi yang bergantung pada ventilator mekanik'=> $model->respirasi_isventilasi,
    'Obstruksi Jalan nafas akut atau yang baru terjadi atau gangguan refleks perlindungan jalan nafas akut'=> $model->respirasi_isobstruksi,
    'Laju pernafas >30 atau < 8 x/menit,retraksi/penggunaan otot nafas tambahan,dan/ atau pola pernafasan yang tidak stabil (misal pernafasan (Cheyne Stokes)'=> $model->respirasi_islajupernapasan,
    'PaO2 < 60 mmHg atau SaO2 < 90% dan sudah dilakukan terapi oksigen'=> $model->respirasi_isterapioksigen,
    'PaCO2 > 60 mmHg dan pH < 7,1 atau pH > 7,7 dengan instabilitas hemodinamik'=> $model->respirasi_isinstabilitas,
    'Pertimbangan bahwa intubasi endoktrakeal dibutuhkan dalam waktu 4 - 8 jam kemudian'=> $model->respirasi_isintubasi
  ];

  $gastro = [
    'Perdarahan gastrointestinal yang mengancam nyawa sampai terjadi hipotensi, angina, perdarahan yang berlanjut, atau terdapat penyakit penyerta'=> $model->gastrointestinal_ispendarahan,
    'Kegagalan hati fulminant'=> $model->gastrointestinal_iskegagalanhati,
    'Pankreatitis berat'=> $model->gastrointestinal_ispankreatitis,
    'Perforasi esophageal'=> $model->gastrointestinal_isperforasi,
    'Obtruksi intestinal akut karena gangguan mobilitas usus'=> $model->gastrointestinal_isobstruksi,
    'Abdomen yang tegang dengan pertimbangan adanya hipertensi intra abdomen atau sindroma kompartemen abdomen dan perlu pemantauan ketat tekanan intra abdome'=> $model->gastrointestinal_isabdomen
  ];

  $renal = [
    'Membutuhkan terapi pengganti ginjal (CRRT, Continous Renal Replacement Therapy)'=> $model->renal_isterapi,
    'Gagal ginjal yang baru di diagnosis dengan azotemia berat (ureum > 200mg /dL)'=> $model->renal_isgagalginjal,
    'Produksi urine < 0,5 ml/kg/jam selama lebih dari 3 jam dan ada gangguan hemodinamik yang tidak membaik dengan fluid challenge test'=> $model->renal_isproduksiurine,
    'Penurunan akut bersihan keratin (creatinine clearance < 30 ml/menit)'=> $model->renal_isbersihankeratin,
  ];

  $endo = [
    'Ketoasisdosis diabetik dengan komplikasi instabilitas hemodinamik, perubahan status mental, gangguan pernafasan, dan atau asidosis berat'=> $model->endokri_isketoasisdosis,
    'Thyroid storm atau koma miksedema dengan instabilitas haemodinami'=> $model->endokri_isthyroidstorm,
    'Kondisi hyperosmolar disertai koma dan/ atau instabilitas hemodinamik yang ketat'=> $model->endokri_ishyperosmolar,
    'Permasalahan endokrin lainnya seperti krisis adrenal dengan instabilitas hemodinamik'=> $model->endokri_ispermasalahanendokrin,
    'Hipofosfatemia disertai kelemahan otot'=> $model->endokri_ishipofosfatemia,
    'Hipo atau hipermagnesemia dengan instabilitas hemodinamik atau disritmi'=> $model->endokri_ishipermagnesemia,
    'Kalsium serum < 5 mg/dL atau > 12 mg/dL disertai perubahan status mental atau membutuhkan monitoring hemodinamik'=> $model->endokri_iskalsiumserum,
    'Natrium serum < 110 mEq/L atau >155 mEq/L disertai kejang atau perubahan status mental'=> $model->endokri_isnatriumserum,
    'Kalium serum < 2,5 mEq/L atau > 6.0 mEq/L disertai disritmia atau kelemahan otot'=> $model->endokri_iskaliumserum,
    'Glukosa serum < 60 atau > 300 mg/dL disertai perubahan status mental'=> $model->endokri_isglukosaserum,
  ];

    $hema = [
      'Adanya hemolisis aktif dengan penurunan hematokrit'=> $model->hematologi_ishemolisis,
      'Trombositopenia (platelete < 70.000) dengan bukti perdarahan aktif'=> $model->hematologi_istrombositopenia,
      'Koagulopati (INR > 2.5 atau Active partial tromboplastin time [aPTT] > 40 - 50 detik) dengan bukti perdarahan aktif'=> $model->hematologi_iskoagulopati,
      'Leukosit > 100.000 / l dan terutama dengan bukti disfungsi organ targe'=> $model->hematologi_isleukosit,
    ];

  $saraf = [
    'Stroke akut dengan perubahan status mental'=> $model->sarafpusat_isstrokeakut,
    'Koma : metabolic,toxic,anoxic'=> $model->sarafpusat_iskoma,
    'Perdarahan intakranial dengan potensi terjadi herniasi atau terdapat perubahan status mental'=> $model->sarafpusat_ispendarahan,
    'Meningitis akut dengan perubahan status mental atau gangguan pernafasan'=> $model->sarafpusat_isminingitis,
    'Gangguan system saraf pusat atau neuromuscular disertai perburukan secra neurologis atau penurunan fungsi paru'=> $model->sarafpusat_isgangguansistem,
    'Status epileptikus'=> $model->sarafpusat_isepileptikus,
    'Kematian otak atau pasien yang berpotensi mati otak (brain dead) yang dengan agresif sementara menunggu status donasi'=> $model->sarafpusat_iskematianotak,
    'Pasien cidera kepala berat akut potensial terjadi perburukan'=> $model->sarafpusat_isciderakepala,
    'Kejang yang tidak terkontrol'=> $model->sarafpusat_iskejang,
    'Kelemahan otot progresif dengan keterlibatan otot otot pernafasan'=> $model->sarafpusat_iskelemahanotot,
    'Delirium berat akut' => $model->sarafpusat_isdelirium,
    'Cidera medulla spinalis untuk pemantauan haemodinamik' => $model->sarafpusat_ismedullaspinalis,
    'Setiap kondisi yang membutuhkan kraniotomi atau ventrikulostomy dengan resiko vasospasme' => $model->sarafpusat_iskraniotomi,
    'Pemantauan pasca prosedur endarterektomi karotis atau Aneurismal Coiling' => $model->sarafpusat_ispemantauan,
    'Setiap kondisi yang dihubungkan dengan peningkatan tekanan inta kranial yang berhubungan dengan defek neurologis yang progresi' => $model->sarafpusat_istekananintakranial,
    'Glasgow Coma Scale < 10' => $model->sarafpusat_isgcs
  ];

  $sepsis = [
    'Shock yang tidak dapat dijelaskan, dengan atau tanpa hipotensi dan perlu hemodinamik monitoring invasif'=> $model->sepsis_isshock,
    'Shock septik dengan instabilitas hemodinamik'=> $model->sepsis_isshockseptik,
    'Bukti adanya shock dengan tekanan darah sistolik < 90 mmHg atau menurun 20 mmHg dari tekanan darah normalnya dan sudah dilakukan resusitasi cairan yang adekuat'=> $model->sepsis_istekanandarah,
    'Asidosis laktat (laktat >4.0 mmol/L)'=> $model->sepsis_isasidosislaktat,
  ];

  $bedah = [
    'Pasien sebelum atau sesudah pembedahan yang memerlukan monitoring ketat (terutama hemodinamik / bantuan ventilasi mekanin) atau perawatan intensif'=> $model->pembedahan_ismonitoring,
    'Pasien perioperative dengan resiko tinggi (kondisi sebelum/pasca beda yang umumnya membutuhkan pemantauan dan tindakan invasif antara lain, seperti: Bedah Jantung terbuka, Bedah Thoraks Kardiovaskuler,Bedah Syaraf,Bedah THT-Kraniofasial-Jalan nafas, Bedah Orthopedi dan Tulang belakang servial, Transplantasi Organ, Bedah Anak,Bedah Urologi dengan komplikasi, Bedah Obsteri dan Ginekologi dengan gangguan pernafasan dan hemodinamik dan Bedah Digestif/umum/lainnya dengan gangguan respirasi dan hemodinamik atau pembedahan dengan kehilangan darah dalam jumlah besar serta waktu yang lama (> 6 jam).'=> $model->pembedahan_isperioperative,
  ];

  $luka = [
    'Setiap pasien luka bakar dewasa dan anak dengan trauma inhalasi'=> $model->lukabakar_istrauma,
    'Setiap pasien luka bakar dewasa > 30% dengan atau tanpa trauma inhalasi ( < 24 jam pasca trauma)'=> $model->lukabakar_istanpatraumakurang,
    'Setiap pasien luka bakar anak >10% dengan atau tanpa trauma inhalasi (>24 jam pasca trauma)'=> $model->lukabakar_istanpatraumalebih,
    'Setiap pasien luka bakar dewasa >30%, > 24 jam pasca trauma dengan salah satu atau lebih gangguan saluran nafas (Airway), pernafasan(Breathing),sirukulasi(Circulation)'=> $model->lukabakar_ispascatraumabesar,
    'Setiap pasien luka bakar dewasa >10%, > 24 jam pasca trauma dengan salah satu atau lebih gangguan saluran nafas (Airway), pernafasan(Breathing),sirukulasi(Circulation)'=> $model->lukabakar_ispascatraumakecil,
  ];

  $lain = [
    'Cidera akibat lingkungan (petir,tenggelam(drowning),hipo/hipertermia'=> $model->kondisilain_iscidera,
    'Trauma multiple dengan atau tanpa gangguan kardiovaskular'=> $model->kondisilain_istrauma,
    'Pengobatan baru / eksperimental yang berpotensi mengalami komplikasi'=> $model->kondisilain_ispengobatan,
    'Intoksisasi obat akut dengan gangguan reflek jalan nafas, ketidakstabilan hemodinamik, aritmia jantung, dan/ atau membutuhkan pengawaswan tindakan bunuh diri'=> $model->kondisilain_isgangguanreflek,
    'Intoksisasi obat akut yang membutuhkan obat obatan infus kontinyu atau pemberian berkala obat obat intravena'=> $model->kondisilain_isobatinfus,
    'Intoksisasi obat akut yang memerlukan dialisis'=> $model->kondisilain_isdialisis,
    'Kondisi metabolik lainnya (misal:rabdomiolisis berat memerlukan pemantauan berkala atau intervensi medis)'=> $model->kondisilain_ismetabolik,
    'Pasien Kehamilan dengan komplikasi hemodiamik, respirasi dan susunan syaraf pusat'=> $model->kondisilain_iskehamilan,
    'Pasien Preeklampasi dengan komplikasi hemodinamik,respirasi dan susunan syaraf pusat'=> $model->kondisilain_isgangguanmultiorgan,
    'Pasien Eklampsia'=> $model->kondisilain_iseklampsia,
    'Pasien emboli air ketuba' => $model->kondisilain_isemboli,
  ];


?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><strong>Checklist Kriteria Masuk ICU</strong></div>
    </div>
    <div class="panel-body">
      <table class="tableBorder" width="100%">
           <tbody>
             <tr>
               <td width="70%"colspan="2">A. Kriteria masuk berdasarkan sistem organ</td>
               <td width="15%"></td>
               <td width="15%"></td>
             </tr>
             <tr>
               <td colspan="4"><b>a) Gangguan sistem kardiovaskular</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_kardio = 0 ?>
             <?php
                foreach($kardio as $label1 => $kd) {
                  if($no_kardio == 14) {
                    echo "<tr>";
                    echo "<td colspan='2'><b>Parameter fisiologis</b></td>";
                    echo "<td><b>Masuk</b></td>";
                    echo "<td><b>Tidak Masuk</b></td>";
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_kardio . ") </td>";
                  echo "<td>" . $label1 . "</td>";
                  echo "<td>" . ($kd ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$kd ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
             <tr>
               <td colspan="4"><b>b) Gangguan sistem respirasi</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_resp = 0 ?>
             <?php
                foreach($resp as $label2 => $rp) {
                  if($no_resp == 7) {
                    echo "<tr>";
                    echo "<td colspan='2'><b>Parameter fisiologis/laboratorium</b></td>";
                    echo "<td><b>Masuk</b></td>";
                    echo "<td><b>Tidak Masuk</b></td>";
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_resp . ") </td>";
                  echo "<td>" . $label2 . "</td>";
                  echo "<td>" . ($rp ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$rp ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
             <tr>
               <td colspan="4"><b>c) Gangguan sistem gastrointestinal</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_gastro = 0 ?>
             <?php
                foreach($gastro as $label3 => $gast) {
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_gastro . ") </td>";
                  echo "<td>" . $label3 . "</td>";
                  echo "<td>" . ($gast ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$gast ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
             <tr>
               <td colspan="4"><b>d) Gangguan sistem renal</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_renal = 0 ?>
             <?php
                foreach($renal as $label4 => $ren) {
                  if($no_renal == 1) {
                    echo "<tr>";
                    echo "<td colspan='2'><b>Parameter fisiologis/laboratorium</b></td>";
                    echo "<td><b>Masuk</b></td>";
                    echo "<td><b>Tidak Masuk</b></td>";
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_renal . ") </td>";
                  echo "<td>" . $label4 . "</td>";
                  echo "<td>" . ($ren ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$ren ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
              <tr>
               <td colspan="4"><b>e) Gangguan sistem endokri</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_endo = 0 ?>
             <?php
                foreach($endo as $label4 => $edk) {
                  if($no_endo == 6) {
                    echo "<tr>";
                    echo "<td colspan='2'><b>Parameter fisiologis/laboratorium</b></td>";
                    echo "<td><b>Masuk</b></td>";
                    echo "<td><b>Tidak Masuk</b></td>";
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_endo . ") </td>";
                  echo "<td>" . $label4 . "</td>";
                  echo "<td>" . ($edk ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$edk ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
              <tr>
               <td colspan="4"><b>f) Gangguan sistem hematologi</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_hema = 0 ?>
             <?php
                foreach($hema as $label5 => $hm) {
                  if($no_hema == 1) {
                    echo "<tr>";
                    echo "<td colspan='2'><b>Parameter fisiologis/laboratorium</b></td>";
                    echo "<td><b>Masuk</b></td>";
                    echo "<td><b>Tidak Masuk</b></td>";
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_hema . ") </td>";
                  echo "<td>" . $label5 . "</td>";
                  echo "<td>" . ($hm ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$hm ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
             <tr>
               <td colspan="4"><b>g) Gangguan sistem saraf pusat</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_saraf = 0 ?>
             <?php
                foreach($saraf as $label5 => $srf) {
                  if($no_saraf == 15) {
                    echo "<tr>";
                    echo "<td colspan='2'><b>Parameter fisiologis/laboratorium</b></td>";
                    echo "<td><b>Masuk</b></td>";
                    echo "<td><b>Tidak Masuk</b></td>";
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_saraf . ") </td>";
                  echo "<td>" . $label5 . "</td>";
                  echo "<td>" . ($srf ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$srf ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
             <tr>
               <td colspan="4"><b>h) Sepsis dan syok sepsis</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_sepsis = 0 ?>
             <?php
                foreach($sepsis as $label5 => $sps) {
                  if($no_sepsis == 2) {
                    echo "<tr>";
                    echo "<td colspan='2'><b>Parameter fisiologis/laboratorium</b></td>";
                    echo "<td><b>Masuk</b></td>";
                    echo "<td><b>Tidak Masuk</b></td>";
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_sepsis . ") </td>";
                  echo "<td>" . $label5 . "</td>";
                  echo "<td>" . ($sps ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$sps ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
             <tr>
               <td colspan="4"><b>i) Pemantauan sebelum dan sesudah pembedahan</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_bedah = 0 ?>
             <?php
                foreach($bedah as $label5 => $bdh) {
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_bedah . ") </td>";
                  echo "<td>" . $label5 . "</td>";
                  echo "<td>" . ($bdh ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$bdh ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
              <tr>
               <td colspan="4"><b>j) Luka bakar</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_luka = 0 ?>
             <?php
                foreach($luka as $label5 => $lk) {
                  if($no_luka == 1) {
                    echo "<tr>";
                    echo "<td colspan='2'><b>Parameter fisiologis/laboratorium</b></td>";
                    echo "<td><b>Masuk</b></td>";
                    echo "<td><b>Tidak Masuk</b></td>";
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_luka . ") </td>";
                  echo "<td>" . $label5 . "</td>";
                  echo "<td>" . ($lk ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$lk ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>

              <tr>
               <td colspan="4"><b>k) Gangguan kondisi lain</b></td>
             </tr>
             <tr>
               <td colspan="2"><b>Diagnosis/Kondisi Klinis</b></td>
               <td><b>Masuk</b></td>
               <td><b>Tidak Masuk</b></td>
             </tr>
             <?php $no_lain = 0 ?>
             <?php
                foreach($lain as $label5 => $ln) {
                  echo "<tr>";
                  echo "<td width='3%;'>" . ++$no_lain . ") </td>";
                  echo "<td>" . $label5 . "</td>";
                  echo "<td>" . ($ln ? "&#x2714;" : "") . "</td>";
                  echo "<td>" . (!$ln ? "&#x2714;" : "") . "</td>";
                  echo "</tr>";
                }
             ?>
             
           </tbody>
      </table>
    </div>
</div>
