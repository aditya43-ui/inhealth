
<?php 
$table = 'ext.bootstrap.widgets.BootGroupGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>3));    
$this->widget($table,array(
	'id'=>'fadiagnosaobat-m-grid',
	'dataProvider'=>$model->searchTabel(),
                'mergeColumns'=>array('diagnosa.diagnosa_kode','diagnosa.diagnosa_nama'),
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'template'=>"{items}",
	'columns'=>array(
                        array(
                            'name'=>'diagnosa.diagnosa_kode',
                            'header'=>'Kode Diagnosa',
                            'value'=>'$data->diagnosa->diagnosa_kode',
                        ),
                        array(
                            'name'=>'diagnosa.diagnosa_nama',
                            'header'=>'Diagnosa',
                            'value'=>'$data->diagnosa->diagnosa_nama',
                        ),
                        array(
                            'header'=>'Obat Alkes',
                            'value'=>'$data->obatalkes->obatalkes_nama',
                            'htmlOptions'=>array(
                                'style'=>'border-left:1px solid #CCCCCC',
                            ),
                        ),
	),
)); ?>