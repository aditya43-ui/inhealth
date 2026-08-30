<style>
*,
*:before,
*:after {
    box-sizing: border-box;
}

.step {
    position: relative;
    min-height: 32px
        /* circle-size */
    ;
}

.step>div:first-child {
    position: static;
    height: 0;
}

.step>div:last-child {
    margin-left: 32px;
    padding-left: 16px;
}

.circle {
    /* background: #4285f4; */
    width: 32px;
    height: 32px;
    line-height: 32px;
    border-radius: 16px;
    position: relative;
    color: white;
    text-align: center;
}

.line-top {
    position: absolute;
    border-left: 2px solid grey;
    background-color: #F5F5F5;
    height: 52px;
    width: 4px;
    left: 16px;
    bottom: 55px;
    top: -12px;
    /* left: 160px;
    bottom: 100px;
    top: 420px; */
}

.line-bottom {
    position: absolute;
    border-left: 2px solid grey;
    background-color: #F5F5F5;
    height: 100px;
    width: 2px;
    left: 16px;
    bottom: 55px;
    top: 32px;
    /* left: 160px;
    bottom: 100px;
    top: 420px; */
}
.line-bottom-dpjp {
    position: absolute;
    border-left: 2px solid grey;
    background-color: #F5F5F5;
    height: 200px;
    width: 2px;
    left: 16px;
    bottom: 55px;
    top: 32px;
    /* left: 160px;
    bottom: 100px;
    top: 420px; */
}

.step:last-child .line {
    display: none;
}

.title {
    line-height: 32px;
    font-weight: bold;
    margin-top: 2px;
}
</style>

