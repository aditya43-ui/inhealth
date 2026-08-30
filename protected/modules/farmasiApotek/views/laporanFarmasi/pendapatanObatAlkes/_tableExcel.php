<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchTablePendapatanObatAlkes();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
    $data = $model->searchTablePendapatanObatAlkes(false);  
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
    'itemsCssClass'=>'table table-striped table-condensed',
    'mergeHeaders'=>array(
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Obat Alkes</p>',
            'start'=>0,
            'end'=>4,
        ),  
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Penjualan</p>',
            'start'=>5,
            'end'=>9,
        ),  
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Retur Penjualan</p>',
            'start'=>10,
            'end'=>14,
        ),  
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
            'start'=>15,
            'end'=>20,
        ),  
    ),
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1',
                'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'Total (Rp)',
            ),
//            array(
//                'header'=>'Tgl. Penjualan',
//                'type'=>'raw',
//                'value'=>'$data->tglpenjualan',
//            ),
            array(
                'header'=>'Jenis Obat Alkes',
                'type'=>'raw',
                'value'=>'$data->jenisobatalkes_nama',
            ),
            array(
                'header'=>'Kode Obat',
                'type'=>'raw',
                'value'=>'$data->obatalkes_kode',
            ),
            array(
                'header'=>'Nama Obat',
                'type'=>'raw',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'header'=>'Golongan',
                'type'=>'raw',
                'value'=>'empty($data->obatalkes_golongan) ? "<p style=\"margin: 0; text-align: center;\">-</p>":$data->obatalkes_golongan',
            ),
            //Penjualan
            array(
                'header'=>'Total (Jumlah)',
                // 'name'=>'qty_oa',
                'value'=>'number_format($data->qty_oa)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
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
                'header '=> 'Keringanan',
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
                'footer'=>'-'
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
            //Retur
            array(
                'header'=>'Total (Jumlah)',
                'value'=>'number_format($data->getOaRetur("qty_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->getOaRetur("hargajual_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaRetur('hargajual_oa',true))
            ),
            array(
                'header '=> 'Keringanan',
                'value'=>'number_format($data->getOaRetur("discount"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaRetur('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->getOaRetur("ppn_persen"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->getOaRetur("harganetto_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaRetur('harganetto_oa',true))
            ),
            //Total
            array(
                'header'=>'Total (Jumlah)',
                'value'=>'number_format($data->getOaTotal("qty_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->getOaTotal("hargajual_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaTotal('hargajual_oa',true))
            ),
            array(
                'header '=> 'Keringanan',
                'value'=>'number_format($data->getOaTotal("discount"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaTotal('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->getOaTotal("ppn_persen"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->getOaTotal("harganetto_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaTotal('harganetto_oa',true))
            ),
            array(
                'header'=>'HPP',
                'value'=>'number_format($data->hpp)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaJual('hpp',true))
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>