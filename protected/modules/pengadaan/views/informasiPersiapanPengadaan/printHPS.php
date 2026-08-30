<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
        size: landscape;
        margin: 27mm 16mm 27mm 16mm;
        font-size: 10px !important;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    @media print {
        html, body {
            padding-top: 30px;
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
    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always;}
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$subprogramkerja = SubprogramkerjaM::model()->findByPk($model->subprogram_id);
$programkerja = ProgramkerjaM::model()->findByPk($subprogramkerja->programkerja_id);
$modRencana = RencanaumumpengadaanT::model()->findByPk($model->rencanaumumpengadaan_id);
$modPengadaanSumberDana = PengadaansumberdanaT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $modRencana->rencanaumumpengadaan_id), array('order' => 'pengadaansumberdana_id ASC'));
$modProgram = MappingrekeninganggaranM::model()->findByPk($modPengadaanSumberDana->mappingrekeninganggaran_id);
$koderekening = !empty($modProgram->mappingrekeninganggaran_id) ? $modProgram->kodeanggaran : "-";
$namarekening = !empty($modProgram->mappingrekeninganggaran_id) ? $modProgram->nama_rekeninganggaran5 : "-";
?>
<div class="container">
    <div class="row-fluid" >
        <table width="100%" border="0px solid">
            <tr>
                <td align="left" style="vertical-align:top" width="30%">
                    <div>
                        PEMERINTAH DAERAH PROPINSI JAWA TIMUR<br>
                        RUMAH SAKIT UMUM DAERAH Dr.SOETOMO<br>
                        <span style="text-transform:uppercase"> <?php echo $modProfilRs->alamatlokasi_rumahsakit;?></span> SURABAYA
                    </div>
                </td>
                <td align="left" style="vertical-align:top" width="25%">
                    </div>
                </td>
                <td align="left" style="vertical-align:top" width="45%">
                    <table width="100%" border="0px solid">
                        <tr>
                            <td colspan="2">OWNER ESTIMATE / HARGA PERHITUNGAN SENDIRI</td>
                        </tr>
                        <tr>
                            <td style="width:150px">ANGGARAN</td>
                            <td>: <?php echo !empty($model->periodeanggaran->anggaran_nama) ? $model->periodeanggaran->anggaran_nama :''; ?></td>
                        </tr>
                        <tr>
                            <td>BAGIAN BELANJA</td>
                            <td>: Langsung</td>
                        </tr>
                        <tr>
                            <td>PROGRAM</td>
                            <td>: <?php echo !empty($programkerja->programkerja_kode) ? $programkerja->programkerja_kode :''; ?></td>
                        </tr>
                        <tr>
                            <td>KEGIATAN</td>
                            <td>: <?php echo !empty($subprogramkerja->subprogramkerja_kode) ? $subprogramkerja->subprogramkerja_kode :''; ?></td>
                        </tr>
                        <tr>
                            <td>KODE REKENING</td>
                            <td>: <?php echo $koderekening; ?></td>
                        </tr>
                        <tr>
                            <td>URAIAN BELANJA</td>
                            <td>: <?php echo $namarekening; ?></td>
                        </tr>
                        <tr>
                            <td>PAKET PEKERJAAN</td>
                            <td>: <?php echo !empty($model->rencanaumumpengadaan_id)?$model->rencanaumumpengadaan->nama_pekerjaan:''; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="80%" style="vertical-align:top">
                    <?php
                        
                    $a = '<table border="1" style="width:100%; text-align:right">
                            <thead>
                                <tr>
                                    <th style="text-align: center" rowspan="2"> No. </th>
                                    <th style="text-align: center" rowspan="2"> Nama Barang / Spesifikasi </th>
                                    <th style="text-align: center" colspan="2"> Barang </th>
                                    <th style="text-align: center" rowspan="2"> Harga Distributor </th>
                                    <th style="text-align: center" rowspan="2"> Harga BPS </th>
                                    <th style="text-align: center" rowspan="2"> Informasi <br>Harga Lain </th>
                                    <th style="text-align: center" rowspan="2"> Harga<br> Standart<br> (Rp) </th>
                                    <th style="text-align: center" rowspan="2"> Estimasi Harga <br>Satuan (Rp) </th>
                                    <th style="text-align: center" rowspan="2"> Harga Satuan (termasuk <br>biaya umum &<br> keuntungan wajar)</th>
                                    <th style="text-align: center" rowspan="2"> Ongkos Kirim <br> (Jasa Instalasi)</th>
                                    <th style="text-align: center" rowspan="2"> Jumlah Harga (Rp)</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center"> Satuan </th>
                                    <th style="text-align: center"> Jumlah </th>
                                </tr>
                                <tr>
                                    <th style="text-align: center"> 1 </th>
                                    <th style="text-align: center"> 2 </th>
                                    <th style="text-align: center"> 3 </th>
                                    <th style="text-align: center"> 4 </th>
                                    <th style="text-align: center"> 5 </th>
                                    <th style="text-align: center"> 6 </th>
                                    <th style="text-align: center"> 7 </th>
                                    <th style="text-align: center"> 8 </th>
                                    <th style="text-align: center"> 9 </th>
                                    <th style="text-align: center"> 10 </th>
                                    <th style="text-align: center"> 11 </th>
                                    <th style="text-align: center"> 12 = (11 x 13)</th>
                                </tr>
                            </thead>
                            <tbody>';
                    $no = 1;
                    $total = 0;
                    $totalpajak = 0;
                    foreach ($modelDetail as $value) {
                        $a .= '<tr>
                                    <td style="text-align: center; width:50px">' . $no++ . '</td>
                                    <td style="text-align: center">' . $value->persiapanpengadaandet_nama . '</td>
                                    <td style="text-align: center">' . $value->persiapanpengadaandet_satuan . '</td>
                                    <td style="text-align: center">' . $value->persiapanpengadaandet_volume . '</td>
                                    <td style="text-align: right">' . number_format($value->harga_estimasi) . '</td>
                                    <td style="text-align: right"></td>
                                    <td style="text-align: right"></td>
                                    <td style="text-align: right"></td>
                                    <td style="text-align: right">' . number_format($value->harga_estimasi) . '</td>
                                    <td style="text-align: right"></td>
                                    <td style="text-align: center">-</td>
                                    <td style="text-align: right">' . number_format($value->jumlah_harga) . '</td>
                                </tr>';
                    }
                    $a .= '</tbody>
                           <tfoot>
                                <tr>
                                    <th colspan="10" style="text-align:center"> Terbilang : '.ucwords(MyFormatter::kataTerbilang($model->total_hargaseluruhnya))." rupiah".'</th>
                                    <th style="text-align: left">JUMLAH<br>PAJAK<br>TOTAL</td>
                                    <th style="text-align: right">'.number_format($model->total_harga,2,',','.').'<br>
                                                                  '.number_format($model->total_pajak,2,',','.').'<br>
                                                                  '.number_format($model->total_hargaseluruhnya,2,',','.').'</td>
                                </tr>
                           </tfoot>
                           </table>';
                    echo $a;
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="30%"></td>
                <td width="40%"></td>
                <td width="30%" style="vertical-align:top; text-align: center;">Surabaya, <?php echo date('d ', strtotime($model->persiapanpengadaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->persiapanpengadaan_tanggal))) . date(' Y', strtotime($model->persiapanpengadaan_tanggal)); ?></td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; text-align: center;"></td>
                <td width="40%"></td>
                <td width="30%" style="vertical-align:top; text-align: center;">Ditetapkan Oleh:<br>PEJABAT PEMBUAT KOMITMEN<br> </td>
            </tr>
            <tr>
                <td width="30%"> </td>
                <td width="40%"> </td>
                <td width="30%" height="80px"> </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; text-align: center; text-decoration: underline"></td>
                <td width="40%"> </td>
                <td width="30%" style="vertical-align:top; text-align: center; text-decoration: underline"><?php echo $model->pegawaipembuat->namaLengkap; ?></td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; text-align: center"> </td>
                <td width="40%"> </td>
                <td width="30%" style="vertical-align:top; text-align: center"> <?php echo $model->pegawaipembuat->pangkat->pangkat_nama; echo ' / '; echo $model->pegawaipembuat->golonganpegawai->golonganpegawai_nama;?></td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; text-align: center"> </td>
                <td width="40%"> </td>
                <td width="30%" style="vertical-align:top; text-align: center"> NIP. <?php echo $model->pegawaipembuat->nomorindukpegawai; ?></td>
            </tr>
        </table>
    </div>
</div>
