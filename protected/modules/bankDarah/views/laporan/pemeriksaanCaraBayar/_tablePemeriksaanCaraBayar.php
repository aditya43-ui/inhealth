<?php

$data = $model->searchLaporanCarabayar();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrintLaporanCarabayar();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}

$this->widget(
    'ext.bootstrap.widgets.HeaderGroupGridViewNonRp',
    array(
        'id' => 'tableGroupPemeriksaanCaraBayar',
        'dataProvider' => $data,
        'template' => $template,
        'enableSorting' => $sort,
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'No.',
                'type' => 'raw',
                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                'htmlOptions' => array(
                    'style' => 'text-align:center'
                ),
                'footerHtmlOptions' => array(
                    'colspan' => 6,
                    'style' => 'text-align:right;font-style:italic;'
                ),
                'footer' => 'Total',
            ),
            array(
                'header' => 'No. Pendaftaran',
                'type' => 'raw',
                'name' => 'no_pendaftaran',
            ),
            array(
                'header' => 'Nama Pasien',
                'type' => 'raw',
                'name' => 'nama_pasien',
            ),
            array(
                'header' => 'Alamat Pasien',
                'type' => 'raw',
                'name' => 'alamat_pasien',
            ),
            array(
                'header' => 'Jenis Penjamin',
                'type' => 'raw',
                'name' => 'carabayar_nama',
            ),
            array(
                'header' => 'Penjamin',
                'type' => 'raw',
                'name' => 'penjamin_nama',
            ),
            array(
                'header' => 'Total Biaya',
                'type' => 'raw',
                'name' => 'total_biaya',
                'value' => 'number_format($data->total_biaya,0,",",".")',
                'htmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_biaya)',
            ),
            array(
                'header' => 'Bayar',
                'type' => 'raw',
                'name' => 'bayartindakan',
                'value' => 'number_format($data->bayartindakan,0,",",".")',
                'htmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(bayartindakan)',
            ),
            array(
                'header' => 'Sisa',
                'type' => 'raw',
                'name' => 'sisatindakan',
                'value' => 'number_format($data->sisatindakan)',
                'htmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(sisatindakan)',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
}',
    )
);
