
<?php 
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    $itemCssClass='table table-bordered datatable';
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
		$row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
         $table = 'ext.bootstrap.widgets.BootExcelGridView';        
        }
        
        $itemCssClass='table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php if(!isset($caraPrint)){ ?>
<?php } ?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>$itemCssClass,
    //'mergeColumns' => array('instalasi_nama', 'ruangan_nama'),
    'columns'=>array(   
		array(
			'header' => 'No.',
			'value' => $row
		),
        array(
            'name'=>'tgl_pendaftaran',
            'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tgl_pendaftaran)))',
        ),
        'no_rekam_medik',
        'no_pendaftaran',
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien'
        ),
     //   'nama_pasien',
        'alamat_pasien',
       // 'jeniskelamin',
        'umur',
        array(
            'header' => 'Instalasi/<br> Ruangan',
            'type' => 'raw',
            'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama'
        ),
        array(
            'header' => 'Jenis Penjamin/<br>Penjamin',
            'type' => 'raw',
            'value' => '$data->carabayar_nama."/<br>".$data->penjamin_nama'
        ),
		array(
			'header' => 'Jenis Kasus Penyakit',
			'name' => 'jeniskasuspenyakit_nama',
		),
        
        'kelaspelayanan_nama',
        'statuspasien',
		'kunjungan'
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
		