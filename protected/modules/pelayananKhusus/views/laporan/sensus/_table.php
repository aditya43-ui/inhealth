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
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
                'header'=>'No. Rekam Medik <br/> No. Pendaftaran',
                'type'=>'raw',
                'value'=>'$data->noRMNoPend',
            ),   
            array(
                'header'=>'Nama / Alias',
                'type'=>'raw',
                'value'=>'$data->NamaNamaBIN',
            ), 
            array(
                'header'=>'Tanggal Masuk Penunjang <br/> No. Penunjang',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->TglMasukNoPenunjang))',
            ),
            array(
                'header'=>'Jenis Kelamin <br/>Umur',
                'type'=>'raw',
                'value'=>'$data->JenisKelaminUmur',
            ),
            array(
                'header'=>'Alamat <br/>RT/RW',
                'type'=>'raw',
                'value'=>'$data->AlamatRTRW',
            ),
            array(
                'header'=>'Instalasi Asal <br/>Ruangan Asal',
                'type'=>'raw',
                'value'=>'$data->InstalasiRuangan',
            ),
            array(
               'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: left')
            ), 
//            array(
//                'header'=>'Jenis Pemeriksaan',
//                'type'=>'raw',
//                'value'=>'$this->grid->getOwner()->renderPartial(\'sensus/_jenis\', array(\'id\'=>$data->pendaftaran_id))',
//            ),
//            array(
//                'header'=>'Nama Pemeriksaan',
//                'type'=>'raw',
//                'value'=>'$this->grid->getOwner()->renderPartial(\'sensus/_nama\', array(\'id\'=>$data->pendaftaran_id))',
//            ),
//               'pemeriksaanrad_jenis',
//               'pemeriksaanrad_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>