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
                'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                                            array(
                                                'header' => 'No.',
                                                'value' => '$row+1'
                                            ),

                                            'no_rekam_medik',    
                                            'NamaNamaBIN',
                                            'nama_bin',
                                            array(
                                                'header'=>'Jenis Kelamin',
                                                'value'=>'$data->jeniskelamin',
                                            ),
                                //            'jeniskelamin',
                                            'umur',
                                            'alamat_pasien',
                                            'statuspasien',
                                            'statusmasuk',
                                            'kunjungan',
                                            'statuspasien',
                                            array(
                                               'name'=>'CaraBayar/Penjamin',
                                               'type'=>'raw',
                                               'value'=>'$data->CaraBayarPenjamin',
                                               'htmlOptions'=>array('style'=>'text-align: center')
                                            ),     
                                            'caramasuk_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>