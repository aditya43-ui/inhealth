<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
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
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' =>$row,
            ),
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien / Alias',
                'value'=>'$data->NamaNamaBIN',
            ), 
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
                'header'=>'Nama Jenis Kasus Penyakit',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
            'kelaspelayanan_nama',
            array(
                'header'=>'Jenis Penjamin / Penjamin',
                'value'=>'$data->carabayarPenjamin',
            ), 
            array(
                'header'=>'Iur Biaya',
                'value'=>'$data->iurbiaya',
            ), 
            array(
                'header'=>'Total Biaya Pelayanan',
                'value'=>'$data->total',
            ), 
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
