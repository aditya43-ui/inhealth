<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
   
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
    <table width="100%" style="margin-top:-2cm" >

        <thead>
            <tr>
                <td colspan="3">
                    <div class="header-space">

                    </div>  
                    <table width="100%"  id="tablekematian" >
                        <tr >
                            <td rowspan="3" style="width:45%"><?php echo $this->renderPartial('anestesi.views.informasiTindakanAnestesi._headerPrint'); ?></td>
                            <td style="width:10%;" border-top="1px"></td>
                            <td style="width:25%;">
                                <table width="100%" style="border:2px solid #727272 ; ">
                                    <tr>
                                        <td ><span>Nama Lengkap</span></td>
                                        <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>Tgl. Lahir </td>
                                        <td><?php echo MyFormatter::formatDateTimeId($modPendaftaran->pasien->tanggal_lahir); ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. Rekam Medik</td>
                                        <td><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
                                    </tr>
                                </table>
                            </td>
                           
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
                        $this->renderPartial('tabel_PrintPDF', array('modPendaftaran' => $modPendaftaran,
                            'modPasienAnestesi' => $modPasienAnestesi, 'modEvaluasi' => $modEvaluasi
                        ));
                        ?>
                    </div>

                </td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space"></div>
                </td>
            </tr>
        </tfoot>
    </table>
    
</body>
</html>