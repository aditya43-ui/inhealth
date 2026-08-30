<?php 
	$itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
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
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 
if(isset($caraPrint) && $caraPrint == "EXCEL"){
    $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $row,
            ),
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien / Nama Panggilan',
                'value'=>'$data->NamaNamaBIN',
            ),
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
                'header'=>'Jenis Kasus Penyakit',
                'type'=>'raw',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
			array(
				'header' => 'Jenis Penjamin/ <br>Penjamin',
				'type' => 'raw',
				'value' => '$data->carabayar_nama."/ <br>".$data->penjamin_nama'
			),            
            array(
                'header'=>'Iur Biaya (Rp)',
                'type'=>'raw',
                'value'=>'$data->iurbiaya',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
//            'iurbiaya',
            array(
                'header'=>'Total Biaya Pelayanan (Rp)',
                'type'=>'raw',
                'value'=>'$data->total',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
}else{
$this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $row,
            ),
			array(
				'header' => 'Tanggal Pendaftaran/ <br>No. Pendaftaran',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
			),
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien',
                'value'=>'$data->namadepan." ".$data->nama_pasien',
            ),
			array(
				'header' => 'Umur/ <br>Jenis Kelamin',
				'type' => 'raw',
				'value' => '$data->umur."/ <br>".$data->jeniskelamin'
			),        
			array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
            array(
				'header' => 'Jenis Penjamin/ <br>Penjamin',
				'type' => 'raw',
				'value' => '$data->carabayar_nama."/ <br>".$data->penjamin_nama'
			),
            array(
                'header'=>'Jenis Kasus Penyakit',
                'type'=>'raw',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            
            array(
                'header'=>'Iur Biaya (Rp)',
                'type'=>'raw',
                'value'=>'MyFormatter::formatNumberForPrint($data->iurbiaya)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
//            'iurbiaya',
            array(
                'header'=>'Total Biaya Pelayanan (Rp)',
                'type'=>'raw',
                'value'=>'MyFormatter::formatNumberForPrint($data->total)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
}
?>