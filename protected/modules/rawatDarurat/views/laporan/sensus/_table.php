<?php 
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
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
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            
            array(
				'header'=>'No. Rekam Medik',
                'name'=>'no_rekam_medik',
                'value'=>'$data->no_rekam_medik',
            ),
            array(
                'header'=>'Nama Pasien',
               // 'name'=>'nama_pasien',
                'value'=>'$data->namadepan." ".$data->nama_pasien',
            ),
//            'alamat_pasien',
			array(
				'header'=>'Umur',
                'value'=>'$data->umur',
            ),
	/*		array(
				'header'=>'Jenis Kelamin',
                'value'=>'$data->jeniskelamin',
            ),*/
			array(
				'header'=>'Alamat Pasien',
                'value'=>'$data->alamat_pasien',
            ),
			array(
				'header'=>'Kunjungan',
                'value'=>'$data->kunjungan',
            ),
			array(
				'header'=>'Status Pasien',
                'value'=>'$data->statuspasien',
            ),
            array(
                'header'=>'Nama Diagnosa',
                'value'=>'$data->diagnosa_nama',
            ),
//            'diagnosa_nama',
            
            array(
               'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),  
            array(
                'name'=>'Uraian Tindakan',
                'type'=>'raw',
                'value'=>'$this->grid->getOwner()->renderPartial(\'sensus/_tindakan\', array(\'id\'=>$data->pendaftaran_id))',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>