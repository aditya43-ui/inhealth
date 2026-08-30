<?php 
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$sort=true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
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
  
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'enableSorting'=>$sort,
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
//            'instalasi_nama',
                array(
			'header'=>'No. Pendaftaran',
			'value'=>'$data->no_pendaftaran',
		),
		array(
			'header'=>'No. Rekam Medik',
			'value'=>'$data->no_rekam_medik',
		),
			// 'NamaNamaBIN',
		array(
			   'header'=>'Nama',
			   //'value'=>'$data->NamaNamaBIN',
                           'value' => '$data->namadepan." ".$data->nama_pasien'

		),  		
		array(
			'header'=>'Umur',
			'value'=>'$data->umur',
		),
		/*array(
			'header'=>'Jenis Kelamin',
			'value'=>'$data->jeniskelamin',
		),*/
		array(
			'header'=>'Nama Perujuk',
			'value'=>'$data->nama_perujuk',
		),
		array(
			   'header'=>'Jenis Penjamin /Penjamin',
			   'type'=>'raw',
			   'value'=>'$data->CaraBayarPenjamin',
			   'htmlOptions'=>array('style'=>'text-align: center')
		),  
		array(
			'header'=>'Alamat Pasien',
			'value'=>'$data->alamat_pasien',
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>