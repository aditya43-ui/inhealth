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
        $data = $model->searchPrint(Params::LOOKUPTYPE_SIGNA_OA);
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint(Params::LOOKUPTYPE_SIGNA_OA);
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
			'header'=>'ID',
			'value'=>'$data->lookup_id',
		),
		array(
			'header'=>'Signa Obat',
			'value'=>'$data->lookup_name',
		),
		array(
				'header'=>'Aktif',
				'value' => '($data->lookup_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),   
 
        ),
    )); 
?>