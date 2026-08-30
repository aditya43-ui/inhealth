<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchTablePendapatanTransaksi();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
    $data = $model->searchTablePendapatanTransaksi(false);  
    $template = "{items}";
    if ($caraPrint == "EXCEL") {
        echo $caraPrint;
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}
?>
<?php 
$this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'mergeHeaders'=>array(  
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Penjualan</p>',
            'start'=>2,
            'end'=>7,
        ),
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Retur Penjualan</p>',
            'start'=>8,
            'end'=>12,
        ),
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Total</p>',
            'start'=>13,
            'end'=>17,
        ),        

    ),

	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1'
            ),
            array(
                'header'=>'No. Resep',
                'type'=>'raw',
                'value'=>'$data->noresep',
            ),
            array(
                'header'=>'Tanggal Penjualan',
                'type'=>'raw',
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpenjualan))',
            ),
            array(
                'header'=>'Jenis Penjualan',
                'type'=>'raw',
                'value'=>'$data->jenispenjualan',
                'footerHtmlOptions'=>array('colspan'=>4,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'Total (Rp)',
            ),
            array(
                'header'=>'Bruto',
                // 'name'=>'hargajual_oa',
                'value'=>'number_format($data->hargajual_oa)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaJual('hargajual_oa',true))
            ),
            array(
                'header'=> 'Keringanan',
                // 'name'=>'discount',
                'value'=>'number_format($data->discount)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaJual('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->ppn_persen)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'%'
            ),
            array(
                'header'=>'Netto',
                // 'name'=>'harganetto_oa',
                'value'=>'number_format($data->harganetto_oa)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaJual('harganetto_oa',true))
            ),
           //  // array(
           //  //     'header'=>'Total',
           //  //     'name'=>'hargajual_oa',
           //  //     'value'=>'number_format($data->hargajual_oa)',
           //  //     'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
           //  //     'htmlOptions'=>array('style'=>'text-align:right;'),
           //  //     'footerHtmlOptions'=>array('style'=>'text-align:right;'),
           //  //     'footer'=>'sum(hargajual_oa)'
           //  // ),
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->getTrRetur("hargajual_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->gettRRetur('hargajual_oa',true))
            ),
            array(
                'header'=> 'Keringanan',
                'value'=>'number_format($data->gettRRetur("discount"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->gettRRetur('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->gettRRetur("ppn_persen"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->gettRRetur("harganetto_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->gettRRetur('harganetto_oa',true))
            ),
           //Total
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->gettRTotal("hargajual_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->gettRTotal('hargajual_oa',true))
            ),
            array(
                'header'=> 'Keringanan',
                'value'=>'number_format($data->gettRTotal("discount"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->gettRTotal('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->gettRTotal("ppn_persen"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->gettRTotal("harganetto_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->gettRTotal('harganetto_oa',true))
            ),
            array(
                'header'=>'HPP',
                'value'=>'number_format($data->getTrTotal("hpp"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTrTotal('hpp',true))
            ),

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>

