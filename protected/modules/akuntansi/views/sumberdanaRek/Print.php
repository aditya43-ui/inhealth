
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
		$rows ='$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
		$rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
  ?>  

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sumberdanarek-m-grid',
	'dataProvider'=>$model->searchPrint(),
//	'filter'=>$model,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(            
		array(
			'header' => 'No.',
			'value'=>$rows,  
		),
		array(
			'header'=>'Sumber Dana',
			'value'=>'$data->sumberdana_nama',  
		),
		array(
			'header'=>'Rekening Debit',
			'type'=>'raw',
			'value'=>'$this->grid->owner->renderPartial("_rek_debet",array("saldonormal"=>"D","sumberdana_id"=>$data->sumberdana_id),true)',
		),   
		 array(
			'header'=>'Rekening Kredit',
			'type'=>'raw',
			'value'=>'$this->grid->owner->renderPartial("_rek_kredit",array("saldonormal"=>"K","sumberdana_id"=>$data->sumberdana_id),true)',
		),
		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>