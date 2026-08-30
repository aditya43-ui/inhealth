<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
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
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<div class="container">
    <table width="100%" border="0px">
        <tr>
            <td align="center" style="vertical-align:top">
                <div style="font-size:12pt !important">
                    UNIT KHUSUS PENGADAAN BARANG / JASA
                </div>
                <div style="font-size:12pt !important">
                    RSUD Dr.SOETOMO SURABAYA
                </div>
                <hr style="border:1px solid">
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="80%" style="vertical-align:top"><?php echo!empty($model->isi_surat) ? $model->isi_surat : ""; ?></td>
        </tr>
    </table>
    <table width="100%">
        <?php $modelInfo = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));?>
        <tr>
            <td width="35%"></td>
            <td width="30%"></td>
            <td width="35%" style="vertical-align:top; text-align: center;"> <?= $modelInfo->jabatan_pengadaan ?><br> </td>
        </tr>
        <tr>
            <td width="35%"> </td>
            <td width="30%"> </td>
            <td width="35%" height="80px"> </td>
        </tr>
        <tr>
            <td width="35%"> </td>
            <td width="30%"> </td>
            <td width="35%" style="vertical-align:top; text-align: center; text-decoration: underline"><?php echo $model->pegawai->namaLengkap; ?></td>
        </tr>
        <tr>
            <td width="35%"> </td>
            <td width="30%"> </td>
            <td width="35%" style="vertical-align:top; text-align: center"> <?php echo $model->pegawai->pangkat->pangkat_nama; ?></td>
        </tr>
        <tr>
            <td width="35%"> </td>
            <td width="30%"> </td>
            <td width="35%" style="vertical-align:top; text-align: center"> NIP. <?php echo $model->pegawai->nomorindukpegawai; ?></td>
        </tr>
    </table>
</div>
