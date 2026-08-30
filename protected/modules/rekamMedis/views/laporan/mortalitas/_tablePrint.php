<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
if (isset($caraPrint)){
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
        'enableSorting'=>false,
        'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Golongan Umur</p>',
                'start'=>2, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Keadaan Meninggal</p>',
                'start'=>10, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table border',
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    'footer'=>'jumlah',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;', 'colspan'=>2),
            ),
            'diagnosa_nama',
            array(
                    'name' => 'umur_0_28hr',
                    'value' => '$data->umur_0_28hr',
                    'footer'=>'sum(umur_0_28hr)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'umur_28hr_1thn',
                    'value' => '$data->umur_28hr_1thn',
                    'footer'=>'sum(umur_28hr_1thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'umur_1_4thn',
                    'value' => '$data->umur_1_4thn',
                    'footer'=>'sum(umur_1_4thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'umur_5_14thn',
                    'value' => '$data->umur_5_14thn',
                    'footer'=>'sum(umur_5_14thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'umur_15_24thn',
                    'value' => '$data->umur_15_24thn',
                    'footer'=>'sum(umur_15_24thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'umur_25_44thn',
                    'value' => '$data->umur_25_44thn',
                    'footer'=>'sum(umur_25_44thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'umur_45_64thn',
                    'value' => '$data->umur_45_64thn',
                    'footer'=>'sum(umur_45_64thn)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'umur_65',
                    'value' => '$data->umur_65',
                    'footer'=>'sum(umur_65)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'kondisipulang1',
                    'header'=>'< 48 Jam',
                    'value' => '$data->kondisipulang1',
                    'footer'=>'sum(kondisipulang1)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'name' => 'kondisipulang2',
                    'header'=>'> 48 Jam',
                    'value' => '$data->kondisipulang2',
                    'footer'=>'sum(kondisipulang2)',
                    'htmlOptions' => array('style'=>'text-align:center;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
            array(
                    'header'=>'Jumlah',
                    'name' => 'jumlahkunjungan',
                    'value' => '(isset($data->jumlahkunjungan) ? $data->jumlahkunjungan : 0)',
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