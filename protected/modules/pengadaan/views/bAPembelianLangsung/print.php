<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

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
    .page-break { display: none; }
    }

    @media print {
    .page-break { padding-top: 1cm; display: block; page-break-before: always; }
    }
    h4{
       font-family: Arial, sans-serif;
       font-size: 20px !important;
    }
    .garis {
        border-top: 3px double black;
    }

</style>
<div class="container">
    <div class="row-fluid" >
        <p style="float:right; border: 1px solid; padding: 5px 10px 5px 10px">
            BA 1
        </p>
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="90%" style="vertical-align:top; text-align: justify"><?php echo !empty($model->dasar) ? $model->dasar : ""; ?></td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center"> <b> PIHAK KEDUA</b> </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <u> <?php echo $model->pegpihakkedua->namaLengkap?> </u> <br>
                                <?php echo "NIP. ".$model->pegpihakkedua->nomorindukpegawai?> 
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center"> <b> PIHAK KESATU </b> </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <u> <?php echo $model->pegpihakkesatu->namaLengkap?> </u> <br>
                                <?php echo "NIP. ".$model->pegpihakkesatu->nomorindukpegawai; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="page-break"> </div>
    
    <div class="row-fluid" >
        <p style="float:right; border: 1px solid; padding: 5px 10px 5px 10px">
            LBA 1
        </p>
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
    </div>
    
    <div class="row-fluid">
        <p> <u> Lampiran Berita Acara Pembelian Langsung</u></p>
        <table>
            <tr>
                <td> Nomor </td>
                <td> : </td>
                <td> <?php echo $model->nomor_beritaacara; ?> </td>
            </tr>
            <tr>
                <td> Tanggal </td>
                <td> : </td>
                <td> <?php echo MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($model->bapembelianlangsung_tanggal))); ?> </td>
            </tr>
        </table>
        <br>        
        <table width="100%" border="1">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Banyaknya </th>
                    <th> Uraian dan Spesifikasi </th>
                    <th> Harga Satuan <br> (Rp) </th>
                    <th> Total Harga <br> (Rp) </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $modDetail = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                $jumlah = 0;
                $ppn = 0;
                if (!empty($modDetail)) {
                    foreach ($modDetail as $key => $value) {
                        echo "
                        <tr>
                            <td>" . ($key + 1) . "</td>
                            <td>" . $value->barang_jumlah . " " . $value->barang_satuan . "</td>
                            <td>" . $value->barang_nama . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->barang_harga,2,",",".") . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->barang_jumlah * $value->barang_harga,2,",",".") . "</td>
                        </tr>
                        ";
                        $jumlah += ($value->barang_jumlah * $value->barang_harga);
                    }
                }

                $ppn = $modSurat->jumlah_pajak;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right"> Jumlah: </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$jumlah,2,",",".") .
                        CHtml::activeHiddenField($model, 'jumlah_harga', array('class' => 'span3', 'readonly' => true, 'value' => $jumlah))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"> PPN 10% : *) </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$ppn,2,",",".") .
                        CHtml::activeHiddenField($model, 'jumlah_pajak', array('class' => 'span3', 'readonly' => true, 'value' => $ppn))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"> Jumlah + PPN : *) </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$jumlah + $ppn,2,",",".") .
                        CHtml::activeHiddenField($model, 'total_harga', array('class' => 'span3', 'readonly' => true, 'value' => ($jumlah + $ppn)));
                        
                        
                        $total = $jumlah + $ppn;
                        $split = explode('.', $total);
                        $terbilang_koma = '';           
                        if (isset($split[1])){
                            $terbilang_koma = ' koma '.MyFormatter::kataTerbilang($split[1]);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"> Terbilang : <?php echo !empty($total) ? ucwords(MyFormatter::kataTerbilang($total).$terbilang_koma). ' rupiah' : 'Nol rupiah'; ?> </td> 
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center"> <b> PIHAK KEDUA</b> </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <u> <?php echo $model->pegpihakkedua->namaLengkap?> </u> <br>
                                <?php echo "NIP. ".$model->pegpihakkedua->nomorindukpegawai?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center"> <b> PIHAK KESATU </b> </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <u> <?php echo $model->pegpihakkesatu->namaLengkap?> </u> <br>
                                <?php echo "NIP. ".$model->pegpihakkesatu->nomorindukpegawai; ?>
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
     $("h3").css("text-align"," center");
     $("big").parent().css("text-align","center");
});
</script>