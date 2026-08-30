<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchLaporanPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchLaporan();
    $template = "{pager}{summary}\n{items}";
}
?>
<div id="div_rekap">
    <legend class="rim"> Tabel Faktur Pembelian - Rekap</legend>
    <?php $this->widget($table, array(
        'id' => 'rekapLaporanFakturPembelian',
        'dataProvider' => $data,
        'template' => $template,
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'mergeColumns' => array('supplier_id'),
        'extraRowColumns' => array('supplier_id'),
        'columns' => array(
            array(
                'header' => 'Nama Supplier',
                'name' => 'supplier_id',
                'value' => '$data->supplier->supplier_nama',
                'footer' => 'Total',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'No Faktur',
                'name' => 'nofaktur',
                'type' => 'raw',
                'value' => '$data->nofaktur',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tgl. Faktur',
                'name' => 'tglfaktur',
                'type' => 'raw',
                'value' => '$data->tglfaktur',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tgl. Jatuh Tempo',
                'name' => 'tgljatuhtempo',
                'type' => 'raw',
                'value' => '$data->tgljatuhtempo',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'footerHtmlOptions' => array(
                    'colspan' => 3,
                    'style' => 'text-align:right;font-style:italic;'
                ),
                'footer' => 'Total',
            ),
            array(
                'header' => 'Bruto',
                'name' => 'total_bruto',
                'value' => 'MyFunction::formatNumber($data->total_bruto)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_bruto)',
            ),
            array(
                'header ' => 'Keringanan',
                'name' => 'total_discount',
                'value' => 'MyFunction::formatNumber($data->total_discount)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_discount)',
            ),
            array(
                'header' => 'PPN (Rp)',
                'name' => 'total_ppn',
                'value' => 'MyFunction::formatNumber($data->total_ppn)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_ppn)',
            ),
            array(
                'header' => 'Meterai (Rp)',
                'name' => 'materai',
                'value' => 'MyFunction::formatNumber($data->materai)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(materai)',
            ),
            array(
                'header' => 'Netto',
                'name' => 'total_netto',
                'value' => 'MyFunction::formatNumber($data->total_netto)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_netto)',
            ),
            array(
                'header' => 'Total Tagihan',
                'name' => 'total_tagihan',
                'value' => 'MyFunction::formatNumber($data->total_tagihan)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_tagihan)',
            ),
            array(
                'header' => 'Bayar',
                'name' => 'total_bayar',
                'type' => 'raw',
                'value' => 'MyFunction::formatNumber($data->total_bayar)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_bayar)',
            ),
            array(
                'header' => 'Sisa',
                'name' => 'total_sisa',
                'value' => 'MyFunction::formatNumber($data->total_sisa)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_sisa)',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
</div>
<div id="div_detail">
    <legend class="rim"> Tabel Faktur Pembelian - Detail</legend>
    <?php $this->widget($table, array(
        'id' => 'rincianLaporanFakturPembelian',
        'dataProvider' => $data,
        'template' => $template,
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'mergeColumns' => array('supplier_id'),
        'extraRowColumns' => array('supplier_id'),
        'columns' => array(
            array(
                'header' => 'Nama Supplier',
                'name' => 'supplier_id',
                'value' => '$data->supplier->supplier_nama',
                'footer' => 'Total',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'No Faktur',
                'name' => 'nofaktur',
                'type' => 'raw',
                'value' => '$data->nofaktur',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tgl. Faktur',
                'name' => 'tglfaktur',
                'type' => 'raw',
                'value' => '$data->tglfaktur',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tgl. Jatuh Tempo',
                'name' => 'tgljatuhtempo',
                'type' => 'raw',
                'value' => '$data->tgljatuhtempo',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'footerHtmlOptions' => array(
                    'colspan' => 3,
                    'style' => 'text-align:right;font-style:italic;'
                ),
                'footer' => 'Total',
            ),
            array(
                'header' => 'Bruto',
                'name' => 'total_bruto',
                'value' => 'MyFunction::formatNumber($data->total_bruto)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_bruto)',
            ),
            array(
                'header ' => 'Keringanan',
                'name' => 'total_discount',
                'value' => 'MyFunction::formatNumber($data->total_discount)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_discount)',
            ),
            array(
                'header' => 'PPN (Rp)',
                'name' => 'total_ppn',
                'value' => 'MyFunction::formatNumber($data->total_ppn)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_ppn)',
            ),
            array(
                'header' => 'Meterai',
                'name' => 'materai',
                'value' => 'MyFunction::formatNumber($data->materai)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(materai)',
            ),
            array(
                'header' => 'Netto',
                'name' => 'total_netto',
                'value' => 'MyFunction::formatNumber($data->total_netto)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_netto)',
            ),
            array(
                'header' => 'Total Tagihan',
                'name' => 'total_tagihan',
                'value' => 'MyFunction::formatNumber($data->total_tagihan)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_tagihan)',
            ),
            array(
                'header' => 'Bayar',
                'name' => 'total_bayar',
                'type' => 'raw',
                'value' => 'MyFunction::formatNumber($data->total_bayar)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_bayar)',
            ),
            array(
                'header' => 'Sisa',
                'name' => 'total_sisa',
                'value' => 'MyFunction::formatNumber($data->total_sisa)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_sisa)',
            ),
            array(
                'header' => 'Print Detail',
                'name' => 'fakturpembelian_id',
                'type' => 'raw',
                'value' => 'CHtml::link("<i class=\"entypo-print\"></i>", "javascript:printDetail(\'$data->fakturpembelian_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mencetak Detail Laporan Faktur Pembelian"))',
                'footer' => 'Total',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right;color:white;',
                    'class' => 'currency'
                ),
                'footer' => '-',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
</div>
<?php

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintDetailFakturPembelian');
$js = <<< JSCRIPT

function printDetail(idFaktur)
   {    
               window.open("${url}/"+$('#search-laporan').serialize()+"&idFaktur="+idFaktur,"",'location=_new, width=900px, scrollbars=yes');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('jsprintdetailfakturpembelian', $js, CClientScript::POS_HEAD);
?>