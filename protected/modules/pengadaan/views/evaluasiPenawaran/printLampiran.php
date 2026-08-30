<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style> 
    @page {
        size: landscape;
        font-family: Arial, sans-serif;
        font-size: 12pt !important;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 2cm;
        margin-right: 2cm;

    }
    @media print {
        @page {
            size: landscape
        }
        html, body {
            padding-top: 30px;
            padding-left: 10px;
            width: 330mm;
            height: 210mm;
            line-height: 1.6;
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
<?php
$crit1 = new CDbCriteria();
$crit1->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit1->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Bertanggal & ditanda tangani') . "'");
$cek1 = EvaluasipenawarandetT::model()->find($crit1);

$crit2 = new CDbCriteria();
$crit2->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit2->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Masa Berlaku Penawaran') . "'");
$cek2 = EvaluasipenawarandetT::model()->find($crit2);

$crit3 = new CDbCriteria();
$crit3->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit3->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Harga (Angka & Huruf)') . "'");
$cek3 = EvaluasipenawarandetT::model()->find($crit3);

$crit4 = new CDbCriteria();
$crit4->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit4->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Penilaian Pengalaman Perusahaan') . "'");
$cek4 = EvaluasipenawarandetT::model()->find($crit4);

$crit5 = new CDbCriteria();
$crit5->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit5->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Kualifikasi Tenaga Ahli') . "'");
$cek5 = EvaluasipenawarandetT::model()->find($crit5);

$crit6 = new CDbCriteria();
$crit6->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit6->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Penilaian Pendekatan dan Metodologi') . "'");
$cek6 = EvaluasipenawarandetT::model()->find($crit6);

$crit7 = new CDbCriteria();
$crit7->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit7->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Total Harga Penawaran Tidak Melebihi HPS') . "'");
$cek7 = EvaluasipenawarandetT::model()->find($crit7);

$crit8 = new CDbCriteria();
$crit8->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit8->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Kewajaran Harga') . "'");
$cek8 = EvaluasipenawarandetT::model()->find($crit8);

$crit9 = new CDbCriteria();
$crit9->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit9->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Akta Perusahaan, NPWP, SPT Tahunan') . "'");
$cek9 = EvaluasipenawarandetT::model()->find($crit9);

$crit10 = new CDbCriteria();
$crit10->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit10->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('SIUJK, SBUJK') . "'");
$cek10 = EvaluasipenawarandetT::model()->find($crit10);

$crit11 = new CDbCriteria();
$crit11->addCondition('evaluasipenawaran_id = ' . $model->evaluasipenawaran_id);
$crit11->addCondition("LOWER(evaluasipenawaran_nama) = '" . strtolower('Pakta Integritas & Form Isian Kualifikasi') . "'");
$cek11 = EvaluasipenawarandetT::model()->find($crit11);

$modInfo = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
$modPersiapan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
?>
<table border="0" cellpadding="1" cellspacing="1" style="width:100%">
    <tbody>
        <tr>
            <td colspan="2" style="text-align:center; font-weight: bold; font-size: 12pt;">LAMPIRAN BERITA ACARA EVALUASI PENAWARAN</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">Nomor : <?php echo $model->nomor_dokumen ?><br><br></td>
        </tr>
        <tr>
            <td style="text-align:left; width:120px">Paket Pekerjaan</td>
            <td>:  <?php echo $modInfo->nama_pekerjaan ?></td>
        </tr>
        <tr>
            <td style="text-align:left; width:120px">Nilai HPS</td>
            <td>: Rp. <?php echo number_format($modPersiapan->total_hargaseluruhnya, 2, ",", ".") ?></td>
        </tr>
    </tbody>
</table>

<table border="1" style="width:100%">
    <thead>
        <tr>
            <th rowspan="3">NO</th>
            <th rowspan="3">NAMA PERUSAHAAN</th>
            <th rowspan="3">HARGA PENAWARAN</th>
            <th rowspan="3">HARGA PENAWARAN TERKOREKSI</th>
            <th colspan="3">EVALUASI ADMINISTRASI</th>
            <th colspan="3" rowspan="2">EVALUASI TEKNIS</th>
            <th colspan="2" rowspan="2">EVALUASI HARGA</th>
            <th colspan="3" rowspan="2">EVALUASI KUALIFIKASI</th>
            <th rowspan="3">Ket.</th>
        </tr>
        <tr>
            <th colspan="3">SURATPENAWARAN</th>
        </tr>
        <tr>
            <th>Bertanggal & ditanda tangani</th>
            <th>Masa berlaku penawaran</th>
            <th>Harga (angka & huruf)</th>
            <th>Penilaian Pengalaman Perusahaan</th>
            <th>Kualifikasi Tenaga Ahli</th>
            <th>Penilaian Pendekatan dan Metodologi</th>
            <th>Total Harga penawaran tidak melebihi HPS</th>
            <th>Kewajaran Harga</th>
            <th>Akta Perusahaan, NPWP, SPT Tahunan</th>
            <th>SIUJK, SBUJK</th>
            <th>Pakta Integritas & Form Isian Kualifikasi</th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>13</th>
            <th>14</th>
            <th>15</th>
            <th>16</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td><?php echo $model->supplier->supplier_nama ?></td>
            <td style="text-align: right"><?php echo number_format($model->harga_penawaran, 2, ",", ".") ?></td>
            <td style="text-align: right"><?php echo number_format($model->harga_terkoreksi, 2, ",", ".") ?></td>
            <td style="text-align: center"><?php echo !empty($cek1->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek2->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek3->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek4->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek5->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek6->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek7->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek8->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek9->ismemenuhi)  ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek10->ismemenuhi) ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td style="text-align: center"><?php echo !empty($cek11->ismemenuhi) ? '<i class="fa fa-check-square-o"></i>' : ''; ?></td>
            <td><?php echo $model->keterangan ?></td>
        </tr>
    </tbody>
</table>