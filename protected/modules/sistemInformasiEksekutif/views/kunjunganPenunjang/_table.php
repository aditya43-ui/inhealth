<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
$table = "table table-striped table-condensed";
$format = new MyFormatter();
if (isset($caraPrint)) {
    $layout = '';
    $table = 'table table-striped';
    //        $data = $modelLaporan->searchNeraca();
    $template = "{summary}\n{items}\n{pager}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $layout = 'max-width: 1250px;';
}
?>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Total Kunjungan ke Penunjang Dari<b>
                <?php
                if ($model->jns_periode == "bulan") {
                    echo !empty($model->bln_awal) ? $model->bln_awal : "";
                } elseif ($model->jns_periode == "tahun") {
                    echo !empty($model->thn_awal) ? $model->thn_awal : "";
                } else {
                    echo !empty($model->tgl_awal) ? $model->tgl_awal : "";
                }
                ?></b>
            Sampai <b><?php
                        if ($model->jns_periode == "bulan") {
                            echo !empty($model->bln_akhir) ? $model->bln_akhir : "";
                        } elseif ($model->jns_periode == "tahun") {
                            echo !empty($model->thn_akhir) ? $model->thn_akhir : "";
                        } else {
                            echo !empty($model->tgl_akhir) ? $model->tgl_akhir : "";
                        }
                        ?></b>
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
                        <th id="tableLaporan_c0">
                            Instalasi Penunjang
                        </th>
                        <?php
                        foreach ($dataTable as $key => $value) {
                        ?><th id="tableLaporan_c0">
                                <?php
                                if ($model->jns_periode == "bulan") {
                                    echo $format->formatMonthForUser(date('Y-m', (strtotime($value->periode))));
                                } else if ($model->jns_periode == "tahun") {
                                    echo date('Y', (strtotime($value->periode)));
                                } else {
                                    echo $format->formatDateTimeForUser(date('Y-m-d', (strtotime($value->periode))));
                                }
                                ?>
                            </th>
                        <?php }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Laboratorium
                        </td>
                        <?php
                        foreach ($dataTable as $key => $value) {
                        ?><td>
                                <?php
                                echo number_format($value->jumlah_lab, 0);
                                ?>
                            </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td>
                            Radiologi
                        </td>
                        <?php
                        foreach ($dataTable as $key => $value) {
                        ?><td>
                                <?php
                                echo number_format($value->jumlah_radio, 0);
                                ?>
                            </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td>
                            <b>Total</b>
                        </td>
                        <?php
                        foreach ($dataTable as $key => $value) {
                        ?><td>
                                <?php
                                echo "<b>" . number_format($value->jumlah_lab + $value->jumlah_radio, 0) . "</b>";
                                ?>
                            </td>
                        <?php }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>