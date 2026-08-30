<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$row+1'
            ),
			array(
                'name'=>'NamaNamaBIN',
                'value'=>'$data->NamaNamaBIN',
            ),
            array(
				'header'=>'No. Rekam Medik',
                'value'=>'$data->no_rekam_medik',
            ),
//            'alamat_pasien',
			array(
				'header'=>'Umur',
                'value'=>'$data->umur',
            ),
			array(
				'header'=>'Jenis Kelamin',
                'value'=>'$data->jeniskelamin',
            ),
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