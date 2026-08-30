<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<style>
@page {
/*   size: 7in 9.25in;*/
/*   margin: 27mm 16mm 27mm 16mm;*/
   font-size: 12pt !important;
   margin-top:0;
   margin-bottom:0;
   margin-left:0;
   margin-right:0;
}
@media print {
  html, body {
    padding:1cm 1.5cm 1cm 1.5cm;
    font-family: "Times New Roman", Times, serif;
    font-size:12pt;
    width:  21cm;
    height: 33cm;
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
.page-break { display: block; page-break-before: always; }
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
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always;}
    }

</style>
<div class="container">
    <div class="row-fluid" >
        <p style="float:right; border: 1px solid; padding: 5px 10px 5px 10px">
            BA 4
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
                            <td align="center">
                                <?php echo $model->supplier->supplier_nama?> 
                            </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <u> <?php echo $model->supplier->direktursupplier?> </u> <br>
                                Direktur 
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
                            <td align="center">PEJABAT PEMBUAT KOMITMEN</td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <u> <?php echo $model->pegawai->namaLengkap?> </u> <br>
                                <?php echo "NIP. ".$model->pegawai->nomorindukpegawai; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="page-break"> </div>
    <div style="height:2cm">&nbsp;</div>
    <div class="row-fluid" >
        <p style="float:right; border: 1px solid; padding: 5px 10px 5px 10px">
            LBA 4
        </p>
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
    </div>
    
    <div class="row-fluid">
        <p> <u> Lampiran Berita Acara Serah Terima Hasil Pekerjaan</u></p>
        <table>
            <tr>
                <td> Nomor </td>
                <td> : </td>
                <td> <?php echo $model->nomor_beritaacara; ?> </td>
            </tr>
            <tr>
                <td> Tanggal </td>
                <td> : </td>
                <td> <?php echo date('d ', strtotime($model->baserahterima_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->baserahterima_tanggal))) . date(' Y', strtotime($model->baserahterima_tanggal)) ?> </td>
            </tr>
        </table>
        <br>        
        <table width="100%" border="1">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Uraian Pekerjaan</th>
                    <th> Satuan </th>
                    <th> Volume </th>
                    <th> Harga Satuan <br> (Rp) </th>
                    <th> Jumlah Harga <br> (Rp) </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $modDetail = BaserahterimadetT::model()->findAllByAttributes(array('baserahterima_id'=>$model->baserahterima_id));
                $jumlah = 0;
                $ppn = 0;
                if (!empty($modDetail)) {
                    foreach ($modDetail as $key => $value) {
                        echo "
                        <tr>
                            <td>" . ($key + 1) . "</td>
                            <td>" . $value->nama_barang . "</td>
                            <td>" . $value->satuan_barang . "</td>
                            <td style=\"text-align: right\">" . $value->jumlah_barang . "</td>
                           
                            <td style=\"text-align: right\">" . number_format((float)$value->harga_satuan,2,",",".") . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->jumlah_barang * $value->harga_satuan,2,",",".") . "</td>
                        </tr>
                        ";
                        
                    }
                }

                $jumlah = $model->jumlah_harga;
                $ppn = $model->jumlah_pajak;
                
                $split = explode('.', $jumlah + $ppn);
                $terbilang_koma = '';           
                if (isset($split[1])){
                    $terbilang_koma = ' koma '.MyFormatter::kataTerbilang($split[1]);
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" rowspan="5"> Terbilang : <?php echo !empty($jumlah + $ppn) ? ucwords(MyFormatter::kataTerbilang($jumlah + $ppn).$terbilang_koma). ' rupiah' : 'Nol rupiah'; ?></td> 
                    <td  style="text-align: right"> Jumlah: </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$model->jumlah_harga,2,",",".") 
                        ?>
                    </td>
                </tr>
                <tr>
                    
                    <td  style="text-align: right"> PPN 10% :  </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$model->jumlah_pajak,2,",",".") 
                        ?>
                    </td>
                </tr>
                <tr>
                    
                    <td  style="text-align: right"> Total :  </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$model->total_harga,2,",",".")
                       
                        ?>
                    </td>
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
                            <td align="center">
                                <?php echo $model->supplier->supplier_nama?> 
                            </td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <u> <?php echo $model->supplier->direktursupplier?> </u> <br>
                                Direktur 
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
                            <td align="center">PEJABAT PEMBUAT KOMITMEN</td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <u> <?php echo $model->pegawai->namaLengkap?> </u> <br>
                                <?php echo "NIP. ".$model->pegawai->nomorindukpegawai; ?>
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
    $("table tbody").find("table").attr("border","0");
     $("table tbody").find("table").attr("border","0");
     $("table tbody").find("table").css("width","100%");
     $("p").css("text-align"," justify");
     $("h2").css("text-align"," center");
     $("h3").css("text-align"," center");
     $("big").parent().css("text-align","center");
     
     $("table tbody").find("table td").attr("text-align","justify");
     $("table tbody").find("table td").css("vertical-align","top");
});
</script>