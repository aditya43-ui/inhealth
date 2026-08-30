<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    @page {
        /*   size: 7in 9.25in;*/
        /*   margin: 27mm 16mm 27mm 16mm;*/
        font-size: 12pt !important;
        margin-top:0;
        margin-bottom:0;
        margin-left:0;
        margin-right:0;
        padding:1cm 1.5cm 1cm 1.5cm;
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
    h3 {
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
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<div class="container">
    <div class="row-fluid" >

        <table width="100%" border="0px">
            <tr>
                <td width="15%" align="center">
                    <img src="<?php echo Params::pathImageErrorAdmin() . "Jawa_Timur.png" ?> " style="max-width: 110px; width:110px;"/>
                </td>
                <td align="center" style="vertical-align:top">
                    <div style="font-size:13pt !important">
                        <?php
                        echo strtoupper($modProfilRs->namakepemilikanrs) . ' ';
                        echo strtoupper($modProfilRs->propinsi->propinsi_nama);
                        ?>
                    </div>
                    <div style="font-size:13pt !important">
                        <?php echo strtoupper($modProfilRs->nama_rumahsakit); ?>
                    </div>
                    <div style="font-size:13pt !important">
                        <?php echo "PEJABAT PEMBUAT KOMITMEN" ?>
                    </div>
                    <div style="font-size:13pt !important">
                        <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>, Telp. <?php echo $modProfilRs->notelphumas; ?> - 5501013
                    </div>

                    <div style="font-size:13pt !important">
                        <u>S U R A B A Y A -60286</u>
                    </div>
                    <hr style="border:1px solid">
                </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="90%" style="vertical-align:top; text-align: justify"><?php echo!empty($model->dasar) ? $model->dasar : ""; ?></td>
            </tr>
        </table>
    </div>


</div>
<table width="100%" >
    <tr>
            <td width="35%"></td>
            <td width="20%"></td>
            <td width="45%" style="vertical-align:top; text-align: center;">Pejabat Pembuat Komitmen<br> </td>
        </tr>
    
     <tr>
            <td width="35%"></td>
            <td width="20%"></td>
            <td width="44%" style="vertical-align:top; text-align: center;">RSUD Dr. Soetomo Prov Jatim<br> </td>
        </tr>
   
       
        <tr>
            <td width="35%"> </td>
            <td width="20%"> </td>
            <td width="45%" height="80px"> </td>
        </tr>
        <tr>
            <td width="35%"> </td>
            <td width="20%"> </td>
            <td width="45%" style="vertical-align:top; text-align: center; text-decoration: underline"><?php echo $model->pegppk->namaLengkap; ?></td>
        </tr>
        <tr>
            <td width="35%"> </td>
            <td width="20%"> </td>
            <td width="45%" style="vertical-align:top; text-align: center"> <?php echo $model->pegppk->pangkat->pangkat_nama; ?></td>
        </tr>
        <tr>
            <td width="35%"> </td>
            <td width="20%"> </td>
            <td width="45%" style="vertical-align:top; text-align: center"> NIP. <?php echo $model->pegppk->nomorindukpegawai; ?></td>
        </tr>
    </table>
</table>


<script>
    $(document).ready(function () {
        $("table tbody").find("table").attr("border", "0");
        $("table tbody").find("table").attr("border", "0");
        $("table tbody").find("table").css("width", "100%");
        $("h2").css("text-align", " center");
        $("h3").css("text-align", " center");
        $("big").parent().css("text-align", "center");

        $("table tbody").find("table td").attr("text-align", "justify");
        $("table tbody").find("table td").css("vertical-align", "top");
    });
</script>