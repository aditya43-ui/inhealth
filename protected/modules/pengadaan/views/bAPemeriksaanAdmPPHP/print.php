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
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
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
                <td width="40%">
                </td>
                <td width="60%">PANITIA PEMERIKSAAN HASIL PEKERJAAN</td>
            </tr>
            <tr>
                <td width="40%">
                </td>
                <td width="60%">
                    <?php
                    $cekPegpphp = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $model->bapemeriksaanadmpphp_id));
                    $a = '<table border="0" style="width:100%; text-align:right">';
                    $no = 1;
                    foreach ($cekPegpphp as $panitia) {
                        $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                        $a .= '<tr>
                                    <td style="text-align: left">' . $no++ . '. </td>
                                    <td style="text-align: left">Nama </td>
                                    <td style="text-align: left"> : ' . $cekPegawai->namaLengkap . '</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left"></td>
                                    <td style="text-align: left">Tanda Tangan </td>
                                    <td style="text-align: left"> : ............................................ </td>
                                </tr>';
                    }
                    $a .= '</table>';
                    echo $a;
                    ?>
                </td>
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
        $modPertanyaan = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpphp_id' => $model->bapemeriksaanadmpphp_id));

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
            <td width="40%">
            </td>
            <td width="60%">Surabaya, <?php echo date('d ', strtotime($model->bapemeriksaanadmpphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpphp_tanggal))) . date(' Y', strtotime($model->bapemeriksaanadmpphp_tanggal)); ?></td>
        </tr>
        <tr>
            <td width="40%">
            </td>
            <td width="60%">&nbsp;</td>
        </tr>
        <tr>
            <td width="40%">
            </td>
            <td width="60%">
                <?php
                $cekPegpphp = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $model->bapemeriksaanadmpphp_id));
                $a = '<table border="0" style="width:100%; text-align:right">';
                $no = 1;
                foreach ($cekPegpphp as $panitia) {
                    $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                    $a .= '<tr>
                                    <td style="text-align: left">' . $no++ . '. </td>
                                    <td style="text-align: left">Nama </td>
                                    <td style="text-align: left"> : ' . $cekPegawai->namaLengkap . '</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left"></td>
                                    <td style="text-align: left">Tanda Tangan </td>
                                    <td style="text-align: left"> : ............................................ </td>
                                </tr>';
                }
                $a .= '</table>';
                echo $a;
                ?>
            </td>
        </tr>
    </table>
</div>
<p>&nbsp;</p>
