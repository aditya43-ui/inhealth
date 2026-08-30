<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchMinimalPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchMinimal();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                'template'=>$template,
       'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
                'start'=>7, //indeks kolom 3
                'end'=>10, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
//                        'footer'=>'<b>Total:</b>',
                        'footerHtmlOptions'=>array('colspan'=>3, 'style'=>'text-align:right;'),
                        'type'=>'raw',
                         'htmlOptions'=>array(
                            'style'=>'text-align:right;padding-right:10%;'
                        ),
                    ),
                    array(
                        'header' => 'Jenis Kelompok',
                        'value' => '$data->lookup_name'
                    ),
                    array(
                        'name'=>'jenisobatalkes_nama',
                        'value'=>'!empty($data->jenisobatalkes_id)?(($data->jenisobatalkes_nama==null)?$data->jenisobatalkes->jenisobatalkes_nama:$data->jenisobatalkes_nama):"-"',
                    ),
                    array(
                        'header' => 'Kategori',
                        'value' => '$data->obatalkes_kategori'
                    ),
                    array(
                        'header' => 'Golongan',
                        'value' => '$data->obatalkes_golongan'
                    ),
                    array(
                        'header'=>'Kode Obat Alkes',
                        'value'=>'$data->obatalkes_kode',
                    ),
                    array(
                        'header'=>'Nama Obat Alkes',
                        'value'=>'$data->obatalkes_nama',
                    ),
                    array(
                        'header'=>'Minimal Stok',
                        'type'=>'raw',
                        'value'=>'number_format($data->minimalstok,0,",",".")',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                        'footer'=>'sum(qty_in)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'header'=>'Stok Sekarang',
                        'type'=>'raw',
                        'value'=>'number_format($data->qtystok,0,",",".")',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                        'footer'=>'sum(qty_out)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    
//                    array(
//                        'header'=>'Harga Jual',
//                        'value'=>'number_format($data->hargajual_oa)',
//                        'footer'=>number_format($model->totalhargajual),
//                    ),
//                    array(
////                        'header'=>'Total Harga',
////                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
////                        'footer'=>number_format($model->totalharga),
//                        'name'=>'totalharga',
//                        'type'=>'raw',
//                        'header'=>'Total Harga',
//                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
//                        'htmlOptions'=>array('style'=>'text-align:right;'),
//                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                        'footer'=>'sum(totalharga)',
//                    ),
	),
)); ?>
<?php
    if(isset($caraPrint) && $caraPrint == 'EXCEL'){
        $this->widget($table, array(
            'id'=>'laporan-grid',
            'dataProvider'=>$data,
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
            'template'=>$template,
           'mergeHeaders'=>array(
                array(
                    'name'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
                    'start'=>3, //indeks kolom 3
                    'end'=>5, //indeks kolom 4
                ),
            ),
            'columns'=>array(
            array(
                'header'=>'No.',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
    //                        'footer'=>'<b>Total:</b>',
                'footerHtmlOptions'=>array('colspan'=>3, 'style'=>'text-align:right;'),
                'type'=>'raw',
                 'htmlOptions'=>array(
                    'style'=>'text-align:right;padding-right:10%;'
                ),
            ),
            array(
                'header'=>'Kode Obat Alkes',
                'value'=>'$data->obatalkes_kode',
            ),
            array(
                'header'=>'Nama Obat Alkes',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
//                'name'=>'qty_in',
                'type'=>'raw',
                'header'=>'<p style="margin: 0; text-align: center;">Stok Minimal</p>',
                'value'=>'$data->minimalstok',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'footerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
//                'name'=>'qty_out',
                'type'=>'raw',
                'header'=>'<p style="margin: 0; text-align: center;">Stok Sekarang</p>',
                'value'=>'$data->qtystok',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'footerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
        ),
    )); 
    }
    ?>