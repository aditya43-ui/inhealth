
<?php 
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
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
	'id'=>'saaksespengguna-k-grid',
	// 'mergeColumns'=>array('loginpemakai.nama_pemakai'),
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>$template,
	 'mergeColumns'=>array('loginpemakai.nama_pemakai','peranpengguna.peranpenggunanama'),
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'tugaspengguna_id',
		array(
					'header'=>'No.',
					'value' => '($this->grid->dataProvider->pagination) ? 
									($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
									: ($row+1)',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
				'loginpemakai.nama_pemakai',
				'peranpengguna.peranpenggunanama',
				'modul.modul_nama',
         
 
        ),
    )); 
?>

