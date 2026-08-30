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
$cekPjphp = PegawaiM::model()->findByPk($model->pegpjphp_id);
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
                <td width="40%" style="text-align: center">Pejabat Pemeriksa Hasil Pekerjaan</td>
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
                <td width="40%" style="text-align: center">NIP. <?php echo!empty($cekPjphp) ? $cekPjphp->nomorindukpegawai : ''; ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break"></div>

<div class="row-fluid" >
    <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
</div>
<table border="0" cellpadding="1" cellspacing="1" style="width:100%">
    <tbody>
        <tr>
            <td style="text-align:left; width:70px; font-weight: bold">DAFTAR</td>
            <td>: Lampiran Berita Acara Hasil Pemeriksaan Administratif <?php
                if ($cekSuratPerjanjian->istermin == true) {
                    echo '(TERMIN ' . $model->terminke . ')';
                } else {
                    echo '';
                }
                ?></td>
        </tr>
        <tr>
            <td style="text-align:left; width:70px">Nomor</td>
            <td>: <?php echo $model->nomor_beritaacara; ?></td>
        </tr>
        <tr>
            <td style="text-align:left; width:70px">Pekerjaan</td>
            <td>: <?php echo $cekSuratPerjanjian->namapekerjaan; ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>

<table border="1" style="width:100%">
    <thead>
        <tr>
            <th style="text-align:center;">No</th>
            <th>Jenis Dokumen Diperiksa</th>
            <th style="text-align:center;">Lengkap Sesuai</th>
            <th style="text-align:center;">Lengkap Tidak Sesuai / Tidak Lengkap</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $modPertanyaan = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpjphp_id' => $model->bapemeriksaanadmpjphp_id));

        $no = 1;
        foreach ($modPertanyaan as $value) {
            echo '<tr>';
            echo '<td style="text-align:center;">' . $no . '</td>';
            echo '<td>' . $value->jenis_dokumen . '</td>';
            echo '<td style="text-align:center;">';
            if ($value->islengkap == true) {
                echo '<span class="entypo-check"></span>';
            }
            echo '</td>';
            echo '<td style="text-align:center;">';
            if ($value->islengkap == false) {
                echo '<span class="entypo-check"></span>';
            }
            echo '</td>';
            echo '<td>' . $value->keterangan . '</td>';
            echo '</tr>';
            $no++;
        }
        ?>
    </tbody>
</table>
<br>
<br>
<div class="row-fluid" >
    <table width="100%">
        <tr>
            <td width="60%"></td>
            <td width="40%">Surabaya, <?php echo date('d ', strtotime($model->bapemeriksaanadmpjphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpjphp_tanggal))) . date(' Y', strtotime($model->bapemeriksaanadmpjphp_tanggal)); ?></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td width="60%">
            </td>
            <td width="40%" style="text-align: center">Pejabat Pemeriksa Hasil Pekerjaan</td>
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
            <td width="40%" style="text-align: center">NIP. <?php echo!empty($cekPjphp) ? $cekPjphp->nomorindukpegawai : ''; ?></td>
        </tr>
    </table>
</div>
