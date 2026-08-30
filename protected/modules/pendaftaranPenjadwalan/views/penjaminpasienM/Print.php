
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
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
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
                        'value'=>'$row+1',
                ),
		array(
		    'header'=>'Jenis Penjamin',
                    'name'=>'carabayar_id',
                    'value'=>'$data->carabayar->carabayar_nama',
		),
		'penjamin_nama',
		'penjamin_namalainnya',
		array(
                  'header'=>'Aktif',
                  'value'=>'($data->penjamin_aktif == 1) ? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
 
        ),
    )); 
?>