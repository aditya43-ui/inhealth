
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

 $table = 'ext.bootstrap.widgets.BootGroupGridView';
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