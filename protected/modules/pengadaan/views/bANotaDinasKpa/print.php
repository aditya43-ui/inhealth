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

$cekKPA = PegawaiM::model()->findByPk($model->pegkpa_id);
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
</div>
<br>
<br>
<div class="row-fluid" >
    <table width="100%">
        <tr>
            <td width="60%"></td>
            <td width="40%" style="text-align: center">Surabaya, <?php echo date('d ', strtotime($model->notadinaskpa_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->notadinaskpa_tanggal))) . date(' Y', strtotime($model->notadinaskpa_tanggal)); ?></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%">
            </td>
            <td width="40%" style="text-align: center">Kuasa Pengguna Anggaran</td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%" style="text-align: center"><u><?php echo!empty($cekKPA) ? $cekKPA->namaLengkap : ''; ?></u></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%" style="text-align: center"><?php echo!empty($cekKPA->pangkat_id) ? $cekKPA->pangkat->pangkat_nama : ''; ?></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%" style="text-align: center">NIP. <?php echo!empty($cekKPA) ? $cekKPA->nomorindukpegawai : ''; ?></td>
        </tr>
    </table>
</div>