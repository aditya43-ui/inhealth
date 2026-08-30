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
//            'instalasi_nama',
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien /Alias',
                'value'=>'$data->NamaNamaBIN',
            ),
            'umur',
            'jeniskelamin',
            'no_pendaftaran',
            'nama_perujuk',
            'alamat_pasien',
            'kelaspelayanan_nama',
            'nomasukkamar',
            'kunjungan',
            array(
                   'header'=>'CaraBayar/Penjamin',
                   'type'=>'raw',
                   'value'=>'$data->CaraBayarPenjamin',
                   'htmlOptions'=>array('style'=>'text-align: center')
            ),   
            'penjamin_nama',
            'kabupaten_nama',
            'kelurahan_nama',
            array(
                'name'=>'Diagnosa Pasien',
                'type'=>'raw',
                'value'=> function($data){
                    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                        //'kelaspelayanan_id'=>$row->kelaspelayanan_id
                    ));
                    return !empty($modMorbiditas->diagnosa_id) ? $modMorbiditas->diagnosa->diagnosa_nama : " ";
                }
                // 'value'=>'!empty($data->diagnosa_id) ? $data->diagnosa_nama : ""',
             ),  
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>