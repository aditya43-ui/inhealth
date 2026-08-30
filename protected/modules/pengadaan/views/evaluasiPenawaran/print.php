<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
        font-size: 12pt !important;
        margin:0;
    }
    @media print {
        html, body {
            margin: 1cm;
            font-family: "Times New Roman", Times, serif;
            font-size:12pt;
/*            width:  21cm;
            height: 33cm;*/
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
        .page-break { padding-top: 1cm; display: block; page-break-before: always; }
    }
    
    td {
        font-family: "Arial";
        color: black;
        font-size:16px !important;
    }
    th {
        font-family: "Arial";
        color: black;
        font-size:16px !important;
    }
    p {
        font-family: "Arial", Times, serif;
        font-size:16px !important;
    }
    h4{
        font-family: Arial, sans-serif;
        font-size: 20px !important;
    }
    .garis {
        border-top: 3px double black;
    }

</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$cekInformasiUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
$cekPjphp = PegawaiM::model()->findByPk($cekInformasiUmum->pegpengadaan_id);
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
                <td width="60%">
                </td>
                <td width="40%" style="text-align: center">PEJABAT PENGADAAN <br> RSUD Dr. SOETOMO Prov. JATIM</td>
            </tr>
            <tr>
                <td width="60%"></td>
                <td width="40%" height="85px"> </td>
            </tr>
            <tr>
                <td width="60%"></td>
                <td width="40%" style="text-align: center"><u><?php echo!empty($cekPjphp) ? $cekPjphp->namaLengkap : ''; ?></u></td>
            </tr>
            <tr>
                <td width="60%"></td>
                <td width="40%" style="text-align: center"><?php echo!empty($cekPjphp) ? $cekPjphp->pangkat->pangkat_nama : ''; ?></td>
            </tr>
            <tr>
                <td width="60%"></td>
                <td width="40%" style="text-align: center">NIP <?php echo!empty($cekPjphp) ? $cekPjphp->nomorindukpegawai : ''; ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break"></div>