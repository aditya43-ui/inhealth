<style>
    @page {
        size: 7in 9.25in;
        margin: 27mm 16mm 27mm 16mm;
        font-size: 10px !important;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    @media print {
        html, body {
            padding-top: 30px;
            width: 210mm;
            height: 297mm;
            line-height: 1.5;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
        td{
            padding: 5px !important;
        }
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }

    td{
        padding: 5px !important;
    }
    @media print {
        .page-break { padding-top: 50px; display: block; page-break-before: always; }
    }
</style>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<div class="container">
    <div class="row-fluid" >
        <table width="100%" border="0px">
            <tr>
                <td width="15%" align="center">
                    <img src="<?php echo Params::pathImageErrorAdmin() . "Jawa_Timur.png" ?> " style="max-width: 80px; width:80px;"/>
                </td>
                <td align="center">
                    <div style="font-size:13pt !important">
                        <b><?php
                            echo strtoupper($modProfilRs->namakepemilikanrs) . ' ';
                            echo strtoupper($modProfilRs->propinsi->propinsi_nama);
                            ?>
                        </b>
                    </div>
                    <div style="font-size:13pt !important">
                        <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
                    </div>
                    <div style="font-size:10pt !important">
                        <i><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>, Telp. <?php echo $modProfilRs->notelphumas; ?>-1013, Fax. <?php echo $modProfilRs->no_faksimili; ?></i>
                    </div>

                    <div style="font-size:10pt !important">
                        <u><b>SURABAYA - 60286</b></u>
                    </div>
                </td>
                <td width="15%" align="center">
                    <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
                </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid">
        <table width="100%">
            <tr>
                <td style="text-align: center"> <b> <u> <h2> SURAT PERJANJIAN KERJA </h2></u></b></td>
            </tr>
            <tr>
                <td style="text-align: center;"> <b> <h3> NOMOR : <?= $model->nosuratperjanjiankerja; ?></h3></b></td>
            </tr>
            <tr>
                <br>
                <br>
                <br>
                <td style="text-indent: 70px; text-align: justify">
                    <p style="padding-top: 50px;"> Pada hari ini <?= MyFormatter::getDayName($model->tglsuratperjanjian); ?>, tanggal <?= ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->tglsuratperjanjian)))); ?>
                    bulan <?= ucwords(MyFormatter::getMonthId(date('m', strtotime($model->tglsuratperjanjian))));?> 
                    tahun <?= ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->tglsuratperjanjian))));?>
                    (<?= date('d-m-Y', strtotime($model->tglsuratperjanjian))?>), yang bertanda tangan di bawah ini : </p>                
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td style="text-align: left; vertical-align: top" rowspan="5" width="3%"> I. </td>
                            <td width="15%"> Nama </td>
                            <td> : <?= $modPPK->pegawai->namaLengkap;?></td>
                        </tr>
                        <tr>
                            <td> NIP </td>
                            <td> : <?= $modPPK->pegawai->nomorindukpegawai;?></td>
                        </tr>
                        <tr>
                            <td> Jabatan </td>
                            <td> : <?= $modPPK->jabatan_pengadaan; ?></td>
                        </tr>
                        <tr>
                            <td> Alamat Kantor </td>
                            <td> : <?= $modProfilRs->alamatlokasi_rumahsakit; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Berdasarkan Keputusan Pengguna Anggaran RSUD Dr. Soetomo Nomor : 
                                <?= !empty($modPPK->no_sk) ? $modPPK->no_sk : "-"?> Tanggal 
                                <?= !empty($modPPK->tgl_sk) ? date('d-m-Y', strtotime($modPPK->tgl_sk)): "-"?>
                                tentang <?= $modPPK->jabatan_pengadaan; ?> yang selanjutnya disebut sebagai <u> PIHAK KESATU</u>.
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; vertical-align: top" rowspan="5" > II. </td>
                            <td> Nama </td>
                            <td> : <?= !empty($model->supplier->direktursupplier) ? $model->supplier->direktursupplier : "-"?> </td>
                        </tr>
                        <tr>
                            <td> Jabatan </td>
                            <td> : Direktur </td>
                        </tr>
                        <tr>
                            <td> Nama Perusahaan </td>
                            <td> : <?= !empty($model->supplier->supplier_nama) ? strtoupper($model->supplier->supplier_nama) : "-"?> </td>
                        </tr>
                        <tr>
                            <td> Alamat Kantor </td>
                            <td> : <?= !empty($model->supplier->supplier_alamat) ? $model->supplier->supplier_alamat : "-"?> </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Berdasarkan Surat Penawaran Nomor : <?= $modPenawaran->penawaranpenyedia_nomorsurat?>,
                                Tanggal <?= MyFormatter::formatDateTimeId(date('d M Y', strtotime($modPenawaran->penawaranpenyedia_tanggal)))?>
                                bertindak untuk dan atas nama <?= strtoupper($model->supplier->supplier_nama)?>,
                                yang selanjutnya <u> PIHAK KEDUA</u>
                            </td>
                        </tr>
                    </table>
                </td> 
            </tr>
            <tr>
                <td> 
                    <br>
                    <br>
                    <br>
                    Berdasarkan : 
                    <br>
                    <br>
                </td>
            </tr>
            <tr> 
                <td style="text-align:justify">
                    <?= !empty($model->dasarpengerjaan) ? $model->dasarpengerjaan : ""?>
                </td>
            </tr>
            <tr>
                <td style="text-align: justify"> 
                    Termasuk semua lampiran yang merupakan satu kesatuan yang tidak terpisahkan yang selanjutnya disebut 
                    <b> <?= $model->namapekerjaan?> </b> Tertanggal <?= MyFormatter::formatDateTimeId(date('d M Y', strtotime($model->tglsuratperjanjian)))?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
<div class="row-fluid">
    <table width="100%">
        <tr>
            <td style="text-align: justify"> 
                Maka dengan ini Kedua Belah Pihak menyetujui semua ketentuan yang tercantum dalam pasal-pasal berikut: 
            </td>
        </tr>
    </table>
    <br>
    <br>
    <?php echo $model->dasar;?>
</div>