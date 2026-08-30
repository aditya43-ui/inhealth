
<?php

if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php

if (!empty($caraPrint)) {

    echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    
    .table{
        box-shadow:none;
        border: 1px solid black;
        border-radius: 0;
    }
    
    .table-bordered {
        border-collapse: collapse;
    }
        
    .table th, .table td {
        border: 1px solid black;
        color: black !important;    
    }
    
    .table-bordered th + th {
        border-left: none;
    }
    
    .table-bordered td + td {
        border-left: none;
    }

    .kertas{
     width:20cm;
     height:12cm;
    }
');

    echo $this->renderPartial('application.views.headerReport.headerRincian', array('judulLaporan' => $judulLaporan));
}

$grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

$this->widget($grid_view,array(
	'id'=>'informasipegawailogin-v-print',
	'dataProvider'=>$model->searchPrintInformasi(),
	'template'=>"{items}",
	'itemsCssClass'=>'table table-bordered datatable',
	'columns'=>array(
        array(
			'header'=>'Instalasi',
			'type'=>'raw',
			'value'=>'$data->instalasi_nama',
		),
            array(
			'header'=>'Ruangan',
			'type'=>'raw',
			'value'=>'$data->ruangan_nama',
		),
            array(
			'header'=>'Pegawai',
			'type'=>'raw',
			'value'=>'$data->nama_pegawai',
		),
            array(
			'header'=>'Jenis Kelamin',
			'type'=>'raw',
			'value'=>'$data->jeniskelamin',
		),
            array(
			'header'=>'Nama Pemakai',
			'type'=>'raw',
			'value'=>'$data->nama_pemakai',
		),
            array(
			'header'=>'Tanggal Pembuatan Login',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglpembuatanlogin)',
		),
            array(
			'header'=>'Tanggal Terakhir Login',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->lastlogin)',
		),
            array(
			'header'=>'Tanggal Update Login',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglupdatelogin)',
		),
            array(
			'header'=>'Status',
			'type'=>'raw',
			'value'=>'($data->statuslogin==1)?"Aktif":"Tidak Aktif"',
		),
            array(
			'header'=>'Modul',
			'type'=>'raw',
			'value'=>'$data->modul_nama',
		)	
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>