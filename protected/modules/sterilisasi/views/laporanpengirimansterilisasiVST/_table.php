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
        'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Pengirim Alat Kotor</p>',
                'start'=>5, 
                'end'=>6, 
            ),
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Penerima Alat Steril</p>',
                'start'=>7, 
                'end'=>8, 
            ),
        ),
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
                   'header'=>'Jam',
                    'value'=> 'isset($data->sterilisasi_jam) ? $data->sterilisasi_jam : "00:00:00"',
                ),
                array(
                   'header'=>'Ruangan',
                    'value'=> '$data->ruangan_nama',
                ),
                array(
                    'header'=>'Nama Barang',
                    'value'=> '$data->barang_nama',
                ),
                array(
                    'header'=>'Jumlah',
                    'value'=> '$data->sterilisasidetail_jml',
                ),
                array(
                    'header'=>'Ruangan',
                    'value'=> '$data->mengetahui_k',
                ),
                array(
                    'header'=>'CSSD',
                    'value'=> '$data->menerima_k',
                ),
                array(
                    'header'=>'Ruangan',
                    'value'=> '$data->mengetahui',
                ),
                array(
                    'header'=>'CSSD',
                    'value'=> '$data->menerima',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>