<div class="row-fluid">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Timeline</div>
            </div>
            <div class="panel">
                <span class="btn btn-danger"><?php echo MyFormatter::formatDateTimeId(date("d M Y"),strtotime($modPendaftaran->tgl_pendaftaran)); ?> </span>
            </div>
            
            </div>
            </div>
             
            <div class="panel-body">
                <div class="step">
                    <div>
                        <div class="line-top"></div>
                        <div class="circle" style="background-color: #145DA0;">&#9633;</div>
                        <div class="line-bottom"></div>
                    </div>
                        <div class="title" style="color:gray;  font-weight: normal;"><strong style="color:#145DA0;">Pendaftaran </strong> <?php
                        if($modPendaftaran->statuspasien == 'pengunjung lama'){
                            $statuspasien = 'Pasien Lama' ?? '';
                        }else{
                            $statuspasien = 'Pasien Baru' ?? '';
                            
                        }
                        $data = !empty($modPendaftaran->createlogin->namaLengkap) ? $modPendaftaran->createlogin->namaLengkap : "Belum Tersedia" ;
                        $time = explode(' ',$modPendaftaran->tgl_pendaftaran);
                        
                        echo '>> pasien didaftarkan oleh <b>'.$data .'</b> Sebagai <b>'.$statuspasien.'</b> <div style="text-align:right;">'.$time[1].'</div>'; ?>
                        <div class="body"><hr></div>
                    </div>
                </div>
                <div class="step">
                    <div>
                        <div class="line-top"></div>
                        <div class="circle" style="background-color: #C55FFC;">&#9633;</div>
                        <div class="line-bottom"></div>
                    </div>
                    <div class="title" style="color:gray;  font-weight: normal;"><strong style="color:#145DA0;">Berkas </strong>
                     <?php  
                     $data=!empty($modPengirim->petugaspengirim) ? $modPengirim->petugaspengirim : "Belum Tersedia" ;
                     $datatime = isset($modPengirim->tglpengirimanrm)?$modPengirim->tglpengirimanrm : ""; 
                     $time = explode(' ',$datatime );
                        if(!empty($datatime)){
                            echo '>> Berkas dikirim oleh <b>'.$data.'</b> <div style="text-align:right;">'.$time[3].'</div>'; 
                     
                        }else{
                            echo '>> Berkas dikirim oleh <b>'.$data.'</b> <div style="text-align:right;">'.'Belum Tersedia'.'</div>'; 
                            
                        }?>
                    </div>
                </div>
      
                <div class="step">
                    <div>
                        <div class="line-top"></div>
                        <div class="circle" style="background-color: #04ECF0;">&#9633;</div>
                        <div class="line-bottom"></div>
                    </div>
                    <div class="title" style="color:gray; font-weight: normal;"><strong style="color:#145DA0;">Masuk Klinik </strong>
                     <?php  
                     $data=!empty($modPendaftaran->instalasi->instalasi_nama) ? $modPendaftaran->instalasi->instalasi_nama : "Belum Tersedia" ;
                     $data2=!empty($modPendaftaran->ruangan->ruangan_nama) ? $modPendaftaran->ruangan->ruangan_nama : "Belum Tersedia" ;
                      echo '>> Pasien Masuk Poliklinik <b>'.$data.'</b> - <b>'.$data2.'</b>'; ?>
                       
                       <div class="body"><hr>
                        <?php  
                        //var_dump($modFisik->paramedis_nama); die;
                     $datas=!empty($modFisik->paramedis_nama) ? $modFisik->paramedis_nama: "Belum Tersedia" ;
                     $datas2=!empty($modPendaftaran->pegawai->namaLengkap) ? $modPendaftaran->pegawai->namaLengkap : "Belum Tersedia" ;
                     $timing = MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran);
                   
                     echo ' Petugas <b>'.$datas.'</b><br> Dokter <b> '.$datas2.'</b><div style="text-align:right;">'.$timing.'</div>'; ?>
                     
                    </div>
                   
                    </div>
                </div>

                <div class="step">
                    <div>
                        <div class="line-top"></div>
                        <div class="circle" style="background-color: #ffb347;">&#9633;</div>
                        <div class="line-bottom"></div>
                    </div>
                    <div class="title" style="color:gray; font-weight: normal;"><strong style="color:#145DA0;">Transfer Ruangan </strong>
                     <?php  
                        $pemindahan = PemindahanpasienT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id  order by pemindahanpasien_id desc");
                        $pengirim = !empty($pemindahan) ? $pemindahan->perawatpengirim->namaLengkap : "Belum Tersedia";
                        $mengetahui = !empty($pemindahan) ? $pemindahan->pegawaimengetahui->namaLengkap : "Belum Tersedia";

                        $timing2 = !empty($pemindahan) ? MyFormatter::formatDateTimeId($pemindahan->create_time) : 'Belum Tersedia';
                      ?>
                       
                       <div class="body"><hr>
                        <?php  
                            echo ' Petugas <b>'.$pengirim.'</b><br> Dokter <b> '.$mengetahui.'</b><div style="text-align:right;">'.$timing2.'</div>'; ?>
                     
                    </div>
                   
                    </div>
                </div>
                <div class="step">
                    <div>
                        <div class="line-top"></div>
                        <div class="circle" style="background-color: #fff49b;">&#9633;</div>
                        <div class="line-bottom-dpjp"></div>
                    </div>
                    <div class="title" style="color:gray; font-weight: normal;"><strong style="color:#145DA0;">Riwayat DPJP </strong>
                     <?php  
                        $ubah = UbahdokterR::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id and lower(alasanperubahandokter) not in ('disposisi', 'alih leader') order by ubahdokter_id desc");
                        $dokterlama = !empty($ubah) ? $ubah->dokterlama->namaLengkap : 'Belum Tersedia';
                        $dokterbaru = !empty($ubah) ? $ubah->dokterbaru->namaLengkap : 'Belum Tersedia';
                        $timing = !empty($ubah) ? MyFormatter::formatDateTimeId($ubah->tglubahdokter) : 'Belum Tersedia';

                        $disposisi = UbahdokterR::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id and lower(alasanperubahandokter) in ('disposisi') order by ubahdokter_id desc");
                        $dokterlama2 = !empty($disposisi) ? $disposisi->dokterlama->namaLengkap : 'Belum Tersedia';
                        $dokterbaru2 = !empty($disposisi) ? $disposisi->dokterbaru->namaLengkap : 'Belum Tersedia';
                        $timing2 = !empty($disposisi) ? MyFormatter::formatDateTimeId($disposisi->tglubahdokter) : 'Belum Tersedia';

                        $alih = UbahdokterR::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id and lower(alasanperubahandokter) in ('alih leader') order by ubahdokter_id desc");
                        $dokterlama3 = !empty($alih) ? $alih->dokterlama->namaLengkap : 'Belum Tersedia';
                        $dokterbaru3 = !empty($alih) ? $alih->dokterbaru->namaLengkap : 'Belum Tersedia';
                        $timing3 = !empty($alih) ? MyFormatter::formatDateTimeId($alih->tglubahdokter) : 'Belum Tersedia';

                      ?>
                       
                       <div class="body"><hr>
                        <?php  echo ' Dilakukan <b>Ubah DPJP</b> oleh <b>' . $dokterlama . '</b> kepada <b>' . $dokterbaru . '</b><div style="text-align:right;">'.$timing.'</div>'; ?>
                        <?php  echo ' Dilakukan <b>Disposisi</b> oleh <b>' . $dokterlama2 . '</b> kepada <b>' . $dokterbaru2 . '</b><div style="text-align:right;">'.$timing2.'</div>'; ?>
                        <?php  echo ' Dilakukan <b>Alih Leader</b> oleh <b>' . $dokterlama3 . '</b> kepada <b>' . $dokterbaru3 . '</b><div style="text-align:right;">'.$timing3.'</div>'; ?>
                     
                    </div>
                   
                    </div>
                </div>
                <div class="step">
                    <div>
                        <div class="line-top"></div>
                        <div class="circle" style="background-color: #abdbaf;">&#9633;</div>
                        <div class="line-bottom-dpjp"></div>
                    </div>
                    <div class="title" style="color:gray; font-weight: normal;"><strong style="color:#145DA0;">Konsul Dokter </strong>
                     <?php  
                        $konsul = KonsulpoliT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id order by konsulpoli_id desc");
                        $pegkonsul = !empty($konsul) ? $konsul->pegawaikonsul->namaLengkap : 'Belum Tersedia';
                        $pegawai = !empty($konsul) ? $konsul->pegawai->namaLengkap : 'Belum Tersedia';
                        $timing = !empty($konsul) ? MyFormatter::formatDateTimeId($konsul->tglkonsulpoli) : 'Belum Tersedia';
                      ?>   
                       <div class="body"><hr>
                            <?php  echo ' Pasien dilakukan konsultasi dari <b>' . $pegkonsul . '</b> ke <b>' . $pegawai . '</b>'; ?>             
                            <?php  echo ' Pasien direspon oleh <b>' . $pegawai . '</b><div style="text-align:right;">'.$timing.'</div>'; ?>             
                        </div>
                   
                    </div>
                </div>
                
      
            <div class="step">
                    <div>
                        <div class="line-top"></div>
                        <div class="circle" style="background-color: #008000;">&#9633;</div>
                        <div class="line-bottom"></div>
                    </div>
                    <div>
                    <div class="title" style="color:gray; font-weight: normal; "><strong style="color:#145DA0;">Keluar Klinik </strong>
                     <?php  
                     $data=!empty($modPendaftaran->statusperiksa) ? $modPendaftaran->statusperiksa : "Belum Tersedia" ;
                     $timesx = MyFormatter::formatDateTimeId($modPendaftaran->tglselesaiperiksa);
                   
                     echo '>> Pasien selesai dilayani dengan status <b>'.$data.'</b><div style="text-align:right;">'.$timesx.'</div>'; ?>
                  
                     
                            </div>
                   
                        </div>
                   </div>
             </div>
          
               </div>
  