<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
        size: 5.90551in 4.133858in;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        margin-right:0px;
        font-size: 8pt !important;
    }
    @media print {
        html, body {
            width: 5.90551in;
            height: 4.133858in;
            font-size: 8pt !important;
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
</style>

<table style="width:5.90551in;" border="0px">
    <tr>
        <td colspan="3" style="padding-left: 0.787402in; padding-top: 0.393701in; width: 3.93701in; vertical-align: top; height:0.19685in; font-size: 9pt;">No.Reg / No.KTP</td>
        <td rowspan="2" colspan="2" style="padding-top: 0.393701in; text-align: center; vertical-align: top; font-size: 8pt;">
            <b>UNIT PELAYANAN TRANSFUSI DARAH<br> 
            RSUD Dr. SOETOMO<br>
            Gedung Diagnostik Center<br></b>
            Jl. Mayjend. Prof. Dr. Moestopo No. 6-7<br>
            Telp. 031-5501745 Surabaya<br>
            <span style="font-size:10pt"><b><u>KARTU DONOR DARAH</u></b></span>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 1.06299in;text-align: left;width: 2.95276in; vertical-align: top">
            <?php $url_photopasien = (!empty($modPendonor->photopendonor) ? Params::urlPendonorDirectory() . $modPendonor->photopendonor : Params::urlPendonorDirectory() . "no_photo.jpeg"); ?>
            <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="max-width: 1.1811in; max-height: 1.1811in; min-width: 1.1811in; min-height: 1.1811in;"/>   
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align: center; width: 2.95276in !important; font-size: 9pt;"><b>CATATAN PENERIMAAN PENGHARGAAN</b></td>
        <td></td>
        <td></td>
        <td style=" width:0.787402in;  height: 0.314961in;vertical-align:top"><span style="text-align:left; font-size: 9pt;"><b>NAMA </b></span></td>
        <td style="vertical-align:top;font-size: 8pt">: <?php echo $modPendonor->nama_lengkap ?></td>
    </tr>
    <tr>
        <td rowspan="5" style="text-align: center; width: 2.95276in !important">
            <table border="1px" width="92%" style="margin-left:10px">
                <tr>
                    <td style="font-size: 9pt"><b>PENGHARGAAN</b></td>
                    <td style="font-size: 9pt"><b>TANGGAL</b></td>
                    <td style="font-size: 9pt"><b>TTD PTGS</b></td>
                </tr>
                <tr>
                    <td style="font-size: 8pt"><b>10X</b></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: 8pt"><b>25X</b></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: 8pt"><b>50X</b></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: 8pt"><b>75X</b></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: 8pt"><b>100X</b></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </td>
        <td></td>
        <td></td>
        <td style=" width:0.787402in; height: 0.314961in;vertical-align:top"><span style="text-align:left; font-size: 8pt;"><b>ALAMAT </b></span></td>
        <td style="vertical-align:top;font-size: 8pt">: <?php echo $modPendonor->alamat_lengkap ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style=" width:0.787402in; height: 0.0787402in;vertical-align:top"><span style="text-align:left; font-size: 8pt;"><b>TGL. LAHIR </b></span></td>
        <td style="vertical-align:top;font-size: 8pt">: <?php echo $modPendonor->tgllahir ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style=" width:0.787402in; height: 0.0787402in;vertical-align:top"><span style="text-align:left; font-size: 8pt;"><b>PEKERJAAN </b></span></td>
        <td style="vertical-align:top;font-size: 8pt">: <?php echo $modPendonor->pekerjaan->pekerjaan_nama ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style=" width:0.787402in; height: 0.0787402in;vertical-align:top"><span style="text-align:left; font-size: 8pt;color:transparent"><b>PEKERJAAN </b></span></td>
        <td style="vertical-align:top"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style=" width:0.787402in; height: 0.0787402in;vertical-align:top"><span style="text-align:left; font-size: 8pt;color:transparent"><b>PEKERJAAN </b></span></td>
        <td style="vertical-align:top"></td>
    </tr>
    <tr>
        <td style="font-size: 8pt">&nbsp;&nbsp;&nbsp;- Bawalah selalu kartu ini</td>
        <td></td>
        <td></td>
        <td rowspan="4" colspan="2">
            <table border="1px" width="98%" height="100%" style="margin-bottom:0.393701in; vertical-align: bottom">
                <tr>
                    <td style="font-size: 10pt"><b>&nbsp;&nbsp;&nbsp;GOLONGAN DARAH : <?php echo $modPendonor->gol_darah ?></b></td>
                </tr>
                <tr>
                    <td style="font-size: 10pt"><b>&nbsp;&nbsp;&nbsp;RHESUS : <?php echo $modPendonor->rhesus ?></b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="font-size: 8pt">&nbsp;&nbsp;&nbsp;- Jika alamat anda telah berubah, mohon</td>
        <td></td>
    </tr>
    <tr>
        <td style="font-size: 8pt">&nbsp;&nbsp;&nbsp;<span style="color:transparent">- </span>untuk memberitahu petugas administrasi</td>
        <td></td>
    </tr>
    <tr>
        <td style="font-size: 8pt">&nbsp;&nbsp;&nbsp;<span style="color:transparent">- </span>Unit Transfusi Darah RSUD Dr. Soetomo Surabaya</td>
        <td></td>
    </tr>
</table>