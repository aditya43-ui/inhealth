
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienpulang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',), //'onSubmit'=>'return cekValidasi()'
    'focus' => '#',
        ));
?>


<span style="float:right; padding-top: 10px;"><h4>RM 08j K</h4></span>
<div style="padding-top: 5px; text-align:center; font-weight:bold">
    <h4 style='padding-left:35px;'>PERNYATAAN PEMBERIAN INFORMASI<br>
        DAN PERSETUJUAN TINDAKAN SEDASI & ANESTESI</h4><br>

</div>
<table width="100%" class="table-condensed" >
   
        <tr>
            <td class="headertd" style="border:1px solid black; background-color:#afdc7e" colspan='4'><b>Diisi oleh Dokter/ Perawat</b></td>
        </tr>
        <tr>
            <td style="border:1px solid black;">
                <table >
                    <tr>
                        <td>Ruangan / Poli :</td>
                        <td><?php echo $modEvaluasi->ruangan_nama ?></td>
                    </tr>
                </table>
            </td>
        </tr>
         
   
        <tr border="1" style="border:1px solid black;">
            <td style=" padding:0.5cm !important;">

                <h3><center>INFORMASI TINDAKAN SEDASI & ANESTESI</center></h3>
                <p align="justify">
                    Untuk tindakan diagnostik atau invasif dan operasi dibutuhkan tindakan sedasi dan anestesia. Sedasi dapat 
                    diberikan ringan, sedang atau berat. Sedangkan pembiusan dapat dilakukan dengan cara umum atau anestesia regional
                    (blok spinal, Epidural, dan Periferal).  Semua tindakan anestesia dan sedasi memerlukan persiapan umum berupa :
                </p>
                
                <table>
                    <tr>
                        <td>1.</td>
                        <td align="justify">Untuk dilakukan sedasi dan anestesia serta operasi berencana pasien harus berpuasa. Puasa ini penting ditaati oleh
                    pasien karena lambung pasien harus kosong untuk menghindari keluarnya isi lambung ke rongga mulut pada waktu pembiusan
                    dan isi lambung dapat masuk kedalam jalan napas dan menyebabkan sumbatan jalan napas yang fatal.<br>
                    Berikut ini adalah rekomendasi lamanya puasa sebelum anestesia dilakukan pada pasien sehat(tidak ada penyerta sepert :
                    Obesitas, DM/Diabetes Mellitus, gangguan pencernaan, ibu hamil dll).</td>
                    </tr>
                    <tr>
                        <td>
                            
                        </td>
                        <td>
                            <table border="1px" width="100%">
                            <thead>
                                <tr>
                                    <th>Jenis Makanan/Minuman</th>
                                    <th>Minimal Waktu Puasa</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cairan jernih</td>
                                    <td>2 jam</td>
                                    <td>Cairan jernih adalah air putih, sari buah(saring), minuman bersoda dan teh</td>
                                </tr>
                                <tr>
                                    <td>Air susu ibu</td>
                                    <td>4 jam</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Susu formola untuk bayi atau susu segar hewani</td>
                                    <td>6 jam</td>
                                    <td>Susu yang bukan asi akan mengalami pencernaan seperti makanan ringan</td>
                                </tr>
                                <tr>
                                    <td>Makanan ringan</td>
                                    <td>6 jam</td>
                                    <td rowspan="2">Makanan ringan yang dimaksud seperi roti atau kue, sedangkan makanan berat dipuasakan sesuai jenis dan jumlahnya</td>
                                </tr>
                                <tr>
                                    <td>Makanan berat</td>
                                    <td>6 - 8 jam</td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td align="justify">
                            Rekomendasi puasa ini berlaku untuk semua kegiatan anestesia yang direncanakan kecuali untuk operasi emergency
                    /darurat. Pada pasien dengan penyakit penyerta(obesitas, DM, gangguan pencernaan, ibu hamil, dll) anjuran diataa tidak menjamin kosong nya lambung.
                        </td>
                       
                    </tr>
                    <tr>
                        <td>2. </td>
                        <td align="justify">
                           Evaluasi oleh dokter spesialis anestesiologi & reanimasi dan konsultasi ke bidang bila diperlukan.
                        </td>
                       
                    </tr>
                    <tr>
                        <td>3. </td>
                        <td align="justify">
                          Pemeriksaan penunjang seperti laboratorium/radiologi dan Elektrokardiogram(EKG) sesuai indikasi.
                        </td>
                       
                    </tr>
                    <tr>
                        <td>4. </td>
                        <td align="justify">
                          Semua make-up(lipstik/pewarna kuku) harus dibersihkan agar warna kulit dapat dimonitor selama pembiusan.
                        </td>
                       
                    </tr>
                    <tr>
                        <td>5. </td>
                        <td align="justify">
                          Perhiasan dan gigi palsu harus dilepas.
                        </td>
                       
                    </tr>
                    <tr>
                        <td>6. </td>
                        <td align="justify">
                          Pasien menyetujui dan menandata tangani Surat Persetujuan Anestesia.
                        </td>
                       
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p align="justify">
                                <b>SEDASI RINGAN, RINGAN DAN BERAT</b>
                            </p>
                            <p align="justify">
                                Keadaan yang dihasilkan oleh efek pemberian obat yang membuat pasien dapat mentoleransi keadaan/kondisi maupun
                                prosedur yang tidak menyenangkan. Pemberian sedasi ringan adalah pemberian obat sedasi yang menyebabkan pasien
                                tenang dan masih memberikan respon terhadap rangsangan verbal. Fungsi kognitif mungkin berkuran tetapi refleks
                                perlindungan jalan nafas tetap utuh, fungsi pernafasan dan kardiovaskuler normal. Kondisi pasien bila sedasi sedang
                                masih dapat dibangunkan dengan verbal dan sentuhan, disertai stabilitas pada nafas dan kardiovaskular. Sedangkan pada
                                kondisi sedasi berat pasien sudah tertidur sulit dibangunkan. Dan kemungkinan mempertahankan jalan nafas dan fungsi
                                nafas dapat terganggu.
                            </p>
                        </td>
                    </tr>
                  
                </table>
            </td>
        </tr>    
        <tr class="page-break">
           
        </tr>
                    
               
        <tr>
            <td style="border:1px solid;padding:0.5cm !important;">
    <p align="justify">
                    <b>ANESTESIA UMUM</b>
                </p>
                <p align="justify">
                    Tindakan anestesia umum adalah pembiusan dimana pasien dibuat tidak sadar sehingga tidak merasakan nyeri. Obat bius
                    diberikan melalui penyuntikan ke dalam pembuluh darah atau melalui gas/uap yang dihirup. Lama kerja obat disesuaikan
                    dengan lama tindakan/operasi. Setelah pasien menjadi tidak sadar, bila perlu akan dipasang alat bantu jalan napas
                    ke dalam rongga mulut(pipa laryngeal) atau tenggorokan (pipa endotrakeal) agar jalan napas tetap terbuka. Oksigen dan
                    gas lain akan dialirkan melalui selang pernapasan.
                </p>
                <p align="justify">
                    <b>Pada Anestesi Umum :</b>
                </p>
                <p align="justify">
                <ul>
                    <li>Sejak awal operasi pasien sudah tidak sadar</li>
                    <li>Lama pembiusan dapat disesuaikan dengan lama operasi</li>
                    <li>Kedalaman pembiusan dapat diatur seusai kebutuhan</li>
                    <li>Obat yang diberikan berefek ke seluruh tubuh pasien, termasuk ke aliran darah janin dalam kandungan</li>
                    <li>Pasca bedah pasien harus sadar penuh sebelum bisa diberi minum</li>
                    <li>Pemulihan relatif lebih lama</li>
                </ul>
                </p>
                <p align="justify">
                    <b>Komplikasi / Efek Samping Anestesi Umum, antara lain :</b>  
                </p>
                <p align="justify">
                <ul>
                    <li>Mual, muntah, menggigil, pusing, mengantuk, sakit tenggorokan, sakit menelan, bisa diatasi dengan obat-obatan</li>
                    <li>Aspirasi (masuknya isi lambung ke dalam jalan napas) dapat terjadi pada pasien tidak puasa</li>
                    <li>Kesulitan pemasangan alat/pipa pernapasan yang tidak diduga sebelumnya, yang dapat mengakibatkan gigi patah dan trauma jalan napas</li>
                    <li>Kejang pita suara (spasme laring), kejang jalan napas bawah (spasme bronkus) dari ringan hingga berat yang dapat menyebabkan henti jantung</li>
                    <li>Alergi/hipersensitif terhadap obat(sangat jarang), mulai derajat ringan hingga berat/fatal</li>
                    <li>Komplikasi akan meningkat pada pasien usia < 1 tahun, umut lanjut, pasien dengan penyakit penyerta (jantung,ginjal,hati,saraf,paru,endokrin, dll) </li>
                    <li>Pada kondisi pasien yang diperiksa pada saat pre anestesi dinyatakan dalam kelompok risiko tinggi, dapat menyebabkan kematian saat induksi, intra operative atau pasca operative dini </li>
                </ul>
                </p>
                <p align="justify">
                    Komplikasi dapat timbul tanpa diduga sebelumnya dan akan ditangani sesuai prosedur medis yang berlaku.
                </p>
                <p align="justify">
                    <b>ANESTESI REGIONAL : BLOK SPINAL, EPIDURAL & BLOK PERIPHERAL</b>
                </p>
                <p align="justify">
                    <b>Blok spinal dan epidural</b> adalah tindakan anestesia regional yang menghilangkan sensasi bagian bawah tubuh, mulai dari
                    perut sampai ke ujung kaki dengan kesadaran tidak terganggu. Dokter Spesialis Anestesiologi & reanimasi dapat
                    memberikan obat tidur (apabila diperlukan). Pada anestesia blok spinal, obat disuntikkan di daerah punggung dengan
                    jarum yang halus. Sedangkan blok epidural menggunakan jarum yang sedikit lebih besar dengan atau tanpa pemasangan
                    selang (kateter). Posisi penyuntikan blok spinal dan epidural adalah duduk atau tidur miring. Setelah penyuntikan obat akan
                    terjadi perubahan sensasi dan merasa seperti tidak memiliki tungkai bawah. Efek ini berlangsung antara 2 atau 4 jam
                    tergantung jenis dan konsentrasi obat yang digunakan. Bila digunakan kateter(epidural), efek anestesi regional dapt
                    diualang.
                </p>
                <p align="justify">
                    <b>Blok perifer</b> adalah penyuntikan obat anestesia lokal pada daerah tertentu untuk menghilangkan sensasi setempat.
                    Umumnya blok perifer dilakukan untuk tindakan/operasi pada anggota gerak(lengan atau tungkai). Bila anestesia
                    regional gagal/tidak berhasil dilakukan maka teknik anestesia dapat diulang atau dapat dilanjutkan dengan anestesi umum.
                    Prosedur regional dapat juga dikombinasikan dengan anestesi umum.

                </p>
               
            </td>
        </tr>
        <tr  class="page-break">
            
        </tr>
        <tr>
            <td style="border:1px solid;padding:0.5cm !important;">
                 <p align="justify">
                    <b>Pada Anestesi Blok Spinal dan Epidural :</b>  
                </p>
                <p align="justify">
                <ul>
                    <li>Untuk anestesi spinal, jumlah obat yang diberikan relatif lebih sedikit daripada anestesi epidural</li>
                    <li>Obat bius lokal yang disuntikkan akan diserap ke seluruh tubuh dalam jumlah sedikit sehingga hanya sedikit yang menuju aliran darah janin</li>
                    <li>Pada kateter epidural dapat dilakukan pengendalian nyeri pasca operasi pada waktu yang lama</li>
                    <li>Dapat langsung minum dan makan segera setelah tindakan/operasi selesai</li>
                    <li>Relatif lebih aman untuk pasien yang tidak puasa atau lama puasanya kurang (operasi darurat)</li>
                    <li>Rasa nyeri dan posisi yang kurang nyaman pada saat penyuntikan</li>
                </ul>
                </p>
                <p align="justify">
                    <b>Komplikasi/Efek Samping Anestesi Blok Spinal dan Epidural, antara lain:</b>  
                </p>
                <p align="justify">
                <ul>
                    <li>Mual, muntah, gatal-gatal terutama di daerah wajah, menggigil</li>
                    <li>Sakit kepala di bagian depan atau belakang pada hari ke 2 atau ke 3, terutama sewaktu mengangkat kepala, dan mengilang setelah 5 sampai 7 hari </li>
                    <li>Alergi/hipersensitif terhadap obat(sangat jarang) mulai ringan sampai berat</li>
                    <li>Gangguan pernapasan dari mulai ringan sampai berat(henti napas)</li>
                    <li>Gangguan saraf perifer atau kesemutan/rasa baal yang memanjang</li>
                    <li>Sakit pinggang</li>
                    <li>Kejang</li>
                    <li>Hematom (lebam/memar) pada lokasi penyuntikan dan kesulitan teknis lain</li>
                </ul>
                </p>
                <p align="justify">
                    <b>Pada Anestesis Blok Peripheral :</b>  
                </p>
                <p align="justify">
                <ul>
                    <li>Tidak mempengaruhi organ tubuh lain</li>
                    <li>Efek hilangnya sensasi cukup kuat dan bertahan lama</li>
                    <li>Lebih aman untuk pasien dengan risiko tinggi</li>
                    <li>Nyeri pada tempat penyuntikan</li>
                    <li>Dapat terjadi blok parsial(tidak seluruh bagian yang akan dioperasikan bebas nyeri) yang memerlukan tambahan obat anestesia umum</li>
                </ul>
                </p>
                <p align="justify">
                    <b>Komplikasi/Efek Samping Anestesi Blok Peripheral, antara lain:</b>  
                </p>
                <p align="justify">
                <ul>
                    <li>Perdarahan pada tempat penyuntikan, terutama bila terkena pembuluh darah</li>
                    <li>Blok yang memanjang lebih dari perkiraan sebelumnya</li>
                    <li>Kejang</li>
                    <li>Gangguan saraf perifer atau kesemutan/rasa baal yang memanjang</li>
                    <li>Hematom (lebam/memar) pada lokasi penyuntikan dan kesulitan teknis lain</li>
                </ul>  
                </p>
                <p align="justify">
                    Komplikasi dapat timbul tanpa diduga sebelumnya dan akan ditangani sesuai prosedur medis yang berlaku. Bila masih ada
                    hal yang belum jelas, maka dapat ditanyakan pada dokter spesialis anestesiologi & reanimasi.
                </p>
                <p align="justify">
                    <b>Nyeri Paska Operasi :</b>  
                </p>
                <p align="justify">
                <ul>
                    <li>Akan dimonitor di rawat inap oleh dokter spesialis, perawat dan peserta didik dokter spesialis</li>
                    <li>Obat-obat anti nyeri diberikan melalui intravena(infus), per oral(diminumkan), per rectal(melalui anus), dan atau melalui selang blok kontinya regional anestesia</li>
                </ul>
                </p>
                
                <p align="justify">
                    Saya yang bertanda tangan di bawah ini (pasien/wali/keluarga) telah mendapat penjelasan/informasi yang cukup mengenai
                    tindakan anestesi dan diberi kesempatan untuk bertanya dan berdiskusi mengenai tindakan anestesi yang akan dilakukan.
                </p>
                <table width="100%" border="0px">
                    <tr>
                        <td style="min-width:50%; text-align:center" >Tanggal <?php echo date('d ',strtotime($modEvaluasi->tglpemberiinformasi)).MyFormatter::getMonthId(date('m',strtotime($modEvaluasi->tglpemberiinformasi))).date(' Y',strtotime($modEvaluasi->tglpemberiinformasi)).", Jam :".date(' H:i',strtotime($modEvaluasi->tglpemberiinformasi))." WIB"; ?></td>
                        <td style="min-width:50%; text-align:center" >Tanggal <?php echo date('d ',strtotime($modEvaluasi->tglpemberiinformasi)).MyFormatter::getMonthId(date('m',strtotime($modEvaluasi->tglterimainformasi_walipasien))).date(' Y',strtotime($modEvaluasi->tglterimainformasi_walipasien)).", Jam :".date(' H:i',strtotime($modEvaluasi->tglterimainformasi_walipasien))." WIB"; ?></td>
                    </tr>
                    <tr rowspan='3'>
                        <td style="min-width:50%; text-align:center" >Nama dan Tanda Tangan Pemberi Informasi</td>
                        <td style="min-width:50%; text-align:center" >Nama dan Tanda Tangan Pasien / Wali / Keluarga</td>
                    </tr>

                </table>
            <br><br><br><br>
            <table width="100%" border="0px">
                <tr>
                    <td style="min-width:50%; text-align:center" ><?php  
                    if(!empty($modEvaluasi->pegawai_pemberiinformasi_id)){
                        echo $modEvaluasi->pegawai->namaLengkap; 
                    }
                    ?></td>
                    <td style="min-width:50%; text-align:center" ><?php 
                        echo $modEvaluasi->namawali_pasien;
                    ?></td>
                </tr>
            </table>
            </td>
        </tr>
        
        
</table>


<?php $this->endWidget(); ?>

