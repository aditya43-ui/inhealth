<style>
    @page {
        size: 297mm 210mm;
        font-family: Times new roman, sans-serif;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    @media print {
        html, body {
            padding-top: 30px;
            /*padding-left: 10px;*/
            height: 210mm;
            width: 297mm;
            line-height: 1.3;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
        .page-break { display: block; page-break-before: always; }
    }

    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always; }
    }

</style>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

if (!empty($model->petugaskirim_id)) {
    $pegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->petugaskirim_id));
    if (!empty($pegawai)) {
        $namapegawai = $pegawai->namaLengkap;
        $nippegawai = $pegawai->nomorindukpegawai;
    } else {
        $namapegawai = '-';
        $nippegawai = '-';
    }
} else {
    $namapegawai = '-';
    $nippegawai = '-';
}
?>
<!--Lembar 1-->
<table width="100%">
    <tr>
        <td width="100%" style="text-align: center; font-weight: bold; font-size: 16px" colspan="2">
            FORMULIR SERAH TERIMA SAMPEL DAN KANTONG DARAH DONOR <br>
            PELAYANAN DONOR - INSTALASI LABORATORIUM RS SAIFUL ANWAR<br>
            <h4>NO PENGIRIMAN SURAT : <br><?php echo $model->no_kirimkantong ?></h4><br>
        </td>
    </tr>
    <tr>
        <td colspan="2"><br></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: left; font-weight: bold">TANGGAL REKRUTMEN : <?php echo MyFormatter::formatDateTimeFOrUser(date('Y-m-d', strtotime($model->tglkirimkantongdarah)),'full'); ?></td>
        <td width="50%" style="text-align: left; font-weight: bold">LOKASI REKRUTMEN : <?php echo !empty($model->ruangankirim_id)?$model->ruangankirim->ruangan_nama:''; ?></td>
    </tr>
