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
        'itemsCssClass'=>'table table-striped table-condensed table-bordered',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1'
            ),
            'no_rekam_medik',    
            array(
                'header'=>' Nama Pasien / Alias',
                'value'=>'$data->NamaNamaBIN',
            ),
            'umur',
            'jeniskelamin',
            array(
               'header'=>'Alamat',
               'value'=>'$data->AlamatLengkap',
            ),
            'kelaspelayanan_nama',
            'nomasukkamar',
            array(
               'name'=>'CaraBayar / Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),
            'kunjungan',
            'statuspasien',
            array(
                'header'=>'Diagnosa / Kelompok',
                'value'=>'$data->diagnosa',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>