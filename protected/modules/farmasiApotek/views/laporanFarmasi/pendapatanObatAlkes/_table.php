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
    'itemsCssClass'=>'table table-bordered table-striped table-bordered table-condensed',
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
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
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
                'value'=>'number_format($data->qty_oa,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'Bruto',
                // 'name'=>'hargajual_oa',
                'value'=>'number_format($data->hargajual_oa,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaJual('hargajual_oa',true),0,"",".")
            ),
            array(
                'header'=> 'Keringanan',
                // 'name'=>'discount',
                'value'=>'number_format($data->discount,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaJual('discount',true),0,"",".")
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->ppn_persen,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                // 'name'=>'harganetto_oa',
                'value'=>'number_format($data->harganetto_oa,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaJual('harganetto_oa',true),0,"",".")
            ),
            //Retur
            array(
                'header'=>'Total (Jumlah)',
                'value'=>'number_format($data->getOaRetur("qty_oa"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->getOaRetur("hargajual_oa"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaRetur('hargajual_oa',true),0,"",".")
            ),
            array(
                'header'=> 'Keringanan',
                'value'=>'number_format($data->getOaRetur("discount"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaRetur('discount',true),0,"",".")
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->getOaRetur("ppn_persen"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->getOaRetur("harganetto_oa"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaRetur('harganetto_oa',true),0,"",".")
            ),
            //Total
            array(
                'header'=>'Total (Jumlah)',
                'value'=>'number_format($data->getOaTotal("qty_oa"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->getOaTotal("hargajual_oa"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaTotal('hargajual_oa',true),0,"",".")
            ),
            array(
                'header'=> 'Keringanan',
                'value'=>'number_format($data->getOaTotal("discount"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaTotal('discount',true),0,"",".")
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->getOaTotal("ppn_persen"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->getOaTotal("harganetto_oa"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaTotal('harganetto_oa',true),0,"",".")
            ),
            array(
                'header'=>'HPP',
                'value'=>'number_format($data->hpp,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getOaJual('hpp',true),0,"",".")
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>