</table>
<table class="table border" width="110%" style="border: 1px solid #000000">
    <thead>
        <tr>
            <th rowspan="2" style="vertical-align : middle;text-align:center;border: 1px solid #000000">No</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;border: 1px solid #000000">Nomor Barcode Kantong Darah</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;border: 1px solid #000000">GOL DARAH A, B, O DAN RHESUS D</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;border: 1px solid #000000">JENIS KAN TONG DARAH</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;border: 1px solid #000000">JAM MULAI PENYA DAPAN</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;border: 1px solid #000000">JAM BERA KHIR NYA PENYA DAPAN</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;border: 1px solid #000000">VOLU ME DARAH</th>
            <th colspan="4" style="vertical-align : middle;text-align:center;border: 1px solid #000000">PENGELOLAAN DI DONOR</th>
            <th colspan="3" style="vertical-align : middle;text-align:center;border: 1px solid #000000">SERAH TERIMA DI LAB ITD GDC LT.5</th>
        </tr>
        <tr>
            <th style="vertical-align : middle;text-align:center;border: 1px solid #000000">PETUGAS</th>
            <th style="vertical-align : middle;text-align:center;border: 1px solid #000000">SAMPEL DARAH UNTUK KONFIR MASI</th>
            <th style="vertical-align : middle;text-align:center;border: 1px solid #000000">SAMPEL DARAH UNTUK SKRINING IMLTD</th>
            <th style="vertical-align : middle;text-align:center;border: 1px solid #000000">KAN TONG DARAH</th>
            <th style="vertical-align : middle;text-align:center;border: 1px solid #000000">PENGI RIM</th>
            <th style="vertical-align : middle;text-align:center;border: 1px solid #000000">PENE RIMA</th>
            <th style="vertical-align : middle;text-align:center;border: 1px solid #000000">TANGGAL DAN JAM</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($modDetail)) {
            $i = 1;
            foreach ($modDetail as $detail) {
//                $komponen = KomponendarahM::model()->findByPk($detail->komponendarah_id);
                $kantongdarah = KantongdarahT::model()->findByAttributes(array('nomorbarcode_utama' => $detail->nomorbarcode_utama));
                $pendonor = PendonorM::model()->findByPk($kantongdarah->pendonor_id);
                
                $coolDet = PenggunaanCoolboxdetT::model()->findByAttributes(array('kantongdarah_id'=>$kantongdarah->kantongdarah_id));
                
                $volume = '';
                $ada_sampelkonfirmasi = '';
                $ada_sampelimltd = '';
                $ada_kantongdarah = '';      
                if (!empty($kantongdarah->observasipendonor_id)) {
                    $observasi = ObservasipendonorT::model()->findByPk($kantongdarah->observasipendonor_id);                    
                    //$volume = !empty($observasi) ? $observasi->volume : '';
                    if (empty($kantongdarah->pendonor_id)){
                        $observasi->tglmulaiobservasi = '';
                        $observasi->sd_observasi = '';
                    }
                } else {
                    $observasi = '';
                    $petugas = '';                                  
                }
                
                if (!empty($coolDet)){
                    $volume = $coolDet->volume_kantong;
                    $ada_sampelkonfirmasi = $coolDet->ada_samplekonfirmasi;
                    $ada_sampelimltd = $coolDet->ada_sampleitd ;
                    $ada_kantongdarah = $coolDet->ada_kantongdarah;
                }

                $cekPetugasObservasi = ObservasipendonorT::model()->findByPk($kantongdarah->observasipendonor_id); 
                if(!empty($cekPetugasObservasi->petugas_id)){
                    $cekPetugas = PegawaiM::model()->findByPk($cekPetugasObservasi->petugas_id);
                    if (!empty($cekPetugas)) {
                        $petugas = $cekPetugas->namaLengkap;
                    } else {
                        $petugas = '';
                    }
                    
                    if (empty($kantongdarah->pendonor_id)){
                        $petugas = '';
                    }
                }else{
                        $petugas = '';
                }

                if(!empty($kantongdarah)){                    
                    if ($kantongdarah->rhesus == 'Positif' || $kantongdarah->rhesus == 'POSITIF') {
                        $rhesus = '+';
                    } else if ($kantongdarah->rhesus == 'Negatif' || $kantongdarah->rhesus == 'NEGATIF') {
                        $rhesus = '-';
                    } else {
                        $rhesus = '';
                    }                                        
                }else{
                    $rhesus = '';
                }

                $cekJenisKantong = JeniskantongdarahM::model()->findByPk($kantongdarah->jeniskantongdarah_id);
                if (!empty($cekJenisKantong)) {
                    $jeniskantong = $cekJenisKantong->nama_jenis;
                } else {
                    $jeniskantong = '';
                }
               

                $cekPengirim = PegawaiM::model()->findByPk($model->petugastransporter_id);
                if (!empty($cekPengirim)) {
                    $pengirim = $cekPengirim->namaLengkap;
                } else {
                    $pengirim = '';
                }
                ?>
                <tr>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo $i; ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo $kantongdarah->nomorbarcode_utama ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php
                        echo!empty($kantongdarah->gol_darah) ? $kantongdarah->gol_darah : '';
                        echo $rhesus
                        ?>
                    </td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo $jeniskantong ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo!empty($observasi->tglmulaiobservasi) ? date('H:i:s', strtotime($observasi->tglmulaiobservasi)) : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo!empty($observasi->sd_observasi) ? date('H:i:s', strtotime($observasi->sd_observasi)) : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo!empty($volume) ? $volume . ' ml' : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo $petugas ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo $ada_sampelkonfirmasi ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo $ada_sampelimltd ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo $ada_kantongdarah ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo $pengirim ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;border: 1px solid #000000"><?php echo '' ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        <tr>
            <th colspan="2" rowspan="2" style="vertical-align : middle;text-align:center;border: 1px solid #000000">Pencatatan Suhu Coolbox</th>
            <th colspan="5" style="vertical-align : middle;text-align:left;border: 1px solid #000000">Berangkat ke Lab ITD GDC Lt.5</th>
            <th colspan="4" style="vertical-align : middle;text-align:left;border: 1px solid #000000">Jam : <?php echo date('H:i:s', strtotime($model->tglkirimkantongdarah)) ?></th>
            <th colspan="3" style="vertical-align : middle;text-align:left;border: 1px solid #000000">Suhu : <?php echo $model->suhu . ' <sup>o</sup>C' ?></th>
        </tr>
        <tr>
            <th colspan="5" style="vertical-align : middle;text-align:left;border: 1px solid #000000">Tiba di Lab ITD GDC Lt.5</th>
            <th colspan="4" style="vertical-align : middle;text-align:left;border: 1px solid #000000">Jam : </th>
            <th colspan="3" style="vertical-align : middle;text-align:left;border: 1px solid #000000">Suhu : </th>
        </tr>
    </tbody>
</table>
<table width="110%">
    <tr>
        <td width="35%" style="text-align: left;">
            <b>KETERANGAN :</b>
            <br>Lembar warna Putih untuk PJ Seleksi & Penyadapan
            <br>Lembar warna Merah untuk PJ Konfirmasi Gol. Darah
            <br>Lembar Warna Kuning untuk PJ IMLTD
            <br>Lembar Warna Hijau untuk PJ Komponen & Distribusi
            <br>SG &nbsp;&nbsp; : Kantong Tunggal / Single
            <br>DB &nbsp;&nbsp; : Kantong Ganda Dua / Double
            <br>TR &nbsp;&nbsp; : Kantong Ganda Tiga / Triple
            <br>S<span style="color: transparent">G</span> &nbsp;&nbsp; : SUKSES
            <br>G<span style="color: transparent">S</span> &nbsp;&nbsp; : GAGAL
        </td>
        <td width="65%" style="text-align: center;">
            <table width="90%">
                <tr>
                    <td width="45%">
                        Mengetahui
                        <br>Koordinator Pelayanan Donor
                        <br><br><br><br><br>
                        Rosa Rusdiana, Amd.Kep
                        <br>NIP. 19961219 198903 2 007
                    </td>
                    <td width="45%">
                        Penanggung Jawab
                        <br>Seleksi dan Penyadapan
                        <br><br><br><br><br>
                        Emmy Rohayati, Amd.Kep
                        <br>NIP. 19680119 200701 2 014
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<?php if ($caraPrint == 'PRINT') { ?>
    <table width="100%" class="footer">
        <tr>
            <td style="text-align: left;"></td>
            <td style="text-align: right;"><div id="pageFooter">Hal </div></td>
        </tr>
    </table>
<?php } ?>

<!--Cetak Halaman 2 (Uji Konfirmasi), 3, 4 (skrining imltd) ada pada file PrintLembar234.php karena saat ini tidak digunakan-->