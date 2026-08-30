<?php
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $row = '$row+1';
  $data = $model->searchPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
        $itemCssClass='table border';
} else{
  $data = $model->search();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
        'itemsCssClass'=>$itemCssClass,
        'template'=>$template,
       'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
                'start'=>7, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' =>$row,
//                        'footer'=>'<b>Total:</b>',
                        'footerHtmlOptions'=>array('colspan'=>6, 'style'=>'text-align:right;'),
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
                        'header' => 'Jenis Obat',
                        'value' => '$data->jenisobatalkes_nama'
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
                        'header'=>'Kode',
                        'value'=>'$data->obatalkes_kode',
                    ),
                    array(
                        'header'=>'Nama Obat Alkes',
                        'value'=>'$data->obatalkes_nama',
                    ),                    
                    array(
                        'name'=>'qty_in',
                        'type'=>'raw',
                        'header'=>'<p style="margin: 0; text-align: center;">Stok Masuk</p>',
                        'value'=>'number_format($data->qty_in,0,"",".")." ".$data->satuankecil_nama',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
//                        'footer'=>'sum(qty_in)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'name'=>'qty_out',
                        'type'=>'raw',
                        'header'=>'<p style="margin: 0; text-align: center;">Stok Keluar</p>',
                        'value'=>'number_format($data->qty_out,0,"",".")." ".$data->satuankecil_nama',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
//                        'footer'=>'sum(qty_out)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'name'=>'qty_current',
                        'type'=>'raw',
                        'header'=>'<p style="margin: 0; text-align: center;">Stok Akhir</p>',
                        'value'=>'number_format($data->qty_current,0,"",".")." ".$data->satuankecil_nama',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;width:100px;'),
//                        'footer'=>'sum(qty_current)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
					array(
						'header' => 'HPP',
						'value'=>'number_format($data->hpp_obat,0,"",".")',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
						'footer'=>'<b>Grand Total</b>',
						'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>11),
					),
					array(
						'header' => 'Subtotal',
						'name'=>'subtotal',
						'value'=>'number_format($data->subtotal,0,"",".")',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
						'footer'=>'sum(subtotal)',
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
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