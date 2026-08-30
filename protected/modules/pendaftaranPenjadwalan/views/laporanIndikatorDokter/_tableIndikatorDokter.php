<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
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
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        array(
			'header'=>'No.',
			'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
			'type'=>'raw',
        ),
		array(
			'header'=>'Nama Dokter',
			'value'=>'(isset($data->dokterbaru_gelardepan) ? $data->dokterbaru_gelardepan : "")." ".$data->dokterbaru_nama.(isset($data->dokterbaru_gelarbelakang) ? ", ".$data->dokterbaru_gelarbelakang : "")',
			'type'=>'raw',
        ),
		array(
			'header'=>'No. Pendaftaran',
			'value'=>'$data->no_pendaftaran',
			'type'=>'raw',
        ),
		array(
			'header'=>'NIP',
			'value'=>'(isset($data->nobadge) ? $data->nobadge : "-")',
			'type'=>'raw',
        ),
		array(
			'header'=>'No. Rekam Medik',
			'value'=>'$data->no_rekam_medik',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:left;'),
        ),
		array(
			'header'=>'Nama Pasien',
			'value'=>'$data->nama_pasien',
			'type'=>'raw',
        ),
		array(
			'header'=>'Alasan Perubahan Dokter',
			'value'=>'$data->alasanperubahandokter',
			'type'=>'raw',
        ),
    ),
)); ?> 
