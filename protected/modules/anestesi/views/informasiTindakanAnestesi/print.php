<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {

        margin: 0cm 0cm 0cm 0cm;
    }

    @media print {
        tr.page-break  { height:100%; page-break-after: always; }
    }
    @media print {
        html, body {
            padding: 1cm 1cm 1cm 1cm;
            font-family: Arial !important;
            font-size: 9pt !important;
            width: 210mm;
            height: 330mm;
            color-adjust: exact;

        }
        .header-space{

            height: 2.5cm;
        }
        .footer-space {
            height: 2.5cm;
        }   
        div.footer {
            position: fixed;
            bottom: 0;
            float:left;
        }
        .headrtd{
            background-color:#afdc7e !important;


        }

        .footer {
            width: 100%;
            position: fixed;
            bottom: 0;
        }
        #pageFooter:after {
            counter-increment: page;
            content: counter(page);
        }
        .footer{
        height: 40mm;
    }
    #setheader{
        margin-top:-2cm;
      }
    }
   
    

</style>

<style>
    div{
        font-size: 9pt !important;
        font-family: Arial !important;
    }
    .form-horizontal .control-label{
        font-size: 9pt !important;
        font-family: Arial !important;
    }
    /*    mengatur spasi dalam td*/
    table td{
        padding:1px !important;
        vertical-align:top;
        font-size: 9pt !important;
        font-family: Arial !important;
        color:black !important;
    }
    table li{
        font-size: 9pt !important;
        font-family: Arial !important;
        color:black !important;
    }
    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    .border {
        box-shadow:none;
        border-spacing:0px;
        padding:0px;
    }
    /*    menghilangkan effect margin bottom pada control group*/
    .control-group{
        margin-bottom:0px !important;
    }
    .controls{
        margin-top:2px !important;
    }
    .alig{
        text-align:left !important;
    }
    .control-label{
        color:black !important;
        text-align:right;

    }
    .control-label .fa{
        padding-top:3px;
        padding-right:3px;


    }
    .controls .fa{
        padding-top:4px;

    }
    body{
        -webkit-print-color-adjust: exact;
    }

</style>
</head>
<body>

    <?php
    $format = new MyFormatter;
    ?>
    <table width="100%" style="" id="setheader" >

        <thead>
            <tr>
                <td colspan="3">
                    <div class="header-space">

                    </div>  
                    <table width="100%" border="1px" id="tablekematian">
                        <tr>
                            <td rowspan="3" style="width:60%"><?php echo $this->renderPartial('anestesi.views.informasiTindakanAnestesi._headerPrint'); ?></td>
                            <td style="width:20%" border-top="1px">Nama Lengkap</td>
                            <td style="width:20%"><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
                        </tr>
                        <tr>
                            <td style="width:20%">Tgl. Lahir </td>
                            <td style="width:20%"><?php echo MyFormatter::formatDateTimeId($modPendaftaran->pasien->tanggal_lahir); ?></td>
                        </tr>
                        <tr>
                            <td style="width:20%">No. Rekam Medik</td>
                            <td style="width:20%"><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
                        </tr>

                    </table>
                    <br>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr class=''>
                <td>
                    <div class="content"><?php
                        $this->renderPartial('tabel_Print', array('modPendaftaran' => $modPendaftaran,
                            'modPasienAnestesi' => $modPasienAnestesi, 'modEvaluasi' => $modEvaluasi
                        ));
                        ?>
                    </div>

                </td></tr>

        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space"><table width="100%">

            <tr>
                <td width="25%" align="left">Revisi : 17/01/17</td>
                <td width="40%" align="center"></td>
                <td width="35%" align="right"><FONT FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><span id="pageFooter">Hal </span><span> Dari 3</span></FONT> </td>
            </tr>

        </table></div>
                </td>
            </tr>
        </tfoot>
    </table>
    
</body>
</html>