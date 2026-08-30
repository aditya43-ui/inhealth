<?php 

$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchPenjualanObat();
$template = "{summary}\n{items}\n{pager}";
$sort = false;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrintPenjualanObat();  
  $template = "{items}";
  if ($caraPrint == "EXCEL") {
      echo $caraPrint;
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  
  
}
$totals = 0;
$labarugi = 0;
$diskons = 0;
$data2 = clone $data;
$data2->pagination = false;

foreach ($data2->data as $item) {
    $totals += $item->hargajual_oa;
    $labarugi += $item->labarugi;
    $diskons += $item->discount_oa;
}
?>
<?php 
$this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
            ),
            array(
                'header'=>'Tgl. Penjualan/<br>No.Penjualan',
                'name'=>'tglpenjualan',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenjualan)."/<br>".$data->noresep',
            ),
            array(
                'header'=>'Jenis Penjualan',
                'type'=>'raw',
                'value'=>'$data->jenispenjualan',
            ),
            array(
                'header' => 'Dokter',
                'type' => 'raw',
                'value' => function($data){
                    if ($data->jenispenjualan == Params::JENISPENJUALAN_DOKTER || $data->jenispenjualan == Params::JENISPENJUALAN_RESEP){
                        $peg = PegawaiM::model()->findByPk($data->pegawai_id);                        
                        if (!empty($peg)){
                            return $peg->namaLengkap;
                        }else{
                            return '-';
                        }                        
                    }else{
                        return '-';
                    }
                }
            ),
            'obatalkes_nama',
            array(
                'header'=>'Satuan Kecil',
                'type'=>'raw',
                'value'=>'$data->satuankecil_nama',
            ),
            array(
                'header'=>'Jumlah',
                'type'=>'raw',
                'value'=>'$data->qty_oa',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
            ),
            array(
                'header'=>'HPP',
                'name'=>'harganetto_oa',
                'value'=>function($data) {
                    return MyFormatter::formatNumberForPrint($data->hpp,0,true);
                }, //'"Rp ".number_format($data->harganetto_oa * (100 - $data->harganetto_oa,0,",",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;', 'nowrap'=>true),
                //'footerHtmlOptions'=>array('style'=>'text-align:right;', 'nowrap'=>true),
                //'footer'=>'sum(harganetto_oa)'
            ),
            array(
                'header'=>'Harga Jual',
                'name'=>'hargasatuan_oa',
                'value'=>'MyFormatter::formatNumberForPrint($data->hargasatuan_oa,0,true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;', 'nowrap'=>true),
                'footerHtmlOptions'=>array('colspan'=>9,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'Total',
            ),
            array(
                'header'=>'Keringanan',
                'name'=>'discount_oa',
                'value'=>'MyFormatter::formatNumberForPrint($data->discount_oa,0,true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;', 'nowrap'=>true),
                'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight: bold;', 'nowrap'=>true),
                'footer'=>MyFormatter::formatNumberForPrint($diskons, 0, true),
            ),
            array(
                'header'=>'Subtotal',
                'name'=>'hargajual_oa',
                'value'=>'MyFormatter::formatNumberForPrint($data->hargajual_oa - $data->discount_oa,0,true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;', 'nowrap'=>true),
                'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight: bold;', 'nowrap'=>true),
                'footer'=>MyFormatter::formatNumberForPrint($totals, 0, true),
            ),
            array(
                'header'=>'Laba / Rugi',
                // 'name'=>'harganetto_oa',
                'value'=>'MyFormatter::formatNumberForPrint($data->labarugi, 0, true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;', 'nowrap'=>true),
                'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight: bold;', 'nowrap'=>true),
                'footer'=>MyFormatter::formatNumberForPrint($labarugi, 0, true),//'sum(labarugi)'
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>