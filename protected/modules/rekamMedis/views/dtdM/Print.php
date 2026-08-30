
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
        'enableSorting'=>false,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                    'header'=>'ID',
                    'value'=>'$data->dtd_id',
                ),
		'dtd_noterperinci',
		'dtd_nama',
		'dtd_namalainnya',
                 array
                (
                        'name'=>'dtd_menular',
                        'type'=>'raw',
                        'value'=>'($data->dtd_menular==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
             array(
                     'header'=>'ICD-X',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_icdx\',array(\'dtd_id\'=>$data[dtd_id]),true)',
                ),
             array
                (
                        'name'=>'dtd_aktif',
                        'type'=>'raw',
                        'value'=>'($data->dtd_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
		/*
		'dtd_katakunci',
		'dtd_nourut',
		'dtd_menular',
		'dtd_aktif',
		*/
 
        ),
    )); 
?>