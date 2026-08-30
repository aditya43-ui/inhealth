<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}

if($model->tglpesanmenu == date('Y-m-d')) {
    $jumlahPasien = count($model->getJumlahPasienPesanToday());
} else {
    $jumlahPasien = count($model->getJumlahPasienPesan());
}
?>

<div class="header">
    <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNoImage', [
        'judulLaporan' => $judulLaporan
    ]); ?>
</div>
<div class="bio">
    <table>
        <tr>
            <td>TANGGAL</td>
            <td>:</td>
            <td><?= $model->tglpesanmenu ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?= $model->ruangan_nama ?? '' ?> - <?= $model->kelaspelayanan_nama ?? '' ?></td>
        </tr>
        <tr>
            <td>Jumlah Pasien</td>
            <td>:</td>
            <td><?= $jumlahPasien ?></td>
        </tr>
    </table>
</div>
<div class="content">
    <?php $this->renderPartial('suratPemberianMakanan/_tablePrint', ['model' => $model, 'caraPrint' => $caraPrint]) ?>
</div>


