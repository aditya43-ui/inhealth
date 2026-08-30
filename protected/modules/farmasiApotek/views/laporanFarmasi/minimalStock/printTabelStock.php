<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$itemCssClass ='table table-striped table-condensed';
if (isset($caraPrint)){
  $data = $model->searchMinimalPrint();
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
  $data = $model->searchMinimalPrint();
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
    ),
)); ?>