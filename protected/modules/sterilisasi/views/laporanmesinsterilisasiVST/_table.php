<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
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
//                array(
//                    'header' => 'No.',
//                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
//                    'value' => '$row+1'
//                ),
                array(
                    'header'=>'Tanggal',
                    'value'=> 'isset($data->sterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($data->sterilisasi_tgl) : "-"',
                ),
                array(
                   'header'=>'Mulai Jam',
                    'value'=> 'isset($data->sterilisasi_jam) ? $data->sterilisasi_jammulai : "00:00:00"',
                ),
                array(
                   'header'=>'Sterilisator',
                    'value'=> '$data->nama_pegawai',
                ),
                array(
                    'header'=>'Alat Yang Disterilkan',
                    'value'=> '$data->alatmedis_nama',
                ),
                array(
                    'header'=>'Jumlah',
                    'value'=> '$data->sterilisasidetail_jml',
                ),
                array(
                    'header'=>'Selesai Jam',
                    'value'=> 'isset($data->sterilisasi_jam) ? $data->sterilisasi_jamselesai : "00:00:00"',
                ),
                array(
                    'header'=>'Hasil',
                    'value'=> '$data->sterilisasi_hasil',
                ),
                array(
                    'header'=>'Keterangan',
                    'value'=> '$data->sterilisasidetail_ket',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>