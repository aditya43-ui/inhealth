<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
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
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
//            'instalasi_nama',
            array(
                'header'=>'No.',
                'value' => $row,
            ),
            array(
                'header'=>'No. Rekam Medik/<br>No. Pendaftaran',
                'type'=>'raw',
                'value'=>'$data->noRMNoPend',
            ),   
            array(
                'header'=>'Nama Pasien / <Br> Alias',
                'value'=>'$data->NamaNamaBIN',
            ),
//            'NamaNamaBIN',
            array(
                'header'=>'Tanggal Masuk Penunjang <br> No. Penunjang',
                'type'=>'raw',
                'value'=>'$data->TglMasukNoPenunjang',
            ),
            array(
                'header'=>'Jenis Kelamin <br>Umur',
                'type'=>'raw',
                'value'=>'$data->JenisKelaminUmur',
            ),
            array(
                'header'=>'Alamat <br>RT/RW',
                'type'=>'raw',
                'value'=>'$data->AlamatRTRW',
            ),
            array(
                'header'=>'Instalasi Asal <br>Ruangan/Poliklinik Asal',
                'type'=>'raw',
                'value'=>'$data->InstalasiRuangan',
            ),
            array(
               'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),
            array(
                'header'=>'Status Masuk',
                'value'=>'$data->statusmasuk',
            ),
            array(
                'header'=>'Nama Kelas Pelayanan',
                'value'=>'$data->kelaspelayanan_nama',
            ),
            array(
                'header'=>'Asal Rujukan',
                'value'=>'$data->asalrujukan_nama',
            ),
            array(
                'header'=>'Nama Jenis Kasus Penyakit',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>