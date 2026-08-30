
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
	'id'=>'saprogram-promo-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'kelompoktindakan_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->programpromo_id',
                ),
		'namaprogrampromo',
		'namalainnya',
		'deskripsi',
		'keterangan',
		array
                (
                        'name'=>'programpromo_aktif',
                        'type'=>'raw',
                        'value'=>'($data->programpromo_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
 
        ),
    )); 
?>