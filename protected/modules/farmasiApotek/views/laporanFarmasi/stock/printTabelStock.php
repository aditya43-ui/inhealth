<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$itemCssClass ='table table-striped table-condensed';
if (isset($caraPrint)){
  $data = $model->searchPrint();
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
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchPrintStock();
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
                'end'=>10, //indeks kolom 4
            ),
        ),
    'columns'=>array(
                    array(
                        'header' => 'No.',
                        'value'=>'$row+1',
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
                        'header'=>'Jenis',
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
                        'name'=>'qty_in',
                        'type'=>'raw',
                        'header'=>'<p style="margin: 0; text-align: center;">Jumlah Masuk</p>',
                        'value'=>'$data->qty_in',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
//                        'footer'=>'sum(qty_in)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'name'=>'qty_out',
                        'type'=>'raw',
                        'header'=>'<p style="margin: 0; text-align: center;">Jumlah Keluar</p>',
                        'value'=>'$data->qty_out',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
//                        'footer'=>'sum(qty_out)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'name'=>'qty_current',
                        'type'=>'raw',
                        'header'=>'<p style="margin: 0; text-align: center;">Jumlah Sekarang</p>',
                        'value'=>'$data->qty_current',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;width:100px;'),
//                        'footer'=>'sum(qty_current)',
                        
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