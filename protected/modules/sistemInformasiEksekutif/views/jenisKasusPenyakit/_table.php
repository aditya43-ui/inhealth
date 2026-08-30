<?php
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
?>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel Jenis Kasus Penyakit Pasien - <?php echo $awal ?> s.d. <?php echo $akhir ?>
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
            $sort = false;
            $template = "{summary}\n{items}\n{pager}";
        }
        ?>
        <?php
        $this->widget($table, array(
            'id' => 'table-grid',
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Jenis Kasus Penyakit',
                    'name' => 'jenis',
                    'type' => 'raw',
                    'value' => 'CHtml::Link($data->jenis,"#",
                                array("onClick" => "setDataKasus($data->id);"))',
                    'footer' => 'Total',
                ),
                array(
                    'header' => 'Periode ' . $awal . ' s.d. ' . $akhir,
                    'name' => 'jumlah',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah)',
                    'footer' => 'sum(jumlah)',
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>