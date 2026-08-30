
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
		$rows = '$row+1';
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
	'id'=>'pelayananrek-m-grid',
	'dataProvider'=>$model->searchPelayanan(),
//	'filter'=>$model,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            
                array(
                    'header' => 'No.',
                    'value'=>$rows,  
                ),                
                array(
                    'header'=>'Jenis Pelayanan',
                    'value'=>'$data->JenisPelayanan', 
                ),
				array(
					'header'=>'Ruangan',
					'name'=>'ruanganNama',
					'value'=>'!empty($data->ruangan_id)?$data->ruangan->ruangan_nama:" - "',  
				),
                array(
                    'header'=>'Nama Pelayanan',
                    'value'=>'$data->daftartindakan->daftartindakan_nama',  
                ),
                array(
                        'header'=>'Rekening Debit',
					'type'=>'raw',
					'name'=>'rekDebit',
					'value'=>'$this->grid->owner->renderPartial("_rekPelayananD",array("saldonormal"=>"D","ruangan_id"=>$data->ruangan_id,"daftartindakan_id"=>$data->daftartindakan_id),true)',
				),   
				 array(
					'header'=>'Rekening Kredit',
					'type'=>'raw',
					'name'=>'rekKredit',
					'value'=>'$this->grid->owner->renderPartial("_rekPelayananK",array("saldonormal"=>"K","ruangan_id"=>$data->ruangan_id,"daftartindakan_id"=>$data->daftartindakan_id),true)',
				), 
		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>