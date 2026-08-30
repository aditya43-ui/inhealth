<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
$table = "table table-bordered table-striped table-condensed";
$format = new MyFormatter();
if (isset($caraPrint)) {
    $layout = '';
    $table = 'table table-bordered table-striped';
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
            <i class="entypo-credit-card"></i> Tabel Pendapatan Terhadap Beban
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="table-grid" class="grid-view" style="<?php echo $layout; ?>">
            <table class="<?php echo $table; ?>">
                <thead>
                    <tr>
                        <th id="tableLaporan_c0">
                            Periode
                        </th>
                        <th id="tableLaporan_c0">
                            Pendapatan
                        </th>
                        <th id="tableLaporan_c0">
                            Beban
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_pendapatan = 0;
                    $total_beban = 0;
                    foreach ($dataTable as $value) {
                    ?> <tr>
                            <td>
                                <?php
                                if ($model->jns_periode == "bulan") {
                                    echo $format->formatMonthForUser(date('Y-m', (strtotime($value['periode']))));
                                } else if ($model->jns_periode == "tahun") {
                                    echo date('Y', (strtotime($value['periode'])));
                                } else {
                                    echo $format->formatDateTimeForUser(date('Y-m-d', (strtotime($value['periode']))));
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo number_format($value['jumlah_pendapatan'], 0, "", ".");
                                $total_pendapatan += $value['jumlah_pendapatan'];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo number_format($value['jumlah_beban'], 0, "", ".");
                                $total_beban += $value['jumlah_beban'];
                                ?>
                            </td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td>
                            <b>Total</b>
                        </td>
                        <td>
                            <?php echo number_format($total_pendapatan); ?>
                        </td>
                        <td>
                            <?php echo number_format($total_beban); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>