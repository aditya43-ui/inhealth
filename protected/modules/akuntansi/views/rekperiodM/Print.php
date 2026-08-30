<?php 

    $table = 'ext.bootstrap.widgets.BootGridView';
    $template = "{summary}\n{items}\n{pager}";
	$rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
    if (isset($caraPrint)){
		$rows = '$row+1';
        $template = "{items}";
    }
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');   
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-bordered datatable',
	'columns'=>array(
		array(
			'header' => 'No.',
			'value'=>$rows,
		),
		'perideawal',
		'sampaidgn',
		'deskripsi',
		array(
			'header'=>'Status Closing',
			'filter'=>false,
			'name'=>'isclosing',
			'value'=>'($data->isclosing == 1) ? "Aktif" : "Tidak Aktif"',
			'htmlOptions'=>array('style'=>'text-align:center'),
		),
 
	),
));
