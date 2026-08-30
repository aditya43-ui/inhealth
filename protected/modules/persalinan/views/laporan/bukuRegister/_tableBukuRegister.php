<?php 
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$sort=true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    $data = $model->searchPrint();  
    $template = "{items}";
    if ($caraPrint=='EXCEL') {
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
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header'=>'Tanggal Pendaftaran/ <br>No. Pendaftaran',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran',
            ),
            array(
                'header'=>'No. Rekam Medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
            ),  
            array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->namadepan." ".$data->nama_pasien',
            ),  
              
            array(
                'header'=>'Umur/ <br> Jenis Kelamin',
                'type'=>'raw',
                'value'=>'$data->umur."/ <br>".$data->jeniskelamin',
            ),              
            array(
                'header'=>'Nama Perujuk',
                'type'=>'raw',
                'value'=>'$data->nama_perujuk',
            ),  
            array(
                   'header'=>'Jenis Penjamin / <br>Penjamin',
                   'type'=>'raw',
                   'value'=>'$data->carabayar_nama."/ <br>".$data->penjamin_nama',
                   'htmlOptions'=>array('style'=>'text-align: left')
            ),  
            array(
                'header'=>'Alamat Pasien',
                'type'=>'raw',
                'value'=>'$data->alamat_pasien',
            ),  
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>