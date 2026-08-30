<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
$table = "table table-striped table-bordered table-condensed";
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
    $template = "{summary}\n{items}\n{pager}";
}

// format date for value

if ($model->jns_periode == "bulan") {
    $awal = $model->bln_awal;
    $akhir = $model->bln_akhir;
} elseif ($model->jns_periode == "tahun") {
    $awal = $model->thn_awal;
    $akhir = $model->thn_akhir;
} else {
    $awal = $model->tgl_awal;
    $akhir = $model->tgl_akhir;
}

$temp_header = array();
foreach ($dataTableKlp as $key => $value) {
    foreach ($value as $data) {
        array_push($temp_header, $data['periode']);
    }
}
$header = (array_unique($temp_header));

$temp_row = array();
foreach ($dataTableKlp as $key => $value) {
    foreach ($value as $data) {
        array_push($temp_row, $data['jenis']);
    }
}
$rows = (array_unique($temp_row));

$temp_total = array();
foreach ($dataTableKlp as $key => $value) {
    foreach ($value as $data) {
        $id = $data['periode'];
        if (isset($temp_total[$id])) {
            $temp_total[$id][] = $data['jumlah'];
        } else {
            $temp_total[$id] = array($data['jumlah']);
        }
    }
}

$total_row = array();
foreach ($temp_total as $key => $value) {
    $total = 0;
    foreach ($value as $data) {
        $total += $data;
    }
    array_push($total_row, $total);
}
?>
<div class="white-container">
    <div id="table-grid" class="grid-view" style="<?php echo $layout; ?>">
        <table class="<?php echo $table; ?>">
            <thead>
                <tr>
                    <th id="tableLaporan_c0">
                        Kelompok Pegawai
                    </th>
                    <?php
                    $jml_kolom = 0;
                    foreach ($header as $value) {
                        ?><th id = "tableLaporan_c0">
                            <?php
                            if ($model->jns_periode == "bulan") {
                                echo $format->formatMonthForUser(date('Y-m', (strtotime($value))));
                            } else if ($model->jns_periode == "tahun") {
                                echo date('Y', (strtotime($value)));
                            } else {
                                echo $format->formatDateTimeForUser(date('Y-m-d', (strtotime($value))));
                            }
                            ?>
                        </th>

                        <?php
                        $periode[$jml_kolom] = $value;
                        $jml_kolom ++;
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $row; ?>
                        </td>
                        <?php
                        for ($x = 0; $x < $jml_kolom; $x++) {
                            $jml[$x] = 0;
                            foreach ($dataTableKlp AS $keys => $values) {
                                foreach ($values as $datas) {
                                    if ($datas['jenis'] == $row && $datas['periode'] == $periode[$x]) {
                                        $jml[$x] = $datas['jumlah'];
                                    }
                                }
                            }
                            ?>
                            <td>
                                <?php
                                echo $jml[$x];
                                ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td>
                        <b>Total</b>
                    </td>
                    <?php
                    foreach ($total_row as $value) {
                        ?><td>
                            <?php
                            echo "<b>" . number_format($value, 0) . "</b>";
                            ?>
                        </td>
                    <?php }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

