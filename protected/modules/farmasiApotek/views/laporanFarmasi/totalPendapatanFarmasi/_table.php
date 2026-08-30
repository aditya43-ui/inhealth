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
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
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
                'value'=>'number_format($data->hargajual_oa,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpJual('hargajual_oa',true),0,"",".")
            ),
          array(
                'header'=> 'Keringanan',
                // 'name'=>'discount',
                'value'=>'number_format($data->discount,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpJual('discount',true),0,"",".")
            ),
             array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->ppn_persen)',
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
                'footer'=>  number_format($model->getTpJual('harganetto_oa',true),0,"",".")
            ),          
            //Retur
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->getTpRetur("hargajual_oa",false,$data->jenisobatalkes_id),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpRetur('hargajual_oa',true),0,"",".")
            ),
            array(
                'header'=> 'Keringanan',
                'value'=>'number_format($data->getTpRetur("discount"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpRetur('discount',true),0,"",".")
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->getTpRetur("ppn_persen"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->getTpRetur("harganetto_oa",false,$data->jenisobatalkes_id),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpRetur('harganetto_oa',true),0,"",".")
            ),
            // //Total
            array(
                'header'=>'Bruto',
                // 'value'=>'number_format($data->getTpTotal("hargajual_oa",false,$data->jenisobatalkes_id),0,"",".")',
                'value' => function ($data) {
                    $brutoPenjualan = $data->hargajual_oa;
                    $brutoRetur = $data->getTpRetur("hargajual_oa",false,$data->jenisobatalkes_id);
                    $brutoTotal = $brutoPenjualan - $brutoRetur;
                    echo number_format($brutoTotal,0, "", ".");
                },
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpTotal('hargajual_oa',true),0,"",".")
            ),
            array(
                'header'=> 'Keringanan',
                'value'=>'number_format($data->getTpTotal("discount"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpTotal('discount',true),0,"",".")
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->getTpTotal("ppn_persen"),0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->getTpTotal("harganetto_oa",false,$data->jenisobatalkes_id),0,"",".")',
                // 'value'=>'$data->getTpTotal("harganetto_oa")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpTotal('harganetto_oa',true),0,"",".")
            ),
            array(
                'header'=>'HPP',
                'value'=>'number_format($data->hpp,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpJual('hpp',true),0,"",".")
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>