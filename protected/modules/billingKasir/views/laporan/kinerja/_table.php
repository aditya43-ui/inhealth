<?php
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchKinerja();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)) {
    $row = '$row+1';
    $sort = false;
    $data = $model->searchPrintKinerja();
    $template = "{items}";
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}
?>

<div class="biru" id="div_kelas">
    <div class="white">
        <?php if (!isset($caraPrint)) { ?>
            <!--<legend class="rim"> Tabel Kinerja per Kelas</legend>-->
            <?php
            $this->widget($table, array(
                'id' => 'tableKinerjaKelas',
                'dataProvider' => $data,
                'enableSorting' => $sort,
                'template' => $template,
                'itemsCssClass' => 'table table-striped table-condensed',
                'columns' => array(
                    array(
                        'header' => 'No.',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'htmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'value' => $row,
                    ),
                    array(
                        'header' => 'Tanggal Masuk Penunjang',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => 'date("d/m/Y",strtotime($data->tgl_masukpenunjang))',
                    ),
                    array(
                        'header' => 'Kelas Pelayanan',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->kelaspelayanan_nama',
                    ),
                    array(
                        'header' => 'No. Rekam Medik',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->no_rekam_medik',
                    ),
                    array(
                        'header' => 'Nama Lengkap',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->nama_pasien',
                    ),
                    array(
                        'header' => 'Jenis Kelamin',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->jeniskelamin',
                    ),
                    array(
                        'header' => 'Daftar Tindakan',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->daftartindakan_nama',
                        'footer' => 'Total :',
                        'footerHtmlOptions' => array('style' => 'text-align:right;vertical-align:middle;', 'colspan' => 7),
                    ),
                    array(
                        'header' => 'Tarif',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'name' => 'tarif_satuan',
                        'value' => 'number_format($data->tarif_satuan)',
                        'htmlOptions' => array('style' => 'text-align:right'),
                        'footer' => 'sum(tarif_satuan)',
                        'footerHtmlOptions' => array('style' => 'text-align:right;vertical-align:middle;'),
                    ),
                    array(
                        'header' => 'Jumlah',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'name' => 'qty_tindakan',
                        'value' => '$data->qty_tindakan',
                        'htmlOptions' => array('style' => 'text-align:center'),
                        'footer' => 'sum(qty_tindakan)',
                        'footerHtmlOptions' => array('style' => 'text-align:center;vertical-align:middle;'),
                    ),
                    array(
                        'name' => 'Sub Total',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'name' => 'total',
                        'value' => 'number_format($data->total)',
                        'htmlOptions' => array('style' => 'text-align:right'),
                        'footer' => 'sum(total)',
                        'footerHtmlOptions' => array('style' => 'text-align:right;vertical-align:middle;'),
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        <?php } ?>
    </div>
</div>
<div class="biru" id="div_bangsal">
    <div class="white">
        <?php if (!isset($caraPrint)) { ?>
            <!--<legend class="rim"> Tabel Kinerja per Bangsal</legend>-->
            <?php
            $this->widget($table, array(
                'id' => 'tableKinerjaBangsal',
                'dataProvider' => $data,
                'enableSorting' => $sort,
                'template' => $template,
                'itemsCssClass' => 'table table-striped table-condensed',
                'columns' => array(
                    array(
                        'header' => 'No.',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'htmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'value' => $row,
                    ),
                    array(
                        'header' => 'Tanggal Masuk Penunjang',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => 'date("d/m/Y",strtotime($data->tgl_masukpenunjang))',
                    ),
                    array(
                        'header' => 'Ruangan',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->ruanganpenunj_nama',
                    ),
                    array(
                        'header' => 'No. Rekam Medik',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->no_rekam_medik',
                    ),
                    array(
                        'header' => 'Nama Lengkap',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->nama_pasien',
                    ),
                    array(
                        'header' => 'Jenis Kelamin',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->jeniskelamin',
                    ),
                    array(
                        'header' => 'Daftar Tindakan',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'value' => '$data->daftartindakan_nama',
                        'footer' => 'Total :',
                        'footerHtmlOptions' => array('style' => 'text-align:right;vertical-align:middle;', 'colspan' => 7),
                    ),
                    array(
                        'header' => 'Tarif',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'name' => 'tarif_satuan',
                        'value' => 'number_format($data->tarif_satuan)',
                        'htmlOptions' => array('style' => 'text-align:right'),
                        'footer' => 'sum(tarif_satuan)',
                        'footerHtmlOptions' => array('style' => 'text-align:right;vertical-align:middle;'),
                    ),
                    array(
                        'header' => 'Jumlah',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'name' => 'qty_tindakan',
                        'value' => '$data->qty_tindakan',
                        'htmlOptions' => array('style' => 'text-align:center'),
                        'footer' => 'sum(qty_tindakan)',
                        'footerHtmlOptions' => array('style' => 'text-align:center;vertical-align:middle;'),
                    ),
                    array(
                        'name' => 'Sub Total',
                        'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                        'type' => 'raw',
                        'name' => 'total',
                        'value' => 'number_format($data->total)',
                        'htmlOptions' => array('style' => 'text-align:right'),
                        'footer' => 'sum(total)',
                        'footerHtmlOptions' => array('style' => 'text-align:right;vertical-align:middle;'),
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        <?php } ?>
    </div>
</div>
<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        //            header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Content-Disposition: attachment;filename="' . 'Laporan Kinerja per Kelas' . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
?>
    <style>
        th {
            border: 1px solid;
            background-color: transparent;
        }

        .grid td {
            border: 1px solid;
            background-color: transparent;
        }

        th {
            text-align: center;
            font-size: 14px;
        }

        table {
            width: 100%;
        }
    </style>
    <?php
    $criteria = new CDbCriteria;
    $format = new MyFormatter();

    $tgl_awal = $model->tgl_awal;
    $tgl_akhir = $model->tgl_akhir;

    $criteria->select = "t.daftartindakan_nama,kelompoktindakan_nama,t.ruanganpenunj_id,no_rekam_medik,nama_pasien,tarif_satuan,sum(qty_tindakan) as qty_tindakan";
    $criteria->group = "t.daftartindakan_nama,kelompoktindakan_nama,t.ruanganpenunj_id,no_rekam_medik,nama_pasien,tarif_satuan";
    if (isset($_GET['BKLaporankinerjapenunjangV']['tgl_awal'])) {
        $tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporankinerjapenunjangV']['tgl_awal']);
    }
    if (isset($_GET['BKLaporankinerjapenunjangV']['tgl_akhir'])) {
        $tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporankinerjapenunjangV']['tgl_akhir']);
    }
    if (isset($_GET['BKLaporankinerjapenunjangV']['ruanganpenunj_id'])) {
        $ruangan = $_GET['BKLaporankinerjapenunjangV']['ruanganpenunj_id'];
    }
    if (isset($_GET['BKLaporankinerjapenunjangV']['kelaspelayanan_id'])) {
        $kelas = $_GET['BKLaporankinerjapenunjangV']['kelaspelayanan_id'];
    }
    $criteria->addBetweenCondition('t.tglmasukpenunjang', $tgl_awal, $tgl_akhir, true);
    if (isset($ruangan)) {
        if (!empty($ruangan)) {
            $criteria->addCondition('ruanganpenunj_id = ' . $ruangan);
        }
    }

    if (!empty($kelas)) {
        if (is_array($kelas)) {
            $criteria->addInCondition('kelaspelayanan_id', $kelas);
        } else {
            $criteria->addCondition('kelaspelayanan_id = ' . $kelas);
        }
    }

    $models = BKLaporankinerjapenunjangV::model()->findAll($criteria);
    $totSub = 0;
    $row = array();

    foreach ($models as $i => $val) {
        $kelompoktindakan_id = $val->kelompoktindakan_id;
        $row[$kelompoktindakan_id]['nama'] = $val->kelompoktindakan_nama;
        $row[$kelompoktindakan_id]['ruanganpenunj_id'] = $val->ruanganpenunj_id;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['daftartindakan_nama'] = $val->daftartindakan_nama;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['nama_pasien'] = $val->nama_pasien;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['no_rekam_medik'] = $val->no_rekam_medik;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['tarif'] = $val->tarif_satuan;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['qty'] = $val->qty_tindakan;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['total'] = ($row[$kelompoktindakan_id]['daftartindakan'][$i]['tarif'] * $row[$kelompoktindakan_id]['daftartindakan'][$i]['qty']);
    }
    ?>
    <?php
    $header = '';

    $header .= '<table width="100%" border = 1 class="grid ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Uraian Tindakan</th>
                            <th>Tarif</th>
                            <th>Jml</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>';
    ?>
    <?php
    $cols = '';
    $totalSub = 0;
    foreach ($row as $values) {
        $cols .= '<table width="100%" margin-right:auto;" class="grid ">';
        $cols .= '<tr>';
        $cols .= '<td colspan=7 style="font-weight:bold;text-align:center;">' . $values['nama'] . '</td>';
        $cols .= '</tr>';
        $cols .= '</table>';
        $col = '';
        $total = 0;
    ?>
    <?php
        $i = 0;
        foreach ($values['daftartindakan'] as $key => $val) {
            $col .= '<tr>';
            $col .= '<td colspan=7 style="font-weight:bold"> Uraian Tindakan : ' . $val['daftartindakan_nama'] . '</td>';
            $col .= '</tr>';
            $col .= '<tr>';
            $col .= '<td>' . ($i + 1) . '</td>';
            $col .= '<td>' . $val['no_rekam_medik'] . '</td>';
            $col .= '<td>' . $val['nama_pasien'] . '</td>';
            $col .= '<td>' . $val['daftartindakan_nama'] . '</td>';
            $col .= '<td style="text-align:center;">' . $val['tarif'] . '</td>';
            $col .= '<td style="text-align:center;">' . $val['qty'] . '</td>';
            $col .= '<td style="text-align:right;">' . $val['total'] . '</td>';
            $col .= '</tr>';
            $total = $val['total'];
            $col .= '<tr>';
            $col .= '<td colspan=6 style="text-align:right;">Jumlah Tindakan Pemakaian ' . $val['daftartindakan_nama'] . ' </td>';
            $col .= '<td style="text-align:right;">' . $total . '</td>';
            $col .= '</tr>';
            $i++;
        }

        $col .= '</table>';
    }
    echo ($cols);
    echo ($header);
    echo ($col);
    ?>

    </table>
<?php } ?>