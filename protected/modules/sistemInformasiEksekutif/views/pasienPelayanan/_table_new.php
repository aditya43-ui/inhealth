<?php
$table      = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort       = true;
$caraPrint  = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
$table      = "table table-striped table-bordered table-condensed";
$format     = new MyFormatter();
if (isset($caraPrint)) {
    $layout     = '';
    $table      = 'table table-striped';
    $template   = "{summary}\n{items}\n{pager}";
    $sort       = false;
    if ($caraPrint == "EXCEL")
        $table  = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $layout     = 'max-width: 1250px;';
    $template   = "{summary}\n{items}\n{pager}";
}
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
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel Pelayanan Pasien - <?php echo $awal ?> sd <?php echo $akhir ?>
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body" style="">
        <div id="table-grid" class="grid-view" style="<?php echo $layout; ?>">
            <table class="<?php echo $table; ?>">
                <thead>
                    <tr>
                        <th>Nama Pelayanan</th>
                        <?php if (!empty($lineChart['bar']['labels'])) : foreach ($lineChart['bar']['labels'] as $i => $ii) : ?>
                                <th><?= $ii ?></th>
                        <?php endforeach;
                        endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lineChart['bar']['datasets'])) : foreach ($lineChart['bar']['datasets'] as $j => $jj) : ?>
                            <tr>
                                <td>
                                    <?= $jj['label'] ?>
                                </td>
                                <?php foreach ($jj['data'] as $k => $kk) : ?>
                                    <td>
                                        <?= $kk ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>