<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1'
            ),
            array(
                'header'=>'Tanggal Pendaftaran/<br> No. Pendaftaran',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran',
            ),   
            array(
                'header'=>'Tanggal Masuk Penunjang/<br>No. Penunjang',
                'type'=>'raw',
                'value'=>'$data->TglMasukNoPenunjang',
            ),
            array(
                'header'=>'No. Rekam Medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
            ),   
            array(
                'header'=>'Nama Pasien',
                'value'=>'$data->namadepan." ".$data->nama_pasien',
            ),
//            'NamaNamaBIN',
            
            array(
                'header'=>'Jenis Kelamin/<br>Umur',
                'type'=>'raw',
                'value'=>'$data->JenisKelaminUmur',
            ),
            array(
                'header'=>'Alamat <br>RT/RW',
                'type'=>'raw',
                'value'=>'$data->AlamatRTRW',
            ),
            array(
                'header'=>'Instalasi Asal/<br>Ruangan Asal',
                'type'=>'raw',
                'value'=>'$data->InstalasiRuangan',
            ),
            array(
               'header'=>'Jenis Penjamin / Penjamin',
               'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
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
            array(
                'header'=>'Jenis Pemeriksaan RAD',
                'value'=>'$data->jenispemeriksaanrad_nama',
            ),
            array(
                'header'=>'Nama Pemeriksaan RAD',
                'value'=>'$data->pemeriksaanrad_nama',
            ),
//               'pemeriksaanrad_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>