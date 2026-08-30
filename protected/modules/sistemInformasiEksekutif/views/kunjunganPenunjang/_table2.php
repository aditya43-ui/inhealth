<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan Rawat Inap Berdasarkan Cara Masuk
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
        $value = "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))";
        $this->widget($table, array(
            'id' => 'table-grid',
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Periode',
                    'type' => 'raw',
                    'value' => $value,
                    'footer' => 'Total',
                ),
                array(
                    'header' => 'Lab PA',
                    'name' => 'jumlah_labpa',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_labpa)',
                    'footer' => 'sum(jumlah_labpa)',
                ),
                array(
                    'header' => 'Lab Patologi Klinik',
                    'name' => 'jumlah_laboratorium',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_laboratorium)',
                    'footer' => 'sum(jumlah_laboratorium)',
                ),
                array(
                    'header' => 'Lab Mikrobiologi Klinik',
                    'name' => 'jumlah_mikro',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_mikro)',
                    'footer' => 'sum(jumlah_mikro)',
                ),
                array(
                    'header' => 'Radiologi',
                    'name' => 'jumlah_radiologi',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_radiologi)',
                    'footer' => 'sum(jumlah_radiologi)',
                ),
                array(
                    'header' => 'Rehabilitasi Medik',
                    'name' => 'jumlah_rehabilitasi',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_rehabilitasi)',
                    'footer' => 'sum(jumlah_rehabilitasi)',
                ),
                array(
                    'header' => 'MCU',
                    'name' => 'jumlah_mcu',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_mcu)',
                    'footer' => 'sum(jumlah_mcu)',
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>