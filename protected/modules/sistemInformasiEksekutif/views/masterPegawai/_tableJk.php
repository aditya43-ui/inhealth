<div class="white-container">

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
        $data = $dataTableJk;
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
        'id' => 'tablejk-grid',
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
                'header' => 'Laki - laki',
                'name' => 'jumlah_lakilaki',
                'type' => 'raw',
                'value' => 'number_format($data->jumlah_lakilaki)',
                'footer' => 'sum(jumlah_lakilaki)',
            ),
            array(
                'header' => 'Perempuan',
                'name' => 'jumlah_perempuan',
                'type' => 'raw',
                'value' => 'number_format($data->jumlah_perempuan)',
                'footer' => 'sum(jumlah_perempuan)',
            )
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>
</div>