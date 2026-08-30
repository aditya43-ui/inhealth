
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

if ($caraPrint=='EXCEL') {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>3));      
} else {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}      

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
	'id'=>'penjaminpasien-m-grid',
	'dataProvider'=>$model->searchRekonsiliasi(), //searchPenjaminPrint
//	'filter'=>$model,
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'value'=>$rows,  
                ),
                // array(
                //     'header'=>'Jenis Penjamin',
                //     'value'=>'$data->penjamin->carabayar->carabayar_nama',  
                // ),
                // array(
                //     'header'=>'Penjamin',
                //     'value'=>'$data->penjamin->penjamin_nama',  
                // ),
                // array(
                //     'header'=>'Rekening Debit',
                //     'type'=>'raw',
                //     'value'=>'$this->grid->owner->renderPartial('.$this->path_view .'"_rekPenjaminD",array("saldonormal"=>"D","penjamin_id"=>$data->penjamin_id),true)',
                // ),
		        // array(
                //     'header'=>'Rekening Kredit',
                //     'type'=>'raw',
                //     'value'=>'$this->grid->owner->renderPartial('.$this->path_view .'"_rekPenjaminK",array("saldonormal"=>"K","penjamin_id"=>$data->penjamin_id),true)',
                // ),
                array(
                    'header' => 'Jenis Rekonsiliasi',
                    'name' => 'jenisrekonsiliasibank_nama',
                    'value' => '$data->jenisrekonsiliasibank->jenisrekonsiliasibank_nama',
                ),
                array(
                    'header' => 'Rekening Debit',
                    'name' => 'rekening_debit',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("sistemAdministrator.views.rekonsiliasibankrekeningM/_rekRekonBankD",array("saldonormal"=>"D","jenisrekonsiliasibank_id"=>$data->jenisrekonsiliasibank_id),true)',
                ),
                array(
                    'header' => 'Rekening Kredit',
                    'name' => 'rekeningKredit',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("sistemAdministrator.views.rekonsiliasibankrekeningM/_rekRekonBankK",array("saldonormal"=>"K","jenisrekonsiliasibank_id"=>$data->jenisrekonsiliasibank_id),true)',
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>