<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
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
    $itemCssClass='table table-striped table-bordered table-condensed';
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
//            'instalasi_nama',
        array(
            'header' => 'No.',
            'value' => $row,
        ),
        array(
            'header' => 'Tanggl Pendaftaran/ <br> No. Pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien'
        ),
        array(
            'header' => 'Umur/ <br> Jenis Kelamin',
            'type' => 'raw',
            'value' => '$data->umur."/ <br>".$data->jeniskelamin'
        ),                        
        'alamat_pasien',
        array(
            'header' => 'Kelas Pelayanan',
            'value' => '$data->kelaspelayanan_nama',
        ),
        array(
            'header' => 'Asal Rujukan',
            'value' => '$data->asalrujukan_nama',
        ),
        array(
            'header' => 'Jenis Kasus Penyakit',
            'value' => '$data->jeniskasuspenyakit_nama',
        ),            
        'statusmasuk',                        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>