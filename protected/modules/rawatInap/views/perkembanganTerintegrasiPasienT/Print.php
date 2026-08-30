<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    #headerset{
        width:80px !important;
        max-width :75px !important;
        margin-top:2% !important;

    }
    #headerset2{
        width:100px !important;
        max-width :100px !important;
        margin-top:-5% !important;

    }
    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always; }
    }
    @page {

        margin: 0cm 0cm 0cm 0cm;
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
        div.footer {
            position: fixed;
            bottom: 0;
            float:left;
        }
        .headrtd{
            background-color:#afdc7e !important;


        }

        #headerset{
            width:80px !important;
            max-width :75px !important;
            margin-top:7% !important;

        }
        #headerset2{
            width:100px !important;
            max-width :100px !important;
            margin-top:-5% !important;
        }
         .header-space{

                height: 2cm;
            }
         

    }
    table.footer {
        position: fixed;
        bottom: 0;

    }

#breakfloat{
       
        overflow: hidden;
        word-wrap: break-word;

        
    }
    /*    jika kondisi print wajib*/
    .form-horizontal .controls {
        float:none;
        
    }
</style>

<style>

    div{
        font-size: 10pt !important;
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
     table th{
        padding:1px !important;
        vertical-align:top;
        font-size: 9pt !important;
        font-family: Arial !important;
        color:black !important;
    }
    .border th, .border td{
        border:1px solid #000;
    }
    #table-dalam tr td{
        border:1px solid ;
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
    p{
        font-size: 9pt !important;
        font-family: Arial !important;
        color:black !important;
    }
    .alig{
        text-align:left !important;
    }
    .control-label{
        color:black !important;

    }
    body{
        -webkit-print-color-adjust: exact;
    }
    #table-dalam tr td{
        border:1px solid ;
    }
    #table-dalam tr th{
        border:1px solid ;
    }

</style>
<span style="width: 100%">
    <table width="100%" border="1px" id="tablekematian" >
        <tr>
            <td rowspan="3" style="width:65%"><?php echo $this->renderPartial('rawatInap.views.asesmenAwalKeperawatan._headerPrint'); ?></td>
            <td style="width:15%" border-top="1px">Nama Lengkap</td>
            <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td style="width:15%">Tgl. Lahir </td>
            <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
        </tr>
        <tr>
            <td style="width:15%">No. Rekam Medik</td>
            <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>

    </table>
    <span style="float:right; padding-top: 10px;"><h4>RM 05C IGD</h4></span>
    <div style="padding-top: 5px; text-align:center; font-weight:bold">
        <h4 style='padding-left:35px;'>PERKEMBANGAN TERINTEGRASI PASIEN <br> <i>INTEGRATED OF CARE</i></h4><br>

    </div>
</span>
<table width="100%" style="margin-top:-1cm" >
    <thead>
        <tr>
            <td>
                <div class="header-space">&nbsp;</div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content"><?php
                    $this->renderPartial($this->path_view . 'Print_table', array('modPendaftaran' => $modPendaftaran,
                        'model' => $model,
                        'modPasien' => $modPasien,
                        'modAdmisi' => $modAdmisi));
                    ?></div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div style="height:2cm">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
   
</div>