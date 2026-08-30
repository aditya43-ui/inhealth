<style>
    .tabel {
        border: 1px solid #000;
    }

    thead th {
        background: #fff;
        border-bottom: 1px solid #000;
        color: #000;
    }

    body {
        font-size: 8pt;
    }

    td.uang {
        text-align: right;
    }

    th {
        text-align: center;
    }

    .border {
        border: 1px solid;
    }

    .tabel th+th,
    .tabel td+td {
        border-left: 1px solid #000;

    }
</style>
<?php
if (isset($caraprint)) {
    if ($caraprint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul_print . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    if ($caraprint != "EXCEL") {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
    } else {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judul_print, 'colspan' => 7));
    }
}
?>

<?php
if (empty($caraprint)) {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
}
?>
<div align="center" width="100%">
    <b><?php echo $judul_print ?></b>
</div>
<table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>No. Terima Mutasi</td>
        <td>:</td>
        <td><?php echo $model->noterimamutasi; ?></td>
    </tr>
    <tr>
        <td>Tanggal Terima Mutasi</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->tglterima); ?></td>
    </tr>
    <tr>
        <td>Ruangan Asal</td>
        <td>:</td>
        <td><?php echo (isset($model->ruanganasal->ruangan_nama) ? $model->ruanganasal->ruangan_nama : "-"); ?></td>
    </tr>
    <tr>
        <td>Ruangan Penerima</td>
        <td>:</td>
        <td><?php echo (isset($model->ruanganpenerima->ruangan_nama) ? $model->ruanganpenerima->ruangan_nama : ""); ?></td>
    </tr>
    <tr>
        <td>Pegawai Mengetahui</td>
        <td>:</td>
        <td><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='tabel'>
    <thead class="border">
        <tr>
            <th>No.</th>
            <th>Asal Barang</th>
            <th>Kategori / Nama Obat</th>
            <th>Tanggal Kedaluwarsa </th>
            <!--<th>Satuan Kecil </th>-->
            <th>Jumlah Mutasi</th>
            <th>Jumlah Terima</th>
            <th>HPP</th>
            <!--<th>Harga Jual</th>-->
            <th>Sub Total Netto</th>
        </tr>
    </thead>
    <?php
    $total = 0;
    $subtotal = 0;
    foreach ($modDetails as $i => $detail) {
    ?>
        <tr>
            <td><?php echo ($i + 1) . "."; ?></td>
            <td><?php echo $detail->sumberdana->sumberdana_nama; ?></td>
            <td><?php echo (!empty($detail->obatalkes->obatalkes_kategori) ? $detail->obatalkes->obatalkes_kategori . "/ " : "") . $detail->obatalkes->obatalkes_nama; ?></td>
            <td><?php echo $format->formatDateTimeForUser($detail->tglkadaluarsa); ?></td>
            <!--<td><?php //echo $detail->satuankecil->satuankecil_nama; 
                    ?></td>-->
            <td><?php echo $detail->jmlmutasi . ' ' . $detail->satuankecil->satuankecil_nama; ?></td>
            <td><?php echo $detail->jmlterima . ' ' . $detail->satuankecil->satuankecil_nama; ?></td>
            <td class='uang'><?php echo "Rp" . number_format($detail->harganettoterima, 0, '', '.'); ?></td>
            <!--<td><?php // echo $format->formatUang($detail->hargajualterima); 
                    ?></td>-->
            <td class="uang"><?php
                                $subtotal = ($detail->harganettoterima * $detail->jmlterima);
                                $total += $subtotal;
                                echo "Rp" . number_format($subtotal, 0, '', '.'); ?>
            </td>
        </tr>
    <?php } ?>
    <tr class='border'>
        <td colspan="7" style="text-align:right"><b>Total (Rp)</b></td>
        <td class="uang"><?php echo number_format($total, 0, '', '.'); ?></td>
    </tr>
</table>
<?php
if (isset($_GET['frame'])) {
    echo "<br>";
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
    echo "&nbsp";
    echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('EXCEL')"));
?>
    <script type='text/javascript'>
        /**
         * print
         */
        function print(caraprint) {
            var terimamutasi_id = '<?php echo $model->terimamutasi_id; ?>';
            window.open('<?php echo $this->createUrl('printTerimaMutasi'); ?>&terimamutasi_id=' + terimamutasi_id + '&caraprint=' + caraprint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }
    </script>
<?php
} else { ?>
    <table width="100%" style="margin-top:20px;">
        <tr>
            <td width="100%" align="left" align="top">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="35%" align="center">
                            <div>Pegawai Mengetahui</div>
                            <div style="margin-top:60px;"><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></div>
                        </td>
                        <td width="35%" align="center">
                            <div><?php echo Yii::app()->user->getState("kabupaten_nama") . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></div>
                            <div>Pegawai Penerima</div>
                            <div style="margin-top:60px;"><?php echo (isset($model->pegawaipenerima->NamaLengkap) ? $model->pegawaipenerima->NamaLengkap : ""); ?></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php } ?>
<div class="footer">

    <?php
    if ($caraprint != "EXCEL") {
        echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array());
    }
    ?>
</div>