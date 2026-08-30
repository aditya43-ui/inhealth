<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    h4{
       text-align: center;
       font-family: Arial, sans-serif;
       font-size: 16px !important;
    }
    table tr td{
       font-family: Arial, sans-serif;
       font-size: 12px !important;
    }
    .garis {
        border-top: 3px double black;
    }
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
            height: 330mm;
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
<div class="container">
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td> <h4 style="text-transform: uppercase">  <center> Unit Khusus Pengadaan Barang / Jasa </center> </h4></td>
            </tr>
            <tr>
                <td> <h4> <center> RSUD Dr. SOETOMO SURABAYA </center> </h4> </td>
            </tr>
            <tr>
                <td style="border-bottom: #000 3px solid"> </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="80%" style="vertical-align:top"><?php echo !empty($model->dasar) ? $model->dasar : ""; ?></td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="35%"> </td>
                <td width="65%" style="vertical-align:top; text-align: center"> 
                    <?php echo 'Surabaya, ', date('d', strtotime($model->pengumumanpemenang_tanggal))." ".MyFormatter::getMonthId(date('m', strtotime($model->pengumumanpemenang_tanggal))).date(' Y', strtotime($model->pengumumanpemenang_tanggal));  ?><br>
                </td>

            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="65%" style="vertical-align:top; text-align: center"> <?php echo $model->peg_jabatan; ?></td> 
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="65%" height="80px"> </td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="65%" style="vertical-align:top; text-align: center"> <u> <?php echo !empty($model->pegawai->namaLengkap) ? $model->pegawai->namaLengkap : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?> </u> </td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="65%" style="vertical-align:top; text-align: center"> <?php echo !empty($model->pegawai->pangkat_id) ? $model->pegawai->pangkat->pangkat_nama: "____________________________";?></td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="65%" style="vertical-align:top; text-align: center"> <?php echo "NIP "; echo !empty($model->pegawai->nomorindukpegawai) ? $model->pegawai->nomorindukpegawai : '_________________________';?></td>
            </tr>
        </table>
    </div>
</div>