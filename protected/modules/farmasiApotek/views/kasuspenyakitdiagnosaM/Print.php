
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      

$this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'sajenis-kelas-m-grid',
                'enableSorting'=>false,
                'dataProvider'=>$model->searchPrint(),
                'mergeColumns'=>'jeniskasuspenyakit.jeniskasuspenyakit_nama',
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'name'=>'jeniskasuspenyakit.jeniskasuspenyakit_nama',
                        'header'=>'Jenis Kasus Penyakit',
                        'value'=>'$data->jeniskasuspenyakit->jeniskasuspenyakit_nama',
                    ),
                    array(
                        'header'=>'Nama Diagnosa',
                        'value'=>'$data->diagnosa->diagnosa_nama',
                        'htmlOptions'=>array(
                            'style'=>'border-left:solid 1px #DDDDDD',
                        ),
                    ),
                    array(
                        'header'=>'Nama Lainnya',
                        'value'=>'$data->diagnosa->diagnosa_namalainnya',
                    ),
        ),
    )); 
?>