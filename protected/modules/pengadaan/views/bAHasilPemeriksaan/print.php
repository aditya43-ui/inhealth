<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());?>

<style>
    @page {
        font-size: 12pt !important;
        margin:0;
    }
    @media print {
        html, body {
            margin: 1cm;
            font-family: "Times New Roman", Times, serif;
            font-size:12pt;
/*            width:  21cm;
            height: 33cm;*/
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }

    @media all {
        .page-break { display: none;}
    }

    @media print {
        .page-break { display: block;page-break-before: always;}
    }
    td {
        font-family: "Arial";
        color: black;
        font-size:12pt;
    }
    th {
        font-family: "Arial";
        color: black;
        font-size:12pt;
    }
    p {
        font-family: "Arial", Times, serif;
        font-size:12pt;
    }
    h4 {
        font-family: "Arial", Times, serif;
        font-size:14pt;
    }
    #judul{
        font-size:14pt;
    }
    u {
        font-family: "Arial", Times, serif;
        font-size:12pt;
    }

    .tabel-pemenang{
        color: black;
        font-family: Arial;
        font-size: 12pt;
    }
    .garis {
        border-top: 3px double black;
    }

    blockquote {
        text-align: center;
        border: none;
    }
    @media all {
        .page-break { display: none;}
    }

    @media print {
        .page-break {padding-top: 1cm; display: block; page-break-before: always;}
    }

</style>
<div class="container">
    <div class="row-fluid" >
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara');?>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="90%" style="vertical-align:top; text-align: justify"><?php echo !empty($model->dasar) ? $model->dasar : "";?></td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center"> <b> PIHAK KEDUA</b> <br> <?php echo $model->supplier->supplier_nama?> </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <u> <b> <?php echo $model->supplier->direktursupplier?>  </b> </u> <br>
                                Direktur
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center"> <b> PIHAK KESATU </b> <br> PEJABAT PEMBUAT KOMITMEN </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <u> <b>  <?php echo $model->pegpihakkesatu->namaLengkap?> </b> </u> <br>
                                <?php echo "NIP. ".$model->pegpihakkesatu->nomorindukpegawai;?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="page-break"> </div>
    
    <div class="row-fluid" >
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara');?>
    </div>
    
    <div class="row-fluid">
        <?php 
            if ($modSurat->istermin == true) { 
            $mTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $modSurat->suratperjanjiankerja_id, 'terminke' => $model->terminke));
        ?>
            <p style="color: black"> <u> Lampiran Berita Acara Hasil Pemeriksaan Pekerjaan (TERMIN <?php echo $mTermin->terminke?>)</u></p>
        <?php } else { ?>
            <p style="color: black"> <u> Lampiran Berita Acara Hasil Pemeriksaan Pekerjaan </u></p>
        <?php } ?>
        <table>
            <tr>
                <td> Nomor </td>
                <td> : </td>
                <td> <?php echo $model->nomor_beritaacara;?> </td>
            </tr>
            <tr>
                <td> Tanggal </td>
                <td> : </td>
                <td> <?php echo MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($model->bahasilpemeriksaanpekerjaan_tanggal)));?> </td>
            </tr>
        </table>
        <br>        
        <table border="1" id="tabel_lampiran" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Uraian Pekerjaan</th>
                        <th>Satuan</th>
                        <th>Volume</th>
                        <th>Harga Satuan (Rp)</th>
                        <th>Jumlah Harga (Rp)</th>
                        <th>Hasil Pemeriksaan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $modSPKRincian = ADBapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id' => $model->bapemeriksaanpekerjaan_id));
                    
                    $jumlah = 0;
                    $ppn = 0;
                    if (count($modSPKRincian)) {

                        foreach ($modSPKRincian as $key => $value) {
                            if ($value->hasil_pemeriksaan == 1) {
                                $hasil = "<i class='fa fa-check'>";
                            } else {
                                $hasil = "<i class='fa fa-times'></i>";
                            }
                            echo "
                        <tr>
                            <td><center>" .
                            ($key + 1)
                            . "<center></td>
                            <td style='text-align:left'>" . $value->nama_barang . "</td>
                            <td style='text-align:center'>" . $value->satuan_barang . "</td>
                            <td style='text-align:center'>" . $value->jumlah_barang . "</td>
                            <td style='text-align:right'>" . number_format((float)$value->harga_satuan,2,",",'.') . "</td>
                            <td style='text-align:right'>" . number_format((float)$value->jumlah_harga,2,",",'.') . "</td>
                            <td style='text-align:center'>" . $hasil . "</td>
                            <td style='text-align:center'>" . $value->keterangan_pemeriksaan . "</td>
                        </tr>
                        ";
                            $jumlah += $value->jumlah_harga;
                        }
                    }
                    $ppn = $model->jumlah_pajak;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align: right">Jumlah : </th>
                        <th style='text-align:right'><?php echo number_format((float)$jumlah,2,",",'.') ?></th>
                        <?php if($modSurat->istermin == true){ ?>
                            <th colspan="2" rowspan="5">&nbsp;</th>
                        <?php } else { ?>
                            <th colspan="2" rowspan="3">&nbsp;</th>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align: right">PPN 10% : </th>
                        <th style='text-align:right'><?php echo number_format((float)$ppn,2,",",'.') ?></th>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align: right">Total : </th>
                        <th style='text-align:right'><?php echo number_format((float)$jumlah + $ppn,2,",",'.') ?></th>
                    </tr>
                    <?php if($modSurat->istermin == true){ ?>
                    <tr>
                        <th colspan="5" style="text-align: right">Dibulatkan : </th>
                        <th style='text-align:right'><?php echo number_format((float)$modSurat->total_pembulatan,2,",",'.') ?></th>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align: right"> Termin <?php echo $model->terminke." (".$model->termin_persen." %)"?> : </th>
                        <th style="text-align: right">
                            <?=
                            number_format((float)$model->total_pembayaran,2,",",'.');?>
                        </th>
                    </tr>
                    <?php } ?>
                </tfoot>
            </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td > 
                                <u>Kolom Keterangan</u> <br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td><i class='fa fa-check'></i></td>
                                        <td>=</td>
                                        <td>Sesuai kontak</td>
                                    </tr>
                                    <tr>
                                        <td><i class='fa fa-times'></i></td>
                                        <td>=</td>
                                        <td>Tidak sesuai kontrak</td>
                                    </tr>
                                </table> 
                            </td>
                        </tr>
                    </table>
                </td> 
            </tr>
            <tr>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center"> <b> PIHAK KEDUA</b> <br> <?php echo $model->supplier->supplier_nama?>  </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <u> <b> <?php echo $model->supplier->direktursupplier?> </b> </u> <br>
                                Direktur
                                
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center"> <b> PIHAK KESATU </b> <br> PEJABAT PEMBUAT KOMITMEN </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <u> <b> <?php echo $model->pegpihakkesatu->namaLengkap?> </b> </u> <br>
                                <?php echo "NIP. ".$model->pegpihakkesatu->nomorindukpegawai;?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid">
        <table width="100%">
            <tr>
                <td> <i> *) jika diperlukan </i></td>
            </tr>
        </table>
    </div>
</div>

<script>
$( document ).ready(function() {
     $("h4").css("text-align", "center");
     $("h4").css("font-weight", "normal");
     $("h4").css("color", "black");
     $("h3").css("text-align"," center");
     $("h3").css("text-decoration", "underline");
     $("h3").css("color", "black");
     $("h3").css("font-size", "24");
});
</script>