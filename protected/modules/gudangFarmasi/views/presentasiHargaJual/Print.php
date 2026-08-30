
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

  $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        $row = '$row+1';
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                    'header' => 'No.',
                    'value'=>$row,
                ),
		'tglberlaku',
		'persenppn',
		'persenpph',
                array(
                    'header'=>'Adm. Racikan',
                    'value'=>'$data->admracikan',
                    'name'=>'admracikan',
                    'type'=>'raw',
                ),
                array(
                    'header'=>'Total Persen Harga Jual Bebas',
                    'value'=>'$data->persjualbebas',
                    'name'=>'persjualbebas',
                    'type'=>'raw',
                ),
		'totalpersenhargajual',
                'marginresep',
                'marginnonresep',
        ),
    )); 
?>