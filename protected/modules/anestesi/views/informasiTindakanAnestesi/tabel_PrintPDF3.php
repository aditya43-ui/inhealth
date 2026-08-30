<table width="100%"  id="tablekematian">
    <tr >
        <td rowspan="3" style="width:60%"><?php echo $this->renderPartial('anestesi.views.informasiTindakanAnestesi._headerPrint'); ?></td>
        <td style="width:10%" border-top="1px"></td>
        <td style="width:10%" border-top="1px"></td>
        <td style="width:20%"></td>
    </tr>
    <tr>
        <td style="width:10%" border-top="1px"></td>
        <td style="width:10%"></td>
        <td style="width:20%"></td>
    </tr>
    <tr>
        <td style="width:10%" ></td>
        <td style="width:10%"></td>
        <td style="width:20%"></td>
    </tr>

</table>
<table width="100%" class="table-condensed">   
       
        <tr>
            <td style="border:1px solid;">
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
                <br>
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
                <br>
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
                <br>
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
                <br>
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
                        <td width="50%" align="center" style="">Tanggal <?php echo date('d ',strtotime($modEvaluasi->tglpemberiinformasi)).MyFormatter::getMonthId(date('m',strtotime($modEvaluasi->tglpemberiinformasi))).date(' Y',strtotime($modEvaluasi->tglpemberiinformasi)).", Jam :".date(' H:i',strtotime($modEvaluasi->tglpemberiinformasi))." WIB"; ?></td>
                        <td width="50%" align="center"  style="">Tanggal <?php echo date('d ',strtotime($modEvaluasi->tglpemberiinformasi)).MyFormatter::getMonthId(date('m',strtotime($modEvaluasi->tglterimainformasi_walipasien))).date(' Y',strtotime($modEvaluasi->tglterimainformasi_walipasien)).", Jam :".date(' H:i',strtotime($modEvaluasi->tglterimainformasi_walipasien))." WIB"; ?></td>
                    </tr>
                    <tr rowspan='3'>
                        <td width="50%" align="center" style="" >Nama dan Tanda Tangan Pemberi Informasi</td>
                        <td width="50%" align="center"  style="border:">Nama dan Tanda Tangan Pasien / Wali / Keluarga</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br>
                    </tr>
                    <tr>
                    <td width="50%" align="center" style=""><?php  
                    if(!empty($modEvaluasi->pegawai_pemberiinformasi_id)){
                        echo $modEvaluasi->pegawai->namaLengkap; 
                    }
                    ?></td>
                    <td width="50%" align="center" style=""><?php 
                        echo $modEvaluasi->namawali_pasien;
                    ?></td>
                </tr>
                </table>
            
            </td>
        </tr>
        
        
</table>
