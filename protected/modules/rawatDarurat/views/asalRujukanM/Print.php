<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>8));
?>

<?php $this->widget($table,array(
	'id'=>'saasal-rujukan-m-grid',
	'dataProvider'=>$model->search(),
        'template'=>"{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'asalrujukan_id',
                array(
                        'name'=>'asalrujukan_id',
                        'value'=>'$data->asalrujukan_id',
                        'filter'=>false,
                ),		
                'asalrujukan_nama',
		'asalrujukan_institusi',
		'asalrujukan_namalainnya',
               array
                (
                   'header'=>'Aktif',
                    'type'=>'raw',
                    'value'=>'($data->asalrujukan_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>