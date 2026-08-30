<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php 

    $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'htmlOptions'=>array(
            'style'=>'font-size',
            
        ),
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                 array(
                    'header'=>'Nama Dokter',
                    // 'name'=>'nobuktibayar',
                    'type'=>'raw',
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
// //                'nobuktibayar',
                array(
                    'header'=>'Tanggal <br> Pembebasan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeFOrUser($data->tglpembebasan)',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Tanggal <br> Pelayanan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeFOrUser($data->tgl_tindakan)',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'No. RM <br> No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik ."<br>".$data->no_pendaftaran',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan.$data->nama_pasien',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Ruangan Peluayanan',
                    'type'=>'raw',
                    'value'=>'$data->ruangan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Jumlah Tarif',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_satuan)',
                    'htmlOptions'=>array('style'=>'font-size:10px; text-align: right;'),
                ),
                array(
                    'header'=>'Uraian Tindakan',
                    'type'=>'raw',
                    'value'=>'$data->daftartindakan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),   
                ),
                array(
                    'header'=>'Kompora Tarif',
                    'type'=>'raw',
                    'value'=>'0',
                    'htmlOptions'=>array('style'=>'font-size:10px;text-align:right;'),
                ),
                array(
                    'header'=>'Jumlah Pembebasan',
                    'type'=>'raw',                    
                    'value'=>'MyFormatter::formatNumberForPrint($data->jmlpembebasan)',
                    'htmlOptions'=>array('style'=>'font-size:10px; text-align: right;'),
                ),                                                                

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>