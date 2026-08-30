<?php
/**
 * menampilkan daftar data
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
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

$hargajual = 0;
$totalharga = 0;

foreach($data->getData() as $dataList){
    $hargajual += $dataList->hargajual;
    $totalharga += ($dataList->hargajual * $dataList->qty_current);
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
                        'type'=>'raw',
                         'htmlOptions'=>array(
                            'style'=>'text-align:right;padding-right:10%;'
                        ),
                        'footer'=>'<b>Total:</b>',
                        'footerHtmlOptions'=>array('colspan'=>10, 'style'=>'text-align:right;'),

                    ),
                    array(
                        'header' => 'Jenis Kelompok',
                        'value' => '$data->lookup_name',
                    ),
                    array(
                        'header' => 'Jenis Obat',
                        'value' => '$data->jenisobatalkes_nama',
                    ),
                    array(
                        'header' => 'Kategori',
                        'value' => '$data->obatalkes_kategori',
                    ),
                    array(
                        'header' => 'Golongan',
                        'value' => '$data->obatalkes_golongan',
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
                    ),
                    array(
                        'name'=>'qty_out',
                        'type'=>'raw',
                        'header'=>'<p style="margin: 0; text-align: center;">Stok Keluar</p>',
                        'value'=>'number_format($data->qty_out,0,"",".")." ".$data->satuankecil_nama',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'qty_current',
                        'type'=>'raw',
                        'header'=>'<p style="margin: 0; text-align: center;">Stok Akhir</p>',
                        'value'=>'number_format($data->qty_current,0,"",".")." ".$data->satuankecil_nama',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;width:100px;'),
//                        'footer'=>'sum(qty_current)',
                        // 'footer'=>'<span></span>'
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                   array(
                       'header'=>'Harga Jual',
                       'value'=>'number_format($data->hargajual)',
                       'htmlOptions'=>array('style'=>'text-align:right;'),
                       'footer'=>number_format($hargajual),
                       'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                   ),
                   array(
//                        'header'=>'Total Harga',
//                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
//                        'footer'=>number_format($model->totalharga),
                       'name'=>'totalharga',
                       'type'=>'raw',
                       'header'=>'Total Harga',
                       'value'=>'number_format($data->hargajual * $data->qty_current)',
                       'htmlOptions'=>array('style'=>'text-align:right;'),
                       'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                       'footer'=>number_format($totalharga),
                   ),
	),
)); ?>