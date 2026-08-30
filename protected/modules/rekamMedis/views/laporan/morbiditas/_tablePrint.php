<?php 
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
if (isset($caraPrint)){
    $row = '$row+1';
  $data = $model->searchPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTable();
  $template = "{summary}\n{items}\n{pager}";
}
?>
<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Golongan Umur</p>',
                'start'=>2, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Jenis Kelamin</p>',
                'start'=>10, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table border',
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => $row,
                    'footer'=>'jumlah',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;', 'colspan'=>2),
            ),
            array(
                'header' => 'Diagnosa Nama',
                'value' => '$data->diagnosa_nama',
            ),            
            array(
                    'header' => '0 - 28hr',
                    'name' => 'umur_0_28hr',                    
                    'value' => '$data->umur_0_28hr',
                    'footer'=>'sum(umur_0_28hr)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => '28hr - 1thn',
                    'name' => 'umur_28hr_1thn',                    
                    'value' => '$data->umur_28hr_1thn',
                    'footer'=>'sum(umur_28hr_1thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => '1 - 4thn',
                    'name' => 'umur_1_4thn',                    
                    'value' => '$data->umur_1_4thn',
                    'footer'=>'sum(umur_1_4thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => '5 - 14thn',
                    'name' => 'umur_5_14thn',                    
                    'value' => '$data->umur_5_14thn',
                    'footer'=>'sum(umur_5_14thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => '15 - 24thn',
                    'name' => 'umur_15_24thn',                    
                    'value' => '$data->umur_15_24thn',
                    'footer'=>'sum(umur_15_24thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => '25 - 44thn',
                    'name' => 'umur_25_44thn',                    
                    'value' => '$data->umur_25_44thn',
                    'footer'=>'sum(umur_25_44thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => '45 - 64thn',
                    'name' => 'umur_45_64thn',                    
                    'value' => '$data->umur_45_64thn',
                    'footer'=>'sum(umur_45_64thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => '65thn',                    
                    'value' => '$data->umur_65',
                    'name' => 'umur_65',                    
                    'footer'=>'sum(umur_65)',
                    'filter'=>false,
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => 'Laki - Laki',
                    'name' => 'lakilaki',                    
                    'value' => '$data->lakilaki',
                    'footer'=>'sum(lakilaki)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header' => 'Perempuan',
                    'name' => 'perempuan',                    
                    'value' => '$data->perempuan',
                    'footer'=>'sum(perempuan)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                'header' => 'Jumlah Kasus Baru',
                'value' => '$data->kasusbaru',
                'name' => 'kasusbaru',
                'htmlOptions' => array('style'=>'text-align:center;'),
                'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                'footer'=>'sum(kasusbaru)',
            ),
            array(
                    'header'=>'Jumlah Kunjungan',
                    'name' => 'jumlahkunjungan',
                    'value' => '$data->jumlahkunjungan',
                    'footer'=>'sum(jumlahkunjungan)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
//            'umur_0_28hr',
//            'umur_28hr_1thn',
//                        'umur_1_4thn',
//            'umur_5_14thn',
//            'umur_15_24thn',
//            'umur_25_44thn',
//            'umur_45_64thn',
//            'umur_65',
//            'lakilaki',
//            'perempuan',
//            array(
//                'header'=>'Jumlah Kunjungan',
//                'value'=>'$data->jumlahkunjungan',
//            ),
            /*

            'diagnosa_id',
            'diagnosa_kode',
            
            'diagnosa_namalainnya',
            'diagnosa_nourut',
            'golonganumur_id',
            , */
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>