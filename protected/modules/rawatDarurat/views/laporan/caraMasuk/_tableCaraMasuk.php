
<?php if (isset($caraPrint)){
  $data = $model->searchPrint();  
} else{
  $data = $model->searchTable();
}
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
//            'instalasi_nama',
            'statusmasuk',
            'no_rekam_medik',
            'nama_pasien',
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            'alamat_pasien',
            'kelaspelayanan_nama',
            'asalrujukan_nama',
            'jeniskasuspenyakit_nama',
//            'catatan_dokter_konsul',
//            'statusperiksa',
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