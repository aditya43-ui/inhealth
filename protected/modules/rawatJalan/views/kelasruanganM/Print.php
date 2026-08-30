<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

 $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchTabel();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTabel();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'rjkelasruangan-m-grid',
	'dataProvider'=>$data,
	'filter'=>$model,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'mergeColumns' => array('ruangan.ruangan_nama'),
	'columns'=>array(
			array(
				'name'=>'ruangan.ruangan_nama',
				'header'=>'Nama Ruangan',
				'value'=>'$data->ruangan->ruangan_nama',
			),
			array(
				'header'=>'Nama Kelas',
				'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
				'htmlOptions'=>array(
					'style'=>'border-left:1px solid #DDDDDD',
				),
			),
			array(
				'header'=>'Nama Lainnya',
				'value'=>'$data->kelaspelayanan->kelaspelayanan_namalainnya',
			),
        ),
    )); 
?>