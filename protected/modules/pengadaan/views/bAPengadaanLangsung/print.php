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
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>

<div class="container">
    <div class="row-fluid" >
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="80%" style="vertical-align:top; text-align: justify"><?php echo!empty($model->isi_surat) ? $model->isi_surat : ""; ?></td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center">Pejabat Pengadaan</td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"><?php // echo !empty($model->supplier_id) ? $model->supplier->supplier_nama : '' ?></td>
                <td width="50%" style="text-align:center">RSUD Dr. Soetomo Surabaya</td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center"></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center"></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center"></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center"></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center"></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center"></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center"></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center"></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"><u><?php // echo $model->direktur_supplier ?></u></td>
                <td width="50%" style="text-align:center"><u><?php echo !empty($model->pegpengadaan->namaLengkap) ? $model->pegpengadaan->namaLengkap : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></u></td>
            </tr>
            <tr>
                <td width="50%" style="text-align:center"></td>
                <td width="50%" style="text-align:center">NIP. <?php echo !empty($model->pegpengadaan->nomorindukpegawai) ? $model->pegpengadaan->nomorindukpegawai : '_________________________'; ?></td>
            </tr>
        </table>
    </div>
</div>