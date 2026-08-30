<?php

/**
 * menampilkan daftar data
 *
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$itemCssClass = 'table table-striped table-condensed';
$sort = true;
$visible =  true;
if (isset($caraPrint)) {
    $data = $model->searchLaporanPrint();
    $template = "{items}";
    $sort = false;
    $visible = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == "PDF") {
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    }

    echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchLaporan();
    $template = "{summary}\n{items}\n{pager}";
}

?>

<div id="div_rekap" <?php echo ($model->tabPrint == 'rekap') ? '' : 'style = "display:none;" ';  ?>>
    <!--<legend class="rim"> Tabel Faktur Pembelian - Rekap</legend>-->
    <?php $this->widget($table, array(
        'id' => 'rekapLaporanFakturPembelian',
        'dataProvider' => $data,
        'template' => $template,
        'itemsCssClass' => $itemCssClass,
        'mergeColumns' => array('supplier_nama'),
        'extraRowColumns' => array('supplier_nama'),
        'columns' => array(
            array(
                'header' => 'Nama Supplier',
                'name' => 'supplier_nama',
                'value' => '$data->supplier->supplier_nama',
                'footer' => '&nbsp;',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tanggal Faktur',
                //'name'=>'tglfaktur',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tglfaktur)))',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'No. Faktur',
                //'name'=>'nofaktur',
                'type' => 'raw',
                'value' => '$data->nofaktur',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),

            array(
                'header' => 'Tanggal Jatuh Tempo',
                //'name'=>'tgljatuhtempo',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tgljatuhtempo)))',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'footerHtmlOptions' => array(
                    'colspan' => 3,
                    'style' => 'text-align:right;font-style:italic;'
                ),
                'footer' => 'Total',
            ),
            array(
                'header' => 'Bruto (Rp)',
                'name' => 'total_bruto',
                'value' => 'number_format($data->total_bruto,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_bruto)',
            ),
            array(
                'header' => 'Keringanan (Rp)',
                'name' => 'total_discount',
                'value' => 'str_replace(".",",",$data->total_discount)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_discount)',
            ),
            array(
                'header' => 'PPN (Rp)',
                'name' => 'total_ppn',
                'value' => 'number_format($data->total_ppn,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_ppn)',
            ),
            array(
                'header' => 'Meterai (Rp)',
                'name' => 'materai',
                'value' => 'number_format($data->materai,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(materai)',
            ),
            array(
                'header' => 'Netto (Rp)',
                'name' => 'total_netto',
                'value' => 'number_format($data->total_netto,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_netto)',
            ),
            array(
                'header' => 'Total Tagihan (Rp)',
                'name' => 'total_tagihan',
                'value' => 'number_format($data->total_tagihan,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_tagihan)',
            ),
            array(
                'header' => 'Bayar (Rp)',
                'name' => 'total_bayar',
                'type' => 'raw',
                'value' => 'number_format($data->total_bayar,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_bayar)',
            ),
            array(
                'header' => 'Sisa (Rp)',
                'name' => 'total_sisa',
                'value' => 'number_format($data->total_sisa,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
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
<div id="div_detail" <?php echo ($model->tabPrint == 'detail') ? '' : 'style = "display:none;" ';  ?>>
    <!--<legend class="rim"> Tabel Faktur Pembelian - Detail</legend>-->
    <?php $this->widget($table, array(
        'id' => 'rincianLaporanFakturPembelian',
        'dataProvider' => $data,
        'template' => $template,
        'itemsCssClass' => $itemCssClass,
        'mergeColumns' => array('supplier_nama'),
        'extraRowColumns' => array('supplier_nama'),
        'columns' => array(
            array(
                'header' => 'Nama Supplier',
                'name' => 'supplier_nama',
                'value' => '$data->supplier->supplier_nama',
                'footer' => '&nbsp;',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tanggal Faktur',
                // 'name'=>'tglfaktur',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tglfaktur)))',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'No. Faktur',
                //'name'=>'nofaktur',
                'type' => 'raw',
                'value' => '$data->nofaktur',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tanggal Jatuh Tempo',
                // 'name'=>'tgljatuhtempo',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tgljatuhtempo)))',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'footerHtmlOptions' => array(
                    'colspan' => 3,
                    'style' => 'text-align:right;font-style:italic;'
                ),
                'footer' => 'Total',
            ),
            array(
                'header' => 'Bruto (Rp)',
                'name' => 'total_bruto',
                'value' => 'number_format($data->total_bruto,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_bruto)',
            ),
            array(
                'header' => 'Keringanan (Rp)',
                'name' => 'total_discount',
                'value' => 'str_replace(".",",",$data->total_discount)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_discount)',
            ),
            array(
                'header' => 'PPN (Rp)',
                'name' => 'total_ppn',
                'value' => 'number_format($data->total_ppn,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_ppn)',
            ),
            array(
                'header' => 'PPh (Rp)',
                'name' => 'total_pph',
                'value' => 'number_format($data->total_pph,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_pph)',
            ),
            array(
                'header' => 'Meterai (Rp)',
                'name' => 'materai',
                'value' => 'number_format($data->materai,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(materai)',
            ),
            array(
                'header' => 'Netto (Rp)',
                'name' => 'total_netto',
                'value' => 'number_format($data->total_netto,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_netto)',
            ),
            array(
                'header' => 'Total Tagihan (Rp)',
                'name' => 'total_tagihan',
                'value' => 'number_format($data->total_tagihan,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_tagihan)',
            ),
            array(
                'header' => 'Bayar (Rp)',
                'name' => 'total_bayar',
                'type' => 'raw',
                'value' => 'number_format($data->total_bayar,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'footerHtmlOptions' => array(
                    'style' => 'text-align:right',
                    'class' => 'currency'
                ),
                'footer' => 'sum(total_bayar)',
            ),
            array(
                'header' => 'Sisa (Rp)',
                'name' => 'total_sisa',
                'value' => 'number_format($data->total_sisa,0,"",".")',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
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
                'visible' => $visible
            )
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