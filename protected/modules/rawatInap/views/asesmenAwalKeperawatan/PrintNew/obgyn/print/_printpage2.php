<table width="100%">
  <tr>
      <td class="textbold padding5 borderclass bordernonetopclass">
          PENILAIAN RESIKO JATUH
      </td>
  </tr>
  <tr>
    <td colspan="2" class="padding10 borderclass">
      <?php if($model->jenisresikojatuh == 'dewasa'){ ?>
          <div class="panel panel-default panel-shadow">
             <div class="panel-heading">
                 <div class="panel-title"><strong>Skrinning Resiko Jatuh Dewasa (Morse Falls Scale)</strong></div>
             </div>
              <div class="panel-body">
                <table class="tableBorder" style="width: 100%">
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
               <div class="panel-title"><strong>Skrinning Resiko Lansia (Sidney Scoring)</strong></div>
           </div>
          <div class="panel-body">
            <table class="tableBorder" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th style="width: 210px">Parameter</th>
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
                        <td>Apakah pasien delirium? (tidak membuat keputusan, pola piker tidak terorganisir, gangguan daya ingat)</td>
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
    </td>
  </tr>
  <tr>
      <td class="textbold padding5 borderclass">
          SKRINING STATUS FUNGSIONAL
      </td>
  </tr>
  <tr>
    <td colspan="2" class="padding10 borderclass">
      <?php if($model->jenis_statusfungsional == 'jenis_fungsionaladl'){ ?>
        <table width="100%">
            <tr>
              <td>
                <table width="100%" class="tablefont">
                  <tr>
                    <td>
                      Jenis Skrining Status Fungsional : ADL (Activity Daily Living)
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
                <td>
                    <table class="tableBorder" style="width: 80%;">
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
                       <tr>
                           <td colspan="3">Perawat Pengisi</td>
                           <td colspan="2"> <?php echo (isset($modBarthelindexadlT->perawat)?$modBarthelindexadlT->perawat->namaLengkap:"-") ?></td>
                       </tr>
                       <tr>
                           <td colspan="5">
                             <b>Keterangan Score Penilaian Status Fungsioanl</b>
                             <br/>
                             Mandiri : 20
                             Tergantungan Ringan : 12-15<br/>
                             Tergantungan Sedang : 9-11<br/>
                             Tergantungan Berat : 5-8<br/>
                             Tergantungan Total : 0-4
                           </td>
                       </tr>
                    </table>
                </td>
            </tr>
        </table>
      <?php }else{ ?>
        <table width="100%">
            <tr>
                <td width="60%">
                    <table class="tableBorder" width="100%">
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
                <td width="3%" valign="top"></td>
                <td width="30%" valign="top">
                    <table class="tableBorder" width="100%">
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
                <td width="2%" valign="top"></td>
            </tr>
        </table>
        <?php } ?>
    </td>
</tr>
</table>
