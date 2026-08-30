
<?php
$table = 'ext.bootstrap.widgets.BootGroupGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>2));      

$this->widget($table,array(
	'id'=>'rjkasuspenyakitruangan-m-grid',
	'dataProvider'=>$model->searchTabel(),
	'filter'=>$model,
                'mergeColumns'=>'ruangan.ruangan_nama',
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'name'=>'ruangan.ruangan_nama',
                        'header'=>'Nama Ruangan',
                        'value'=>'$data->ruangan->ruangan_nama',
                    ),
                    array(
                        'header'=>'Nama Pegawai',
                        'value'=>'$data->pegawai->nama_pegawai',
                        'htmlOptions'=>array(
                            'style'=>'border-left: 1px solid #DDDDDD;'
                        ),
                    ),
        ),
    )); 
?>