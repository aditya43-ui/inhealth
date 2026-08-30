<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchTableTotalPendapatanFarmasi();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
    $data = $model->searchTableTotalPendapatanFarmasi(false);  
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
            'name'=>'<p style="margin: 0; text-align: center;">Penjualan</p>',
            'start'=>2,
            'end'=>5,
        ),
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Retur Penjualan</p>',
            'start'=>6,
            'end'=>9,
        ),
        array(
            'name'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
            'start'=>10,
            'end'=>14,
        ),                  
    ),
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1',
                'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>' Grand Total (Rp)',
            ),
           // array(
           //     'header'=>'jenisobatalkes_id',
           //     'type'=>'raw',
           //     'value'=>'$data->jenisobatalkes_id',
           // ),
            array(
                'header'=>'Kelompok',
                'type'=>'raw',
                'value'=>'$data->jenisobatalkes_nama',
            ),
            // //Penjualan
            array(
                'header'=>'Bruto',
                // 'name'=>'hargajual_oa',
                'value'=>'MyFormatter::formatNumberForPrint($data->hargajual_oa)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpJual('hargajual_oa',true))
            ),
          array(
                'header'=> 'Keringanan',
                // 'name'=>'discount',
                'value'=>'MyFormatter::formatNumberForPrint($data->discount)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpJual('discount',true))
            ),
             array(
                'header'=>'PPn (%)',
                'value'=>'MyFormatter::formatNumberForPrint($data->ppn_persen, 2)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
             array(
                'header'=>'Netto',
                // 'name'=>'harganetto_oa',
                'value'=>'MyFormatter::formatNumberForPrint($data->harganetto_oa)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpJual('harganetto_oa',true))
            ),          
            //Retur
            array(
                'header'=>'Bruto',
                'value'=>'MyFormatter::formatNumberForPrint($data->getTpRetur("hargajual_oa",false,$data->jenisobatalkes_id))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpRetur('hargajual_oa',true))
            ),
            array(
                'header'=> 'Keringanan',
                'value'=>'MyFormatter::formatNumberForPrint($data->getTpRetur("discount"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpRetur('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'MyFormatter::formatNumberForPrint($data->getTpRetur("ppn_persen"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'MyFormatter::formatNumberForPrint($data->getTpRetur("harganetto_oa",false,$data->jenisobatalkes_id))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpRetur('harganetto_oa',true))
            ),
            // //Total
            array(
                'header'=>'Bruto',
                'value'=>'MyFormatter::formatNumberForPrint($data->getTpTotal("hargajual_oa",false,$data->jenisobatalkes_id))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpTotal('hargajual_oa',true))
            ),
            array(
                'header'=> 'Keringanan',
                'value'=>'MyFormatter::formatNumberForPrint($data->getTpTotal("discount"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpTotal('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'MyFormatter::formatNumberForPrint($data->getTpTotal("ppn_persen"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'MyFormatter::formatNumberForPrint($data->getTpTotal("harganetto_oa",false,$data->jenisobatalkes_id))',
                // 'value'=>'$data->getTpTotal("harganetto_oa")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpTotal('harganetto_oa',true))
            ),
            array(
                'header'=>'HPP',
                'value'=>'MyFormatter::formatNumberForPrint($data->hpp)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  MyFormatter::formatNumberForPrint($model->getTpJual('hpp',true))
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>