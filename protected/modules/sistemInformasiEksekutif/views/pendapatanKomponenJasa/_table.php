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
            <i class="entypo-credit-card"></i> Tabel Pendapatan Rumah Sakit Berdasarkan Jasa
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
                            Akun Pendapatan
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
                            Pendapatan Jasa Medis
                        </td>
                        <?php
                        foreach ($dataTable as $key => $value) {
                        ?><td>
                                <?php
                                echo number_format($value->jumlah_medis, 0, "", ".");
                                ?>
                            </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td>
                            Pendapatan Jasa Paramedis
                        </td>
                        <?php
                        foreach ($dataTable as $key => $value) {
                        ?><td>
                                <?php
                                echo number_format($value->jumlah_paramedis, 0, "", ".");
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
                                echo "<b>" . number_format($value->jumlah_medis + $value->jumlah_paramedis, 0, "", ".") . "</b>";
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