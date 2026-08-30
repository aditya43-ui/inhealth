<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTableGF();
$itemCssClass='table table-bordered table-striped table-condensed';
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $row = '$row+1';
    $sort = false;
  $data = $model->searchPrintGF();  
  $template = "{items}";
  if ($caraPrint == "EXCEL") {
      echo $caraPrint;
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
   
      if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
}
?>
<?php 
$this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
	'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		array(
			'header' => 'No.',
			'value' => $row,
		),
		array(
			'header'=>'Jenis <br> Obat Alkes',
			'type'=>'raw',
			'value'=>'$data->jenisobatalkes_nama',
		),
		array(
			'header'=>'Kode <br> Obat Alkes',
			'type'=>'raw',
			'value'=>'$data->obatalkes_kode',
		),
		array(
			'header'=>'Golongan <br> Kategori',
			'type'=>'raw',
			'value'=>'$data->obatalkes_golongan."<br>".$data->obatalkes_kategori',
		),
		array(
			'header'=>'Nama <br> Obat Alkes',
			'type'=>'raw',
			'value'=>'$data->obatalkes_nama',
		),
		array(
			'header'=>'Sumber <br> Dana',
			'type'=>'raw',
			'value'=>'$data->sumberdana_nama',
		),
		array(
			'header'=>'Harga <br> Netto',
			'type'=>'raw',
			'value'=>(Params::cekHiddenHargaGudangFarmasi()==true)?'number_format($data->harganetto,0,"",".")':'"Hidden"',
			'htmlOptions'=>array('style'=>(Params::cekHiddenHargaGudangFarmasi()==true)?'text-align:right':'text-align:center'),
		),
		array(
			'header'=>'Stock <br> Minimal',
			'type'=>'raw',
			'value'=>'number_format($data->kemasanbesar,0,"",".")',
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		array(
			'header'=>'Stock <br> Opname',
			'type'=>'raw',
			'value'=>'number_format($data->volume_fisik,0,"",".")',
			'htmlOptions'=>array('style'=>'text-align:right'),
		),
		array(
			'header'=>'Tanggal Kedaluwarsa',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglkadaluarsa)))',
		),
		array(
			'header'=>'Kondisi <br> Barang',
			'type'=>'raw',
			'value'=>'$data->kondisibarang',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>