<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
@page {
/*   size: 7in 9.25in;*/
/*   margin: 27mm 16mm 27mm 16mm;*/
   font-size: 10pt !important;
   margin-top:0;
   margin-bottom:0;
   margin-left:0;
   margin-right:0;
}
@media print {
  html, body {
    padding:1cm 1.5cm 1cm 1.5cm;
    font-family: "Arial", Times, serif;
    font-size:10pt;
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
}
p {
  font-family: "Arial", Times, serif;
  font-size:10pt;
}
h2 {
  font-family: "Arial", Times, serif;
  font-size:14pt;
}
h3 {
  font-family: "Arial", Times, serif;
  font-size:12pt;
}
#judul{
    font-size:12pt;
}
u {
  font-family: "Arial", Times, serif;
  font-size:10pt;
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
div{
        font-size: 10pt !important;
        font-family: Arial !important;
    }
    .form-horizontal .control-label{
        font-size: 10pt !important;
        font-family: Arial !important;
    }
/*    mengatur spasi dalam td*/
    table td{
        
        font-size: 10pt !important;
        font-family: Arial !important;
        
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
                    <div style="font-size:12pt !important">
                        <b><?php
                            echo strtoupper($modProfilRs->namakepemilikanrs) . ' ';
                            echo strtoupper($modProfilRs->propinsi->propinsi_nama);
                            ?>
                        </b>
                    </div>
                    <div style="font-size:12pt !important">
                        <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
                    </div>
                    <div style="font-size:9pt !important">
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
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="80%" style="vertical-align:top"><?php echo!empty($model->isi_surat) ? $model->isi_surat : ""; ?></td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <br>
        <table width="100%">
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center"></td>
                <td width="30%"> </td>
                <td width="35%"style="vertical-align:top; text-align: center" >  
                    <table width="100%" border="1">
                        <tr>
                            <td style="text-align:right" width="50%">
                              Ditetapkan di  
                            </td>
                            <td style="text-align:left" width="50%">:Surabaya </td>
                           
                        </tr>
                        <tr>
                            <td style="text-align:right">
                              Pada Tanggal  
                            </td>
                            <td style="text-align:left">:<?php echo date('d ', strtotime($model->perintahmulaikerja_tanggal)).MyFormatter::getMonthId(date('m', strtotime($model->perintahmulaikerja_tanggal))).date(' Y', strtotime($model->perintahmulaikerja_tanggal));  ?>  </td>
                            
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center"> PIHAK KEDUA<br> </td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> PIHAK KESATU<br> </td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center"> <?php echo $model->supplier_nama ?></td> 
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> PEJABAT PEMBUAT KOMITMEN</td> 
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="30%"> </td>
                <td width="35%" height="80px"> </td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center; text-decoration: underline"> <?php echo $model->nama_direktur ?></td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center; text-decoration: underline"> <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->namaLengkap : '' ?></td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center;"> Direktur</td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->pangkat->pangkat_nama : '' ?></td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> NIP. <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->nomorindukpegawai : '' ?></td>
            </tr>
        </table>
        
    </div>
</div>
<script>
$( document ).ready(function() {
    $("table tbody").find("table").attr("border","0");
     $("table tbody").find("table").attr("border","0");
     $("table tbody").find("table").css("width","80%");
     $("p").css("text-align"," justify");
     $("h2").css("text-align"," center");
     $("h3").css("text-align"," center");
     $("big").parent().css("text-align","center");
     
     $("table tbody").find("table td").attr("text-align","justify");
     $("table tbody").find("table td").css("vertical-align","top");
});
</script>