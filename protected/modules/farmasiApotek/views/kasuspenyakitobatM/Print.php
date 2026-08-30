
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
	'id'=>'sajenis-kelas-m-grid',
                'enableSorting'=>false,
                'dataProvider'=>$model->searchPrint(),
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
				'mergeColumns'=>'jeniskasuspenyakit_nama',
                'columns'=>array(
                   array(
                        'name'=>'jeniskasuspenyakit_nama',
                        'header'=>'Jenis Kasus Penyakit',
                        'value'=>'$data->jeniskasuspenyakit_nama',
                    ),
                    array(
                        'name'=>'obatalkes_kode',
                        'header'=>'Kode Obat Alkes',
                        'value'=>'$data->obatalkes_kode',
                        'htmlOptions'=>array(
                            'style'=>'border-left:solid 1px #DDDDDD',
                        ),
                    ),
                    array(
                        'name'=>'obatalkes_nama',
                        'header'=>'Nama Obat Alkes',
                        'value'=>'$data->obatalkes_nama',
                    ),
        ),
    )); 
?>