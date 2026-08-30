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
			'header'=>'Tgl. Re-evaluasi',
			'name'=>'reevaluasiaset_tgl',
			'type'=>'raw',
        ),		
		array(
			'header'=>'No. Re-evaluasi',
			'name'=>'reevaluasiaset_no',
			'type'=>'raw',
        ),
		array(
			'header'=>'Nama Aset',
			'name'=>'barang_nama',
			'type'=>'raw',
        ),
		array(
			'header'=>'Kode Inventaris',
			'value'=>'$data->invtanah_id.$data->invasetlain_id.$data->invgedung_id.$data->invperalatan_id.$data->invjalan_id',
			'type'=>'raw',
        ),
		array(
			'header'=>'No. Register',
			'value'=>'$data->invtanah_noregister.$data->invasetlain_noregister.$data->invgedung_noregister.$data->invperalatan_noregister.$data->invjalan_noregister',
			'type'=>'raw',
        ),		
		array(
			'header'=>'Umur Ekonomis',
			'name'=>'reevaluasiaset_umurekonomis',
			'value'=>'number_format($data->reevaluasiaset_umurekonomis)',
			'type'=>'raw',
        ),
		array(
			'header'=>'Nilai Buku',
			'name'=>'reevaluasiaset_nilaibuku',
			'value'=>'number_format($data->reevaluasiaset_nilaibuku)',			
			'type'=>'raw',
        ),
		array(
			'header'=>'Harga Pasar',
			'name'=>'reevaluasiaset_hargaperolehan',
			'value'=>'number_format($data->reevaluasiaset_hargaperolehan)',			
			'type'=>'raw',
        ),
		array(
			'header'=>'Selisih Reevaluasi',
			'name'=>'reevaluasiaset_selisihreevaluasi',
			'value'=>'number_format($data->reevaluasiaset_selisihreevaluasi)',			
			'type'=>'raw',
        ),
    ),
)); ?> 
