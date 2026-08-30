
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
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    
$this->widget($table,array(
	'id'=>'sakonfigfarmasi-k-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'konfigfarmasi_id',
		array(
                        'name'=>'konfigfarmasi_id',
                        'value'=>'$data->konfigfarmasi_id',
                        'filter'=>false,
                ),
//		'tglberlaku',
                array(
                        'name'=>'tglberlaku',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglberlaku)',
                ),
		'persenppn',
		'persenpph',
		'bayarlangsung',
		'pesandistruk',
		'pesandifaktur',
		'formulajasadokter',
		'formulajasaparamedis',
		'hargaygdigunakan',
		'pembulatanharga',
                'metodeantrian',
//		'konfigfarmasi_aktif',
		
            
                array(
                    'header' => 'Status',
                    'value'=>'($data->konfigfarmasi_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
        ),
    )); 
?>