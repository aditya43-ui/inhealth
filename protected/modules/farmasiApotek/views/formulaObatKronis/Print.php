<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

  $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'fa-lookup-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        array(
            'header' => 'No',
            'type' => 'raw',
            'value' => '$row+1',
        ),
		array(
			'header'=>'Jumlah Obat',
			'value'=>'$data->jumlahobat',
		),
        array(
			'header'=>'Jumlah Obat Minimal',
			'value'=>'$data->jumlahobat_minimal',
		),
        array(
			'header'=>'Jumlah Obat Maksimal',
			'value'=>'$data->jumlahobat_maksimal',
		),
		array(
				'header'=>'Aktif',
				'value' => '($data->is_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),   
 
        ),
    )); 
?>