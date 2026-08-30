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
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table, array(
	'id'=>'esselon-m-grid',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'filter'=>$model,
	'columns'=>array(
                array(
                    'header'=>'ID',
                    'value'=>'$data->esselon_id',
                ),
                array(
                    'header'=>'Esselon',
                    'value'=>'$data->esselon_nama',
                ),
                array(
                    'header'=>'Nama lainnya',
                    'value'=>'$data->esselon_namalainnya',
                ),
                array(
                    'header'=>'Aktif',
                    'value'=>'(($data->esselon_aktif==1)? "Ya" : "Tidak")',
                ),
//		'esselon_id',
//		'esselon_nama',
//		'esselon_namalainnya',
//                                array(
//                                    'header'=>'Aktif',
//                                    'class'=>'CCheckBoxColumn',
//                                    'selectableRows'=>0,
//                                    'checked'=>'$data->esselon_aktif',
//                                ),
//		array(
//                                                'header'=>Yii::t('zii','View'),
//			'class'=>'ext.bootstrap.widgets.BootButtonColumn',
//                                                'template'=>'{view}',
//		),
//		array(
//                                                'header'=>Yii::t('zii','Update'),
//			'class'=>'ext.bootstrap.widgets.BootButtonColumn',
//                                                'template'=>'{update}',
//		),
//		array(
//                                                'header'=>'Hapus',
//			'class'=>'ext.bootstrap.widgets.BootButtonColumn',
//                                                'template'=>'{delete}',
//		),
	),
)); ?>