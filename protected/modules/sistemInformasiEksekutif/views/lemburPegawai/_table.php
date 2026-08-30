<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel Lembur Pegawai Dari <b>
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
                    'header' => 'Rencana Lembur',
                    'name' => 'jumlah_rencana',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_rencana)',
                    'footer' => 'sum(jumlah_rencana)',
                ),
                array(
                    'header' => 'Realisasi Lembur',
                    'name' => 'jumlah_real',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_real)',
                    'footer' => 'sum(jumlah_real)',
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>