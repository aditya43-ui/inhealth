<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
        size: 5.90551in 4.094488in;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        margin-right:0px;
    }
    @media print {
        html, body {
            width: 5.90551in;
            height: 4.133858in;
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

<table style="width:5.90551in; height: 4.094488in" border="0px">
    <tr>
        <td style="padding-left: 0.787402in; padding-top: 0.393701in; width: 3.54331in !important; vertical-align: top; height:0.19685in; font-size: 9pt;"><?php echo !empty($modPendonor->no_pendonor) ? $modPendonor->no_pendonor : '' ?> / <?php echo !empty($modPendonor->no_identitas) ? $modPendonor->no_identitas :'' ?></td>
        <td rowspan="2" style="padding-top: 1.49606in; text-align: left; vertical-align: top;">
            <table border="0px" style=" height: 100%; width: 100%;">
                <tr>
                    <td style="vertical-align:top; padding-bottom: 0.314961in; height:0.19685in;"><?php echo !empty($modPendonor->nama_lengkap) ? $modPendonor->nama_lengkap : '' ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top; padding-bottom: 0.314961in; height:0.19685in;"><?php echo !empty($modPendonor->alamat_lengkap) ? $modPendonor->alamat_lengkap : '' ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top; padding-bottom: 0.0787402in; height:0.19685in;"><?php echo date('d ', strtotime($modPendonor->tgllahir)).MyFormatter::getMonthId(date('m', strtotime($modPendonor->tgllahir))).date(' Y', strtotime($modPendonor->tgllahir));  ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top; padding-bottom: 0.0787402in; height:0.19685in;"><?php echo !empty($modPendonor->pekerjaan_id) ? $modPendonor->pekerjaan->pekerjaan_nama : '' ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:bottom; padding-bottom: 0.393701in;"><?php echo !empty($modPendonor->rhesus) ? $modPendonor->rhesus : '' ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 1.06299in;text-align: left; width: 2.95276in; vertical-align: top">
            <?php $url_photopasien = (!empty($modPendonor->photopendonor) ? Params::urlPendonorDirectory() . $modPendonor->photopendonor : Params::urlPendonorDirectory() . "no_photo.jpeg"); ?>
            <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="max-width: 1.1811in; max-height: 1.1811in; min-width: 1.1811in; min-height: 1.1811in;"/>   
        </td>
    </tr>
</table>