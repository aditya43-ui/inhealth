<?php
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcelNew', array('judulLaporan' => $judulLaporan, 'colspan' => 12));
?>

<?= "<div class='header-space'>&nbsp;</div>" ?>
<?php
    $table      = 'table table-striped';

    if ($model->jns_periode == "bulan") {
        $awal   = $model->bln_awal;
        $akhir  = $model->bln_akhir;
    } elseif ($model->jns_periode == "tahun") {
        $awal   = $model->thn_awal;
        $akhir  = $model->thn_akhir;
    } else {
        $awal   = $model->tgl_awal;
        $akhir  = $model->tgl_akhir;
    }
?>
    <table class="<?php echo $table; ?>">
        <thead>
            <tr>
                <th>Cara Pasien Pulang</th>
                <?php if(!empty($dataTable['bar']['labels'])) : foreach ($dataTable['bar']['labels'] As $i => $ii): ?>
                <th><?= $ii ?></th>
                <?php endforeach; endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($dataTable['bar']['datasets'])) : foreach ($dataTable['bar']['datasets'] As $j => $jj): ?>
            <tr>
                <td>
                    <?= $jj['label'] ?>
                </td>
                <?php foreach ($jj['data'] As $k=>$kk): ?>
                <td>
                    <?= $kk ?>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
<?= "<div class='footer-space'>&nbsp;</div>" ?>