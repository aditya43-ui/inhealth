<?php
// format date for periode
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
?>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel Persediaan Obat - <?php echo $awal ?> sd <?php echo $akhir ?>
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL")
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
        } else {
            $data = $dataTable;
            $template = "{summary}\n{items}\n{pager}";
        }
        // format date for value
        if ($model->jns_periode == "bulan") {
            $value = "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))";
        } elseif ($model->jns_periode == "tahun") {
            $value = "date('Y',(strtotime(" . "$" . "data->periode)))";
        } else {
            $value = "MyFormatter::formatDateTimeForUser(date('Y-m-d',(strtotime(" . "$" . "data->periode))))";
        }
        ?>
        <?php
        $this->widget($table, array(
            'id' => 'table-grid',
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Periode',
                    'type' => 'raw',
                    'value' => $value,
                    'footer' => 'Total',
                ),
                array(
                    'header' => 'Obat',
                    'name' => 'jumlah_obat',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_obat)',
                    'footer' => 'sum(jumlah_obat)',
                ),
                array(
                    'header' => 'Alkes',
                    'name' => 'jumlah_alkes',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_alkes)',
                    'footer' => 'sum(jumlah_alkes)',
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>