<?php 
$itemCssClass='table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
 $no = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $sort = false;
    $no = '$row+1';
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
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
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $no,
            ),
			array(
				'header' => 'Tanggal Pendaftaran',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
			),
			array(
				'header' => 'No. Pendaftaran',
				'value' => '$data->no_pendaftaran'
			),
			array(
				'header' => 'Tanggal Masuk Penunjang/<br> No Masuk Penunjang',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."/ <br>".$data->no_masukpenunjang'
			),
            array(
                'header'=>'No. Rekam Medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
            ),   
            array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->NamaNamaBIN',
            ),          
            array(
                'header'=>'Jenis Kelamin/ <br>Umur',
                'type'=>'raw',
                'value'=>'$data->JenisKelaminUmur',
            ),
            array(
                'header'=>'Alamat',
                'type'=>'raw',
                'value'=>'$data->alamat_pasien',
            ),
            array(
                'header'=>'Instalasi Asal/ <br>Ruangan Asal',
                'type'=>'raw',
                'value'=>'$data->InstalasiRuangan',
            ),
            array(
               'header'=>'Jenis Penjamin /<br>Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: left')
            ),
            array(
               'name'=>'Kunjungan',
               'type'=>'raw',
               'value'=>'$data->kunjungan',
               'htmlOptions'=>array('style'=>'text-align: left')
            ),
//            'kunjungan',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>