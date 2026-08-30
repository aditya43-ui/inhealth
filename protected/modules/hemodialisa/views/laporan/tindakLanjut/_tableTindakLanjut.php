<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$sort = true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
//            'instalasi_nama',
//            'carakeluar',
            array(
                'header'=>'Tindak Lanjut',
                'type'=>'raw',
                'value'=>'(empty($data->pasienpulang_id))?"PULANG":$data->carakeluar',
            ),
            'no_rekam_medik',
            'nama_pasien',
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
             array(
                'header'=>'Nama Diagnosa',
                'type'=>'raw',
                'value'=>'(!empty($data->diagnosa_nama))?$data->diagnosa_nama:""',
            ),
            // 'diagnosa_nama',
//            array(
//                   'header'=>'CaraBayar/Penjamin',
//                   'type'=>'raw',
//                   'value'=>'$data->CaraBayarPenjamin',
//                   'htmlOptions'=>array('style'=>'text-align: center')
//            ),  
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>