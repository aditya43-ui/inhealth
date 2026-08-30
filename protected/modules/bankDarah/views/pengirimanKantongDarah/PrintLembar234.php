<!-- Cetak Halaman 2 (Uji Konfirmasi), 3, 4 (skrining imltd) karena saat ini tidak digunakan -->
<!--Lembar 2-->
<table width="130%">
    <tr>
        <td width="130%" style="text-align: center; font-weight: bold; font-size: 16px" colspan="2">
            FORMULIR SERAH TERIMA SAMPEL DAN KANTONG DARAH DONOR DAN UJI KONFIRMASI GOLONGAN DARAH<br>
            PELAYANAN DONOR - INSTALASI TRANSFUSI DARAH RSUD Dr. SOETOMO SURABAYA<br><br>
        </td>
    </tr>
    <tr>
        <td colspan="2"><br></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: left; font-weight: bold">TANGGAL REKRUTMEN :</td>
        <td width="50%" style="text-align: left; font-weight: bold">LOKASI REKRUTMEN :</td>
    </tr>
</table>
<table class="table border" width="100%">
    <thead>
        <tr>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">Nomor Barcode Kantong Darah</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">GOL DARAH A, B, O DAN RHESUS D</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">JENIS KAN TONG DARAH</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">JAM MULAI PENYA DAPAN</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">JAM BERA KHIR NYA PENYA DAPAN</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">VOLU ME DARAH</th>
            <th colspan="4" style="vertical-align : middle;text-align:center;">PENGELOLAAN DI DONOR</th>
            <th colspan="3" style="vertical-align : middle;text-align:center;">SERAH TERIMA DI LAB ITD DOC I.T.S</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">TANGGAL DAN JAM PEMERIK SAAN</th>
            <th colspan="6" style="vertical-align : middle;text-align:center;">LAB KONFIRMASI GOLONGAN DARAH</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">HASIL UJI KONFIR MASI</th>
            <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA PETUGAS KONFIRMASI</th>
        </tr>
        <tr>
            <th style="vertical-align : middle;text-align:center;">PETUGAS</th>
            <th style="vertical-align : middle;text-align:center;">SAMPEL DARAH UNTUK KONFIR MASI</th>
            <th style="vertical-align : middle;text-align:center;">SAMPEL DARAH UNTUK SKRINNING IMLTD</th>
            <th style="vertical-align : middle;text-align:center;">KAN TONG DARAH</th>
            <th style="vertical-align : middle;text-align:center;">PENGI RIM</th>
            <th style="vertical-align : middle;text-align:center;">PENE RIMA</th>
            <th style="vertical-align : middle;text-align:center;">TANGGAL DAN JAM</th>
            <th style="vertical-align : middle;text-align:center;">ANTI A</th>
            <th style="vertical-align : middle;text-align:center;">ANTI B</th>
            <th style="vertical-align : middle;text-align:center;">ANTI D</th>
            <th style="vertical-align : middle;text-align:center;">SEL A</th>
            <th style="vertical-align : middle;text-align:center;">SEL B</th>
            <th style="vertical-align : middle;text-align:center;">SEL O</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($modDetail)) {
            $i = 1;
            foreach ($modDetail as $detail) {
                $komponen = KomponendarahM::model()->findByPk($detail->komponendarah_id);
                $kantongdarah = KantongdarahT::model()->findByPk($detail->kantongdarah_id);
                $pendonor = PendonorM::model()->findByPk($kantongdarah->pendonor_id);
                if (!empty($kantongdarah->observasipendonor_id)) {
                    $observasi = ObservasipendonorT::model()->findByPk($kantongdarah->observasipendonor_id);
                    $cekPetugas= PegawaiM::model()->findByPk($observasi->petugas_id);
                    if(!empty($cekPetugas)){
                        $petugas = $cekPetugas->namaLengkap;
                    }else{
                        $petugas = '';
                    }
                }else{
                    $observasi = '';
                    $petugas = '';
                }
                
                if ($pendonor->rhesus == 'Positif' || $pendonor->rhesus == 'POSITIF') {
                    $rhesus = '+';
                } else if ($pendonor->rhesus == 'Negatif' || $pendonor->rhesus == 'NEGATIF') {
                    $rhesus = '-';
                }else{
                    $rhesus = '';
                }
                
                $cekJenisKantong = JeniskantongdarahM::model()->findByPk($detail->jeniskantongdarah_id);
                if(!empty($cekJenisKantong)){
                    $jeniskantong = $cekJenisKantong->nama_jenis;
                }else{
                    $jeniskantong = '';
                }
                
                $cekPengirim = PegawaiM::model()->findByPk($model->petugaskirim_id);
                if(!empty($cekPengirim)){
                    $pengirim = $cekPengirim->namaLengkap;
                }else{
                    $pengirim = '';
                }
                ?>
                <tr>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $i; ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $detail->nomorbarcode ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($pendonor->gol_darah) ? $pendonor->gol_darah : ''; echo $rhesus ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $jeniskantong ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($observasi->tglmulaiobservasi) ? date('H:i:s', strtotime($observasi->tglmulaiobservasi)) : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($observasi->sd_observasi) ? date('H:i:s', strtotime($observasi->sd_observasi)) : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $petugas ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $pengirim ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        <tr>
            <th colspan="2" rowspan="2" style="vertical-align : middle;text-align:center;">Pencatatan Suhu Coolbox</th>
            <th colspan="5" style="vertical-align : middle;text-align:left;">Berangkat ke Lab ITD GDC Lt.5</th>
            <th colspan="4" style="vertical-align : middle;text-align:left;">Jam : <?php echo date('H:i:s', strtotime($model->tglkirimkantongdarah)) ?></th>
            <th colspan="3" style="vertical-align : middle;text-align:left;">Suhu : <?php echo $model->suhu . ' C' ?></th>
        </tr>
        <tr>
            <th colspan="5" style="vertical-align : middle;text-align:left;">Tiba di Lab ITD GDC Lt.5</th>
            <th colspan="4" style="vertical-align : middle;text-align:left;">Jam : </th>
            <th colspan="3" style="vertical-align : middle;text-align:left;">Suhu : </th>
        </tr>
    </tbody>
</table>
<table width="130%" border="0px">
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
        <td width="100%" style="text-align: center;">
            <table width="100%" >
                <tr>
                    <td width="25%">
                        Mengetahui
                        <br>Koordinator Pelayanan Donor
                        <br><br><br><br><br>
                        Rosa Rusdiana, Amd.Kep
                        <br>NIP. 19961219 198903 2 007
                    </td>
                    <td width="25%">
                        Penanggung Jawab
                        <br>Seleksi dan Penyadapan
                        <br><br><br><br><br>
                        Emi Rohayati, Amd.Kep
                        <br>NIP. 19680119 200701 2 014
                    </td>
                    <td width="25%">
                        Mengetahui
                        <br>Koordinator Pelayanan Donor
                        <br><br><br><br><br>
                        Rosa Rusdiana, Amd.Kep
                        <br>NIP. 19961219 198903 2 007
                    </td>
                    <td width="25%">
                        Penanggung Jawab
                        <br>Konfirmasi Golongan Darah
                        <br><br><br><br><br>
                        Hari Lestari Ratna, PTTD
                        <br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<div class="page-break" style="padding-bottom:60px"></div>
<!--Lembar 3-->
<table width="143%" border="0px">
    <tr>
        <td width="143%" style="text-align: center; font-weight: bold; font-size: 16px" colspan="2">
            FORMULIR SERAH TERIMA SAMPEL DAN KANTONG DARAH DONOR DAN SKRINING INFEKSI MENULAR LEWAT TRANSFUSI DARAH (IMLTD)<br>
            PELAYANAN DONOR - INSTALASI TRANSFUSI DARAH RSUD Dr. SOETOMO SURABAYA<br><br>
        </td>
    </tr>
    <tr>
        <td colspan="2"><br></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: left; font-weight: bold">TANGGAL REKRUTMEN :</td>
        <td width="50%" style="text-align: left; font-weight: bold">LOKASI REKRUTMEN :</td>
    </tr>
</table>
<table class="table border" width="100%">
    <thead>
        <tr>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">No</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">Nomor Barcode Kantong Darah</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">GOL DARAH A, B, O DAN RHESUS D</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">JENIS KAN TONG DARAH</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">JAM MULAI PENYA DAPAN</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">JAM BERA KHIR NYA PENYA DAPAN</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">VOLU ME DARAH</th>
            <th colspan="4" rowspan="2" style="vertical-align : middle;text-align:center;">PENGELOLAAN DI DONOR</th>
            <th colspan="3" rowspan="2" style="vertical-align : middle;text-align:center;">SERAH TERIMA DI LAB ITD DOC I.T.S</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">TANG GAL DAN JAM PENYIA PAN SAM PEL</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">VOL SAM PEL DARAH 3 ml</th>
            <th colspan="8" style="vertical-align : middle;text-align:center;">HASIL PEMERIKSAAN SKRINING DENGAN METODE ELIZA</th>
            <th colspan="2" rowspan="2" style="vertical-align : middle;text-align:center;">VERIFIKATOR</th>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align : middle;text-align:center;">Hiv/Aids</th>
            <th colspan="2" style="vertical-align : middle;text-align:center;">ANTI HCV</th>
            <th colspan="2" style="vertical-align : middle;text-align:center;">ANTI HIV</th>
            <th colspan="2" style="vertical-align : middle;text-align:center;">SIFILIS</th>
        </tr>
        <tr>
            <th style="vertical-align : middle;text-align:center;">PETUGAS</th>
            <th style="vertical-align : middle;text-align:center;">SAMPEL DARAH UNTUK KONFIR MASI</th>
            <th style="vertical-align : middle;text-align:center;">SAMPEL DARAH UNTUK SKRINNING IMLTD</th>
            <th style="vertical-align : middle;text-align:center;">KAN TONG DARAH</th>
            <th style="vertical-align : middle;text-align:center;">PENGI RIM</th>
            <th style="vertical-align : middle;text-align:center;">PENE RIMA</th>
            <th style="vertical-align : middle;text-align:center;">TANGGAL DAN JAM</th>
            <th style="vertical-align : middle;text-align:center;">RE AKTIF (R)</th>
            <th style="vertical-align : middle;text-align:center;">NON RE AKTIF (NR)</th>
            <th style="vertical-align : middle;text-align:center;">RE AKTIF (R)</th>
            <th style="vertical-align : middle;text-align:center;">NON RE AKTIF (NR)</th>
            <th style="vertical-align : middle;text-align:center;">RE AKTIF (R)</th>
            <th style="vertical-align : middle;text-align:center;">NON RE AKTIF (NR)</th>
            <th style="vertical-align : middle;text-align:center;">RE AKTIF (R)</th>
            <th style="vertical-align : middle;text-align:center;">NON RE AKTIF (NR)</th>
            <th style="vertical-align : middle;text-align:center;">I</th>
            <th style="vertical-align : middle;text-align:center;">H</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($modDetail)) {
            $i = 1;
            foreach ($modDetail as $detail) {
                if (!empty($kantongdarah->observasipendonor_id)) {
                    $observasi = ObservasipendonorT::model()->findByPk($kantongdarah->observasipendonor_id);
                    $cekPetugas= PegawaiM::model()->findByPk($observasi->petugas_id);
                    if(!empty($cekPetugas)){
                        $petugas = $cekPetugas->namaLengkap;
                    }else{
                        $petugas = '';
                    }
                }else{
                    $observasi = '';
                    $petugas = '';
                }
                
                if ($pendonor->rhesus == 'Positif' || $pendonor->rhesus == 'POSITIF') {
                    $rhesus = '+';
                } else if ($pendonor->rhesus == 'Negatif' || $pendonor->rhesus == 'NEGATIF') {
                    $rhesus = '-';
                }else{
                    $rhesus = '';
                }
                
                $cekJenisKantong = JeniskantongdarahM::model()->findByPk($detail->jeniskantongdarah_id);
                if(!empty($cekJenisKantong)){
                    $jeniskantong = $cekJenisKantong->nama_jenis;
                }else{
                    $jeniskantong = '';
                }
                
                $cekPengirim = PegawaiM::model()->findByPk($model->petugaskirim_id);
                if(!empty($cekPengirim)){
                    $pengirim = $cekPengirim->namaLengkap;
                }else{
                    $pengirim = '';
                }
                ?>
                <tr>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $i; ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $detail->nomorbarcode ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($pendonor->gol_darah) ? $pendonor->gol_darah : ''; echo $rhesus ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $jeniskantong ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($observasi->tglmulaiobservasi) ? date('H:i:s', strtotime($observasi->tglmulaiobservasi)) : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($observasi->sd_observasi) ? date('H:i:s', strtotime($observasi->sd_observasi)) : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $petugas ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $pengirim ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        <tr>
            <th colspan="2" rowspan="2" style="vertical-align : middle;text-align:center;">Pencatatan Suhu Coolbox</th>
            <th colspan="5" style="vertical-align : middle;text-align:left;">Berangkat ke Lab ITD GDC Lt.5</th>
            <th colspan="4" style="vertical-align : middle;text-align:left;">Jam : <?php echo date('H:i:s', strtotime($model->tglkirimkantongdarah)) ?></th>
            <th colspan="3" style="vertical-align : middle;text-align:left;">Suhu : <?php echo $model->suhu . ' C' ?></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;">NO LOT</th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
        </tr>
        <tr>
            <th colspan="5" style="vertical-align : middle;text-align:left;">Tiba di Lab ITD GDC Lt.5</th>
            <th colspan="4" style="vertical-align : middle;text-align:left;">Jam : </th>
            <th colspan="3" style="vertical-align : middle;text-align:left;">Suhu : </th>
            <th colspan="2" style="vertical-align : middle;text-align:left;">EXP DATE</th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
        </tr>
        <tr>
            <th colspan="14" style="vertical-align : middle;text-align:left; border-left: 0px; border-bottom: 0px"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;">VALIDASI</th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
        </tr>
    </tbody>
</table>
<table width="143%" border="0px">
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
        <td width="100%" style="text-align: center;">
            <table width="100%" >
                <tr>
                    <td width="20%">
                        Mengetahui
                        <br>Koordinator Pelayanan Donor
                        <br><br><br><br><br>
                        Rosa Rusdiana, Amd.Kep
                        <br>NIP. 19961219 198903 2 007
                    </td>
                    <td width="20%">
                        Penanggung Jawab
                        <br>Seleksi dan Penyadapan
                        <br><br><br><br><br>
                        Emi Rohayati, Amd.Kep
                        <br>NIP. 19680119 200701 2 014
                    </td>
                    <td width="20%">
                        Mengetahui
                        <br>Skrining IMLTD
                        <br><br><br><br><br>
                        Rosa Rusdiana, Amd.Kep
                        <br>NIP. 19961219 198903 2 007
                    </td>
                    <td width="20%">
                        Mengetahui
                        <br>Skrining IMLTD
                        <br><br><br><br><br>
                        &nbsp;
                        <br>Indarwati, Amd.AK
                    </td>
                    <td width="20%">
                        Petugas Pelaksana
                        <br>Skrining IMLTD
                        <br><br><br><br><br>
                        &nbsp;
                        <br>.....................................
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<div class="page-break" style="padding-bottom:60px"></div>
<!--Lembar 4-->
<table width="143%" border="0px">
    <tr>
        <td width="143%" style="text-align: center; font-weight: bold; font-size: 16px" colspan="2">
            FORMULIR SERAH TERIMA SAMPEL DAN KANTONG DARAH DONOR DAN SKRINING INFEKSI MENULAR LEWAT TRANSFUSI DARAH (IMLTD)<br>
            PELAYANAN DONOR - INSTALASI TRANSFUSI DARAH RSUD Dr. SOETOMO SURABAYA<br><br>
        </td>
    </tr>
    <tr>
        <td colspan="2"><br></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: left; font-weight: bold">TANGGAL REKRUTMEN :</td>
        <td width="50%" style="text-align: left; font-weight: bold">LOKASI REKRUTMEN :</td>
    </tr>
</table>
<table class="table border" width="100%">
    <thead>
        <tr>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">No</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">Nomor Barcode Kantong Darah</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">GOL DARAH A, B, O DAN RHESUS D</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">JENIS KAN TONG DARAH</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">JAM MULAI PENYA DAPAN</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">JAM BERA KHIR NYA PENYA DAPAN</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">VOLU ME DARAH</th>
            <th colspan="4" rowspan="2" style="vertical-align : middle;text-align:center;">PENGELOLAAN DI DONOR</th>
            <th colspan="3" rowspan="2" style="vertical-align : middle;text-align:center;">SERAH TERIMA DI LAB ITD DOC I.T.S</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">TANG GAL DAN JAM PENYIA PAN SAM PEL</th>
            <th rowspan="3" style="vertical-align : middle;text-align:center;">VOL SAM PEL DARAH 3 ml</th>
            <th colspan="8" style="vertical-align : middle;text-align:center;">HASIL PEMERIKSAAN SKRINING DENGAN METODE ELIZA</th>
            <th colspan="2" rowspan="2" style="vertical-align : middle;text-align:center;">VERIFIKATOR</th>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align : middle;text-align:center;">Hiv/Aids</th>
            <th colspan="2" style="vertical-align : middle;text-align:center;">ANTI HCV</th>
            <th colspan="2" style="vertical-align : middle;text-align:center;">ANTI HIV</th>
            <th colspan="2" style="vertical-align : middle;text-align:center;">SIFILIS</th>
        </tr>
        <tr>
            <th style="vertical-align : middle;text-align:center;">PETUGAS</th>
            <th style="vertical-align : middle;text-align:center;">SAMPEL DARAH UNTUK KONFIR MASI</th>
            <th style="vertical-align : middle;text-align:center;">SAMPEL DARAH UNTUK SKRINNING IMLTD</th>
            <th style="vertical-align : middle;text-align:center;">KAN TONG DARAH</th>
            <th style="vertical-align : middle;text-align:center;">PENGI RIM</th>
            <th style="vertical-align : middle;text-align:center;">PENE RIMA</th>
            <th style="vertical-align : middle;text-align:center;">TANGGAL DAN JAM</th>
            <th style="vertical-align : middle;text-align:center;">RE AKTIF (R)</th>
            <th style="vertical-align : middle;text-align:center;">NON RE AKTIF (NR)</th>
            <th style="vertical-align : middle;text-align:center;">RE AKTIF (R)</th>
            <th style="vertical-align : middle;text-align:center;">NON RE AKTIF (NR)</th>
            <th style="vertical-align : middle;text-align:center;">RE AKTIF (R)</th>
            <th style="vertical-align : middle;text-align:center;">NON RE AKTIF (NR)</th>
            <th style="vertical-align : middle;text-align:center;">RE AKTIF (R)</th>
            <th style="vertical-align : middle;text-align:center;">NON RE AKTIF (NR)</th>
            <th style="vertical-align : middle;text-align:center;">I</th>
            <th style="vertical-align : middle;text-align:center;">H</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($modDetail)) {
            $i = 1;
            foreach ($modDetail as $detail) {
                $komponen = KomponendarahM::model()->findByPk($detail->komponendarah_id);
                $kantongdarah = KantongdarahT::model()->findByPk($detail->kantongdarah_id);
                $pendonor = PendonorM::model()->findByPk($kantongdarah->pendonor_id);
                if (!empty($kantongdarah->observasipendonor_id)) {
                    $observasi = ObservasipendonorT::model()->findByPk($kantongdarah->observasipendonor_id);
                    $cekPetugas= PegawaiM::model()->findByPk($observasi->petugas_id);
                    if(!empty($cekPetugas)){
                        $petugas = $cekPetugas->namaLengkap;
                    }else{
                        $petugas = '';
                    }
                }else{
                    $observasi = '';
                    $petugas = '';
                }
                
                if ($pendonor->rhesus == 'Positif' || $pendonor->rhesus == 'POSITIF') {
                    $rhesus = '+';
                } else if ($pendonor->rhesus == 'Negatif' || $pendonor->rhesus == 'NEGATIF') {
                    $rhesus = '-';
                }else{
                    $rhesus = '';
                }
                
                $cekJenisKantong = JeniskantongdarahM::model()->findByPk($detail->jeniskantongdarah_id);
                if(!empty($cekJenisKantong)){
                    $jeniskantong = $cekJenisKantong->nama_jenis;
                }else{
                    $jeniskantong = '';
                }
                
                $cekPengirim = PegawaiM::model()->findByPk($model->petugaskirim_id);
                if(!empty($cekPengirim)){
                    $pengirim = $cekPengirim->namaLengkap;
                }else{
                    $pengirim = '';
                }
                ?>
                <tr>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $i; ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $detail->nomorbarcode ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($pendonor->gol_darah) ? $pendonor->gol_darah : ''; echo $rhesus ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $jeniskantong ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($observasi->tglmulaiobservasi) ? date('H:i:s', strtotime($observasi->tglmulaiobservasi)) : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo !empty($observasi->sd_observasi) ? date('H:i:s', strtotime($observasi->sd_observasi)) : '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $petugas ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo 'Ada' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo $pengirim ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                    <td style="vertical-align : middle;text-align:center;"><?php echo '' ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        <tr>
            <th colspan="2" rowspan="2" style="vertical-align : middle;text-align:center;">Pencatatan Suhu Coolbox</th>
            <th colspan="5" style="vertical-align : middle;text-align:left;">Berangkat ke Lab ITD GDC Lt.5</th>
            <th colspan="4" style="vertical-align : middle;text-align:left;">Jam : <?php echo date('H:i:s', strtotime($model->tglkirimkantongdarah)) ?></th>
            <th colspan="3" style="vertical-align : middle;text-align:left;">Suhu : <?php echo $model->suhu . ' C' ?></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;">NO LOT</th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
        </tr>
        <tr>
            <th colspan="5" style="vertical-align : middle;text-align:left;">Tiba di Lab ITD GDC Lt.5</th>
            <th colspan="4" style="vertical-align : middle;text-align:left;">Jam : </th>
            <th colspan="3" style="vertical-align : middle;text-align:left;">Suhu : </th>
            <th colspan="2" style="vertical-align : middle;text-align:left;">EXP DATE</th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
        </tr>
        <tr>
            <th colspan="14" style="vertical-align : middle;text-align:left; border-left: 0px; border-bottom: 0px"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;">VALIDASI</th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th colspan="2" style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
            <th style="vertical-align : middle;text-align:left;"></th>
        </tr>
    </tbody>
</table>
<table width="143%" border="0px">
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
        <td width="100%" style="text-align: center;">
            <table width="100%" >
                <tr>
                    <td width="20%">
                        Mengetahui
                        <br>Koordinator Pelayanan Donor
                        <br><br><br><br><br>
                        Rosa Rusdiana, Amd.Kep
                        <br>NIP. 19961219 198903 2 007
                    </td>
                    <td width="20%">
                        Penanggung Jawab
                        <br>Seleksi dan Penyadapan
                        <br><br><br><br><br>
                        Emi Rohayati, Amd.Kep
                        <br>NIP. 19680119 200701 2 014
                    </td>
                    <td width="20%">
                        Mengetahui
                        <br>Skrining IMLTD
                        <br><br><br><br><br>
                        Rosa Rusdiana, Amd.Kep
                        <br>NIP. 19961219 198903 2 007
                    </td>
                    <td width="20%">
                        Mengetahui
                        <br>Skrining IMLTD
                        <br><br><br><br><br>
                        &nbsp;
                        <br>Indarwati, Amd.AK
                    </td>
                    <td width="20%">
                        Petugas Pelaksana
                        <br>Skrining IMLTD
                        <br><br><br><br><br>
                        &nbsp;
                        <br>.....................................
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>